<?php
/**
 * Archivo que define la clase indexController que extiende de BaseController
 */

  namespace App\Controllers;
 class IndexController extends BaseController{
    public function IndexAction()
    {
        $data = array('message'=>'Hola mundo');
        $this->renderHTML('../app/view/index_view.php',$data);
    }

    public function SaludarAction($request): void
    {
        $nombre = explode("/", $request);
        $nombre = end($nombre);
        $data = array('message'=> $nombre);
        $this->renderHTML('../app/view/saludo_view.php',$data);
    }

    /* 
    1. Mensaje
    Controlador : IndecController
    Vista: saludo_view
    Ruta: /

    2. Numeros pares 
    Controlador: NUmerosController: paresAction
    Vista: pares_view
    Ruta= numeros/pares


    3: Numeros pares rango
    Controlador: NumerosController: rangoAction
    VIsta: rango_pares_view
    Ruta: numeros/pares/s
    */
 }


