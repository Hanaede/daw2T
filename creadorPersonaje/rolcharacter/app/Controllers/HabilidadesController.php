<?php

namespace App\Controllers;
use App\Models\Habilidades;

class HabilidadesController extends BaseController {

    // Método para crear una nueva habilidad
    public function CrearHabilidadAction() {
        // Inicializar variables para almacenar datos
        $data = [];
        $data['nombre_habilidad'] = $data['descripcion'] = $data['elemento'] =  $data['visible'] = $data['personaje_id'] = $data['nivel_habilidad'] = '';

        // Verificar si se ha enviado el formulario
        if (!empty($_POST)) {
            // Asignar los datos del formulario a las variables
            $data['nombre_habilidad'] = $_POST['nombre_habilidad'];
            $data['descripcion'] = $_POST['descripcion'];
            $data['elemento'] = $_POST['elemento'];
            $data['visible'] = $_POST['visible'];
            $data['personaje_id'] = $_POST['personaje_id'];
            $data['nivel_habilidad'] = $_POST['nivel_habilidad'];

            // Crear una instancia del modelo Habilidades y asignar los datos
            $habilidadModel = Habilidades::getInstancia();
            $habilidadModel->setNombreHabilidad($data['nombre_habilidad']);
            $habilidadModel->setDescripcion($data['descripcion']);
            $habilidadModel->setElemento($data['elemento']);
            $habilidadModel->setPersonajeId($data['personaje_id']);
            $habilidadModel->setNivelHabilidad($data['nivel_habilidad']);
            $habilidadModel->setVisible($data['visible']);
            $habilidadModel->set();

            // Redirigir al perfil del usuario
            header('Location: /');
        }

        // Renderizar la vista para añadir una nueva habilidad
        $this->renderHTML('../app/views/anadir_habilidad_view.php');
    }

    public function ModificarHabilidadAction() {
        $id_habilidad = explode('/', $_SERVER['REQUEST_URI'])[2];

        $habilidad = Habilidades::getInstancia()->get($id_habilidad);
        if ($habilidad[0]['personaje'] != $_SESSION['id']) {
            header('Location: /');
            exit();
        }

        $data = [];
        $data['nombre_habilidad'] = $data['descripcion'] = $data['elemento'] = $data['visible'] = $data['personaje_id'] = $data['nivel_habilidad'] = '';

        $data['nombre_habilidad'] = $habilidad[0]['nombre_habilidad'];

        if(!empty($_POST)) {
            $data['nombre_habilidad'] = $_POST['nombre_habilidad'];
            $data['descripcion'] = $_POST['descripcion'];
            $data['elemento'] = $_POST['elemento'];
            $data['visible'] = $_POST['visible'];
            $data['personaje_id'] = $_POST['personaje_id'];
            $data['nivel_habilidad'] = $_POST['nivel_habilidad'];

            $habilidadModel = Habilidades::getInstancia();
            $habilidadModel->setNombreHabilidad($data['nombre_habilidad']);
            $habilidadModel->setDescripcion($data['descripcion']);
            $habilidadModel->setElemento($data['elemento']);
            $habilidadModel->setPersonajeId($data['personaje_id']);
            $habilidadModel->setNivelHabilidad($data['nivel_habilidad']);
            $habilidadModel->setVisible($data['visible']);
            $habilidadModel->update($id_habilidad);

            header('Location: /');
        }
                // Renderizar la vista para modificar el trabajo
                $this->renderHTML('../app/views/modificar_habilidad_view.php', $data);

    }

    
}