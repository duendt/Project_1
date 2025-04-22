<?php

use App\Controller\AdminController\ProductController;
use App\Controller\AdminController\BrandController;
use App\Controller\AdminController\TypeController;
use App\Controller\AdminController\DashboardController;
use App\Controller\AdminController\OrderController;
use App\Controller\AdminController\UserController;
use App\Controllers\Admin\CartController;
use App\Controllers\Admin\VoucherController;
use App\Controller\AdminController\ConfigController;
use App\Controller\AdminController\StorageController;
use App\Controller\AdminController\ColorController;
use App\Controller\AdminController\VariantController;
use App\Controller\AdminController\NewsController;

// Kiểm tra quyền admin trước khi cho phép truy cập vào các route của admin
$router->filter('admin', function () {
    // Kiểm tra người dùng đã đăng nhập chưa
    if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
        return redirect('login');
    }

    // Kiểm tra người dùng có quyền admin không
    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 1) {
        return redirect('');
    }
});

$router->group(['prefix' => 'admin', 'before' => 'admin'], function ($router) {
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
    $router->post('/brands/edit/{id}', [BrandController::class, 'update']);
    $router->post('/brands/delete/{id}', [BrandController::class, 'destroy']);
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
    // Users
    $router->get('/users', [UserController::class, 'index']);
    $router->get('/users/create', [UserController::class, 'create']);
    $router->get('/users/edit/{id}', [UserController::class, 'edit']);
    $router->post('/users/create', [UserController::class, 'store']);
    $router->post('/users/edit/{id}', [UserController::class, 'update']);
    // News
    $router->get('/news', [NewsController::class, 'index']);
    $router->get('/news/create', [NewsController::class, 'create']);
    $router->get('/news/edit/{id}', [NewsController::class, 'edit']);
    $router->post('/news/create', [NewsController::class, 'store']);
    $router->post('/news/edit/{id}', [NewsController::class, 'update']);
    $router->post('/news/delete/{id}', [NewsController::class, 'destroy']);
});