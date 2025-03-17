@extends('layout')

@section('Titulo', 'Mi Carrito')

@section('styles')
@vite('resources/css/cart.css')
@endsection

@section('Contenido')
<div class="container">
    <h1 class="cart-title">Mi Carrito de Compras</h1>


    @if(isset($products) && count($products) > 0)
    <div class="cart-card">
        <div class="cart-items">
            @php
            $cartSubtotal = 0;
            $cartDiscount = 0;
            $cartTotal = 0;
            @endphp

            @foreach($products as $product)
            <div class="cart-item">
                <div class="cart-item-image">
                    @if($product->images->count() > 0)
                    <img src="{{ asset('storage/' . $product->images[0]->image_path) }}"
                        alt="{{ $product->name }}" class="product-image">
                    @else
                    <div class="no-image">Sin imagen</div>
                    @endif
                </div>
                
                <div class="cart-item-details">
                    <h3 class="product-name">
                        <a href="{{ route('product.show', $product->id) }}">{{ $product->name }}</a>
                    </h3>
                    <div class="product-price">
                        @if($product->offer)
                        <span class="original-price">${{ number_format($product->price, 2) }}</span>
                        <span class="discount-badge">-{{ number_format($product->offer, 2) }}%</span>
                        @else
                        <span>${{ number_format($product->price, 2) }}</span>
                        @endif
                    </div>
                </div>

                <div class="cart-item-quantity">
                    <form action="{{ route('cart.update') }}" method="POST" class="quantity-form">
                        @csrf
                        <input type="hidden" name="id" value="{{ $product->id }}">
                        <div class="quantity-control">
                            <button type="button" class="quantity-btn quantity-decrease" onclick="decreaseQuantity(this)">-</button>
                            <input type="number" name="quantity" class="quantity-input"
                                value="{{ $product->quantity }}" min="1">
                            <button type="button" class="quantity-btn quantity-increase" onclick="increaseQuantity(this)">+</button>
                        </div>
                        <button class="update-btn" type="submit">
                            <i class="fas fa-sync-alt"></i>
                            <span class="sr-only">Actualizar</span>
                        </button>
                    </form>
                </div>

                <div class="cart-item-totals">
                    @php
                    $price = $product->price;
                    $subtotal = $price * $product->quantity;
                    $discountPercentage = $product->offer;
                    $discountAmount = $subtotal * ($discountPercentage / 100);
                    $total = $subtotal - $discountAmount;
                    
                    $cartSubtotal += $subtotal;
                    $cartDiscount += $discountAmount;
                    $cartTotal += $total;
                    @endphp

                    <div class="item-price-details">
                        <div>Subtotal: <span>${{ number_format($subtotal, 2) }}</span></div>
                        @if($product->offer)
                        <div>Descuento: <span class="discount-amount">-${{ number_format($discountAmount, 2) }}</span></div>
                        @endif
                        <div class="item-total">Total: <span>${{ number_format($total, 2) }}</span></div>
                    </div>
                </div>

                <div class="cart-item-actions">
                    <form action="{{ route('cart.remove') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $product->id }}">
                        <button type="submit" class="remove-btn">
                            <i class="fas fa-trash"></i>
                            Eliminar
                        </button>
                    </form>
                </div>
            </div>
            <div class="separator"></div>
            @endforeach
        </div>
            
        <div class="order-summary">
            <div class="summary-content">
                <h4 class="summary-title">Resumen del pedido</h4>
                <div class="summary-row">
                    <span>Subtotal:</span>
                    <span>${{ number_format($cartSubtotal, 2) }}</span>
                </div>
                <div class="summary-row discount-row">
                    <span>Descuento total:</span>
                    <span>-${{ number_format($cartDiscount, 2) }}</span>
                </div>
                <div class="separator"></div>
                <div class="summary-row total-row">
                    <span>Total a pagar:</span>
                    <span>${{ number_format($cartTotal, 2) }}</span>
                </div>
            </div>
        </div>
            
        <div class="cart-actions">
            <form action="{{ route('cart.clear') }}" method="POST">
                @csrf
                <button type="submit" class="clear-cart-btn">
                    <i class="fas fa-trash"></i>
                    Vaciar carrito
                </button>
            </form>
                
            <a href="#" class="checkout-btn">
                <i class="fas fa-shopping-cart"></i>
                Proceder al pago
            </a>
        </div>
    </div>
    @else
    <div class="cart-card empty-cart">
        <div class="empty-cart-content">
            <div class="empty-cart-icon">
                <i class="fas fa-shopping-bag"></i>
            </div>
            <h3 class="empty-cart-title">El carrito está vacío</h3>
            <p class="empty-cart-message">Parece que aún no has agregado productos a tu carrito.</p>
            <a href="{{ route('Home') }}" class="continue-shopping-btn">
                Continuar comprando
            </a>
        </div>
    </div>
    @endif
</div>
@endsection

@section('scripts')
@vite('resources/js/cart.js')
@endsection

