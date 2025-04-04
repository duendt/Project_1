<?php
require_once __DIR__ . "/../env.php";
require_once __DIR__ . "/../app/Controllers/HomeController.php";
require_once __DIR__ . "/../app/Controllers/ProductController.php";
require_once __DIR__ . "/../app/Controllers/CartController.php";
require_once __DIR__ . "/../app/Controllers/CheckoutController.php";

use App\Controllers\HomeController;
use App\Controllers\ProductController;
use App\Controllers\CartController;
use App\Controllers\CheckoutController;

// Lấy URL hiện tại
$request_url = !empty($_GET['url']) ? $_GET['url'] : '/';
$url_parts = explode('/', $request_url);
$route = $url_parts[0];

// Router
switch ($route) {
    case '':
    case '/':
        $controller = new HomeController();
        $controller->index();
        break;

    // Routes for admin
    case 'admin':
        // Bỏ qua view function và sử dụng layout admin trực tiếp
        if (!isset($url_parts[1]) || $url_parts[1] == '') {
            // Mặc định là dashboard
            $url_parts[1] = 'dashboard';
        }
        
        // Kiểm tra file tồn tại
        $admin_view_file = __DIR__ . "/../app/Views/admin/{$url_parts[1]}/index.php";
        if (file_exists($admin_view_file)) {
            // Include layout admin
            include_once __DIR__ . "/../app/Views/layouts/admin.php";
        } else {
            // 404 Not Found
            header("HTTP/1.0 404 Not Found");
            require_once __DIR__ . '/../app/Views/404.php';
        }
        break;

    case 'san-pham':
        $controller = new ProductController();
        if (isset($url_parts[1])) {
            $controller->detail($url_parts[1]);
        } else {
            $controller->index();
        }
        break;

    case 'danh-muc':
        $controller = new ProductController();
        if (isset($url_parts[1])) {
            $controller->category($url_parts[1]);
        } else {
            $controller->categories();
        }
        break;

    case 'gio-hang':
        $controller = new CartController();
        $controller->index();
        break;

    case 'thanh-toan':
        $controller = new CheckoutController();
        $controller->index();
        break;

    // API routes
    case 'api':
        header('Content-Type: application/json');
        switch ($url_parts[1]) {
            case 'cart':
                $controller = new CartController();
                switch ($_SERVER['REQUEST_METHOD']) {
                    case 'POST':
                        $controller->add();
                        break;
                    case 'PUT':
                        $controller->update();
                        break;
                    case 'DELETE':
                        $controller->remove();
                        break;
                }
                break;

            case 'districts':
                if (isset($url_parts[2])) {
                    echo json_encode([
                        ['id' => 1, 'name' => 'Quận 1'],
                        ['id' => 2, 'name' => 'Quận 2'],
                        ['id' => 3, 'name' => 'Quận 3']
                    ]);
                }
                break;

            case 'wards':
                if (isset($url_parts[2])) {
                    echo json_encode([
                        ['id' => 1, 'name' => 'Phường 1'],
                        ['id' => 2, 'name' => 'Phường 2'],
                        ['id' => 3, 'name' => 'Phường 3']
                    ]);
                }
                break;

            case 'shipping-fee':
                echo json_encode(['fee' => 30000]);
                break;

            case 'orders':
                $controller = new CheckoutController();
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $controller->createOrder();
                }
                break;
        }
        break;

    default:
        // 404 Not Found
        header("HTTP/1.0 404 Not Found");
        require_once __DIR__ . '/../app/Views/404.php';
        break;
}
