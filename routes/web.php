<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdController;
use App\Models\Product;
use App\Models\Ad;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\StripePaymentController;
use Illuminate\Support\Facades\File;  // Add this at the top with other imports

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

    $ads = Ad::where('banner_type', 'horizontal')->get(); // O el tipo que necesites

    return view('Homepage', ['products' => $products,  'ads' => $ads]);
})->name("Home");

//vista de muestra de productos individual y relacionados
Route::get('/product/{id}', [ProductController::class, 'show'])->name("product.show");

//vista dashboard
Route::get('dasboard', function () {
    return view('dashboard');
})->name("mi dashboard");


// Ruta para mostrar el formulario 
Route::get('/subir-publicidad', function () {
    return view('publisherpage');
})->name('ads.create');

// Ruta para procesar el formulario
Route::post('/subir-publicidad', [AdController::class, 'store'])->name('ads.store');


//vista de historial decompra de usuario
Route::get('History', function () {
    return view('Historypage');
})->name("Historial");

//vista de notificaciones de usuario
Route::get('Notifications', function () {
    return view('Notificationpage');
})->name("Notificaciones");

//vista del carrito de compras de usuario
Route::get(
    'Cart',
    [
        App\Http\Controllers\CartController::class,
        'index'
    ]
)->name("carrito");



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

//rutas de manejo de usuarios
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



    // Formulario de edición de perfil de usuario

    Route::get('perfil', [AuthController::class, 'show'])->name("miperfil")->middleware('auth');

    Route::get('perfil/{user}', [AuthController::class, 'edit'])->name('miperfil.edit');

    // Actualizar perfil de usuario
    Route::put('perfil/{user}', [AuthController::class, 'update'])->name('miperfil.update');

    // Eliminar usuario
    Route::delete('perfil/{user}', [AuthController::class, 'destroy'])->name('miperfil.destroy');

    //vista dashboard
    Route::get('dashboard', [AuthController::class, 'dashboard'])->name('midashboard');

    //edicion y borrado desde el dashboard
    Route::get('/users/{user}/edit', [AuthController::class, 'edit'])->name('users.edit');
    Route::delete('/users/{user}', [AuthController::class, 'destroy'])->name('users.destroy');
});

Route::get('/check-models', function () {
    $modelPath = public_path('models');
    $files = File::files($modelPath);
    return [
        'path_exists' => File::exists($modelPath),
        'files' => collect($files)->map(fn($file) => $file->getFilename())->toArray()
    ];
});


// Rutas adicionales del carrito
Route::post('/cart/add', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [App\Http\Controllers\CartController::class, 'clear'])->name('cart.clear');