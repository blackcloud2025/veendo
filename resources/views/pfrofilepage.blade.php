@extends('layout')

@section('Titulo','profile.')

@section('Contenido')

    <style>
      .contenedor{
        padding-top: 50px;
        width: 100%;
        height: 100%;
      }
        .product-panel {
            max-width: 800px;
            min-width: 300px ;
            margin:0 auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        /* Carousel Styles */
        .container-carousel {
            position: relative;
            overflow: hidden;
            width: 100%;
            aspect-ratio: 14/9;
        }

        .carruseles {
            display: flex;
            transition: transform 0.3s ease-in-out;
            height: 100%;
        }

        .slider-section {
            min-width: 100%;
            height: 100%;
        }

        .slider-section img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .btn-left, .btn-right {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255,255,255,0.8);
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .btn-left:hover, .btn-right:hover {
            background: white;
        }

        .btn-left { left: 10px; }
        .btn-right { right: 10px; }

        /* Content Styles */
        .content {
            padding: 20px;
        }

        .discount {
            display: inline-block;
            background: #ef4444;
            color: white;
            padding: 4px 12px;
            border-radius: 999px;
            font-size: 14px;
            font-weight: 500;
            margin: 10px 0;
        }

        .content h3 {
            font-size: 1.25rem;
            color: #1f2937;
            margin-bottom: 10px;
        }

        .price {
            font-size: 1.5rem;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 20px;
        }

        .buttons {
            display: flex;
            gap: 16px;
            margin-top: 20px;
        }

        .btn {
            flex: 1;
            padding: 10px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-weight: 500;
            text-decoration: none;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-secondary {
            background: #f3f4f6;
            color: #1f2937;
        }

        .btn-primary:hover {
            background: #1d4ed8;
        }

        .btn-secondary:hover {
            background: #e5e7eb;
        }

        /* Content 2 Styles */
        .content2 {
            padding: 20px;
            background: #f9fafb;
            border-top: 1px solid #e5e7eb;
        }

        .details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-top: 16px;
        }

        .detail-box {
            background: white;
            padding: 12px;
            border-radius: 8px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }

        /* Content 3 Styles */
        .content3 {
            padding: 20px;
            border-top: 1px solid #e5e7eb;
        }
    </style>

    <div class="contenedor">
    <div class="product-panel">
        <div class="content">
            <div class="container-carousel">
                <div class="carruseles" id="slider">
                    <section class="slider-section">
                        <img loading="lazy" src="/api/placeholder/800/450" alt="Product Image 1">
                    </section>
                    <section class="slider-section">
                        <img loading="lazy" src="/api/placeholder/800/450" alt="Product Image 2">
                    </section>
                    <section class="slider-section">
                        <img loading="lazy" src="/api/placeholder/800/450" alt="Product Image 3">
                    </section>
                </div>
                <button class="btn-left">
                    <i class='bx bx-chevron-left'></i>
                </button>
                <button class="btn-right">
                    <i class='bx bx-chevron-right'></i>
                </button>
            </div>

            <p class="discount">20% OFF</p>
            <h3>Nombre del Producto</h3>
            <div class="price">$199.99</div>

            <div class="buttons">
                <a href="#" class="btn btn-primary">
                    <i class='bx bx-shopping-bag'></i>
                    Comprar
                </a>
                <a href="#" class="btn btn-secondary">
                    <i class='bx bx-cart-add'></i>
                    Carrito +
                </a>
            </div>
        </div>

        <div class="content2">
            <h3>Descripción del Producto</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            
            <h3>Categoría: Electrónicos</h3>
            
            <div class="details-grid">
                <div class="detail-box">
                    <span>Color: Negro</span>
                </div>
                <div class="detail-box">
                    <span>Talla/Tamaño: Grande</span>
                </div>
                <div class="detail-box">
                    <span>Versión: 2.0</span>
                </div>
                <div class="detail-box">
                    <span>Modelo: XYZ-123</span>
                </div>
            </div>
        </div>

        <div class="content3">
            <!-- Espacio para contenido adicional -->
        </div>
    </div>
    </div>
@endsection