<?php
use App\Controller\AdminController\ProductController;
use App\Controller\AdminController\BrandController;
use App\Controller\AdminController\TypeController;
use App\Models\Post;
use App\Controllers\Admin\DashboardController;
use App\Controllers\Admin\OrderController;
use App\Controllers\Admin\UserController;
use App\Controllers\Admin\CartController;
use App\Controllers\Admin\VoucherController;

// Dashboard
// $router->get('/admin/dashboard', [DashboardController::class, 'index']);

//auth

$router->group(['prefix' => 'admin'], function ($router) {
    // get
    $router->get('/products', [ProductController::class, 'index']);    
    // $router->post('/products', [ProductController::class, 'update']);    

    $router->get('/products/create', [ProductController::class, 'create']);
    $router->get('/products/edit/{id}', handler: [ProductController::class, 'edit']);
    // post
    $router->post('/products/create', [ProductController::class, 'store']);
    $router->post('/products/edit/{id}', handler: [ProductController::class, 'update']);
    $router->delete('/products/{id}', [ProductController::class, 'destroy']);
});

// Products

// // Product Variants
// $router->get('/admin/variants', [ProductController::class, 'index']);
// $router->post('/admin/variants', [ProductController::class, 'storeVariant']);
// $router->put('/admin/variants/{id}', [ProductController::class, 'updateVariant']);
// $router->delete('/admin/variants/{id}', [ProductController::class, 'destroyVariant']);
// // Brands
// $router->get('/admin/brands', [BrandController::class, 'index']);
// $router->post('/admin/brands', [BrandController::class, 'storeBrand']);
// $router->put('/admin/brands/{id}', [BrandController::class, 'updateBrand']);
// $router->delete('/admin/brands/{id}', [BrandController::class, 'destroyBrand']);

// // Product Types
// $router->get('/admin/product-types', [TypeController::class, 'index']);
// $router->post('/admin/product-types', [TypeController::class, 'storeType']);
// $router->put('/admin/product-types/{id}', [TypeController::class, 'updateType']);
// $router->delete('/admin/product-types/{id}', [TypeController::class, 'destroyType']);

// // Orders
// $router->get('/admin/orders', [OrderController::class, 'index']);
// $router->get('/admin/orders/{id}', [OrderController::class, 'show']);
// $router->put('/admin/orders/{id}/status', [OrderController::class, 'updateStatus']);

// // Users
// $router->get('/admin/users', [UserController::class, 'index']);
// $router->get('/admin/users/create', [UserController::class, 'create']);
// $router->post('/admin/users', [UserController::class, 'store']);
// $router->get('/admin/users/{id}/edit', [UserController::class, 'edit']);
// $router->put('/admin/users/{id}', [UserController::class, 'update']);
// $router->delete('/admin/users/{id}', [UserController::class, 'destroy']);
// $router->put('/admin/users/{id}/permissions', [UserController::class, 'updatePermissions']);

// // Carts
// $router->get('/admin/carts', [CartController::class, 'index']);
// $router->get('/admin/carts/{id}', [CartController::class, 'show']);
// $router->post('/admin/carts/{id}/convert-to-order', [CartController::class, 'convertToOrder']);

// // Vouchers
// $router->get('/admin/vouchers', [VoucherController::class, 'index']);
// $router->get('/admin/vouchers/create', [VoucherController::class, 'create']);
// $router->post('/admin/vouchers', [VoucherController::class, 'store']);
// $router->get('/admin/vouchers/{id}/edit', [VoucherController::class, 'edit']);
// $router->put('/admin/vouchers/{id}', [VoucherController::class, 'update']);
// $router->delete('/admin/vouchers/{id}', [VoucherController::class, 'destroy']);
// $router->get('/admin/vouchers/{id}/usage', [VoucherController::class, 'usageDetails']); 