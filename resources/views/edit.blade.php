@extends('layout')

@section('Titulo','mis ventas.')

@section('styles')
    @vite('resources/css/uploadForm.css')
@endsection

@section('Contenido')

<div class="product-upload-form">
    <h1 style="color: white;">editar producto.</h1>
    <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div>
            <label for="name">Nombre</label>
            <input type="text" name="name" value="{{ $product->name }}" required>
        </div>
        <div>
            <label for="description">Descripción</label>
            <textarea name="description" required>{{ $product->description }}</textarea>
        </div>
        <div>
            <label for="price">Precio</label>
            <input type="number" step="0.01" name="price" value="{{ $product->price }}" required>
        </div>
        <div>
            <label for="offer">Oferta</label>
            <input type="number" step="0.01" name="offer" value="{{ $product->offer }}">
        </div>
        <div>
            <label for="category">Categoría</label>
            <input type="text" name="category" value="{{ $product->category }}">
        </div>
        <div>
            <label for="color">Color</label>
            <input type="text" name="color" value="{{ $product->color }}">
        </div>
        <div>
            <label for="size">Tamaño</label>
            <input type="text" name="size" value="{{ $product->size }}">
        </div>
        <div>
            <label for="model">Modelo</label>
            <input type="text" name="model" value="{{ $product->model }}">
        </div>
        <div>
            <label for="version">Versión</label>
            <input type="text" name="version" value="{{ $product->version }}">
        </div>
        <div>
            <label for="images">Imágenes</label>
            <input type="file" name="images[]" multiple>
        </div>
        <button type="submit">Actualizar Producto</button>
    </form>
</div>
@endsection

@section('scripts')
    @vite('resources/js/uploadImageBox.js')
@endsection