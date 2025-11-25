<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Contact;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\contactExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $query = Contact::orderby('created_at');

        if ($request->has('filters')) {
            $filters = $request->input('filters');

            if (isset($filters['read_status'])) {
                $readStatuses = $filters['read_status'];

                if (!(in_array('read', $readStatuses) && in_array('unread', $readStatuses))) {
                    if (in_array('read', $readStatuses)) {
                        $query->where('is_read', true);
                    } elseif (in_array('unread', haystack: $readStatuses)) {
                        $query->where('is_read', false);
                    }
                }
            }

        }

        $contact = $query->orderBy('created_at', 'desc')->get();

        return view('admin.apps.contact.index', [
            'contact' => $contact,
            'filters' => $request->input('filters', [])
        ]);
    }

    public function show($id)
    {
        $contact = contact::findOrFail($id);

        if (!$contact->is_read) {
            $contact->update([
                'is_read' => true,
                'read_by_user_id' => auth()->id(),
                'read_at' => now(),
            ]);
        }

        return view('admin.apps.contact.show', compact('contact'));
    }



    public function exportReturnPdf($id)
    {
        $contact = contact::findOrFail($id);

        $pdf = Pdf::loadView('admin.apps.contact.render-vous-pdf', compact('contact'));
        $pdf->setPaper('a4');

        return $pdf->stream('fiche_retour_' . $contact->first_name . '_' . $contact->last_name . '.pdf');
    }
}
