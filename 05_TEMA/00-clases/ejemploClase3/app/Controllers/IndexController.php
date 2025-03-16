<?php
 namespace App\Controllers;

 /**
  * Summary of IndexController
  */
 class IndexController extends BaseController
 {
    public function IndexAction()
    {
       $data = array('message' => 'Hola mundo');
       $this->renderHTML('../app/views/index_view.php',$data);
    }

    public function SaludarAction($request)
    {
      $nombre = explode("/", $request);
      $nombre = end($nombre);
      $data = array('message' =>'Hola ' . $nombre);
      $this ->renderHTML('../app/views/saluda_view.php', $data);
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
    Ruta: numeros/pares/8
    */
 }
