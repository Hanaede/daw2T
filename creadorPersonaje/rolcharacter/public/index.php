<?php
session_start();
require_once "../bootstrap.php";
require_once "../vendor/autoload.php";

use App\Core\Router;
use App\Controllers\PersonajeController;
use App\Controllers\HabilidadesController;

if (!isset($_SESSION['id'])) {
    $_SESSION['id'] = '';
    $_SESSION['rol'] = 'invitado';
}

$router = new Router();

$router->add([
    'name' => 'index',
    'path' => '/^\/$/',
    'action' => [PersonajeController::class, 'IndexAction']
]);

// Ruta para añadir un personaje
$router->add([
    'name' => 'Añadir personaje',
    'path' => '/^\/add$/',
    'action' => [PersonajeController::class, 'AddAction']
]);

// Ruta para iniciar sesión de usuario
$router->add([
    'name' => 'Iniciar sesión de personaje',
    'path' => '/^\/login\/$/',
    'action' => [PersonajeController::class, 'LoginAction'],
    'rol' => ['invitado']
]);

// Ruta para cerrar sesión de usuario
$router->add([
    'name' => 'Cerrar sesión de usuario',
    'path' => '/^\/logout\/$/',
    'action' => [PersonajeController::class, 'LogoutAction'],
    'rol' => ['usuario']
]);

// Crea habilidad
$router->add([
    'name' => 'Habilidad',
    'path' => '/^\/crearHabilidad\/$/',
    'action' => [HabilidadesController::class, 'CrearHabilidadAction'],
    'rol' => ['usuario']
]);

// Ruta para activar cuenta
$router->add([
    'name' => 'Activar cuenta',
    'path' => '/^\/verificacion\/.*$/',
    'action' => [PersonajeController::class, 'VerificarAction'],
    'rol' => ['invitado']
]);

// Ruta para eliminar personaje
$router->add([
    'name' => 'Eliminar personaje',
    'path' => '/^\/eliminarPersonaje\/\d+$/',
    'action' => [PersonajeController::class, 'EliminarPersonajeAction'],
    'rol' => ['usuario']
]);

// Ruta para cambiar visibilidad del perfil
$router->add([
    'name' => 'Visibilizar perfil',
    'path' => '/^\/cambiarVisibilidadPerfil\/$/',
    'action' => [PersonajeController::class, 'CambiarVisibilidadPerfilAction'],
    'rol' => ['usuario']
]);

// Ruta para ver el perfil
$router->add([  
    'name' => 'Ver perfil',
    'path'=>'/^\/perfil\/$/',
    'action' => [PersonajeController::class, 'VerPerfilAction'],
    'rol' => ['usuario']
]);

//Modificar habilidad
$router->add([  
    'name' => 'Trabajos',
    'path'=>'/^\/modificarHabilidad\/\d+$/',
    'action' => [HabilidadesController::class, 'ModificarHabilidadAction'],
    'rol' => ['usuario']
]);

$request = $_SERVER['REQUEST_URI'];
$route = $router->match($request);
if ($route) {
    if (isset($route['rol']) && !in_array($_SESSION['rol'], $route['rol'])) {
        header("Location: /");
    } else {
        $controllerName = $route['action'][0];
        $actionName = $route['action'][1];
        $controller = new $controllerName;
        $controller->$actionName($request);
    }
} else {
    echo "No route";
}
?>