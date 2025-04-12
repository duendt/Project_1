<?php

use App\Controller\HomeController;
use App\Controller\DetailProductController;
use App\Controller\CartController;
use App\Controller\CheckoutController;
use App\Controller\Auth\AuthController;

$router->get('/', [HomeController::class,'index']);
$router->get('/san-pham/{id}', [DetailProductController::class, 'index']);

// Auth routes
$router->get('/login', [AuthController::class, 'showLoginForm']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/regsiter', [AuthController::class, 'showRegisterForm']);
$router->post('/regsiter', [AuthController::class, 'register']);
$router->get('/logout', [AuthController::class, 'logout']);

// Kiểm tra đăng nhập trước khi cho phép truy cập vào giỏ hàng và thanh toán
$router->filter('auth', function() {
    if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
        return redirect('login');
    }
});

// Cart routes
$router->group(['prefix' => 'cart', 'before' => 'auth'], function ($router) {
    $router->get('/', [CartController::class, 'index']);
    $router->post('/add', [CartController::class, 'add']);
    $router->post('/update', [CartController::class, 'update']);
    $router->post('/remove', [CartController::class, 'remove']);
    $router->post('/clear', [CartController::class, 'clear']);
});

// Checkout routes
$router->group(['before' => 'auth'], function ($router) {
    $router->get('/thanh-toan', [CheckoutController::class, 'index']);
    $router->post('/thanh-toan', [CheckoutController::class, 'process']);
});