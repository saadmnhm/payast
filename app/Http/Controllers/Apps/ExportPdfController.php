<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Order;

class ExportPdfController extends Controller
{
    public function exportDevisPdf($id)
    {
        $order = Order::with(['items'])->findOrFail($id);

        $pdf = Pdf::loadView('admin.apps.devis.pdf', compact('order'));
        $pdf->setPaper('a4');

        return $pdf->stream('commande_' . $order->order_number . '.pdf');
    }
}
