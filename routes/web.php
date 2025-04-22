<?php

use App\Controller\HomeController;
use App\Controller\DetailProductController;
use App\Controller\ClientController\CartController;
use App\Controller\ClientController\CheckoutController;
use App\Controller\ClientController\OrderController;
use App\Controller\Auth\AuthController;
use App\Controller\NewsController;
// Trang chủ
$router->get('/', [HomeController::class, 'index']);
// Danh sách sản phẩm
$router->get('/category/{id}', [HomeController::class, 'ProductTypes']);

// Tìm kiếm
$router->get('/search', [HomeController::class, 'search']);
// Sản phẩm
$router->get('/san-pham/{id}', [DetailProductController::class, 'index']);

// Tin tức
$router->get('/news', [NewsController::class, 'index']);
$router->get('/news/{id}', [NewsController::class, 'detail']);

// Auth routes
$router->get('/login', [AuthController::class, 'showLoginForm']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/register', [AuthController::class, 'showRegisterForm']);
$router->post('/register', [AuthController::class, 'register']);
$router->get('/logout', [AuthController::class, 'logout']);

// Kiểm tra đăng nhập trước khi cho phép truy cập vào giỏ hàng và thanh toán
$router->filter('auth', function () {
    if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
        return redirect('login');
    }
});
// Lucky
$router->group(['prefix' => 'lucky', 'before' => 'auth'], function ($router) {
    $router->get('/', [HomeController::class, 'lucky']);
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
    $router->post('/checkout', [CheckoutController::class, 'index']);
    $router->post('/check-out', [CheckoutController::class, 'process']);
});

// Order routes
$router->group(['prefix' => 'order', 'before' => 'auth'], function ($router) {
    $router->get('/', [OrderController::class, 'index']);
});