@extends('layout')

@section('titulo', 'Dashboard')

@section('styles')
    @vite('resources/css/publisher.css')
@endsection

@section('Contenido')
<div class="containerform">
    <div class="form-wrapper">
        <h1 class="page-title">Subir Publicidad</h1>
        <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-grid">
                <!-- Nombre del Producto -->
                <div class="form-group full-width">
                    <label class="form-label" for="name">Nombe de publicidad (opcional). </label>
                    <input type="text" id="name" name="name" required class="form-control">
                </div>

                <!-- Descripción -->
                <div class="form-group full-width">
                    <label class="form-label" for="description">Descripción (opcional).</label>
                    <textarea id="description" name="description" required class="form-control"></textarea>
                </div>
            <div class="widgetbx">
            <button  class="buttonH">
            <img loading="lazy" clr src="{{asset('images/banner.png')}}">
            <span>Main banner#1</span>
            </button>    
            <button  class="buttonV">L banner #2.</button>
            <button class="minispacer"></button>
            <button  class="buttonVR">R banner #3.</button>
            </div>
            <div class="widgetbx">
                <p>escoja el baner donde publicara su campania recuerde que casa uno tiene diferente precio.</p>
            </div>

                <!-- Subida de Imágenes -->
                <div class="form-group full-width">
                    <label class="form-label">Imágenes a publicar (máximo 3).</label>
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
            </div>

            <div class="submit-wrapper">
                <button type="submit" class="submit-button">Subir publicidad</button>
            </div>
        </form>
    </div>
</div>
@endsection