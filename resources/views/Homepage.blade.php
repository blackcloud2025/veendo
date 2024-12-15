@extends('layout')

@section('Titulo','Home')


@section('styles')
@vite('resources/css/slider.css')
@endsection

@section('Contenido')


<!-------------------carrusel---------------------------------------------------------->

<div class="container-carousel">
    <div class="carruseles" id="slider">
        <section class="slider-section">
            <img loading="lazy" clr src="{{asset('images/Veendologo.png')}}">
        </section>
        <section class="slider-section">
            <img loading="lazy" clr src="{{asset('images/invitbg.jpeg')}}">
        </section>
        <section class="slider-section">
            <img loading="lazy" clr src="{{asset('images/producto.jpg')}}">
        </section>
        <section class="slider-section">
            <img loading="lazy" clr src="{{asset('images/Veendologo.jpg')}}">
        </section>
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
                <p class="price">Precio: ${{ $product->price }}</p>
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
      <span class="btn disabled">Siguiente</span> @endif






      <style>

.pagination-buttons {
    display: flex;
    justify-content: center;
    margin-top: 20px;
   
}

.pagination-buttons .btn {
    max-width: 80px;
    min-width: 50px;
    margin: 5px;
    padding: 5px;
    border-radius: 7px;
    text-decoration: none;
    color: #333;
    background-color: var(sidebar--color);
    cursor: pointer;
}

.pagination-buttons .btn:hover {
    background-color: #e9ecef;
}

.pagination-buttons .disabled {
    max-width: 80px;
    min-width: 50px;
    margin: 5px;
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 7px;
    text-decoration: none;
    color: #aaa;
    background-color: #f8f9fa;
    cursor: not-allowed;
}


      </style>

@endsection

@section('scripts')
@vite('resources/js/slider.js')
@endsection