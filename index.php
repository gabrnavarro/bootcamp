<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '/vendor/autoload.php';

include 'src/Settings.php';

$app = new \Slim\App($config);

foreach (glob("src/Config/*.php") as $filename)
{
    include $filename;
}



foreach (glob("src/Routes/*.php") as $filename)
{
    include $filename;
}

foreach (glob("src/Views/*.php") as $filename)
{
    include $filename;
}

foreach (glob("src/Controllers/*.php") as $filename)
{
    include $filename;
}




$app->run();