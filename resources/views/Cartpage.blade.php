@extends('layout')

@section('Titulo','my cart.')

@section('styles')
@vite('resources/css/Cart.css')
@endsection

@section('Contenido')
<div class="container py-5">
    <h1 class="mb-4">Mi Carrito de Compras</h1>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    @if(isset($products) && count($products) > 0)
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Imagen</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Subtotal</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td>
                                        <a href="{{ route('product.show', $product->id) }}">{{ $product->name }}</a>
                                    </td>
                                    <td>
                                        @if($product->images->count() > 0)
                                            <img src="{{ asset('storage/' . $product->images[0]->image_path) }}" 
                                                alt="{{ $product->name }}" 
                                                style="width: 80px; height: auto;">
                                        @else
                                            <span>Sin imagen</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($product->offer)
                                            <span class="text-decoration-line-through">${{ number_format($product->price, 2) }}</span>
                                            <span class="text-danger">${{ number_format($product->offer, 2) }}</span>
                                        @else
                                            ${{ number_format($product->price, 2) }}
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('cart.update') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $product->id }}">
                                            <div class="input-group" style="width: 120px;">
                                                <input type="number" name="quantity" class="form-control form-control-sm" 
                                                    value="{{ $product->quantity }}" min="1">
                                                <div class="input-group-append">
                                                    <button class="btn btn-sm btn-outline-secondary" type="submit">
                                                        <i class="fas fa-sync-alt"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </td>
                                    <td>
                                        @php
                                            $price = $product->offer ? $product->offer : $product->price;
                                            $subtotal = $price * $product->quantity;
                                        @endphp
                                        ${{ number_format($subtotal, 2) }}
                                    </td>
                                    <td>
                                        <form action="{{ route('cart.remove') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $product->id }}">
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bx bx-trash"></i> Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-right font-weight-bold">Total:</td>
                                <td colspan="2" class="font-weight-bold">${{ number_format($total, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <div class="d-flex justify-content-between mt-4">
                    <form action="{{ route('cart.clear') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-trash"></i> Vaciar carrito
                        </button>
                    </form>
                    
                    <a href="#" class="btn btn-success">
                        <i class="fas fa-shopping-cart"></i> Proceder al pago
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="bx bx-cart"></i>
                <h3>El carrito está vacío</h3>
                <p>Parece que aún no has agregado productos a tu carrito.</p>
                <a href="{{ route('Home') }}" class="btn btn-primary mt-3">
                    Continuar comprando
                </a>
            </div>
        </div>
    @endif
</div>
@endsection

@section('scripts')
@endsection