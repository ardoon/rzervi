<?php

use App\Http\Controllers\Admin\ProviderController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\VerifyPhoneController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\UserController as userCtrl;
use App\Http\Controllers\Customer\RequestController;
use App\Http\Controllers\Customer\ServerController;
use App\Http\Controllers\Provider\CustomerController;
use App\Http\Controllers\Provider\RequestController as ProviderRequestController;
use App\Http\Controllers\Provider\ServiceController as ProviderServices;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
})->middleware(['guest']);

Route::get('/sna/{provider}', function ($provider) {
    $url = url('/') . '/register?provider=' . $provider;
    return redirect($url);
})->middleware(['guest']);

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified', 'verifyPhone'])->name('dashboard');

// Verify Phone Number
Route::get('/verify/phone', [VerifyPhoneController::class, 'create'])->middleware(['auth', 'verified'])->name('verify.phone');

Route::post('/verify/phone', [VerifyPhoneController::class, 'store'])->middleware(['auth', 'verified'])->name('verify.phone');

Route::get('/setting', function () {
    return Inertia::render('Setting', [
        'csrf' => csrf_token()
    ]);
})->middleware(['auth', 'verified'])->name('setting');

Route::put('/setting/{user}', [userCtrl::class, 'update'])->middleware(['auth', 'verified']);

Route::get('/media/{user}/{type}', [MediaController::class, 'show'])->middleware(['auth', 'verified']);
Route::post('/media', [MediaController::class, 'store']);
Route::delete('/media/{user}/{type}', [MediaController::class, 'destroy'])->middleware(['auth', 'verified']);

//  :::::::::::::::::::::::::::: ADMIN PANEL ::::::::::::::::::::::::::::

Route::middleware(['auth', 'verified', 'verifyPhone', 'can:admin'])->prefix('/admin')->group(function () {

    Route::prefix('/users')->group(function () {

        Route::get('/', [UserController::class, 'index'])->name('admin.users');
        Route::get('/create', [UserController::class, 'create'])->name('admin.users.create');
        Route::post('/', [UserController::class, 'store'])->name('admin.users');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('admin.users.delete');

    });

    Route::prefix('/services')->group(function () {

        Route::get('/', [ServiceController::class, 'index'])->name('admin.services');
        Route::get('/create', [ServiceController::class, 'create'])->name('admin.services.create');
        Route::post('/', [ServiceController::class, 'store'])->name('admin.services');
        Route::get('/{service}/edit', [ServiceController::class, 'edit'])->name('admin.services.edit');
        Route::put('/{service}', [ServiceController::class, 'update'])->name('admin.services.update');
        Route::delete('/{service}', [ServiceController::class, 'destroy'])->name('admin.services.delete');

    });

    Route::prefix('/providers')->group(function () {

        Route::get('/', [ProviderController::class, 'index'])->name('admin.providers');
        Route::get('/create', [ProviderController::class, 'create'])->name('admin.providers.create');
        Route::post('/', [ProviderController::class, 'store'])->name('admin.providers');
        Route::get('/{provider}/edit', [ProviderController::class, 'edit'])->name('admin.providers.edit');
        Route::put('/{provider}', [ProviderController::class, 'update'])->name('admin.providers.update');
        Route::delete('/{provider}', [ProviderController::class, 'destroy'])->name('admin.providers.delete');

    });

});

//  :::::::::::::::::::::::::::: Provider PANEL ::::::::::::::::::::::::::::

Route::middleware(['auth', 'verified', 'verifyPhone', 'can:provider'])->prefix('/provider')->group(function () {

    Route::prefix('/users')->group(function () {

        Route::get('/', [CustomerController::class, 'index'])->name('provider.users');
        Route::get('/create', [CustomerController::class, 'create'])->name('provider.users.create');
        Route::post('/', [CustomerController::class, 'store'])->name('provider.users');
        Route::get('/{user}/edit', [CustomerController::class, 'edit'])->name('provider.users.edit');
        Route::put('/{user}', [CustomerController::class, 'update'])->name('provider.users.update');
        Route::delete('/{user}', [CustomerController::class, 'destroy'])->name('provider.users.delete');

    });

    Route::prefix('/services')->group(function () {

        Route::get('/', [ProviderServices::class, 'index'])->name('provider.services');
        Route::get('/create', [ProviderServices::class, 'create'])->name('provider.services.create');
        Route::post('/', [ProviderServices::class, 'store'])->name('provider.services');
        Route::get('/{service}/edit', [ProviderServices::class, 'edit'])->name('provider.services.edit');
        Route::put('/{service}', [ProviderServices::class, 'update'])->name('provider.services.update');
        Route::delete('/{service}', [ProviderServices::class, 'destroy'])->name('provider.services.delete');

    });

    Route::prefix('/requests')->group(function () {
        Route::get('/', [ProviderRequestController::class, 'index'])->name('provider.requests');
        Route::get('/{request}', [ProviderRequestController::class, 'show']);
        Route::delete('/{request}', [ProviderRequestController::class, 'destroy']);
        Route::post('/{request}/accept', [ProviderRequestController::class, 'accept']);
        Route::post('/{request}/cancel', [ProviderRequestController::class, 'cancel']);

    });

});

//  :::::::::::::::::::::::::::: Customer PANEL ::::::::::::::::::::::::::::
Route::middleware(['auth', 'verified', 'verifyPhone', 'can:customer'])->prefix('/customer')->group(function () {

    Route::prefix('/requests')->group(function () {

        Route::get('/', [RequestController::class, 'index'])->name('customer.requests');
        Route::get('/create', [RequestController::class, 'create'])->name('customer.requests.create');
        Route::get('/{server}/services', [RequestController::class, 'get_services']);
        Route::post('/', [RequestController::class, 'store'])->name('customer.requests');

        Route::get('/{request}/edit', [RequestController::class, 'edit']);
        Route::put('/{request}', [RequestController::class, 'update']);
        Route::delete('/{request}', [RequestController::class, 'destroy']);
        Route::post('/{request}/cancel', [RequestController::class, 'cancel']);

    });

    Route::prefix('/servers')->group(function () {

        Route::get('/', [ServerController::class, 'index'])->name('customer.servers');
        Route::get('/create', [ServerController::class, 'create'])->name('customer.servers.create');
        Route::get('/{server}/destroy', [ServerController::class, 'destroy']);
        Route::get('/{server}/join', [ServerController::class, 'join']);

    });

});


require __DIR__ . '/auth.php';
