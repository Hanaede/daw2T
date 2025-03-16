<?php

namespace App\Controllers;

// use App\Controllers\BaseController;

class IndexController extends BaseController
{
    public function IndexAction()
    {
        $data = array('message' => 'Hola Mundo');
        $this->renderHTML('../app/View/Index_view.php', $data);
    }

    public function SaludaAction($request)
    {
        $arequest = explode('/', $request);
        $nombre = end($arequest);
        $data = array('message' => 'Hola '. $nombre);
        $this->renderHTML('../app/View/Index_view.php', $data);
    }

    public function NumerosAction()
    {

        // $data = array('message' => 'Hola ');
        $this->renderHTML('../app/View/Nums_view.php');

    }
}

?>
