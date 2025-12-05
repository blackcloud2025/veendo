@extends('layout')

@section('Titulo', 'Detalle de Orden #' . $order->id)

@section('styles')
@vite('resources/css/cart.css')
<style>
    .order-detail-container {
        max-width: 900px;
        margin: 30px auto;
        padding: 20px;
    }

    .order-detail-header {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }

    .order-detail-header h1 {
        margin: 0 0 20px 0;
        color: #333;
    }

    .order-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 20px;
    }

    .info-item {
        padding: 15px;
        background: #f9f9f9;
        border-radius: 4px;
        border-left: 4px solid #007bff;
    }

    .info-item label {
        display: block;
        font-weight: 600;
        color: #666;
        font-size: 12px;
        text-transform: uppercase;
        margin-bottom: 5px;
    }

    .info-item value {
        display: block;
        font-size: 16px;
        color: #333;
    }

    .status-badge {
        display: inline-block;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .status-pendiente {
        background-color: #fff3cd;
        color: #856404;
    }

    .status-procesando {
        background-color: #e2e3e5;
        color: #383d41;
    }

    .status-completado {
        background-color: #d4edda;
        color: #155724;
    }

    .status-cancelado {
        background-color: #f8d7da;
        color: #721c24;
    }

    .order-items {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }

    .order-items h2 {
        margin-top: 0;
        color: #333;
        border-bottom: 2px solid #007bff;
        padding-bottom: 10px;
    }

    .item-row {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1fr 1fr;
        gap: 15px;
        padding: 15px 0;
        border-bottom: 1px solid #eee;
        align-items: center;
    }

    .item-row:last-child {
        border-bottom: none;
    }

    .item-header {
        font-weight: 600;
        color: #666;
        font-size: 12px;
        text-transform: uppercase;
    }

    .order-summary {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #eee;
    }

    .summary-row:last-child {
        border-bottom: none;
    }

    .summary-row.total {
        font-weight: bold;
        font-size: 18px;
        color: #007bff;
        padding-top: 15px;
        border-top: 2px solid #007bff;
    }

    .order-actions {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }

    .btn {
        padding: 12px 24px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-back {
        background-color: #6c757d;
        color: white;
    }

    .btn-back:hover {
        background-color: #5a6268;
    }

    .btn-edit {
        background-color: #ffc107;
        color: #333;
    }

    .btn-edit:hover {
        background-color: #e0a800;
    }

    .btn-pdf {
        background-color: #dc3545;
        color: white;
    }

    .btn-pdf:hover {
        background-color: #c82333;
    }

    .btn-delete {
        background-color: #dc3545;
        color: white;
    }

    .btn-delete:hover {
        background-color: #c82333;
    }

    .customer-info {
        background: #f0f7ff;
        padding: 15px;
        border-radius: 4px;
        border-left: 4px solid #0056b3;
    }

    .customer-info h3 {
        margin: 0 0 10px 0;
        color: #0056b3;
    }

    .customer-info p {
        margin: 5px 0;
        color: #333;
    }
</style>
@endsection

@section('Contenido')
<div class="order-detail-container">
    <a href="{{ route('orders.index') }}" class="btn btn-back">← Volver a Órdenes</a>

    <div class="order-detail-header">
        <h1>Orden #{{ $order->id }}</h1>

        <div class="order-info-grid">
            <div class="info-item">
                <label>Estado</label>
                <span class="status-badge status-{{ $order->status }}">
                    {{ ucfirst($order->status) }}
                </span>
            </div>

            <div class="info-item">
                <label>Fecha</label>
                <value>{{ $order->created_at->format('d/m/Y H:i') }}</value>
            </div>

            <div class="info-item">
                <label>Total</label>
                <value>${{ number_format($order->total, 2) }}</value>
            </div>
        </div>

        <div class="customer-info">
            <h3>Información del Cliente</h3>
            <p><strong>Nombre:</strong> {{ $order->user->name }}</p>
            <p><strong>Email:</strong> {{ $order->user->email }}</p>
            <p><strong>Teléfono:</strong> {{ $order->user->phone ?? 'No proporcionado' }}</p>
        </div>
    </div>

    <div class="order-items">
        <h2>Productos</h2>

        @if(count($order->items) > 0)
            <div class="item-row">
                <div class="item-header">Producto</div>
                <div class="item-header">Cantidad</div>
                <div class="item-header">Precio</div>
                <div class="item-header">Descuento</div>
                <div class="item-header">Total</div>
            </div>

            @foreach($order->items as $item)
            <div class="item-row">
                <div><strong>{{ $item['name'] }}</strong></div>
                <div>{{ $item['quantity'] }}</div>
                <div>${{ number_format($item['price'], 2) }}</div>
                <div>
                    @if($item['discount'] > 0)
                        -${{ number_format($item['discount'], 2) }}
                        ({{ $item['offer'] ?? 0 }}%)
                    @else
                        -
                    @endif
                </div>
                <div>${{ number_format($item['total'], 2) }}</div>
            </div>
            @endforeach
        @else
            <p>No hay productos en esta orden.</p>
        @endif
    </div>

    <div class="order-summary">
        <h2 style="margin-top: 0;">Resumen</h2>

        <div class="summary-row">
            <span>Subtotal:</span>
            <span>${{ number_format($order->subtotal, 2) }}</span>
        </div>

        @if($order->discount > 0)
        <div class="summary-row">
            <span>Descuento:</span>
            <span>-${{ number_format($order->discount, 2) }}</span>
        </div>
        @endif

        <div class="summary-row total">
            <span>Total Final:</span>
            <span>${{ number_format($order->total, 2) }}</span>
        </div>
    </div>

    <div class="order-actions">
        <a href="{{ route('orders.downloadPdf', $order->id) }}" class="btn btn-pdf">
            📥 Descargar PDF
        </a>

        @if(Auth::user()->role === 'admin' || Auth::user()->role === 'administrator')
            <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-edit">
                ✏️ Editar Estado
            </a>

            <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta orden?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-delete">
                    🗑️ Eliminar
                </button>
            </form>
        @endif
    </div>
</div>

@endsection
