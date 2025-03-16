<?php
/**
 * Archivo con clase BaseController 
 */

 /*Definimos el espacio de nombres */
 namespace App\Controllers;

 class BaseController
 {
 public function renderHTML($fileName, $data=[])
    {
        include($fileName);
    }
 }
