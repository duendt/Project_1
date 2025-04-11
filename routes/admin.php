<?php
use App\Controller\AdminController\ProductController;
use App\Controller\AdminController\BrandController;
use App\Controller\AdminController\TypeController;
use App\Controller\AdminController\DashboardController;  // Note the correct namespace with 's'
use App\Controller\AdminController\OrderController;
use App\Controller\AdminController\UserController;
use App\Controllers\Admin\CartController;
use App\Controllers\Admin\VoucherController;
use App\Controller\AdminController\ConfigController;
use App\Controller\AdminController\StorageController;
use App\Controller\AdminController\ColorController;
use App\Controller\AdminController\VariantController;
// Dashboard
// $router->get('/admin/dashboard', [DashboardController::class, 'index']);

//auth

$router->group(['prefix' => 'admin'], function ($router) {
    $router->get('/', [DashboardController::class, 'index']);
    $router->get('/products', [ProductController::class, 'index']);    
    $router->get('/products/create', [ProductController::class, 'create']);
    $router->get('/products/edit/{id}', handler: [ProductController::class, 'edit']);
    $router->post('/products/create', [ProductController::class, 'store']);
    $router->post('/products/edit/{id}', handler: [ProductController::class, 'update']);
    $router->post('/products/delete/{id}', [ProductController::class, 'destroy']);
    // Product Variants
    $router->get('/variants', [VariantController::class, 'index']);
    $router->get('/variants/create', [VariantController::class, 'create']);
    $router->get('/variants/edit/{id}', handler: [VariantController::class, 'edit']);
    $router->post('/variants/create', [VariantController::class, 'store']);
    $router->post('/variants/edit/{id}', handler: [VariantController::class, 'update']);
    $router->post('/variants/delete/{id}', handler: [VariantController::class, 'destroy']);
    // Configs
    $router->get('/configs', [ConfigController::class, 'index']);
    $router->get('/configs/create', [ConfigController::class, 'create']);
    $router->get('/configs/edit/{id}', handler: [ConfigController::class, 'edit']);
    $router->post('/configs/create', [ConfigController::class, 'store']);
    $router->post('/configs/edit/{id}', handler: [ConfigController::class, 'update']);
    $router->post('/configs/delete/{id}', handler: [ConfigController::class, 'destroy']);
    // Storages
    $router->get('/storages', [StorageController::class, 'index']);
    $router->get('/storages/create', [StorageController::class, 'create']);
    $router->get('/storages/edit/{id}', handler: [StorageController::class, 'edit']);
    $router->post('/storages/create', [StorageController::class, 'store']);
    $router->post('/storages/edit/{id}', handler: [StorageController::class, 'update']);
    $router->post('/storages/delete/{id}', handler: [StorageController::class, 'destroy']);
    // Colors
    $router->get('/colors', [ColorController::class, 'index']);
    $router->get('/colors/create', [ColorController::class, 'create']);
    $router->get('/colors/edit/{id}', handler: [ColorController::class, 'edit']);
    $router->post('/colors/create', [ColorController::class, 'store']);
    $router->post('/colors/edit/{id}', handler: [ColorController::class, 'update']);
    $router->post('/colors/delete/{id}', handler: [ColorController::class, 'destroy']);
    // Brands
    $router->get('/brands', [BrandController::class, 'index']);
    $router->get('/brands/create', [BrandController::class, 'create']);
    $router->get('/brands/edit/{id}', [BrandController::class, 'edit']);
    $router->post('/brands/create', [BrandController::class, 'store']);
    $router->post('/brands/edit/{id}',[BrandController::class, 'update']);
    $router->post('/brands/delete/{id}',[BrandController::class, 'destroy']);
    // Product Types
    $router->get('/types', [TypeController::class, 'index']);
    $router->get('/types/create', [TypeController::class, 'create']);
    $router->get('/types/edit/{id}', handler: [TypeController::class, 'edit']);
    $router->post('/types/create', [TypeController::class, 'store']);
    $router->post('/types/edit/{id}', handler: [TypeController::class, 'update']);
    $router->post('/types/delete/{id}', handler: [TypeController::class, 'destroy']);
    // Orders
    $router->get('/order', [OrderController::class, 'index']);
    $router->get('/order/edit/{id}', [OrderController::class, 'edit']);
    $router->post('/order/update/{id}', [OrderController::class, 'update']);
    $router->post('/order/delete/{id}', [OrderController::class, 'delete']);
    $router->post('/order/add-product/{id}', [OrderController::class, 'addProduct']);
    $router->post('/order/update-quantity/{id}', [OrderController::class, 'updateQuantity']);
    $router->post('/order/remove-product/{id}', [OrderController::class, 'removeProduct']);
    // Users
    $router->get('/users', [UserController::class, 'index']);
    $router->get('/users/create', [UserController::class, 'create']);
    $router->get('/users/edit/{id}', [UserController::class, 'edit']);
    $router->post('/users/create', [UserController::class, 'store']);
    $router->post('/users/edit/{id}', [UserController::class, 'update']);
    $router->post('/users/delete/{id}', [UserController::class, 'destroy']);
    // Carts
    // $router->get('/carts', [CartController::class, 'index']);
    // $router->get('/carts/{id}', [CartController::class, 'show']);
    // $router->post('/carts/{id}/convert-to-order', [CartController::class, 'convertToOrder']);
    // // Vouchers 
    // $router->get('/vouchers', [VoucherController::class, 'index']);
    // $router->get('/vouchers/create', [VoucherController::class, 'create']);
    // $router->post('/vouchers', [VoucherController::class, 'store']);
    // $router->get('/vouchers/{id}/edit', [VoucherController::class, 'edit']);
    // $router->put('/vouchers/{id}', [VoucherController::class, 'update']);
    // $router->delete('/vouchers/{id}', [VoucherController::class, 'destroy']);
    // $router->get('/vouchers/{id}/usage', [VoucherController::class, 'usageDetails']);
});


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