<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\StripePaymentController;

//vista principarl, indexado y buscado de productos
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
        ->paginate(10);

    return view('Homepage', ['products' => $products]);
})->name("Home");

//vista de muestra de productos individual y relacionados
Route::get('/product/{id}', [ProductController::class, 'show'])->name("product.show");

//vista de historial decompra de usuario
Route::get('History', function () {
    return view('Historypage');
})->name("Historial");

//vista de notificaciones de usuario
Route::get('Notifications', function () {
    return view('Notificationpage');
})->name("Notificaciones");


// Rutas para el perfil del usuario autenticado 
Route::middleware(['auth'])->group(function () {
    Route::get('perfil', [AuthController::class, 'show'])->name('miperfil');
    Route::get('perfil/edit', [AuthController::class, 'edit'])->name('perfil.edit');
    Route::put('perfil', [AuthController::class, 'update'])->name('perfil.update');
    Route::delete('perfil', [AuthController::class, 'destroy'])->name('perfil.destroy');
});


//vista de favoritos de usuario
Route::get('favorites', function () {
    return view('favoritespage');
})->name("favoritos");

//vista de billetera electronica de usuario
Route::get('ewallet', function () {
    return view('ewalletpage');
})->name("billetera-e");

//vista de ventas de usuario
Route::get('mysales', function () {
    $userId = Auth::id(); // Obtén el ID del usuario autenticado
    $products = Product::with('images')->where('user_id', $userId)->get(); // Filtra los productos por user_id
    return view('Mysalespage', ['products' => $products]);
})->name("misventas")->middleware('auth'); // Asegurarme luego de que la ruta esté protegida por el middleware auth

//vista de subida de producto
Route::get('uploadpage', function () {
    return view('uploadpage');
})->name("subirproducto");
Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');


//vista de invitacion de usuario
Route::get('inviation', function () {
    return view('invitationpage');
})->name("invitacion");

//vista de acceso de usuario
Route::middleware(['guest'])->group(function () {
    Route::get('loggin', function () {
        return view('LogginPage');
    })->name("loggeo");
});

//rutas de manejo de usuarios para loggueo y creacion de usuario
Route::post('login', [AuthController::class, 'login'])->name("login.store");
Route::post('register', [AuthController::class, 'registro'])->name("register.store");
Route::get('logout', [AuthController::class, 'logout'])->name("logout.store");

//rutas de manejo de prodctos
Route::middleware(['auth'])->group(function () {
    //ruta indice de productos
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');

    //ruta subida de producto
    Route::put('/product/{id}', [ProductController::class, 'update'])->name('product.update');

    //ruta guardado de producto 
    Route::post('/product', [ProductController::class, 'store'])->name('product.store');

    //ruta editado de producto 
    Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('editar');


    //ruta borrado de producto
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

    // ruta de pago con stripe
    Route::get('/payment', function () {
        return view('payment');
    });

    Route::post('/process-payment', [StripePaymentController::class, 'processPayment'])->name('process.payment');
});
