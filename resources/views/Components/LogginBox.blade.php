<div class="container-form register">
    <div class="information">
        <div class="info-childs">
            <h2>Bienvenido <br> a <br> veendo!!</h2>
            <p>disfruta de nuestra tienda!! <br> Inicie Sesión con tus datos o registrate.</p>
            <input type="button" value="Iniciar Sesión" id="sign-in">
        </div>
    </div>
    <div class="form-information">
        <div class="form-information-childs">
            <h2>Crear una Cuenta</h2>
            <p>¡Únete para comprar y vender ya!</p>
            <form class="form form-register" method="POST" action="{{route('register.store')}}">
                @csrf
                <input type="hidden" name="face_descriptor" id="face-descriptor-register">
                <div class="camera-box" style="margin-top: 1px;">
                    <video id="camera-feed" style="display: none;" autoplay></video>
                    <div class="toggle-switch">
                        <label class="switch">
                            <input type="checkbox" id="camera-toggle">
                            <span class="slider round"></span>
                        </label>
                        <span class="toggle-label">IA reg cámara.</span>
                        <i class='bx bx-camera'></i>
                    </div>
                </div>


                <div alt="name">
                    <label>
                        <i class='bx bx-user'></i>
                        <input type="text" placeholder="Nombre Usuario" name="name">
                    </label>
                </div>

                <div alt="phone">
                    <label>
                        <i class='bx bx-phone'></i>
                        <input type="phone" placeholder="teléfono ej:123-456-7890" name="phone">
                    </label>
                </div>

                <div alt="email">
                    <label>
                        <i class='bx bx-envelope'></i>
                        <input type="email" placeholder="Correo Electronico" name="email">
                    </label>
                </div>

                <div alt="password">
                    <label>
                        <i class='bx bx-lock-alt'></i>
                        <input type="password" placeholder="Contraseña min 1 num y una mayuscula " name="password">
                    </label>
                </div>

                <div alt="idcard">
                    <label>
                        <i class='bx bx-id-card'></i>
                        <input type="identificacion" placeholder="Número de identificacion" name="identificacion">
                    </label>
                </div>


                <div alt="adress">
                    <label>
                        <i class='bx bx-map'></i>
                        <input type="adress" placeholder="Direccion fisica" name="adress">
                    </label>
                </div>

                <input type="submit" value="Registrarse">
                <div class="alerta-error">Todos los campos son obligatorios</div>
                <div class="alerta-exito">Te registraste correctamente</div>
            </form>
        </div>
    </div>
</div>


<div class="container-form login hide">
    <div class="information">
        <div class="info-childs">
            <h2>¡¡Bienvenido <br>de<br> nuevo!!</h2>
            <p>Para unirte a nuestra comunidad por favor Inicie Sesión con sus datos.</p>
            <input type="button" value="Registrarse" id="sign-up">
        </div>
    </div>
    
    <div class="form-information">
        <div class="form-information-childs">
            <h2>Iniciar Sesión</h2>
            <p> Inicie Sesión con su cuenta.</p>
            <form class="form form-login" novalidate method="POST" action="{{route('login.store')}}">
                @csrf
                <input type="hidden" name="face_descriptor">
                <div class="camera-box-1">
                    <video id="camera-feed-1" style="display: none; margin-top: 1px;" autoplay></video>
                        <div class="toggle-switch">
                        <label class="switch">
                            <input type="checkbox" id="camera-toggle-1">
                            <span class="slider round"></span>
                        </label>
                        <span class="toggle-label">IA reg cámara.</span>
                        <i class='bx bx-camera'></i>
                    </div>
                </div>


                <div>
                    <label>
                        <i class='bx bx-envelope'></i>
                        <input type="email" placeholder="Correo Electronico" name="email">
                    </label>
                </div>
                <div>
                    <label>
                        <i class='bx bx-lock-alt'></i>
                        <input type="password" placeholder="Contraseña" name="password">
                    </label>
                </div>
                <input type="submit" value="Iniciar Sesión">
                <div class="alerta-error">Todos los campos son obligatorios</div>
                <div class="alerta-exito">Te registraste correctamente</div>
            </form>
        </div>
    </div>
</div>