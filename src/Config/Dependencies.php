<?php

$container = $app->getContainer();

// Register Twig View helper
$container['view'] = function ($c) {
    $view = new \Slim\Views\Twig('src/Views');

    $basePath = rtrim(str_ireplace('index.php', '', $c['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($c['router'], $basePath));
    $view->getEnvironment()->addGlobal('session', $_SESSION);
    return $view;
};


$container['flash'] = function () {
    return new \Slim\Flash\Messages();
};

