@extends('layout')

@section('Titulo','mis ventas.')

@section('styles')
@vite('resources/css/uploadForm.css')
@endsection

@section('Contenido')

<div class="containerform">
    <div class="form-wrapper">
        <h1 style="font-size: 24px; color: var(--text-color); margin-bottom: 1.5rem; font-weight: bold;">editar producto.</h1>
        <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group full-width">
                <label class="form-label" for="name">Nombre</label>
                <input class="form-control type=" text" name="name" value="{{ $product->name }}" required>
            </div>
            <div class="form-group full-width">
                <label class="form-label" for="description">Descripción</label>
                <textarea class="form-control" name="description" required>{{ $product->description }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label" for="price">Precio</label>
                <div class="price-input-wrapper">
                    <input class="form-control price-input" type="number" step="0.01" name="price" value="{{ $product->price }}" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="offer">Oferta</label>
                <div class="percentage-input-wrapper">
                    <input class="form-control" type="number" step="0.01" name="offer" value="{{ $product->offer }}">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="category">Categoría</label>
                <input class="form-control" type="text" name="category" value="{{ $product->category }}">
            </div>

            <div class="form-group">
                <label class="form-label" for="color">Color</label>
                <input class="form-control" type="text" name="color" value="{{ $product->color }}">
            </div>

            <div class="form-group">
                <label class="form-label" for="size">Tamaño</label>
                <input class="form-control" type="text" name="size" value="{{ $product->size }}">
            </div>

            <div class="form-group">
                <label class="form-label" for="model">Modelo</label>
                <input class="form-control" type="text" name="model" value="{{ $product->model }}">
            </div>

            <div class="form-group">
                <label class="form-label" for="version">Versión</label>
                <input class="form-control" type="text" name="version" value="{{ $product->version }}">
            </div>

            <!-- Subida de Imágenes -->
            <div class="form-group full-width">
                <label class="form-label">Imágenes del Producto (máximo 10)</label>
                <div class="upload-area" id="dropZone" onclick="document.getElementById('images').click()">
                    <svg class="upload-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="upload-text"><span>Haz clic para subir</span> o arrastra y suelta</p>
                    <p class="upload-hint">PNG, JPG, GIF hasta 10 MB</p>

                    <input type="file" id="images" name="images[]" multiple accept="image/*" required style="opacity: 0; position: absolute;">
                    <div id="imagePreview"></div>
                </div>
            </div>
            
            
            <div class="submit-wrapper">
                <button class="submit-button" type="submit">Actualizar Producto</button>
            </div>
            

            <div id="notification" class="notification">
                <div class="notification-content">
                <span class="notification-message"></span>
                <span class="notification-close">&times;</span>
            </div>
            </div>

            <!--crear alerta o pop up para cuando se edite un producto-->
    </div>
    </form>
</div>
</div>
@endsection

@section('scripts')
@vite('resources/js/uploadImageBox.js')
@endsection