<div class="spacer">
    <div class="product-panel">
        <div class="content">
            <div class="containerpanel-carousel">

                <div class="carruseles" id="slider">
                    @foreach($images as $image)
                    <section class="slider-section">
                        <img loading="lazy" src="{{ asset('storage/' . $image->image_path) }}" alt="Product Image">
                    </section>
                    @endforeach
                </div>

                <div class="btn-left"><i class='bx bx-chevron-left'></i></div>
                <div class="btn-right"><i class='bx bx-chevron-right'></i></div>
                <div class="dots-container"></div>
            </div>

            <div>
                <h3>{{ $name }}</h3>
                <p class="discountPanel">{{ $offer }}% OFF</p>
                <span class="panelprice" style="color:var(--text-color);">${{ $price }}</span>
            </div>
            <div class="buttons">

                @guest
                <a href="{{ route('invitacion') }}" class="btn btn-primary">
                    <i class='bx bx-shopping-bag'></i>
                    Comprar
                </a>
                @endguest

                @auth
                <a href="#" class="btn btn-primary">
                    <i class='bx bx-shopping-bag'></i>
                    Comprar
                </a>
                @endauth

                @guest
                <a href="{{ route('invitacion') }}" class="btn btn-secondary">
                    <i class='bx bx-cart-alt'></i>
                    Carrito
                </a>
                @endguest

                @auth
                

                <form action="{{ route('cart.add') }}" method="POST" class="btn btn-secondary">
                            @csrf
                            <input type="hidden" name="id" value="{{ $id }}">
                            <button type="submit" class="btn btn-add-cart">
                                <i class='bx bx-cart-alt'></i> Agregar al carrito
                            </button>
                        </form>

                @endauth
            </div>
        </div>

        <div class="content2">
            <h3>{{ $descriptionTitle }}</h3>
            <p>{{ $description }}</p>

            @if($category)
            <h3>Categoría: {{ $category }}</h3>
            @endif

            <div class="details-grid">
                @if($color)
                <div class="detail-box">
                    <span>Color: {{ $color }}</span>
                </div>
                @endif

                @if($size)
                <div class="detail-box">
                    <span>Talla/Tamaño: {{ $size }}</span>
                </div>
                @endif

                @if($version)
                <div class="detail-box">
                    <span>Versión: {{ $version }}</span>
                </div>
                @endif

                @if($model)
                <div class="detail-box">
                    <span>Modelo: {{ $model }}</span>
                </div>
                @endif
            </div>
        </div>

        <div class="content3">
            //espacio para informacion extra a futuro listo para usarse 
            <h2> otros Productos: </h2>
        </div>
    </div>
</div>
</div>