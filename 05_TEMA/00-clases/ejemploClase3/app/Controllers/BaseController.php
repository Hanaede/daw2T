<?php
 namespace App\Controllers;

 /**
  * Summary of BaseController
  */
 class BaseController
 {
    public function renderHTML($fileName, $data=[])
    {
        include($fileName);
    }
 }
 