<?php

namespace App\Core;
class Router
{
    private $routes = array(); // array de rutas
    public function add($route) // añadimos la ruta al array
    {
        $this->routes[] = $route;
    }
    public function match(string $request) // recibe un string $request
    {
        $matches = array();
        foreach ($this->routes as $route) {
            $patron = $route['path']; // saca el path de la ruta
            if (preg_match($patron, $request)) { // compara con expresiones regulares el patrón con la entrada
                $matches = $route;
            }
        }
        return $matches;
    }
}