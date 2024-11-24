<!---barra superior navbar-->

<div class="BarraBusqueda">
    <li class="search-box1">
        <ul class='bx bx-search icon'></ul>
        <input type="text" placeholder="  Buscar...">
    </li>

</div>

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