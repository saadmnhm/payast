<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commande #{{ $order->order_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #333;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e31e24;
        }

        .header h1 {
            color: #e31e24;
            font-size: 24px;
            margin-bottom: 5px;
        }

        .info-section {
            margin-bottom: 20px;
        }

        .info-section h2 {
            font-size: 14px;
            color: #e31e24;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }

        .info-row {
            margin-bottom: 5px;
        }

        .info-label {
            font-weight: bold;
            color: #666;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table thead {
            background-color: #e31e24;
            color: white;
        }

        table th,
        table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        table th {
            font-weight: bold;
        }

        table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .total-section {
            margin-top: 20px;
            text-align: right;
        }

        .total-row {
            margin-bottom: 5px;
        }

        .total-label {
            font-weight: bold;
            margin-right: 20px;
        }

        .grand-total {
            font-size: 16px;
            color: #e31e24;
            font-weight: bold;
            padding-top: 10px;
            border-top: 2px solid #e31e24;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

    </style>
</head>

<body>
    <div class="header">
        <h1>COMMANDE #{{ $order->order_number }}</h1>
        <p>Date: {{ $order->created_at->format('d/m/Y') }}</p>
    </div>

    <div class="info-section">
        <h2>Informations Client</h2>
        <div class="info-row">
            <span class="info-label">Nom complet:</span>
            <span>{{ $order->first_name }} {{ $order->last_name }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Email:</span>
            <span>{{ $order->email }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Téléphone:</span>
            <span>{{ $order->phone }}</span>
        </div>
        @if($order->shipping_method === 'delivery')
        <div class="info-row">
            <span class="info-label">Adresse:</span>
            <span>{{ $order->address }}, {{ $order->city }} {{ $order->postcode }}</span>
        </div>
        @endif
    </div>

    <div class="info-section">
        <h2>Détails de la Commande</h2>
        <table>
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Référence</th>
                    <th style="text-align: center;">Quantité</th>
                    <th style="text-align: right;">Prix unitaire</th>
                    <th style="text-align: right;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product_name }}</td>
                    <td>{{ $item->product_reference ?? 'N/A' }}</td>
                    <td style="text-align: center;">{{ $item->quantity }}</td>
                    <td style="text-align: right;">{{ number_format($item->price, 2) }} DH</td>
                    <td style="text-align: right;">{{ number_format($item->price * $item->quantity, 2) }} DH</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="total-section">
        <div class="total-row">
            <span class="total-label">Sous-total:</span>
            <span>{{ number_format($order->subtotal, 2) }} DH</span>
        </div>
        <div class="total-row">
            <span class="total-label">Livraison:</span>
            <span>{{ number_format($order->shipping_cost, 2) }} DH</span>
        </div>
        @if(isset($order->tax) && $order->tax > 0)
        <div class="total-row">
            <span class="total-label">TVA (20%):</span>
            <span>{{ number_format($order->tax, 2) }} DH</span>
        </div>
        @endif
        <div class="total-row grand-total">
            <span class="total-label">TOTAL:</span>
            <span>{{ number_format($order->total, 2) }} DH</span>
        </div>
    </div>

    <div class="footer">
        <p>Merci pour votre commande | {{ config('app.name', 'pyassat') }}</p>
    </div>
</body>

</html>
