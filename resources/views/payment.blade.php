<!-- resources/views/payment.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago con Stripe</title>
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>
    <h1>Realizar pago</h1>
    @if (session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div style="color: red;">{{ session('error') }}</div>
    @endif
    <form action="{{ route('process.payment') }}" method="POST" id="payment-form">
        @csrf
        <div>
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
        <button>Pagar $10.00</button>
    </form>

    <script>
        var stripe = Stripe('{{ env('STRIPE_KEY')}}');
        var elements = stripe.elements();
        var card = elements.create('card');
        card.mount('#card-element');

        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            stripe.createToken(card).then(function(result) {
                if (result.error) {
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    stripeTokenHandler(result.token);
                }
            });
        });

        function stripeTokenHandler(token) {
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);
            form.submit();
        }
    </script>
</body>
</html>