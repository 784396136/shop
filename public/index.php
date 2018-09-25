<?php

// 定义根目录
define('ROOT',__DIR__.'/../');

// 类的自动加载     controllers\IndexControllers
function load($class)
{
    $path = str_replace("\\","/",$class);
    require ROOT . $path . ".php";
}
spl_autoload_register('load');

// 解析路由
$controller = "controllers\IndexController";
$active = "index";
if(isset($_SERVER['PATH_INFO']))
{
    $router = explode("/",$_SERVER['PATH_INFO']);
    $controller = "\controllers\\" . ucfirst($router[1]) . "Controller";
    $active = $router[2];
}

$c = new $controller;
$c->$active();