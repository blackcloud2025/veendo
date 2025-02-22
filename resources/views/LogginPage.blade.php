@extends('layout')

@section('Titulo','loggin.')

@section('styles')
    @vite('resources/css/loggin.css')
@endsection

@section('Contenido')
<x-LogginBox ></x-LogginBox>
@endsection



@section('scripts')
    @vite('resources/js/facedetect.js')
    @vite('resources/js/face-api.min.js')
@endsection