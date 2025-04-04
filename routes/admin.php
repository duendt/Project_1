<?php
use App\Controller\AdminController\ListProduct;
use App\Models\Post;
$router->get('/admin', [ListProduct::class, 'index']);

$router->get('/product_variant/{id}', [ListProduct::class, 'productVariant']);
$router->get('/config_variant/{id}', [ListProduct::class, 'configVariant']);
