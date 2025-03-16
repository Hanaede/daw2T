<?php
namespace App\Controllers;
use App\Models\Usuarios;


class IndexController extends BaseController
{
    // Método para mostrar la página principal con la lista de usuarios
    public function IndexAction(){
        $usuarioModel = Usuarios::getInstancia();
        $data['usuarios'] = [];

        // Obtener todos los usuarios 
        $usuarios = $usuarioModel->getAll();

        // Obtener notas para cada usuario
        foreach ($usuarios as &$usuario) {
            $usuario['notas'] = $usuarioModel->getNotas($usuario['id']);
        }

        $data['usuarios'] = $usuarios;
        //var_dump($data['usuarios']);

        // Verificar si no se han encontrado usuarios
        if(empty($data['usuarios'])){
            $data['error'] = 'No se han encontrado usuarios';
        }
        
        // Renderizar la vista principal con los datos de los usuarios
        $this->renderHTML('../app/views/index_view.php', $data);
    }
}