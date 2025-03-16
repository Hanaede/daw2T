<?php
// Inicia la sesión
session_start();

// Si no hay una sesión iniciada, se establece el rol como 'invitado'
if (!isset($_SESSION['id'])) {
    $_SESSION['id'] = '';
    $_SESSION['rol'] = 'invitado';
}

require_once "../bootstrap.php";
require_once "../vendor/autoload.php";

use App\Core\Router;
use App\Controllers\IndexController;
use App\Controllers\UsuariosController;
use App\Controllers\ExamenesController;
use App\Controllers\PerfilController;

$router = new Router();

$router->add([  'name' => 'index',
                'path' => '/^\/$/',
                'action' => [IndexController::class, 'IndexAction']]);


// Ruta para añadir un usuario
$router->add([
    'name' => 'Añadir personaje',
    'path' => '/^\/add$/',
    'action' => [UsuariosController::class, 'AddAction']
]);

// Ruta para iniciar sesión de usuario
$router->add([  
    'name' => 'Iniciar sesión de usuario',
    'path'=>'/^\/login\/$/',
    'action' => [UsuariosController::class, 'LoginAction'],
    'rol' => ['invitado']
]);

// Ruta para cerrar sesión de usuario
$router->add([
    'name' => 'Cerrar sesión de usuario',
    'path' => '/^\/logout\/$/',
    'action' => [UsuariosController::class, 'LogoutAction'],
    'rol' => ['usuario']
]);

// Ruta para cerrar sesión de usuario
$router->add([
    'name' => 'Cerrar sesión de usuario',
    'path' => '/^\/examen\/$/',
    'action' => [ExamenesController::class, 'MostrarExamenAction'],
    'rol' => ['usuario']
]);

// Ruta para ver el perfil
$router->add([  
    'name' => 'Ver perfil',
    'path'=>'/^\/perfil\/$/',
    'action' => [PerfilController::class, 'VerPerfilAction'],
    'rol' => ['usuario']
]);

// Ruta para modificar el perfil
$router->add([  
    'name' => 'Modificar perfil',
    'path'=>'/^\/modificarPerfil\/$/',
    'action' => [PerfilController::class, 'ModificarPerfilAction'],
    'rol' => ['usuario']
]);

$router->add([
    'name' => 'examen',
    'path' => '/^\/eliminarusuario\/$/',
    'action' => [UsuariosController::class, 'EliminarUsuarioAction'],
    'rol' => ['usuario']
]);

// Limpia la ruta de petición
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Busca la ruta solicitada 
$route = $router->match($request);

// Si la ruta existe y el rol del usuario es permitido, se ejecuta la acción correspondiente
if($route){
    if (isset($route['rol']) && !in_array($_SESSION['rol'], $route['rol'])) {
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