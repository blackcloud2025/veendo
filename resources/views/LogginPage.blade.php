@extends('layout')

@section('Titulo','loggin.')

@section('styles')
    @vite('resources/css/logginBehaviour.css')
@endsection

@section('Contenido')
<x-LogginBox ></x-LogginBox>
@endsection

@section('scripts')
    @vite('resources/js/logginBehaviour.js')
@endsection