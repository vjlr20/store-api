<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Importando controladores (Controllers)
use App\Http\Controllers\HelloController; // <- Importación
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController; // Controlador de Autenticación
use App\Http\Controllers\PaymentController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Primera ruta 
/*
    https://localhost:8000/api/saludo <-
*/
Route::get("/saludo", array(
    HelloController::class, // <- Controlador (Controller)
    'helloWorld' // <- Método del controlador
))->name('hello-world.saludo'); // Nombre de ruta para identificar

/*
    https://localhost:8000/api/info <-
*/
Route::get("/info", array(
    HelloController::class,
    'message'
))->name('hello-world.info');

Route::get("/show-info", array(
    HelloController::class,
    'showInfo'
))->name('hello-world.show-info');

// Rutas para envio e datos (POST)
Route::post("/save-info", array(
    HelloController::class,
    'saveInfo',
))->name('hello-world.save-info');

// Customer routes (Rutas para clientes)

// Listar todos los clientes (index, get-all, all, get)
Route::get('/customer/index', array(
    CustomerController::class,
    'index'
))->name('customer.index');

/* 
    Obtener un cliente (show, find, getBy) 

    http://localhost:8000/api/customer/show/10000000-3
*/
Route::get('/customer/show/{dui}', array(
    CustomerController::class,
    'show'
))->name('customer.show');

// Agregar un cliente (store, insert, add, new, new-resource)
Route::post('/customer/store', array(
    CustomerController::class,
    'store'
))->name('customer.store');

// http://localhost:8000/api/customer/update/12345678-9

Route::put('/customer/update/{dui}', array(
    CustomerController::class,
    'update'
))->name('customer.update');

// http://localhost:8000/api/customer/destroy/12345678-9

Route::delete('/customer/delete/{dui}', array(
    CustomerController::class,
    'destroy'
))->name('customer.delete');

// Customer routes (Rutas para clientes)

// Product routes (Rutas para productos)

Route::get('/product/index', array(
    ProductController::class,
    'index'
))->name('product.index');

Route::get('/product/show', array(
    ProductController::class,
    'show'
))->name('product.show');

Route::post('/product/store', array(
    ProductController::class,
    'store'
))->name('product.store');

Route::put('/product/update', array(
    ProductController::class,
    'update'
))->name('product.update');

Route::delete('/product/delete', array(
    ProductController::class,
    'destroy'
))->name('product.delete');

Route::put('/product/restore', array(
    ProductController::class,
    'restore'
))->name('product.restore');

// Product routes (Rutas para productos)

/* Auth Routes */

/* 
    /api/auth/
*/
Route::group(array( // Arreglo de configuraciones
    'prefix' => "auth" // <- Prefijo global del grupo
), function () { // Función para agrupar
    
    Route::post('/register', array(
        AuthController::class,
        'register'
    ))->name('auth.register');

    Route::post('/login', array(
        AuthController::class,
        'login'
    ))->name('auth.login');

    Route::get('/logout', array(
        AuthController::class,
        'logout'
    ))
    ->middleware([ 'auth:api' ])
    ->name('auth.logout');

    Route::get('/profile', array(
        AuthController::class,
        'profile'
    ))
    ->middleware([ 'auth:api' ])
    ->name('auth.profile');

    // Ruta para enviar correo de cambio
    Route::post('/forgot-password', array(
        AuthController::class,
        'sendResetLink'
    ))->name('password.sent');

    // Ruta para realizar cambio de contraseña
    Route::post('/reset-password', array(
        AuthController::class,
        'resetPassword'
    ))->name('password.reset');
});

Route::post('/payment/checkout', array(
    PaymentController::class,
    'makePayment'
))->name('payment.checkout');
