<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\View;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('loggeo');
        }

        $cartItems = Session::get('cart', []);
        
        if (empty($cartItems)) {
            return redirect()->route('carrito')->with('error', 'El carrito está vacío');
        }

        // Obtener productos del carrito con detalles
        $products = [];
        $cartSubtotal = 0;
        $cartDiscount = 0;
        $cartTotal = 0;

        foreach ($cartItems as $id => $details) {
            $product = Product::with('images')->find($id);
            if ($product) {
                $price = $product->price;
                $subtotal = $price * $details['quantity'];
                $discountPercentage = $product->offer ?? 0;
                $discountAmount = $subtotal * ($discountPercentage / 100);
                $total = $subtotal - $discountAmount;

                $products[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $price,
                    'quantity' => $details['quantity'],
                    'offer' => $discountPercentage,
                    'subtotal' => $subtotal,
                    'discount' => $discountAmount,
                    'total' => $total
                ];

                $cartSubtotal += $subtotal;
                $cartDiscount += $discountAmount;
                $cartTotal += $total;
            }
        }

        return view('order-popup', [
            'products' => $products,
            'cartSubtotal' => $cartSubtotal,
            'cartDiscount' => $cartDiscount,
            'cartTotal' => $cartTotal
        ]);
    }

    public function createFromCart(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'No autenticado'], 401);
        }

        $cartItems = Session::get('cart', []);
        
        if (empty($cartItems)) {
            return response()->json(['error' => 'El carrito está vacío'], 400);
        }

        // Obtener productos del carrito con detalles
        $products = [];
        $cartSubtotal = 0;
        $cartDiscount = 0;
        $cartTotal = 0;

        foreach ($cartItems as $id => $details) {
            $product = Product::with('images')->find($id);
            if ($product) {
                $price = $product->price;
                $subtotal = $price * $details['quantity'];
                $discountPercentage = $product->offer ?? 0;
                $discountAmount = $subtotal * ($discountPercentage / 100);
                $total = $subtotal - $discountAmount;

                $products[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $price,
                    'quantity' => $details['quantity'],
                    'offer' => $discountPercentage,
                    'subtotal' => $subtotal,
                    'discount' => $discountAmount,
                    'total' => $total
                ];

                $cartSubtotal += $subtotal;
                $cartDiscount += $discountAmount;
                $cartTotal += $total;
            }
        }

        // Retornar solo HTML sin layout
        return View::make('order-popup-content', [
            'products' => $products,
            'cartSubtotal' => $cartSubtotal,
            'cartDiscount' => $cartDiscount,
            'cartTotal' => $cartTotal
        ])->render();
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'No autenticado'
            ], 401);
        }

        $cartItems = Session::get('cart', []);
        
        if (empty($cartItems)) {
            return response()->json([
                'success' => false,
                'message' => 'El carrito está vacío'
            ], 400);
        }

        // Calcular totales
        $products = [];
        $cartSubtotal = 0;
        $cartDiscount = 0;
        $cartTotal = 0;

        foreach ($cartItems as $id => $details) {
            $product = Product::with('images')->find($id);
            if ($product) {
                $price = $product->price;
                $subtotal = $price * $details['quantity'];
                $discountPercentage = $product->offer ?? 0;
                $discountAmount = $subtotal * ($discountPercentage / 100);
                $total = $subtotal - $discountAmount;

                $products[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $price,
                    'quantity' => $details['quantity'],
                    'offer' => $discountPercentage,
                    'subtotal' => $subtotal,
                    'discount' => $discountAmount,
                    'total' => $total
                ];

                $cartSubtotal += $subtotal;
                $cartDiscount += $discountAmount;
                $cartTotal += $total;
            }
        }

        // Crear orden
        $order = Order::create([
            'user_id' => Auth::id(),
            'subtotal' => $cartSubtotal,
            'discount' => $cartDiscount,
            'total' => $cartTotal,
            'items' => $products,
            'status' => 'pendiente'
        ]);

        // Limpiar carrito
        Session::forget('cart');

        return response()->json([
            'success' => true,
            'message' => 'Orden creada correctamente',
            'order_id' => $order->id
        ]);
    }

    public function generatePdf($id)
    {
        $order = Order::findOrFail($id);

        // Verificar que el usuario sea el dueño de la orden
        if ($order->user_id !== Auth::id()) {
            return redirect()->route('carrito')->with('error', 'No autorizado');
        }

        // Renderizar la vista
        $html = View::make('ticket-pdf', ['order' => $order])->render();

        // Generar PDF con Dompdf
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->stream('ticket-' . $order->id . '.pdf');
    }
}
