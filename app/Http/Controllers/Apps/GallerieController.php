<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\Gallerie;
use App\Models\GalleryMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class GallerieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $galleries = Gallerie::ordered()->paginate(12);
        return view('admin.apps.gallerie.index', compact('galleries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.apps.gallerie.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'files' => 'required|array|min:1',
            'files.*' => 'file|mimes:jpeg,png,jpg,gif,svg,mp4,avi,mov,wmv,flv,webm|max:51200', // 50MB max per file
            'is_featured' => 'boolean',
            'is_active' => 'boolean'
        ]);

        $gallery = Gallerie::create([
            'title' => $request->title,
            'description' => $request->description,
            'is_featured' => $request->boolean('is_featured'),
            'is_active' => $request->boolean('is_active', true),
            'sort_order' => Gallerie::max('sort_order') + 1,
        ]);

        foreach ($request->file('files') as $index => $file) {
            $this->processAndStoreFile($file, $gallery, $index);
        }

        return redirect()->route('apps.gallerie.index')
            ->with('success', 'Gallery created successfully with ' . count($request->file('files')) . ' file(s)!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Gallerie $gallerie)
    {
        return view('admin.apps.gallerie.show', compact('gallerie'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gallerie $gallerie)
    {
        return view('admin.apps.gallerie.edit', compact('gallerie'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gallerie $gallerie)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'files' => 'nullable|array',
            'files.*' => 'file|mimes:jpeg,png,jpg,gif,svg,mp4,avi,mov,wmv,flv,webm|max:51200',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'delete_media' => 'nullable|array',
            'delete_media.*' => 'integer|exists:gallery_media,id'
        ]);

        try {
            $gallerie->update([
                'title' => $request->title,
                'description' => $request->description,
                'is_featured' => $request->boolean('is_featured'),
                'is_active' => $request->boolean('is_active')
            ]);

            if ($request->has('delete_media')) {
                foreach ($request->delete_media as $mediaId) {
                    $media = $gallerie->media()->find($mediaId);
                    if ($media) {
                        if (Storage::disk('public')->exists($media->file_path)) {
                            Storage::disk('public')->delete($media->file_path);
                        }
                        $media->delete();
                    }
                }
            }

            if ($request->hasFile('files')) {
                $maxSortOrder = $gallerie->media()->max('sort_order') ?? 0;
                foreach ($request->file('files') as $index => $file) {
                    $this->processAndStoreFile($file, $gallerie, $maxSortOrder + $index + 1);
                }
            }

            return redirect()->route('apps.gallerie.index')
                ->with('success', 'Gallery updated successfully!');

        } catch (\Exception $e) {
            Log::error('Gallery update error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Error updating gallery: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gallerie $gallerie)
    {
        try {
            foreach ($gallerie->media as $media) {
                if (Storage::disk('public')->exists($media->file_path)) {
                    Storage::disk('public')->delete($media->file_path);
                }
            }

            $gallerie->delete();

            return redirect()->route('apps.gallerie.index')
                ->with('success', 'Gallery deleted successfully!');

        } catch (\Exception $e) {
            Log::error('Gallery deletion error: ' . $e->getMessage());
            return back()->with('error', 'Error deleting gallery: ' . $e->getMessage());
        }
    }

    /**
     * Update sort order via AJAX
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:galleries,id',
            'items.*.sort_order' => 'required|integer'
        ]);

        foreach ($request->items as $item) {
            Gallerie::where('id', $item['id'])->update(['sort_order' => $item['sort_order']]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Process and store a file with compression if needed
     */
    private function processAndStoreFile($file, $gallery, $sortOrder)
    {
        $originalSize = $file->getSize();
        $mimeType = $file->getMimeType();
        $fileType = str_starts_with($mimeType, 'image/') ? 'image' : 'video';
        $originalName = $file->getClientOriginalName();

        $fileName = time() . '_' . $sortOrder . '_' . Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();

        $isCompressed = false;
        $finalSize = $originalSize;

        if ($fileType === 'image' && $originalSize > 1048576) { // 1MB = 1048576 bytes
            $compressedPath = $this->compressImage($file, $fileName);
            if ($compressedPath) {
                $filePath = 'galleries/' . $fileName;
                $isCompressed = true;
                $finalSize = Storage::disk('public')->size($filePath);
            } else {
                $filePath = $file->storeAs('galleries', $fileName, 'public');
            }
        } else {
            $filePath = $file->storeAs('galleries', $fileName, 'public');
        }

        $gallery->media()->create([
            'file_path' => $filePath,
            'file_name' => $fileName,
            'original_name' => $originalName,
            'file_type' => $fileType,
            'mime_type' => $mimeType,
            'file_size' => $finalSize,
            'original_size' => $originalSize,
            'sort_order' => $sortOrder,
            'is_compressed' => $isCompressed,
        ]);
    }

    /**
     * Compress image if it's larger than 1MB
     */
    private function compressImage($file, $fileName)
    {
        try {
            $tempPath = $file->getPathname();
            $extension = strtolower($file->getClientOriginalExtension());

            switch ($extension) {
                case 'jpg':
                case 'jpeg':
                    $image = imagecreatefromjpeg($tempPath);
                    break;
                case 'png':
                    $image = imagecreatefrompng($tempPath);
                    break;
                case 'gif':
                    $image = imagecreatefromgif($tempPath);
                    break;
                default:
                    return false;
            }

            if (!$image) {
                return false;
            }

            $originalWidth = imagesx($image);
            $originalHeight = imagesy($image);

            $newWidth = intval($originalWidth * 0.8);
            $newHeight = intval($originalHeight * 0.8);

            $compressedImage = imagecreatetruecolor($newWidth, $newHeight);

            if ($extension === 'png' || $extension === 'gif') {
                imagealphablending($compressedImage, false);
                imagesavealpha($compressedImage, true);
                $transparent = imagecolorallocatealpha($compressedImage, 255, 255, 255, 127);
                imagefill($compressedImage, 0, 0, $transparent);
            }

            imagecopyresampled($compressedImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);

            $storagePath = storage_path('app/public/galleries/' . $fileName);

            $directory = dirname($storagePath);
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }

            $quality = 75;
            $success = false;

            switch ($extension) {
                case 'jpg':
                case 'jpeg':
                    $success = imagejpeg($compressedImage, $storagePath, $quality);
                    break;
                case 'png':
                    $success = imagepng($compressedImage, $storagePath, 6); // PNG compression level 6
                    break;
                case 'gif':
                    $success = imagegif($compressedImage, $storagePath);
                    break;
            }

            imagedestroy($image);
            imagedestroy($compressedImage);

            return $success ? $storagePath : false;

        } catch (\Exception $e) {
            Log::error('Image compression error: ' . $e->getMessage());
            return false;
        }
    }
}
