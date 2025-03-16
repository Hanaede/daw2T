<?php
namespace App\Controllers;

use App\Models\Usuarios;
use App\Models\Multas;

class UsuariosController extends BaseController
{
    public function verMultasAction(){
        $data = [];
        $data['multas'] = "";
        $data['usuario'] = "";

        if(isset($_SESSION['id'])){
            //Obtener usuario y multas
            $usuarioModel = Usuarios::getInstancia();
            $usuario = $usuarioModel->get($_SESSION['id']);
            $data['usuario'] = $usuario;
            var_dump($data['usuario']);
   

            $multasModel = Multas::getInstancia();
            $data['multas'] = $multasModel->getByUsuario($_SESSION['id']);

        }
        $this->renderHTML('../app/views/perfil_conductor_view.php', $data);
    }

    public function verMultasAgenteAction() {
        $data = [];
        $data['multas'] = "";
        $data['usuario'] = "";
        $data['coeficiente'] = 0;
    
        if (isset($_SESSION['id'])) {
            // Obtener usuario y multas del agente actual
            $usuarioModel = Usuarios::getInstancia();
            $usuario = $usuarioModel->get($_SESSION['id']);
            $data['usuario'] = $usuario;
    
            $multasModel = Multas::getInstancia();
            $multasAgente = $multasModel->getByAgente($_SESSION['id']);
            $data['multas'] = $multasAgente;
    
            // Obtener el total de multas impuestas por todos los agentes
            $totalMultas = $multasModel->getTotalMultas();
            $multasAgenteCount = count($multasAgente);
    
            // Calcular el coeficiente
            if ($totalMultas > 0) {
                $data['coeficiente'] = ($multasAgenteCount / $totalMultas) * 100;
            }
        }
    
        $this->renderHTML('../app/views/perfil_agente_view.php', $data);
    }
    
}