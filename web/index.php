<?php
    require_once ('../vendor/autoload.php');
    
    use \SciMS\Controller\Router;
    
    $router = new Router();
    echo $router->parse($_SERVER['REQUEST_URI']);