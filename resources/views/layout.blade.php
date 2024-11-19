<!-- Html-->
<!-- nuevo html 1.03. -->
<!-- Coding by Saul H rodriguez. -->
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!----===== importar CSS y JS  para vite ===== -->
    @vite(['resources/css/app.css', 'resources/js/app.js',])

    <!----===== Boxicons CSS ===== -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>


    <title>@yield('Titulo')</title>

    @yield('styles')



</head>

<body>

    <script>
        //obtener modo actual
        if (localStorage.getItem('dark-mode') == 'true') {
            const body = document.querySelector('body');
            body.classList.add("dark");
        }
    </script>

    @include('Components.Sidebar')

    @yield('Contenido')



</body>

@yield('scripts')

</html>