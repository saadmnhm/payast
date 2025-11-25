<?php

use App\Http\Controllers\Apps\PermissionManagementController;
use App\Http\Controllers\Apps\RoleManagementController;
use App\Http\Controllers\Apps\UserManagementController;
use App\Http\Controllers\Apps\ContactController;
use App\Http\Controllers\Apps\BrandController;
use App\Http\Controllers\Apps\ConstructeurController;
use App\Http\Controllers\Apps\CatalogeController;
use App\Http\Controllers\Apps\NavigationMenuController;
use App\Http\Controllers\Apps\PromotionController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactFormController;
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
        Route::prefix('apps/contacts')->name('apps.contact.')->controller(ContactController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{contact}', 'show')->name('show');
            Route::patch('/{id}/update-status', 'updateStatus')->name('update-status');
        });

        Route::prefix('orders')->name('apps.orders.')->controller(\App\Http\Controllers\Apps\OrderController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{order}', 'show')->name('show');
            Route::patch('/{order}/status', 'updateStatus')->name('update-status');
            Route::patch('/{order}/payment-status', 'updatePaymentStatus')->name('update-payment-status');
            Route::delete('/{order}', 'destroy')->name('destroy');
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


        Route::prefix('cataloge')->name('apps.cataloge.')->controller(CatalogeController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            
            // Categories
            Route::prefix('categories')->name('categories.')->group(function () {
                Route::get('/', 'categoriesIndex')->name('index');
                Route::get('/create', 'createCategory')->name('create');
                Route::post('/', 'storeCategory')->name('store');
                Route::get('/{category}', 'showCategory')->name('show');
                Route::get('/{category}/edit', 'editCategory')->name('edit');
                Route::put('/{category}', 'updateCategory')->name('update');
                Route::delete('/{category}', 'destroyCategory')->name('destroy');
            });
            
            // Pieces
            Route::prefix('pieces')->name('pieces.')->group(function () {
                Route::get('/', 'piecesIndex')->name('index');
                Route::get('/create', 'createPiece')->name('create');
                Route::post('/', 'storePiece')->name('store');
                Route::get('/{piece}', 'showPiece')->name('show');
                Route::get('/{piece}/edit', 'editPiece')->name('edit');
                Route::put('/{piece}', 'updatePiece')->name('update');
                Route::delete('/{piece}', 'destroyPiece')->name('destroy');
            });
        });

        // Promotions
        Route::prefix('promotions')->name('apps.promotions.')->controller(PromotionController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::post('/piece/{piece}', 'addPieceToPromotion')->name('add-piece');
            Route::get('/{promotion}', 'show')->name('show');
            Route::get('/{promotion}/edit', 'edit')->name('edit');
            Route::put('/{promotion}', 'update')->name('update');
            Route::delete('/{promotion}', 'destroy')->name('destroy');
        });
    
    });
});


Route::name('front.')->group(function () {
    Route::get('/', [HomeController::class, 'home'])->name('home');
    
    // Search
    Route::get('/search/suggestions', [PeiceController::class, 'searchSuggestions'])->name('search.suggestions');
    
    Route::get('/pieces', [PeiceController::class, 'index'])->name('list');
    Route::get('/pieces/{category}/{subcategory?}', [PeiceController::class, 'index'])
        ->where('subcategory', '.*')
        ->name('list.category');
    Route::get('/piece/{id}', [PeiceController::class, 'show'])->name('piece.show');

    Route::prefix('contact')->name('contact.')->group(function () {
        Route::get('/', [ContactFormController::class, 'index'])->name('index');
        Route::post('/', [ContactFormController::class, 'store'])->name('store');
    });  

    Route::get('/promo', [HomeController::class, 'promo'])->name('promotion.promo');
    Route::get('/checkout/cart', [CheckoutController::class, 'index'])->name('cart');
    Route::post('/checkout/process', [CheckoutController::class, 'processOrder'])->name('checkout.process');
    Route::get('/order/success/{order}', [CheckoutController::class, 'success'])->name('order.success');
});



// Other routes
Route::get('/error', function () {
    abort(500);
});

Route::get('/auth/redirect/{provider}', [SocialiteController::class, 'redirect']);





require __DIR__ . '/auth.php';
