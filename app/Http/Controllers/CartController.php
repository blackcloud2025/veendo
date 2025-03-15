<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Session::get('cart', []);
        $products = [];
        $total = 0;
        
        // Si hay productos en el carrito, los obtenemos de la base de datos
        if (!empty($cartItems)) {
            foreach ($cartItems as $id => $details) {
                $product = Product::with('images')->find($id);
                if ($product) {
                    $product->quantity = $details['quantity'];
                    $products[] = $product;
                    
                    // Calculamos el precio considerando ofertas
                    $price = $product->offer ? $product->offer : $product->price;
                    $total += $price * $details['quantity'];
                }
            }
        }
        
        return view('Cartpage', compact('products', 'total'));
    }
    
    public function add(Request $request)
    {
        $id = $request->id;
        $product = Product::findOrFail($id);
        $cart = Session::get('cart', []);
        
        // Si el producto ya está en el carrito, incrementamos la cantidad
        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            // Si no, lo agregamos con cantidad 1
            $cart[$id] = [
                'quantity' => 1
            ];
        }
        
        Session::put('cart', $cart);
        return redirect()->back()->with('success', 'Producto agregado al carrito!');
    }
    
    public function update(Request $request)
    {
        if($request->id && $request->quantity){
            $cart = Session::get('cart');
            $cart[$request->id]['quantity'] = $request->quantity;
            Session::put('cart', $cart);
        }
        
        return redirect()->route('carrito')->with('success', 'Carrito actualizado!');
    }
    
    public function remove(Request $request)
    {
        if($request->id) {
            $cart = Session::get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                Session::put('cart', $cart);
            }
        }
        
        return redirect()->route('carrito')->with('success', 'Producto eliminado del carrito!');
    }
    
    public function clear()
    {
        Session::forget('cart');
        return redirect()->route('carrito')->with('success', 'Carrito vaciado!');
    }
}