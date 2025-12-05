# Simple Image Upload System

## Overview
All images are saved directly to the `uploads/` folder in the project root with simple PHP file operations.

## Upload Locations
- **Avatars**: `uploads/avatars/`
- **Brands**: `uploads/brands/`
- **Constructeurs**: `uploads/constructeurs/`
- **Categories**: `uploads/categories/`
- **Pieces**: `uploads/pieces/`
- **Promotions**: `uploads/promotions/`

## How It Works

### Uploading Images
Controllers use simple file move operations:
```php
if ($request->hasFile('image')) {
    $uploadPath = public_path('uploads/brands');
    
    if (!file_exists($uploadPath)) {
        mkdir($uploadPath, 0755, true);
    }
    
    $image = $request->file('image');
    $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
    $image->move($uploadPath, $filename);
    $data['image'] = 'brands/' . $filename;
}
```

### Deleting Images
Simple unlink operation:
```php
if ($brand->image && file_exists(public_path('uploads/' . $brand->image))) {
    unlink(public_path('uploads/' . $brand->image));
}
```

### Displaying Images
Models use asset() helper:
```php
public function getImageUrlAttribute(): string
{
    if ($this->image) {
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }
        
        return asset('uploads/' . $this->image);
    }
    
    return asset('assets/media/svg/files/blank-image.svg');
}
```

## Database Storage
Images are stored in the database as relative paths:
- `avatars/1234567890_abc123.jpg`
- `brands/1234567890_abc123.png`
- `constructeurs/1234567890_abc123.jpg`

## Accessing Images
Images are publicly accessible at:
- `http://localhost:8000/uploads/brands/1234567890_abc123.png`
- `http://localhost:8000/uploads/avatars/1234567890_abc123.jpg`

## Production Deployment
Simply upload the `uploads/` folder to your server. Images will be accessible at:
- `https://pyasat.blinkagency.ma/uploads/brands/filename.jpg`
