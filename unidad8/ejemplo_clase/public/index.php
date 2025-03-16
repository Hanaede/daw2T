<?php
// session_start();
// requreimos el bootstrap y el autoload para la carga automatica de clases
require_once "../boostrap.php";
require_once "../vendor/autoload.php";

// Usamos el espacio de nombre
use App\Core\Router;
use App\Controllers\AnimalesController;

// Creamos una instancia de la clase Router
$router = new Router();

// Añadimos rutas al array
$router->add([
    'name' => 'index',
    'path' => '/^\/(\?.*)?$/',
    'action' => [AnimalesController::class, 'IndexAction']
]);   

$request = $_SERVER['REQUEST_URI'];
$route = $router->match($request); // Comprobamos que coincide una ruta

if($route){

    $controllerName = $route['action'][0];
    $actionName = $route['action'][1];
    $controller = new $controllerName;
    $controller->$actionName($request);
}else{
    echo "No route";
}
?>