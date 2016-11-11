<?php
    require_once('../vendor/autoload.php');
    
    $path   = dirname(__DIR__) . '/views/';
    $loader = new \Twig_Loader_Filesystem($path);
    $twig   = new \Twig_Environment($loader);
    
    echo $twig->render('user.html.twig', ['username' => 'Jean Bonbeurre']);