<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .ticket-header {
            text-align: center;
            border-bottom: 3px solid #333;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }

        .ticket-header h1 {
            margin: 0 0 5px 0;
            font-size: 28px;
        }

        .ticket-header p {
            margin: 5px 0;
            color: #666;
        }

        .customer-info {
            background: #f5f5f5;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .customer-info p {
            margin: 5px 0;
            font-size: 13px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .items-table th {
            background: #333;
            color: white;
            padding: 10px;
            text-align: left;
            font-weight: bold;
        }

        .items-table td {
            padding: 12px 10px;
            border-bottom: 1px solid #ddd;
        }

        .items-table .text-right {
            text-align: right;
        }

        .totals {
            border-top: 3px solid #333;
            padding-top: 15px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-weight: bold;
        }

        .discount-row {
            color: #27ae60;
        }

        .final-total {
            background: #333;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 20px;
            border-radius: 5px;
            margin-top: 15px;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            font-size: 12px;
            color: #666;
        }

        .order-number {
            font-size: 14px;
            text-align: center;
            margin-top: 20px;
            padding: 10px;
            background: #f0f0f0;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="ticket-header">
        <h1>TICKET DE COMPRA</h1>
        <p>Veendo Shop</p>
        <p style="font-size: 12px;">{{ config('app.name') }}</p>
    </div>

    <div class="customer-info">
        <p><strong>Cliente:</strong> {{ $order->user->name }}</p>
        <p><strong>Email:</strong> {{ $order->user->email }}</p>
        <p><strong>Teléfono:</strong> {{ $order->user->phone ?? 'N/A' }}</p>
        <p><strong>Fecha:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
    </div>

    <table class="items-table">
        <thead>
            <tr>
                <th>Producto</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Precio</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>
                    <strong>{{ $item['name'] }}</strong>
                    @if($item['offer'] > 0)
                    <br><span style="color: #27ae60; font-size: 12px;">Descuento: {{ $item['offer'] }}%</span>
                    @endif
                </td>
                <td class="text-right">{{ $item['quantity'] }}</td>
                <td class="text-right">${{ number_format($item['price'], 2) }}</td>
                <td class="text-right">${{ number_format($item['total'], 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <div class="total-row">
            <span>Subtotal:</span>
            <span>${{ number_format($order->subtotal, 2) }}</span>
        </div>
        @if($order->discount > 0)
        <div class="total-row discount-row">
            <span>Descuento Total:</span>
            <span>-${{ number_format($order->discount, 2) }}</span>
        </div>
        @endif

        <div class="final-total">
            TOTAL: ${{ number_format($order->total, 2) }}
        </div>
    </div>

    <div class="order-number">
        <strong>Número de Orden: #{{ $order->id }}</strong><br>
        Estado: {{ ucfirst($order->status) }}
    </div>

    <div class="footer">
        <p>Gracias por su compra</p>
        <p>{{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html>
