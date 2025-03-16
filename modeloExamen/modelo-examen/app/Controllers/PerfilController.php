<?php
namespace App\Controllers;
use App\Models\Usuarios;
use App\Models\Publicaciones;

class PerfilController extends BaseController
{
    public function MostrarAction() {
        $usuarioModel = Usuarios::getInstancia();
        $publicacionModel = Publicaciones::getInstancia();
        $data['usuario'] = [];
        $data['publicaciones'] = [];

        // Obtener el id del usuario
        $id = $_SESSION['id'];

        // Obtener el usuario
        $usuario = $usuarioModel->get($id);

        // Asegurarse de que $usuario sea un array
        if (!is_array($usuario)) {
            $usuario = [];
        }

        // Obtener publicaciones para el usuario
        $publicaciones = $publicacionModel->getPublicaciones($id);

        $data['usuario'] = $usuario;
        $data['publicaciones'] = $publicaciones;

        // Verificar si no se ha encontrado el usuario
        if(empty($data['usuario'])){
            $data['error'] = 'No se ha encontrado el usuario';
        }

        // Renderizar la vista de perfil con los datos del usuario
        $this->renderHTML('../app/views/perfil_view.php', $data);
    }
}