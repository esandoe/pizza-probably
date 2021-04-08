<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Hello world!");
    return $response;
});

$app->run();
?>


<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🍕</text></svg>">
    <title>Pizza-Probably!</title>
    <style>
        .content_wrap {
            max-width: 1000px;
            margin: 150px auto 0 auto;
            padding: 0 50px;
        }

        header {
            max-width: 1000px;
            margin: 0 auto;
            padding: 0 50px;
        }
    </style>
</head>

<body>
<header>
    <a href="/">
        <text y='.9em' font-size='12'>🍕</text>
        Pizza-Probably!
    </a>
</header>

<div class="content_wrap">
<?
require '../vendor/autoload.php';
$request = $_SERVER['REQUEST_URI'];

/*
 * A very simple router!!
 */

$views = array(
    'home'   => '/^\/(recipes(\/?))?$/',
    'recipe' => '/^\/recipes\/([a-z-_0-9]+)\/?$/',
    'editor' => '/^\/edit\/([a-z-_0-9]+)\/?$/',
);

if (preg_match($views['home'], $request))
    require '../views/home.php';

elseif (preg_match($views['recipe'], $request))
    require '../views/recipe.php';

elseif (preg_match($views['editor'], $request))
    require '../views/editor.php';

else
    require '../views/404.php';
?>
</div>
</body>
</html>