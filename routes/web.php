<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    $products = Product::with('images')
        ->when(request('search'), function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                         ->orWhere('description', 'like', "%{$search}%")
                         ->orWhere('category', 'like', "%{$search}%");
        })
        ->when(request('category'), function ($query, $category) {
            return $query->where('category', $category);
        })
        ->get();
    
    return view('Homepage', ['products' => $products]);
})->name("Home");


Route::get('/product/{id}',[ProductController::class,'show'])->name("product.show");

Route::get('History', function () { return view('Historypage'); })->name("Historial");

Route::get('Notifications', function () { return view('Notificationpage'); })->name("Notificaciones");

Route::get('perfil', function () { return view('pfrofilepage'); })->name("miperfil");

Route::get('favorites', function () { return view('favoritespage'); })->name("favoritos");

Route::get('ewallet', function () { return view('ewalletpage'); })->name("billetera-e");

Route::get('mysales', function () {
    $userId = Auth::id(); // Obtén el ID del usuario autenticado
    $products = Product::with('images')->where('user_id', $userId)->get(); // Filtra los productos por user_id
    return view('Mysalespage', ['products' => $products]);
})->name("misventas")->middleware('auth'); // Asegúrate de que la ruta esté protegida por el middleware auth


Route::get('uploadpage', function () { return view('uploadpage'); })->name("subirproducto");

Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');

Route::get('inviation', function () { return view('invitationpage'); })->name("invitacion");

Route::middleware(['guest'])->group(function () {
    Route::get('loggin', function () { return view('LogginPage'); })->name("loggeo");
});

Route::post('login', [AuthController::class, 'login'])->name("login.store");
Route::post('register', [AuthController::class, 'registro'])->name("register.store");
Route::get('logout', [AuthController::class, 'logout'])->name("logout.store");

Route::middleware(['auth'])->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::post('/product', [ProductController::class, 'store'])->name('product.store');
    Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('editar');
    Route::put('/product/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
});

