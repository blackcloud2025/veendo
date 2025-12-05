@extends('layout')

@section('Titulo', 'Confirmar Orden')

@section('styles')
@vite('resources/css/cart.css')
@vite('resources/css/payform.css')
@endsection

@section('Contenido')
<div class="modal-overlay">
    <div class="modal-content">
        <div class="ticket-header">
            <h2>TICKET DE COMPRA</h2>
            <p style="color: #666; margin: 0; font-size: 12px;">Veendo Shop</p>
        </div>

        <div id="ticket-content">
            <div style="margin-bottom: 15px;">
                <p style="font-size: 12px; color: #666;">
                    <strong>Cliente:</strong> {{ Auth::user()->name }}<br>
                    <strong>Email:</strong> {{ Auth::user()->email }}<br>
                    <strong>Fecha:</strong> {{ now()->format('d/m/Y H:i') }}
                </p>
            </div>

            <div style="border-top: 1px solid #eee; padding-top: 10px;">
                @foreach($products as $product)
                <div class="ticket-item">
                    <div class="ticket-item-name">
                        <strong>{{ $product['name'] }}</strong>
                        <div class="ticket-item-qty">Qty: {{ $product['quantity'] }} x ${{ number_format($product['price'], 2) }}</div>
                    </div>
                    <div style="text-align: right;">
                        <div>${{ number_format($product['total'], 2) }}</div>
                        @if($product['offer'] > 0)
                        <div style="font-size: 11px; color: #27ae60;">-{{ $product['offer'] }}%</div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            <div class="ticket-totals">
                <div class="total-row">
                    <span>Subtotal:</span>
                    <span>${{ number_format($cartSubtotal, 2) }}</span>
                </div>
                @if($cartDiscount > 0)
                <div class="total-row discount-row">
                    <span>Descuento:</span>
                    <span>-${{ number_format($cartDiscount, 2) }}</span>
                </div>
                @endif
                <div class="final-total">
                    <div style="display: flex; justify-content: space-between;">
                        <span>TOTAL:</span>
                        <span>${{ number_format($cartTotal, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="loading" id="loading">
            <div class="spinner"></div>
            <p>Procesando...</p>
        </div>

        <div class="modal-actions">
            <button class="btn-modal btn-save" onclick="saveOrder()">
                <i class="fas fa-save"></i> Guardar Venta
            </button>
            <button class="btn-modal btn-print" onclick="printTicket()">
                <i class="fas fa-print"></i> Imprimir
            </button>
            <form action="{{ route('carrito') }}">
                @csrf
                 <button class="btn-modal btn-cancel" onclick="cancelOrder()">
                <i class="fas fa-times"></i> Cancelar
            </button>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
@vite('resources/js/payform.js')
@endsection