<?php
/**
 * Archivo que se va a mostrar
 */
use App\Controllers\IndexController;
use App\Core\Router;

require_once("../app/config/config.php");
require_once("../vendor/autoload.php");

 $router = new Router();
 $router->add(array(
                'name' => 'home',
                'path' => '/^\/$/',
                'action' => [IndexController::class, 'IndexAction']),
            );
$router->add(array(
                'name' => 'home',
                'path' => '/^\/saludo\/([a-zA-ZáéíóúÁÉÍÓÚñÑ0-9_-]+)$/',
                'action' => [IndexController::class, 'SaludarAction']),
            );

$request=str_replace(DIRBASURL,'',$_SERVER['REQUEST_URI']);



$route =$router->match($request);

if ($route) {
    $controllerName = $route['action'][0];
    $actionName = $route['action'][1];
    $controller = new $controllerName;
    $controller->$actionName($request);
}
else {
    echo "No route";
}


