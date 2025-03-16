<?php


require_once '../vendor/autoload.php';
require_once '../app/Config/Config.php';

use App\Core\Router;
use App\Controllers\IndexController;

$router = new Router();
$router-> add([
        'name' => 'home',
        'path' => '/^\/$/',
        'action' =>[IndexController::class, 'IndexAction']
]);


$router-> add([
    'name' => 'mensaje',
    'path' => '/^\/saludo\/([a-zA-ZáéíóúÁÉÍÓÚñÑ0-9_-]+)$/',
    'action' => [IndexController::class, 'SaludaAction'],
]);

$router-> add([
    'name' => 'numeros',
    'path' => '/numeros$/',
    'action' => [IndexController::class, 'NumerosAction'],
]);

$router-> add([
    'name' => 'pares',
    'path' => '/numeros\/\d+\d$/',
    'action' => [IndexController::class, 'ParesAction'],
]);

$request = str_replace(DIRBASEURL, '', $_SERVER['REQUEST_URI']);

// echo $request."</br>";
$route = $router->match($request);

if($route) {
    $controllerName = $route['action'][0];
    $actionName = $route['action'][1];
    $controller = new $controllerName;
    $controller->$actionName($request);
}
else{
    echo "No route";
}




?>