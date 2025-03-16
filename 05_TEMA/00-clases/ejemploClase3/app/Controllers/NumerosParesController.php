<?php
 namespace App\Controllers;

 /**
  * Summary of IndexController
  */
 class NumerosParesController extends BaseController
 {
    public function Pares(){
        $pares = [];
        $numero = 2;

        while (count($pares) < 10) {
            $pares[] = $numero;
            $numero += 2;
        };
        $data = array('message' =>$pares);


        $this->renderHTML('../app/views/pares_view.php',$data);
    }
 }
