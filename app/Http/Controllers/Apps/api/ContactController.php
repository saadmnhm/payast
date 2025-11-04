<?php

namespace App\Http\Controllers\Apps\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Devis;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\DevisSubmitted;

class ContactController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }
        // Create new devis
        $devis = Devis::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->description,
            'is_read' => false
        ]);

        Mail::to('saad@blinkagency.ma')->send(new DevisSubmitted($devis));

        return response()->json([
            'success' => true,
            'message' => 'Devis créé avec succès',
            'data' => $devis
        ], 201);
    }



}
