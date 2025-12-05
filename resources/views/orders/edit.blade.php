@extends('layout')

@section('Titulo', 'Editar Orden #' . $order->id)

@section('styles')
@vite('resources/css/cart.css')
<style>
    .edit-container {
        max-width: 600px;
        margin: 40px auto;
        padding: 20px;
    }

    .edit-form {
        background: white;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.1);
    }

    .edit-form h1 {
        margin-top: 0;
        color: #333;
        border-bottom: 2px solid #007bff;
        padding-bottom: 15px;
    }

    .order-info {
        background: #f9f9f9;
        padding: 15px;
        border-radius: 4px;
        margin-bottom: 25px;
        border-left: 4px solid #007bff;
    }

    .order-info p {
        margin: 8px 0;
        color: #333;
    }

    .order-info strong {
        color: #666;
        font-weight: 600;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .form-group select {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
        font-family: inherit;
        transition: border-color 0.3s;
    }

    .form-group select:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
    }

    .status-info {
        background: #e7f3ff;
        padding: 12px;
        border-radius: 4px;
        margin-bottom: 20px;
        border-left: 4px solid #2196F3;
        font-size: 14px;
        color: #1565c0;
    }

    .form-actions {
        display: flex;
        gap: 10px;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 2px solid #eee;
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
        flex: 1;
        text-align: center;
    }

    .btn-submit {
        background-color: #28a745;
        color: white;
    }

    .btn-submit:hover {
        background-color: #218838;
    }

    .btn-cancel {
        background-color: #6c757d;
        color: white;
    }

    .btn-cancel:hover {
        background-color: #5a6268;
    }

    .admin-badge {
        display: inline-block;
        background-color: #ffc107;
        color: #333;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
        margin-left: 10px;
    }

    .status-descriptions {
        background: #f0f7ff;
        padding: 15px;
        border-radius: 4px;
        margin-top: 15px;
        font-size: 13px;
    }

    .status-descriptions dt {
        font-weight: 600;
        color: #0056b3;
        margin-top: 8px;
    }

    .status-descriptions dd {
        margin-left: 0;
        color: #666;
        font-size: 12px;
    }
</style>
@endsection

@section('Contenido')
<div class="edit-container">
    <a href="{{ route('orders.show', $order->id) }}" style="display: inline-block; margin-bottom: 20px; padding: 8px 16px; background: #6c757d; color: white; border-radius: 4px; text-decoration: none;">← Volver</a>

    <div class="edit-form">
        <h1>
            Editar Orden #{{ $order->id }}
            <span class="admin-badge">🔐 ADMIN ONLY</span>
        </h1>

        <div class="order-info">
            <p><strong>Cliente:</strong> {{ $order->user->name }} ({{ $order->user->email }})</p>
            <p><strong>Total:</strong> ${{ number_format($order->total, 2) }}</p>
            <p><strong>Fecha Creación:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Estado Actual:</strong> <span style="text-transform: uppercase; font-weight: bold; color: #007bff;">{{ $order->status }}</span></p>
        </div>

        <form action="{{ route('orders.update', $order->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="status-info">
                ℹ️ Cambia el estado de la orden para actualizar el seguimiento
            </div>

            <div class="form-group">
                <label for="status">Nuevo Estado</label>
                <select name="status" id="status" required>
                    <option value="">-- Selecciona un estado --</option>
                    @foreach($statuses as $status)
                        <option value="{{ $status }}" {{ $order->status === $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>

                @error('status')
                    <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>

            <div class="status-descriptions">
                <dt>📌 Descripción de Estados</dt>
                <dd>
                    <strong style="color: #0056b3;">Pendiente:</strong> Orden recibida, en espera de procesamiento<br>
                    <strong style="color: #0056b3;">Procesando:</strong> Orden en preparación<br>
                    <strong style="color: #0056b3;">Completado:</strong> Orden entregada al cliente<br>
                    <strong style="color: #0056b3;">Cancelado:</strong> Orden cancelada por cliente o administrador
                </dd>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-submit">
                    ✓ Guardar Cambios
                </button>
                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-cancel">
                    ✕ Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
