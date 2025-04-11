@extends('layout')

@section('Titulo','History.')

@section('styles')
@vite('resources/css/history.css')

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
      <!-- Carousel -->
      <div class="carousel">
        <div class="carousel-container" id="carousel-container">
          <div class="carousel-slide">
            <img src="https://via.placeholder.com/1200x400" alt="Promotion 1">
          </div>
          <div class="carousel-slide">
            <img src="https://via.placeholder.com/1200x400" alt="Promotion 2">
          </div>
          <div class="carousel-slide">
            <img src="https://via.placeholder.com/1200x400" alt="Promotion 3">
          </div>
        </div>
        
        <!-- Blur overlay -->
        <div class="carousel-overlay"></div>
        
        <!-- Navigation buttons -->
        <button class="carousel-btn prev-btn" aria-label="Previous slide">
          <i class="fas fa-chevron-left"></i>
        </button>
        
        <button class="carousel-btn next-btn" aria-label="Next slide">
          <i class="fas fa-chevron-right"></i>
        </button>
        
        <!-- Dots -->
        <div class="carousel-dots" id="carousel-dots">
          <!-- Dots will be added by JavaScript -->
        </div>
      </div>

      <!-- Category Buttons -->
      <div class="category-grid">
        <a href="#" class="category-link">
          <div class="category-card">
            <div class="category-icon blue">
              <i class="fas fa-newspaper"></i>
            </div>
            <h3 class="category-title">Recien visto</h3>
            <span class="category-more blue">Ver más</span>
          </div>
        </a>

        <a href="#" class="category-link">
          <div class="category-card">
            <div class="category-icon green">
              <i class="fas fa-money-bill-wave"></i>
            </div>
            <h3 class="category-title">Mis pagos</h3>
            <span class="category-more green">Ver más</span>
          </div>
        </a>

        <a href="#" class="category-link">
          <div class="category-card">
            <div class="category-icon red">
              <i class="fas fa-fire"></i>
            </div>
            <h3 class="category-title">Más vendido</h3>
            <span class="category-more red">Ver más</span>
          </div>
        </a>

        <a href="#" class="category-link">
          <div class="category-card">
            <div class="category-icon purple">
              <i class="fas fa-tag"></i>
            </div>
            <h3 class="category-title">Liquidación</h3>
            <span class="category-more purple">Ver más</span>
          </div>
        </a>
      </div>

      <!-- Products Grid -->
      <div class="products-grid" id="products-grid">
        <!-- Products will be added by JavaScript -->
      </div>

      <!-- Pagination -->
      <div class="pagination">
        <button class="pagination-btn" id="prev-page" disabled>Anterior</button>
        <button class="pagination-btn" id="next-page">Siguiente</button>
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
