<?php 
    spl_autoload_register();

    require_once 'app/config/routes.php';
    require_once 'app/vendor/Route.php';

    $route = new \vendor\Route();
    $route->startApp();