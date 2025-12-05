@extends('layout')
@section('Titulo','mis ventas.')

@section('styles')
@vite('resources/css/Prodcard.css')
@endsection

@section('Contenido')


<div class="action-bar">
    <a href="{{route('subirproducto')}}">
        <i class='bx bxs-file-plus'></i>
        <span class="text nav-text">Subir producto.</span>
    </a>
</div>
<div class="action-bar" style="padding-left: 50px; padding-top: 7px; color:var(--text-color)"><h1> Mis productos.</h1></div>


<div class="Contenedor">
    <div class="product-container">
        <!-- tarjeta que muestra el contenido -->
        @foreach($products as $product)
        <div class="product-card" data-id="{{$product->id}}">
        <div class="image-container">
            @if($product->images->isNotEmpty())
            <img loading="lazy" clr src="{{Storage::url($product->images->first()->image_path) }}" alt="{{ $product->name }}">
            @endif
        </div>
            <div class="product-details">
            <p class="discount">OFF {{ $product->offer }}%</p>
            <h3>{{ $product->name }}</h3>
            
            <!--hay que hacer que no se desborde el precio--> 
            <p class="price">${{ $product->price }}</p>

            <!-- boton para editar el producto -->    
                <form action="{{ route('editar', $product->id) }}">
                    @csrf
                    <button type="submit">
                        <i class='bx bxs-edit-alt'></i>
                        <span class="text nav-text"> Editar.</span>
                    </button>
                </form>


                <!-- Formulario para eliminar producto -->
                <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit">
                        <i class='bx bxs-trash'></i>
                        <span class="text nav-text"> Borrar.</span>
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>

<div class="action-bar">
    <a href="{{ route('orders.index') }}">
        <i class='bx bxs-file-plus'></i>
        <span class="text nav-text"> Ver Órdenes</span>
    </a>
</div>

@endsection