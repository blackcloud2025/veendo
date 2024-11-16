<div class="Mi-stock">
<div class="action-bar">
        <a href="#">
        <i class='bx bxs-edit-alt'></i>
        <span class="text nav-text">Editar producto.</span>
    </a>
    <a href="#">
        <i class='bx bxs-trash'></i>
        <span class="text nav-text">Eliminar producto.</span>
    </a>
    <span class="text nav-text">nombre del producto.</span>
    
</div>   
</div>



<div class="Contenedor">

    <div class="TarjetaSeccion">
        @foreach($products as $product)
        <div class="TarjetaV" data-id="{{$product->id}}">
        @if($product->images->isNotEmpty())
                    <img loading="lazy"clr src="{{Storage::url($product->images->first()->image_path) }}" alt="{{ $product->name }}">
                @endif
            <div class="content">
                <h3>{{$product->name}}</h3>
                <p>${{$product->price}}</p>
               <a href="{{ route('product.show', ['id' => $product->id]) }}">saber mas.</a>
            </div>
        </div>
        @endforeach
    </div>
</div>