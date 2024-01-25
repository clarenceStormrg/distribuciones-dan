<?php

use App\Http\Controllers\admin\CategoryProductController;
use App\Http\Controllers\admin\ClientController;
use App\Http\Controllers\admin\GraphController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\AuthController;
use App\Models\CategoryProduct;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AuthController::class, 'index'])->name('inicio');
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logados', [AuthController::class, 'logados'])->name('logados');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/maps', [AuthController::class, 'maps'])->name('maps');

Route::group(['middleware' => ['auth']], function () {
    
    Route::get('/home', [AuthController::class, 'home'])->name('home');

    Route::get('/users', [UserController::class, 'index'])->name('user.index');
    Route::get('/users/create',  [UserController::class, 'create'])->name('user.create');
    Route::post('/users', UserController::class .'@store')->name('user.store');
    Route::get('/users/{user}/edit', UserController::class .'@edit')->name('user.edit');
    Route::put('/users/{user}', UserController::class .'@update')->name('user.update');
    Route::delete('/users/{user}', UserController::class .'@destroy')->name('user.destroy');

    Route::get('/categoryProducts', [CategoryProductController::class, 'index'])->name('categoryProduct.index');
    Route::get('/categoryProducts/create',  [CategoryProductController::class, 'create'])->name('categoryProduct.create');
    Route::post('/categoryProducts', CategoryProductController::class .'@store')->name('categoryProduct.store');
    Route::get('/categoryProducts/{category}/edit', CategoryProductController::class .'@edit')->name('categoryProduct.edit');
    Route::put('/categoryProducts/{category}', CategoryProductController::class .'@update')->name('categoryProduct.update');
    Route::delete('/categoryProducts/{category}', CategoryProductController::class .'@destroy')->name('categoryProduct.destroy');

    Route::get('/products', [ProductController::class, 'index'])->name('product.index');
    Route::get('/products/create',  [ProductController::class, 'create'])->name('product.create');
    Route::post('/products', ProductController::class .'@store')->name('product.store');
    Route::get('/products/{product}/edit', ProductController::class .'@edit')->name('product.edit');
    Route::put('/products/{product}', ProductController::class .'@update')->name('product.update');
    Route::delete('/products/{product}', ProductController::class .'@destroy')->name('product.destroy');

    Route::get('/client', [ClientController::class, 'index'])->name('client.index');
    Route::get('/client/create',  [ClientController::class, 'create'])->name('client.create');
    Route::post('/client', ClientController::class .'@store')->name('client.store');
    Route::get('/client/{client}/edit', ClientController::class .'@edit')->name('client.edit');
    Route::put('/client/{client}', ClientController::class .'@update')->name('client.update');
    Route::delete('/client/{client}', ClientController::class .'@destroy')->name('client.destroy');

    Route::get('/order', [OrderController::class, 'index'])->name('order.index');
    Route::get('/order/create',  [OrderController::class, 'create'])->name('order.create');
    Route::post('/order', OrderController::class .'@store')->name('order.store');
    Route::get('/order/{order}/edit', OrderController::class .'@edit')->name('order.edit');
    Route::put('/order/{order}', OrderController::class .'@update')->name('order.update');
    Route::delete('/order/{order}', OrderController::class .'@destroy')->name('order.destroy');
    Route::get('/order/{order}/print', OrderController::class .'@print')->name('order.print');

    Route::get('/pickup', OrderController::class .'@pickup')->name('order.pickup');
    Route::post('/pickupProduct', OrderController::class .'@pickupProduct')->name('pickup.product');
    Route::post('/pickupMaps', OrderController::class .'@pickupMaps')->name('pickup.maps');

    Route::get('/report', GraphController::class .'@report')->name('graph.report');
});

