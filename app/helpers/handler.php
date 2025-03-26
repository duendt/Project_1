<?php

use eftec\bladeone\BladeOne;

function view($pathView, $data = [])
{

    $views = ROOT_DIR . "/app/Views";
    $cache = ROOT_DIR . '/app/cache';

    $blade = new BladeOne($views, $cache, BladeOne::MODE_AUTO);

    return $blade->run($pathView, $data);
}

//Hàm dd để debug
function dd($data)
{
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
    die;
}
//Chuyển hướng website
function redirect($path)
{
    $path = APP_URL . $path;
    header("location: $path");
    die;
}
