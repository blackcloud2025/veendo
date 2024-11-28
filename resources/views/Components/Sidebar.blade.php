<!---barra superior navbar-->


<div class="BarraBusqueda">
    <form action="{{ route('Home') }}" method="GET" class="search-container">
        <div class="search-box1">
            <div class="search-input-container">
                <i class='bx bx-search icon'></i>
                <input type="text" 
                       name="search" 
                       placeholder="Buscar..." 
                       value="{{ request('search') }}"
                       class="search-input">
            </div>

            <select name="category" class="category-select">
                <option value="">Todas las categorías</option>
                @php
                $categories = App\Models\Product::distinct()->pluck('category');
                @endphp
                @foreach($categories as $category)
                    <option value="{{ $category }}"
                        {{ request('category') == $category ? 'selected' : '' }}>
                        {{ $category }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="search-button">
                <i class='bx bx-search'></i>
                <span>Buscar</span>
            </button>
        </div>
    </form>
</div>



<nav class="sidebar close">
    <header>
        <div class="image-text">
            <div class="text logo-text">
                <span class="titulo">Veendo.</span>
            </div>
        </div>
        <div class='imgbar toggle'>
            <div class="img-logo">
                <img loading="lazy" clr src="{{asset('images/Veendologo.png')}}">
            </div>


    </header>

    <div class="menu-bar">
        <div class="menu">

            <li class="search-box">
                <i class='bx bx-search icon'></i>
                <input type="text" placeholder="Buscar...">
            </li>


            <ul class="menu-links">
                <li class="nav-link">
                    <a href="{{route('Home')}}">
                        <i class='bx bx-home-alt icon'></i>
                        <span class="text nav-text">Inicio</span>
                    </a>
                </li>

                <ul class="menu-links">

                    <li class="nav-link">
                        @guest
                        <a href="{{route('loggeo')}}">
                            <i class='bx bx-user-circle icon'></i>
                            <span class="text nav-text">iniciar sesion</span>
                        </a>
                        @endguest

                        @auth
                        <a href="{{route('miperfil')}}">
                            <i class='bx bx-user-circle icon'></i>
                            <span class="text nav-text">Mi perfil</span>
                        </a>
                        @endauth
                    </li>


                    <li class="nav-link">
                        @guest
                        <a href="{{route('invitacion')}}">
                            <i class='bx bx-history icon'></i>
                            <span class="text nav-text">Historial</span>
                        </a>
                        @endguest

                        @auth
                        <a href="{{route('Historial')}}">
                            <i class='bx bx-history icon'></i>
                            <span class="text nav-text">Historial</span>
                        </a>
                        @endauth
                    </li>

                    <li class="nav-link">
                        @guest
                        <a href="{{route('invitacion')}}">
                            <i class='bx bx-bell icon'></i>
                            <span class="text nav-text">alertas</span>
                        </a>
                        @endguest

                        @auth
                        <a href="{{route('Notificaciones')}}">
                            <i class='bx bx-bell icon'></i>
                            <span class="text nav-text">Notificaciones</span>
                        </a>
                        @endauth
                    </li>

                    <li class="nav-link">
                        @guest
                        <a href="{{route('invitacion')}}">
                            <i class='bx bx-shopping-bag icon'></i>
                            <span class="text nav-text">Compras</span>
                        </a>
                        @endguest

                        @auth
                        <a href="#">
                            <i class='bx bx-shopping-bag icon'></i>
                            <span class="text nav-text">Compras</span>
                        </a>
                        @endauth
                    </li>

                    <li class="nav-link">
                        @guest
                        <a href="{{route('invitacion')}}">
                            <i class='bx bx-heart icon'></i>
                            <span class="text nav-text">Favoritos</span>
                        </a>
                        @endguest

                        @auth
                        <a href="{{route('favoritos')}}">
                            <i class='bx bx-heart icon'></i>
                            <span class="text nav-text">Favoritos</span>
                        </a>
                        @endauth

                    </li>

                    <li class="nav-link">

                        @guest
                        <a href="{{route('invitacion')}}">
                            <i class='bx bx-wallet icon'></i>
                            <span class="text nav-text">E-points</span>
                        </a>
                        @endguest

                        @auth
                        <a href="{{route('billetera-e')}}">
                            <i class='bx bx-wallet icon'></i>
                            <span class="text nav-text">Mis E-points</span>
                        </a>
                        @endauth
                    </li>

                    <li class="nav-link">
                        <a href="#">
                            <i class='bx bx-category icon'></i>
                            <span class="text nav-text">Categorias</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        @guest
                        <a href="{{route('invitacion')}}">
                            <i class='bx bx-purchase-tag-alt icon'></i>
                            <span class="text nav-text">Ventas</span>
                        </a>
                        @endguest

                        @auth
                        <a href="{{route('misventas')}}">
                            <i class='bx bx-purchase-tag-alt icon'></i>
                            <span class="text nav-text">Mis ventas</span>
                        </a>
                        @endauth
                    </li>

                </ul>
        </div>


        <div class="bottom-content">
            @auth
            <li class="">
                <a href="{{route('logout.store')}}">
                    <i class='bx bx-log-out icon'></i>
                    <span class="text nav-text">Salir</span>
                </a>
            </li>
            @endauth

            <li class="mode">
                <div class="sun-moon">
                    <i class='bx bx-moon icon moon'></i>
                    <i class='bx bx-sun icon sun'></i>
                </div>
                <span class="mode-text text">light mode</span>

                <div class="toggle-switch">
                    <span class="switch"></span>
                </div>
            </li>

        </div>
    </div>

</nav>

<footer class="footer">
    <div class="container">
        <div class="footer-row">
            <div class="footer-links">
                <h4>Empresa.</h4>
                <ul>
                    <li><a href="#">Quienes somos</a></li>
                    <li><a href="#">Servicios</a></li>
                    <li><a href="#">Contactanos</a></li>
                </ul>
            </div>
            <div class="footer-links">
                <h4>Ayuda.</h4>
                <ul>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Soporte</a></li>
                    <li><a href="#">Politicas</a></li>
                </ul>
            </div>
            <div class="footer-links">
                <h4>Siguenos.</h4>
                <ul>
                    <li><a href="#"><i class="fab fa-facebook-f"></i> Facebook</a></li>
                    <li><a href="#"><i class="fab fa-twitter"></i> Twitter(X)</a></li>
                    <li><a href="#"><i class="fab fa-instagram"></i> Instagram</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>


<style>




.search-box1 {
    display: flex;
    flex-wrap: wrap;
    width: 100%;
    gap: 10px;
    align-items: center;
    margin-right: 10px;
}



.search-input-container .icon {
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
    color: #888;
    z-index: 1;
}

.search-input {
    max-width: 700px;
    min-width: 100px;
    padding: 10px 10px 10px 35px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.category-select {
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    min-width: 100px;
    width: 200px;
}

.search-button {
    display: flex;
    align-items: center;
    gap: 5px;
    padding: 10px 15px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    width: 100px;
}

.search-button i {
    margin-right: 5px;
}
</style>
