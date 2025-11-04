<?php

use App\Http\Controllers\Apps\PermissionManagementController;
use App\Http\Controllers\Apps\RoleManagementController;
use App\Http\Controllers\Apps\UserManagementController;
use App\Http\Controllers\Apps\GallerieController;
use App\Http\Controllers\Apps\ContactController;
use App\Http\Controllers\Apps\BrandController;
use App\Http\Controllers\Apps\ConstructeurController;
use App\Http\Controllers\Apps\NavigationMenuController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PeiceController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->get('/', function () {
    return redirect()->route('dashboard');
});
// Admin routes
Route::middleware(['auth'])->group(function () {
    Route::prefix('')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // User management routes
        Route::prefix('users')->name('apps.users.')->controller(UserManagementController::class)->group(function () {
            Route::get('/trashed', 'trashed')->name('trashed');
            Route::post('/{id}/restore', 'restore')->name('restore');
            Route::put('/{user}/update-field', 'updateField')->name('update-field');
            Route::put('/{user}/update-password', 'updatePassword')->name('update-password');
            Route::post('/{user}/update-avatar', 'updateAvatar')->name('update-avatar');
            Route::post('/{user}/toggle-status', 'toggleStatus')->name('toggle-status');

            // Resource routes
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{user}', 'show')->name('show');
            Route::get('/{user}/edit', 'edit')->name('edit');
            Route::put('/{user}', 'update')->name('update');
            Route::delete('/{user}', 'destroy')->name('destroy');
        });

        // Role and permission routes
        Route::resource('roles', RoleManagementController::class)->names('apps.roles');
        Route::resource('permissions', PermissionManagementController::class)->names('apps.permissions');


        // Contact routes
        Route::prefix('contact')->name('apps.contact.')->controller(ContactController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{contact}', 'show')->name('show');
            Route::patch('/{id}/update-status', 'updateStatus')->name('update-status');
        });



        // Gallery routes
        Route::prefix('gallerie')->name('apps.gallerie.')->controller(GallerieController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{gallerie}', 'show')->name('show');
            Route::get('/{gallerie}/edit', 'edit')->name('edit');
            Route::put('/{gallerie}', 'update')->name('update');
            Route::delete('/{gallerie}', 'destroy')->name('destroy');
            Route::post('/update-order', 'updateOrder')->name('update-order');
        });

        // Navigation Menu routes
        Route::prefix('navigation-menu')->name('apps.navigation-menu.')->controller(NavigationMenuController::class)->group(function () {
            Route::post('/update-order', 'updateOrder')->name('update-order');
            Route::post('/{navigationMenu}/toggle-status', 'toggleStatus')->name('toggle-status');

            // Resource routes
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{navigationMenu}', 'show')->name('show');
            Route::get('/{navigationMenu}/edit', 'edit')->name('edit');
            Route::put('/{navigationMenu}', 'update')->name('update');
            Route::delete('/{navigationMenu}', 'destroy')->name('destroy');
        });

        
        Route::prefix('brands')->name('apps.brand.')->controller(BrandController::class)->group(function () {

            Route::post('/{brand}/toggle-status', 'toggleStatus')->name('toggle-status');
            // Resource routes
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{brand}/edit', 'edit')->name('edit');
            Route::put('/{brand}', 'update')->name('update');
            Route::delete('/{brand}', 'destroy')->name('destroy');
        });

        Route::prefix('Constructeurs')->name('apps.constructeur.')->controller(ConstructeurController::class)->group(function () {

            Route::post('/{constructeur}/toggle-status', 'toggleStatus')->name('toggle-status');
            // Resource routes
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{constructeur}/edit', 'edit')->name('edit');
            Route::put('/{constructeur}', 'update')->name('update');
            Route::delete('/{constructeur}', 'destroy')->name('destroy');
        });
    
    });
});


Route::name('front.')->group(function () {
    Route::get('/', [HomeController::class, 'home'])->name('home');
    Route::get('/pieces', [PeiceController::class, 'index'])->name('list');
    Route::get('/checkout/cart', [CheckoutController::class, 'index'])->name('cart');
    Route::post('/checkout/process', [CheckoutController::class, 'processOrder'])->name('checkout.process');
});



// Other routes
Route::get('/error', function () {
    abort(500);
});

Route::get('/auth/redirect/{provider}', [SocialiteController::class, 'redirect']);





require __DIR__ . '/auth.php';
