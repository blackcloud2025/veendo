@extends('layout')

@section('Titulo','subir producto.')

@section('Contenido')

    <div class="product-upload-form">
        <h1>Subir Producto</h1>
        <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div>
                <label for="name">Nombre del Producto:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div>
                <label for="description">Descripción:</label>
                <textarea id="description" name="description" required></textarea>
            </div>
            <div>
                <label for="price">Precio:</label>
                <input type="number" id="price" name="price" step="0.01" required>
            </div>
            <div>
                <label for="offer">porcentaje de descuento(opcional).</label>
                <input type="number" id="offer" name="offer">
            </div>
            <div>
                <label for="category">categoria:</label>
                <input type="text" id="category" name="category">
            </div>
            <div>
                <label for="images">Imágenes del Producto (máximo 10):</label>
                <input type="file" id="images" name="images[]" multiple accept="image/*" required>
            </div>
            <button type="submit">Subir Producto</button>
        </form>
    </div>

@endsection