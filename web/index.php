<?php
    require_once('../vendor/autoload.php');
    
    use \SciMS\Controller\Router;
    
    session_start();
    
    // Create an object Router to redirect user.
    $router = new Router();
    $view = $router->render($_SERVER['REQUEST_URI']);
    
    // Display the corresponding view.
    echo $view;
