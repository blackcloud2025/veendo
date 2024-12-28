@extends('layout')

@section('Titulo', 'profile')

@section('styles')
    @vite('resources/css/payment.css')
@endsection

@section('Contenido')
    <div class="payment-container">
        <h1>Realizar pago</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        <form action="{{ route('process.payment') }}" method="POST" id="payment-form">
            @csrf
            <div class="form-group">
                <label for="card-element">
                    Tarjeta de crédito o débito
                </label>
                <div id="card-element">
                    <!-- Un elemento de Stripe será insertado aquí. -->
                </div>
                <!-- Usado para mostrar errores de formulario. -->
                <div id="card-errors" role="alert"></div>
            </div>

            <input type="hidden" name="amount" value="10.00">
            <button class="payment-button">Pagar $10.00</button>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="https://js.stripe.com/v3/"></script>
    @vite('resources/js/payment.js')
@endsection