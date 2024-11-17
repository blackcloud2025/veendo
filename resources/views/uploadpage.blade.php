@extends('layout')

@section('Titulo', 'Subir producto')

@section('Contenido')
<style>
    .containerform {
        min-height: 100vh;
        padding: 2rem;
        background-color: var(--body-color);
    }

    .form-wrapper {
        max-width: 800px;
        margin: 0 auto;
        background: var(--navbar-color);
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .page-title {
        font-size: 24px;
        color: var(--text-color);
        margin-bottom: 1.5rem;
        font-weight: bold;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }

    @media (min-width: 768px) {
        .form-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group.full-width {
        grid-column: 1 / -1;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        color: var(--text-color);
        font-size: 0.875rem;
        font-weight: 500;
    }

    .form-control {
        width: 100%;
        padding: 0.5rem 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 4px;
        font-size: 0.875rem;
        transition: border-color 0.15s ease-in-out;
        background-color: var(--primary-color-light);
        color: var(--text-color);
    }

    .form-control:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    textarea.form-control {
        min-height: 100px;
        resize: vertical;
    }

    .price-input-wrapper {
        position: relative;
    }

    .price-input-wrapper::before {
        content: '$';
        position: absolute;
        left: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-color);
    }

    .price-input {
        padding-left: 1.5rem;
    }

    .percentage-input-wrapper {
        position: relative;
    }

    .percentage-input-wrapper::after {
        content: '%';
        position: absolute;
        right: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-color);
    }

    .upload-area {
        border: 2px dashed #d1d5db;
        padding: 2rem;
        border-radius: 8px;
        text-align: center;
        cursor: pointer;
        transition: background-color 0.15s ease-in-out;
    }

    .upload-area:hover {
        background-color: #f9fafb;
    }

    .upload-icon {
        width: 48px;
        height: 48px;
        margin: 0 auto 1rem;
        color: var(--text-color);
    }

    .upload-text {
        color: var(--text-color);
        margin-bottom: 0.5rem;
    }

    .upload-text span {
        color: #2563eb;
        font-weight: 500;
    }

    .upload-hint {
        color: var(--text-color);
        font-size: 0.75rem;
    }

    #imagePreview {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
    }

    .preview-item {
        position: relative;
        aspect-ratio: 1;
    }

    .preview-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 4px;
    }

    .remove-image {
        position: absolute;
        top: 0.25rem;
        right: 0.25rem;
        background: #ef4444;
        color: white;
        border: none;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.15s ease-in-out;
    }

    .preview-item:hover .remove-image {
        opacity: 1;
    }

    .submit-button {
        background-color: #2563eb;
        color: white;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 4px;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.15s ease-in-out;
    }

    .submit-button:hover {
        background-color: #1d4ed8;
    }

    .submit-wrapper {
        display: flex;
        justify-content: flex-end;
        margin-top: 2rem;
    }
</style>

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

<script>
document.getElementById('images').addEventListener('change', function(e) {
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = ''; // Limpiar preview existente
    
    if (this.files.length > 10) {
        alert('Solo puedes subir un máximo de 10 imágenes');
        this.value = '';
        return;
    }

    [...this.files].forEach(file => {
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'preview-item';
                
                div.innerHTML = `
                    <img src="${e.target.result}" class="preview-image">
                    <button type="button" class="remove-image">×</button>
                `;
                
                div.querySelector('.remove-image').onclick = function() {
                    div.remove();
                };
                
                preview.appendChild(div);
            };
            
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endsection