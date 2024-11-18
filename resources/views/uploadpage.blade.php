@extends('layout')

@section('Titulo', 'Subir producto')

@section('Contenido')


<div class="containerform">
    <div class="form-wrapper">
        <h1 class="page-title">Subir Producto</h1>
        
        <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-grid">
                <!-- Nombre del Producto -->
                <div class="form-group full-width">
                    <label class="form-label" for="name">Nombre del Producto</label>
                    <input type="text" id="name" name="name" required class="form-control">
                </div>
                
                <!-- Descripción -->
                <div class="form-group full-width">
                    <label class="form-label" for="description">Descripción</label>
                    <textarea id="description" name="description" required class="form-control"></textarea>
                </div>

                <!-- Precio -->
                <div class="form-group">
                    <label class="form-label" for="price">Precio</label>
                    <div class="price-input-wrapper">
                        <input type="number" id="price" name="price" step="0.01" required class="form-control price-input">
                    </div>
                </div>

                <!-- Descuento -->
                <div class="form-group">
                    <label class="form-label" for="offer">Porcentaje de descuento</label>
                    <div class="percentage-input-wrapper">
                        <input type="number" id="offer" name="offer" class="form-control">
                    </div>
                </div>

                <!-- Categoría -->
                <div class="form-group">
                    <label class="form-label" for="category">Categoría</label>
                    <input type="text" id="category" name="category" class="form-control">
                </div>

                <!-- Color -->
                <div class="form-group">
                    <label class="form-label" for="color">Color</label>
                    <input type="text" id="color" name="color" class="form-control">
                </div>

                <!-- Tamaño -->
                <div class="form-group">
                    <label class="form-label" for="size">Tamaño o talla</label>
                    <input type="text" id="size" name="size" class="form-control">
                </div>

                <!-- Modelo -->
                <div class="form-group">
                    <label class="form-label" for="model">Modelo</label>
                    <input type="text" id="model" name="model" class="form-control">
                </div>

                <!-- Versión -->
                <div class="form-group">
                    <label class="form-label" for="version">Versión</label>
                    <input type="text" id="version" name="version" class="form-control">
                </div>

                <!-- Subida de Imágenes -->
                <div class="form-group full-width">
                    <label class="form-label">Imágenes del Producto (máximo 10)</label>
                    <div class="upload-area" onclick="document.getElementById('images').click()">
                        <svg class="upload-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="upload-text"><span>Haz clic para subir</span> o arrastra y suelta</p>
                        <p class="upload-hint">PNG, JPG, GIF hasta 10 MB</p>
                        <input type="file" id="images" name="images[]" multiple accept="image/*" required 
                               style="display: none;">
                    </div>
                    <div id="imagePreview"></div>
                </div>
            </div>

            <div class="submit-wrapper">
                <button type="submit" class="submit-button">Subir Producto</button>
            </div>
        </form>
    </div>
</div>


@endsection

@section('scripts')
    @vite('resources/js/imageUploadPreview.js')
@endsection