<?php

use App\Controller\HomeController;
use App\Controller\DetailProductController;
use App\Controller\ClientController\CartController;
use App\Controller\ClientController\CheckoutController;
use App\Controller\ClientController\OrderController;
use App\Controller\Auth\AuthController;

$router->get('/', [HomeController::class,'index']);
$router->get('/san-pham/{id}', [DetailProductController::class, 'index']);
$router->get('/category/{id}', [HomeController::class, 'ProductTypes']);
$router->get('/lucky', function () {
    return view('Voucher.lucky');
    // Trả về view với danh sách sản phẩm ngẫu nhiên
});


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
    $router->post('/update-quantity', [CartController::class, 'updateQuantity']);
    $router->post('/remove', [CartController::class, 'removeItem']);
});

// Checkout routes
$router->group(['before' => 'auth'], function ($router) {
    $router->post('/checkout', [CheckoutController::class, 'index']);
    $router->post('/check-out', [CheckoutController::class, 'process']); // Đảm bảo route này tồn tại
});

$router->group(['prefix' => 'order', 'before' => 'auth'], function ($router) {
    $router->get('/', [OrderController::class, 'index']);
});