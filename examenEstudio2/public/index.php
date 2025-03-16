<?php
// Inicia la sesión
session_start();

// Si no hay una sesión iniciada, se establece el rol como 'invitado'
if (!isset($_SESSION['id'])) {
    $_SESSION['id'] = '';
    $_SESSION['perfil'] = 'invitado';
}

require_once "../bootstrap.php";
require_once "../vendor/autoload.php";

use App\Core\Router;
use App\Controllers\IndexController;
use App\Controllers\UsuariosController;
use App\Controllers\MultasController;

$router = new Router();

$router->add([  'name' => 'index',
                'path' => '/^\/$/',
                'action' => [IndexController::class, 'IndexAction']]);     


//ruta para logout
$router->add([  'name' => 'logout',
                'path' => '/^\/logout\/$/',
                'action' => [IndexController::class, 'LogoutAction']]);



//Ruta poara el perfil del conductor
$router->add([  'name' => 'perfilconductor',
                'path' => '/^\/perfilconductor\/$/',
                'action' => [UsuariosController::class, 'verMultasAction'],
                'perfil' => ['conductor']]);


//Ruta para el perfil del agente
$router->add([  'name' => 'perfilagente',
                'path' => '/^\/perfilagente\/$/',
                'action' => [UsuariosController::class, 'verMultasAgenteAction'],
                'perfil' => ['agente']]);

// Ruta para añadir multas
$router->add([
    'name' => 'addmultas',
    'path' => '/^\/addmultas\/$/',
    'action' => [MultasController::class, 'addMultasAction'],
    'perfil' => ['agente']
]);

//Ruta para pagar multas
$router->add([
    'name' => 'pagarmultas',
    'path' => '/^\/pagarmultas\/\d+$/',
    'action' => [MultasController::class, 'pagarMultasAction'],
    'perfil' => ['conductor']
]);


// Ruta para añadir multas
$router->add([
    'name' => 'addmultas',
    'path' => '/^\/addmultas\/$/',
    'action' => [MultasController::class, 'addMultasAction'],
    'perfil' => ['agente']
]);



// Limpia la ruta de petición
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Busca la ruta solicitada 
$route = $router->match($request);

// Si la ruta existe y el rol del usuario es permitido, se ejecuta la acción correspondiente
if($route){
    if (isset($route['perfil']) && !in_array($_SESSION['perfil'], $route['perfil'])) {
        header("Location: /");
    } else{
        $controllerName = $route['action'][0];
        $actionName = $route['action'][1];
        $controller = new $controllerName;
        $controller->$actionName($request);
    }
}else{
    echo "No route";
}