@extends('layout')

@section('Titulo','Home')

@section('styles')
@vite(['resources/css/slider.css', 'resources/css/home.css'])
@endsection

@section('Contenido')
<div class="flex min-h-screen">
    <!-- Left Banner -->
    <div class="left-banner">
        <a href="#" class="block h-full">
            <div class="banner-content purple-gradient">
                <div class="banner-pattern"></div>
                <div class="banner-inner">
                    <div class="banner-icon">
                        <img src="https://via.placeholder.com/80" alt="Promo" class="rounded-full">
                    </div>
                    <div class="banner-text">
                        <h3 class="banner-title purple">OFERTA ESPECIAL</h3>
                        <p class="banner-subtitle purple">Hasta 50% OFF</p>
                        <div class="banner-button purple">Ver Ahora</div>
                    </div>
                    <div class="banner-product">
                        <img src="https://via.placeholder.com/120" alt="Product">
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Existing Carousel -->
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

        <!-- Modified Category Buttons -->
        <div class="category-grid">
            <a href="#" class="category-link">
                <div class="category-card">
                    <div class="category-icon blue">
                        <i class='bx bxs-news'></i>
                    </div>
                    <h3 class="category-title">Recien visto</h3>
                    <span class="category-more blue">Ver más</span>
                </div>
            </a>

            <a href="#" class="category-link">
                <div class="category-card">
                    <div class="category-icon green">
                        <i class='bx bx-money-withdraw'></i>
                    </div>
                    <h3 class="category-title">Mis pagos</h3>
                    <span class="category-more green">Ver más</span>
                </div>
            </a>

            <a href="#" class="category-link">
                <div class="category-card">
                    <div class="category-icon red">
                        <i class='bx bxs-hot'></i>
                    </div>
                    <h3 class="category-title">Más vendido</h3>
                    <span class="category-more red">Ver más</span>
                </div>
            </a>

            <a href="#" class="category-link">
                <div class="category-card">
                    <div class="category-icon purple">
                        <i class='bx bxs-offer'></i>
                    </div>
                    <h3 class="category-title">Liquidación</h3>
                    <span class="category-more purple">Ver más</span>
                </div>
            </a>
        </div>

        <!-- Existing Products Grid -->
        <div class="product-container">
            @foreach($products as $product)
            <div class="product-card" data-id="{{$product->id}}">
                <div class="image-container">
                    @if($product->images->isNotEmpty())
                    <img loading="lazy" src="{{ Storage::url($product->images->first()->image_path) }}" alt="{{ $product->name }}">
                    @endif
                </div>
                <div class="product-details">
                    <span class="discount">OFF {{ $product->offer }}%</span>
                    <h3>{{ $product->name }}</h3>
                    <p class="price"> ${{ $product->price }}</p>
                    <div class="button-group">
                        <a href="{{ route('product.show', ['id' => $product->id]) }}" class="btn">
                            <span class="text nav-text">Saber más</span>
                        </a>
                        <form action="{{ route('cart.add') }}" method="POST" class="cart-form">
                            @csrf
                            <input type="hidden" name="id" value="{{ $product->id }}">
                            <button type="submit" class="btn btn-add-cart">
                                <i class='bx bx-cart-add'></i> Agregar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Modified Pagination -->
        <div class="pagination">
            @if ($products->currentPage() > 1)
            <a href="{{ $products->previousPageUrl() }}" class="pagination-btn">Anterior</a>
            @else
            <span class="pagination-btn disabled">Anterior</span>
            @endif
            
            @if ($products->hasMorePages())
            <a href="{{ $products->nextPageUrl() }}" class="pagination-btn">Siguiente</a>
            @else
            <span class="pagination-btn disabled">Siguiente</span>
            @endif
        </div>
    </div>

    <!-- Right Banner -->
    <div class="right-banner">
        <a href="#" class="block h-full">
            <div class="banner-content amber-gradient">
                <div class="banner-pattern"></div>
                <div class="banner-inner">
                    <div class="banner-icon">
                        <img src="https://via.placeholder.com/80" alt="Promo" class="rounded-full">
                    </div>
                    <div class="banner-text">
                        <h3 class="banner-title amber">NUEVOS PRODUCTOS</h3>
                        <p class="banner-subtitle amber">Envío Gratis</p>
                        <div class="banner-button amber">Comprar</div>
                    </div>
                    <div class="banner-product">
                        <img src="https://via.placeholder.com/120" alt="Product">
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>
@endsection

@section('scripts')
@vite('resources/js/slider.js')
@endsection