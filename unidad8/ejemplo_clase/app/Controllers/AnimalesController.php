<?php
namespace App\Controllers;

use App\Models\Animales;

class AnimalesController extends BaseController{

    public function IndexAction($filter){

        $data = array();

        $animales = Animales::getInstancia();

        $data['animales'] = $animales->getMascotasByFilter($filter);

        $this->renderHTML('../app/views/index_view.php', $data);
    }

    public function getAnimalesAction($filter){

        $data = array();

        $animales = Animales::getInstancia();

        $data['animales'] = $animales->getMascotasByFilter($filter);

        $this->renderHTML('../public/list_view.php', $data);
    }
}
?>