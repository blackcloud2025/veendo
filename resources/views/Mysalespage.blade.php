@extends('layout')
@section('Titulo','mis ventas.')
@section('Contenido')

<div class="action-bar">
    <a href="{{route('subirproducto')}}">
        <i class='bx bxs-file-plus'></i>
        <span class="text nav-text">Subir producto.</span>
    </a>
</div>

<div class="Contenedor">
    <div class="product-container">
        @foreach($products as $product)
        <div class="product-card" data-id="{{$product->id}}">
        <div class="image-container">
            @if($product->images->isNotEmpty())
            <img loading="lazy" clr src="{{Storage::url($product->images->first()->image_path) }}" alt="{{ $product->name }}">
            @endif
        </div>
            <!-- tarjeta que muestra el contenido -->
            <div class="product-details">
            <p class="discount">OFF {{ $product->offer }}%</p>
            <h3>{{ $product->name }}</h3>
            <p class="price">Precio: ${{ $product->price }}</p>

            <!-- boton para editar el producto -->    
                <a href="{{ route('editar', $product->id) }}">
                    <i class='bx bxs-edit-alt'></i>
                    <span class="text nav-text"> Editar. </span>
                </a>

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
    <a href="#">
        <i class='bx bxs-file-plus'></i>
        <span class="text nav-text"> poner graficas luego.</span>
    </a>
</div>

<div class="action-bar">
    <a href="#">
        <i class='bx bxs-file-plus'></i>
        <span class="text nav-text"> vere que agregar</span>
    </a>
</div>
@endsection