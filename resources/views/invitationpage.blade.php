@extends('layout')

@section('Titulo','unete.')

@section('Contenido')

<div class="TarjetainV">
            <figure>
            <img loading="lazy"clr src="{{asset('images/invitbg.jpeg')}}">
            </figure>
            <div class="content">
                <h3>te invitamos!!</h3>
                <p>se parte de nuestra plataforma para que compres y vendas lo que quieras pulsando el boton.</p>
                <a href="{{route('loggeo')}}">unirme.</a>
            </div>
        </div>

@endsection