<!---barra superior navbar-->


<div class="BarraBusqueda">
    <form action="{{ route('Home') }}" method="GET" class="search-container">

        <input type="text"
            name="search"
            placeholder="Buscar..."
            value="{{ request('search') }}"
            class="search-input">

        <button type="submit" class="search-button">
            <i class='bx bx-search'></i>
        </button>



        <select name="category" class="category-select">
            <option value="">todas las categorías</option>
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
<<<<<<< HEAD
                <img loading="lazy" clr src="{{asset('images/Veendologo.png')}}">
=======
                <img loading="lazy" clr src="{{asset('images/VeendoLogoNewColor.png')}}" style="width: 48px;">
>>>>>>> parent of 73caea6 (mejoramiento en data para el login falta implementar api para reconocimiento facial y mejorapara crud de usuario funcional)
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

                    @auth
                    @if(Auth::user() && Auth::User()->isAdmin())
                    <li class="nav-link">
                        <a href="{{route('midashboard')}}">
                            <i class='bx bx-list-ul icon'></i>
                            <span class="text nav-text">dashboard</span>
                        </a>
                    </li>
                    @endif
                    @endauth

                    @auth
                    @if(Auth::user() && (Auth::user()->isAdmin() || Auth::user()->isPublisher()))
                    <li class="nav-link">
                        <a href="{{route('ads.create')}}">
                            <i class='bx bx-list-plus icon'></i>
                            <span class="text nav-text">campaña</span>
                        </a>
                    </li>
                    @endif
                    @endauth



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
    /* ===== barra busqueda ===== */

    .BarraBusqueda {
        width: 100%;
        align-items: center;
        height: auto;
        min-height: 77px;
        flex-direction: row;
        justify-content: space-between;
        position: relative;
        display: flex;
        background-color: var(--navbar-color);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        border-bottom-color: #18191a;
        padding: 10px;
    }

    .search-container {
        margin-left: 70px;
    }

    .search-input {
        height: 35px;
        background-color: var(--primary-color-light);
        color: var(--text-color);
        margin: 3px;
        border-style: none;
        outline: none;
        border-radius: 5px;
        padding: 5px;
    }

    .search-button {
        width: 35px;
        height: 35px;
        background-color: var(--primary-color-light2);
        color: var(--text-color);
        border-style: none;
        border-radius: 5px;
        padding: 5px;
    }

    .search-button i {
        margin-top: 5px;
    }

    .category-select {
        height: 35px;
        background-color: var(--primary-color-light);
        color: var(--text-color);
        margin: 3px;
        outline: none;
        border-style: none;
        border-radius: 5px;
        padding: 5px;
    }
</style>