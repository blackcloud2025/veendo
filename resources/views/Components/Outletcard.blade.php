<div class="Contenedor">

    <div class="TarjetaSeccion">
        @foreach($products as $product)
        <div class="TarjetaV">
        @if($product->images->isNotEmpty())
                    <img src="{{ Storage::url($product->images->first()->image_path) }}" alt="{{ $product->name }}">
                @endif
            <div class="content">
                <h3>{{$product->name}}</h3>
                <p>${{$product->price}}</p>
                <a href="#">Saber más.</a> 
            </div>
        </div>
        @endforeach
    </div>
</div>