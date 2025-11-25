<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Piece;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmation;

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
            'address' => 'required_if:shipping_method,delivery|nullable|string',
            'city' => 'required_if:shipping_method,delivery|nullable|string',
            'postcode' => 'nullable|string',
            'payment_method' => 'required|in:cash,card,transfer',
            'cart_items' => 'required|json'
        ], [
            'first_name.required' => 'Le prénom est obligatoire',
            'last_name.required' => 'Le nom est obligatoire',
            'email.required' => 'L\'email est obligatoire',
            'phone.required' => 'Le téléphone est obligatoire',
            'address.required_if' => 'L\'adresse est obligatoire pour la livraison',
            'city.required_if' => 'La ville est obligatoire pour la livraison',
        ]);

        try {
            DB::beginTransaction();

            $cartItems = json_decode($request->cart_items, true);
            
            if (empty($cartItems)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Votre panier est vide'
                ], 400);
            }

            $subtotal = 0;
            $orderItems = [];

            foreach ($cartItems as $item) {
                $piece = Piece::where('name', $item['product'])->first();
                
                if (!$piece) {
                    throw new \Exception("Produit non trouvé: {$item['product']}");
                }

                $quantity = $item['quantity'] ?? 1;
                if ($piece->stock < $quantity) {
                    throw new \Exception("Stock insuffisant pour {$piece->name}");
                }

                $itemPrice = $item['price'];
                $itemSubtotal = $itemPrice * $quantity;
                $subtotal += $itemSubtotal;

                $orderItems[] = [
                    'piece_id' => $piece->id,
                    'product_name' => $piece->name,
                    'product_reference' => $piece->reference,
                    'price' => $itemPrice,
                    'quantity' => $quantity,
                    'subtotal' => $itemSubtotal
                ];

                // Decrease stock
                $piece->decrement('stock', $quantity);
            }

            $shippingCost = $validated['shipping_method'] === 'delivery' ? 30.00 : 0.00;
            $tax = $subtotal * 0.20;
            $total = $subtotal + $shippingCost + $tax;

            // Create order
            $order = Order::create([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'shipping_method' => $validated['shipping_method'],
                'address' => $validated['address'] ?? null,
                'city' => $validated['city'] ?? null,
                'postcode' => $validated['postcode'] ?? null,
                'country' => $validated['country'] ?? 'MA',
                'payment_method' => $validated['payment_method'],
                'status' => 'pending',
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'tax' => $tax,
                'total' => $total
            ]);

            // Create order items
            foreach ($orderItems as $itemData) {
                $order->items()->create($itemData);
            }

            // Send confirmation email
            try {
                Mail::to($order->email)->send(new OrderConfirmation($order));
            } catch (\Exception $e) {
                \Log::error('Failed to send order confirmation email: ' . $e->getMessage());
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Votre commande a été enregistrée avec succès',
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'redirect' => route('front.order.success', ['order' => $order->id])
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue: ' . $e->getMessage()
            ], 500);
        }
    }

    public function success($orderId)
    {
        $order = Order::with('items.piece')->findOrFail($orderId);
        return view('front.checkout.success', compact('order'));
    }
}