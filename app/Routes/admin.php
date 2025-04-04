<?php

use App\Controllers\Admin\DashboardController;
use App\Controllers\Admin\ProductController;
use App\Controllers\Admin\OrderController;
use App\Controllers\Admin\UserController;
use App\Controllers\Admin\CartController;
use App\Controllers\Admin\VoucherController;

// Dashboard
$router->get('/admin/dashboard', [DashboardController::class, 'index']);

// Products
$router->get('/admin/products', [ProductController::class, 'index']);
$router->get('/admin/products/create', [ProductController::class, 'create']);
$router->post('/admin/products', [ProductController::class, 'store']);
$router->get('/admin/products/{id}/edit', [ProductController::class, 'edit']);
$router->put('/admin/products/{id}', [ProductController::class, 'update']);
$router->delete('/admin/products/{id}', [ProductController::class, 'destroy']);

// Brands
$router->get('/admin/brands', [ProductController::class, 'brands']);
$router->post('/admin/brands', [ProductController::class, 'storeBrand']);
$router->put('/admin/brands/{id}', [ProductController::class, 'updateBrand']);
$router->delete('/admin/brands/{id}', [ProductController::class, 'destroyBrand']);

// Product Types
$router->get('/admin/product-types', [ProductController::class, 'types']);
$router->post('/admin/product-types', [ProductController::class, 'storeType']);
$router->put('/admin/product-types/{id}', [ProductController::class, 'updateType']);
$router->delete('/admin/product-types/{id}', [ProductController::class, 'destroyType']);

// Product Variants
$router->get('/admin/variants', [ProductController::class, 'variants']);
$router->post('/admin/variants', [ProductController::class, 'storeVariant']);
$router->put('/admin/variants/{id}', [ProductController::class, 'updateVariant']);
$router->delete('/admin/variants/{id}', [ProductController::class, 'destroyVariant']);

// Orders
$router->get('/admin/orders', [OrderController::class, 'index']);
$router->get('/admin/orders/{id}', [OrderController::class, 'show']);
$router->put('/admin/orders/{id}/status', [OrderController::class, 'updateStatus']);

// Users
$router->get('/admin/users', [UserController::class, 'index']);
$router->get('/admin/users/create', [UserController::class, 'create']);
$router->post('/admin/users', [UserController::class, 'store']);
$router->get('/admin/users/{id}/edit', [UserController::class, 'edit']);
$router->put('/admin/users/{id}', [UserController::class, 'update']);
$router->delete('/admin/users/{id}', [UserController::class, 'destroy']);
$router->put('/admin/users/{id}/permissions', [UserController::class, 'updatePermissions']);

// Carts
$router->get('/admin/carts', [CartController::class, 'index']);
$router->get('/admin/carts/{id}', [CartController::class, 'show']);
$router->post('/admin/carts/{id}/convert-to-order', [CartController::class, 'convertToOrder']);

// Vouchers
$router->get('/admin/vouchers', [VoucherController::class, 'index']);
$router->get('/admin/vouchers/create', [VoucherController::class, 'create']);
$router->post('/admin/vouchers', [VoucherController::class, 'store']);
$router->get('/admin/vouchers/{id}/edit', [VoucherController::class, 'edit']);
$router->put('/admin/vouchers/{id}', [VoucherController::class, 'update']);
$router->delete('/admin/vouchers/{id}', [VoucherController::class, 'destroy']);
$router->get('/admin/vouchers/{id}/usage', [VoucherController::class, 'usageDetails']); 