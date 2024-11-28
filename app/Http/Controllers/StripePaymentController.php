<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;

class StripePaymentController extends Controller
{
    public function processPayment(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $charge = Charge::create([
                'amount' => $request->amount * 100, // Stripe espera el monto en centavos
                'currency' => 'usd',
                'source' => $request->stripeToken,
                'description' => 'Pago de prueba',
            ]);

            // Aquí puedes guardar los detalles del pago en tu base de datos

            return redirect()->back()->with('success', 'Pago realizado con éxito');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}