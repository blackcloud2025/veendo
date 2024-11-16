@extends('layout')

@section('Titulo','Product.')
@section('Contenido')
<x-trjrpod
    :images="$product->images"
    :name="$product->name"
    :description="$product->description"
    :offer="$product->offer"
    :price="$product->price"
    :category="$product->category"
    :color="$product->color"
    :size="$product->size"
    :model="$product->model"
    :version="$product->version"
    liga="Home"
    descriptionTitle="Descripcion:">
            
</x-trjrpod>



<h2 style="color: white; margin-left:30px; width: 300px;"> otros Productos: </h2>

<div class="contenedor">
    <div class="product-container">
        @foreach($relatedProducts as $relatedProduct)
        <div class="product-card">
            <div class="image-container">
                @if($relatedProduct->images->isNotEmpty())
                <img class="product-image" src="{{ Storage::url($relatedProduct->images->first()->image_path) }}" alt="{{ $relatedProduct->name }}">
                @endif
            </div>
            <div class="product-details">
                <p class="discount">OFF {{ $relatedProduct->offer }}%</p>
                <h3>{{ $relatedProduct->name }}</h3>
                <p class="price">Precio: ${{ $relatedProduct->price }}</p>
                <a href="{{ route('product.show', $relatedProduct->id) }}">Ver</a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection



