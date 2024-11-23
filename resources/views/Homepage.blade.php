@extends('layout')

@section('Titulo','Home')


@section('styles')
    @vite('resources/css/slider.css')
@endsection

@section('Contenido')


<!------------------------------------carrusel---------------------------------------------------------->

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
    <div class="btn-left"><i class='bx bx-chevron-left'></i></div>
    <div class="btn-right"><i class='bx bx-chevron-right'></i></div>
    <div class="dots-container"></div>
</div>



<!----------------------------------------------SsliderBtns.---------------------------------------------->
<div class="SliderBtns">

    <div class="Btn">
        <h3>Recien visto.</h3>
        <a href="#">Ver más.</a>
    </div>

    <div class="Btn">
        <h3>Mis pagos.</h3>
        <a href="#">Ver más.</a>
    </div>

    <div class="Btn">
        <h3>Lo más vendido.</h3>
        <a href="#">Ver más.</a>
    </div>

    <div class="Btn">
        <h3>En liquidación.</h3>
        <a href="#">Ver más.</a>
    </div>

</div>

<!------------------------------------display de productos en la pagina----------------------------------->
<div class="contenedor">
    <div class="product-container">
        @foreach($products as $product)

        <div class="product-card" data-id="{{$product->id}}">

            <div class="image-container">
                @if($product->images->isNotEmpty())
                <img loading="lazy" clr src="{{Storage::url($product->images->first()->image_path) }}" alt="{{ $product->name }}">
                @endif
            </div>

            <div class="product-details">
            <p class="discount">OFF {{ $product->offer }}%</p>
            <h3>{{ $product->name }}</h3>
            <p class="price">Precio: ${{ $product->price }}</p>

            <form action="{{ route('product.show', ['id' => $product->id]) }}">
                    @csrf
                    <button type="submit">
                        <span class="text nav-text"> saber mas.</span>
                    </button>
            </form>

            <form action="#">
                    <button type="submit">
                        <span class="text nav-text"> agregar.</span>
                    </button>
            </form>
                
            
            </div>
            
        </div>
        @endforeach
    </div>
</div>
@endsection

@section('scripts')
    @vite('resources/js/slider.js')
@endsection



