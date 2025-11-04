<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('front.checkout.index');
    }

    public function processOrder(Request $request)
    {
        $validated = $request->validate([
            'shipping_method' => 'required|in:pickup,delivery',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'address' => 'required_if:shipping_method,delivery',
            'city' => 'required_if:shipping_method,delivery',
            'postcode' => 'nullable|string',
            'payment_method' => 'required|in:cash,card,transfer',
        ]);

        // Process order logic here

        return response()->json([
            'success' => true,
            'message' => 'Commande enregistrée avec succès',
            'order_id' => rand(1000, 9999)
        ]);
    }
}