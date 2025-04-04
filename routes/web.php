<?php

use App\Controller\HomeController;
use App\Models\Post;

$router->get('/', [HomeController::class,'index']);
