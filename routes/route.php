<?php
require_once __DIR__ . "/../vendor/autoload.php";


$url = $_GET['url'] ?? '';

use Phroute\Phroute\RouteCollector;

$router = new RouteCollector();

require_once "web.php";
require_once "admin.php";


try {
    # NB. You can cache the return value from $router->getData() so you don't have to create the routes each request - massive speed gains
    $dispatcher = new Phroute\Phroute\Dispatcher($router->getData());

    $response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $url);

    // Print out the value returned from the dispatched function
    echo $response;
} catch (\Phroute\Phroute\Exception\HttpRouteNotFoundException $ex) {
    echo view('404');
    return 0;
} catch (\Phroute\Phroute\Exception\HttpException $ex) {
    echo $ex->getMessage();
}
