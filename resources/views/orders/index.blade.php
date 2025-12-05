@extends('layout')

@section('Titulo', 'Mis Órdenes')

@section('styles')
@vite('resources/css/cart.css')
<style>
    .orders-container {
        max-width: 1000px;
        margin: 30px auto;
        padding: 20px;
    }

    .orders-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        border-bottom: 2px solid #007bff;
        padding-bottom: 15px;
    }

    .orders-header h1 {
        margin: 0;
        color: #333;
    }

    .orders-table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        border-radius: 8px;
        overflow: hidden;
    }

    .orders-table thead {
        background: #007bff;
        color: white;
    }

    .orders-table th {
        padding: 15px;
        text-align: left;
        font-weight: 600;
    }

    .orders-table td {
        padding: 15px;
        border-bottom: 1px solid #eee;
    }

    .orders-table tbody tr:hover {
        background-color: #f9f9f9;
    }

    .status-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
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

    .order-actions {
        display: flex;
        gap: 10px;
    }

    .btn-sm {
        padding: 6px 12px;
        font-size: 12px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s;
    }

    .btn-view {
        background-color: #17a2b8;
        color: white;
    }

    .btn-view:hover {
        background-color: #138496;
    }

    .btn-edit {
        background-color: #ffc107;
        color: #333;
    }

    .btn-edit:hover {
        background-color: #e0a800;
    }

    .btn-delete {
        background-color: #dc3545;
        color: white;
    }

    .btn-delete:hover {
        background-color: #c82333;
    }

    .pagination {
        display: flex;
        justify-content: center;
        gap: 5px;
        margin-top: 30px;
    }

    .pagination a, .pagination span {
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        color: #007bff;
        text-decoration: none;
    }

    .pagination .active {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #666;
    }

    .empty-state p {
        margin: 10px 0;
        font-size: 16px;
    }

    .btn-back {
        display: inline-block;
        margin-bottom: 20px;
        padding: 10px 20px;
        background-color: #6c757d;
        color: white;
        border-radius: 4px;
        text-decoration: none;
    }

    .btn-back:hover {
        background-color: #5a6268;
    }

    .summary-section {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-left: 4px solid #007bff;
    }

    .summary-total {
        font-size: 24px;
        font-weight: bold;
        color: #007bff;
    }

    .summary-label {
        color: #666;
        font-size: 14px;
    }

    .btn-export-pdf {
        background-color: #28a745;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        font-size: 14px;
        font-weight: 600;
    }

    .btn-export-pdf:hover {
        background-color: #218838;
    }

    .btn-complete {
        background-color: #007bff;
        color: white;
    }

    .btn-complete:hover {
        background-color: #0056b3;
    }

</style>
@endsection

@section('Contenido')
<div class="orders-container">
    <a href="{{ route('Home') }}" class="btn-back">← Volver</a>

    <div class="orders-header">
        <h1>
            @if(Auth::user()->role === 'admin' || Auth::user()->role === 'administrator')
                Todas las Órdenes
            @else
                Mis Órdenes
            @endif
        </h1>
        <a href="javascript:void(0)" onclick="exportarPDF()" class="btn-export-pdf">
            📄 Descargar PDF
        </a>
    </div>

    @if($orders->count() > 0)
        <div class="summary-section">
            <div>
                <div class="summary-label">Total de Ventas</div>
                <div class="summary-total">${{ number_format($orders->sum('total'), 2) }}</div>
            </div>
            <div style="color: #666;">
                Total de órdenes: <strong>{{ $orders->total() }}</strong>
            </div>
        </div>
        <div class="table-responsive">
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>ID Orden</th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td>${{ number_format($order->total, 2) }}</td>
                        <td>
                            <span class="status-badge status-{{ $order->status }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="order-actions">
                                <a href="{{ route('orders.show', $order->id) }}" class="btn-sm btn-view">
                                    Ver
                                </a>
                                @if(Auth::user()->role === 'admin' || Auth::user()->role === 'administrator')
                                    @if($order->status !== 'completado')
                                    <form action="{{ route('orders.update', $order->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="completado">
                                        <button type="submit" class="btn-sm btn-complete" onclick="return confirm('¿Marcar como completado?')">
                                            Completar
                                        </button>
                                    </form>
                                    @endif
                                    <a href="{{ route('orders.edit', $order->id) }}" class="btn-sm btn-edit">
                                        Editar
                                    </a>
                                    <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Estás seguro?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-sm btn-delete">
                                            Eliminar
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pagination">
            {{ $orders->links() }}
        </div>
    @else
        <div class="empty-state">
            <p>📦 No hay órdenes disponibles</p>
            <a href="{{ route('Home') }}" class="btn-back">Ir a comprar</a>
        </div>
    @endif
</div>

@endsection

@section('scripts')
<script>
function exportarPDF() {
    const table = document.querySelector('.orders-table');
    const html = `
        <html>
            <head>
                <title>Reporte de Órdenes</title>
                <style>
                    body { font-family: Arial, sans-serif; }
                    h1 { text-align: center; }
                    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                    th { background-color: #007bff; color: white; padding: 10px; text-align: left; }
                    td { padding: 10px; border-bottom: 1px solid #ddd; }
                    .summary { margin-top: 30px; text-align: right; font-weight: bold; }
                    .total { color: #007bff; font-size: 18px; }
                </style>
            </head>
            <body>
                <h1>Reporte de Órdenes</h1>
                <p>Fecha: ${new Date().toLocaleDateString('es-ES')}</p>
                ${table.outerHTML}
                <div class="summary">
                    <div class="total">
                        Total de Ventas: $${document.querySelector('.summary-total').textContent}
                    </div>
                </div>
            </body>
        </html>
    `;
    
    const printWindow = window.open('', '', 'width=1000,height=600');
    printWindow.document.write(html);
    printWindow.document.close();
    printWindow.print();
}
</script>
@endsection