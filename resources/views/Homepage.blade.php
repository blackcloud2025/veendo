@extends('layout')

@section('Titulo','Home')


@section('styles')
@vite('resources/css/slider.css')
@endsection

@section('Contenido')


<!-------------------carrusel---------------------------------------------------------->

<div class="container-carousel">
    <div class="carruseles" id="slider">

        @foreach($ads as $ad)
        <section class="slider-section">
            <img loading="lazy" src="{{ Storage::url($ad->image_path) }}" alt="{{ $ad->name }}">
        </section>
        @endforeach

    </div>
    <div class="blur-overlay"></div>
    <div class="btn-left"><i class='bx bx-chevron-left'></i></div>
    <div class="btn-right"><i class='bx bx-chevron-right'></i></div>
    <div class="dots-container"></div>
</div>



<!-----------------------SsliderBtns.--------------------------------------------------------------->
<div class="SliderBtns">

    <div class="Btn news">
        <i class='bx bxs-news'></i>
        <h3>Recien visto.</h3>
        <a href="#">Ver más.</a>
    </div>



    <div class="Btn payments">
        <i class='bx bx-money-withdraw'></i>
        <h3>Mis pagos.</h3>
        <a href="#">Ver más.</a>
    </div>

    <div class="Btn hot">
        <i class='bx bxs-hot'></i>
        <h3>más vendido.</h3>
        <a href="#">Ver más.</a>
    </div>

    <div class="Btn offer">
        <i class='bx bxs-offer'></i>
        <h3>liquidación.</h3>
        <a href="#">Ver más.</a>
    </div>

</div>


<div class="contenedor">
    <div class="product-container">
        @foreach($products as $product)
        <div class="product-card" data-id="{{$product->id}}">
            <div class="image-container">
                @if($product->images->isNotEmpty())
                <img loading="lazy" clr src="{{ Storage::url($product->images->first()->image_path) }}" alt="{{ $product->name }}">
                @endif
            </div>
            <div class="product-details">
                <p class="discount">OFF {{ $product->offer }}%</p>
                <h3>{{ $product->name }}</h3>
                <p class="price"> ${{ $product->price }}</p>
                <a href="{{ route('product.show', ['id' => $product->id]) }}" class="btn">
                    <span class="text nav-text">Saber más</span>
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Botones de paginación -->
<div class="pagination-buttons">
    @if ($products->currentPage() > 1)
    <a href="{{ $products->previousPageUrl() }}" class="btn">Anterior</a>
    @else <span class="btn disabled">Anterior</span> @endif @if ($products->hasMorePages())
    <a href="{{ $products->nextPageUrl() }}" class="btn">Siguiente</a> @else
    <span class="btn disabled">Siguiente.</span> @endif

    <style>
        .pagination-buttons {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination-buttons .btn {
            max-width: 100px;
            margin: 5px;
            padding: 15px;
            border-radius: 7px;
            color: var(--text-color);
            background-color: var(--primary-color-light2);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            /* Agregar márgenes al texto */
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            white-space: nowrap;
        }

        .pagination-buttons .btn:hover {
            background-color: #e9ecef;
        }
    </style>

    @endsection

    @section('scripts')
    @vite('resources/js/slider.js')
    @endsection