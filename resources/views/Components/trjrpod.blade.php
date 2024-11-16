<div class="trjrpod">
    <div class="content">
        <div class="container-carousel">
            <div class="carruseles" id="slider">
                @foreach($images as $image)
                <section class="slider-section">
                    <img loading="lazy" src="{{ asset('storage/' . $image->image_path) }}" alt="Product Image">
                </section>
                @endforeach
            </div>
            <div class="btn-left"><i class='bx bx-chevron-left'></i></div>
            <div class="btn-right"><i class='bx bx-chevron-right'></i></div>
        </div>
        <p class="discount">{{ $offer }}% OFF</p>
        <h3>{{ $name }}</h3>
        <div><span style="color:var(--text-color);">${{ $price }}</span></div>
        <a href="{{ route($liga) }}">Comprar.</a>
        <a href="#">Carrito +.</a>
    </div>

    <div class="content2">
        <h3>{{ $descriptionTitle }}</h3>
        <p>{{ $description }}</p>
    </div>

    <div class="content3">
        <h3>Categoría: {{ $category ?? 'No especificada' }}</h3>
        @if($color)
            <div class="colorbx"><span>Color: {{ $color }}</span></div>
        @endif
        @if($size)
            <div class="colorbx"><span>Talla/Tamaño: {{ $size }}</span></div>
        @endif
        @if($version)
            <div class="txtbx"><span>Versión: {{ $version }}</span></div>
        @endif
        @if($model)
            <div class="txtbx"><span>Modelo: {{ $model }}</span></div>
        @endif
    </div>
</div>