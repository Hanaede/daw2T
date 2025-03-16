<?php
namespace App\Controllers;
use App\Models\Usuarios;
use App\Models\Notas;
use App\Models\Examenes;

class PerfilController extends BaseController
{
    public function VerPerfilAction() {
        $data['usuario'] = [];
        $data['notas'] = [];
        $data['examenes'] = [];
        
        // Obtener los datos del usuario logueado
        $usuarioModel = Usuarios::getInstancia();
        $data['usuario'] = $usuarioModel->get($_SESSION['id']); 

        // Obtener las notas del usuario
        $notasModel = Notas::getInstancia();
        $data['notas'] = $notasModel->getByUserId($_SESSION['id']);

        $this->renderHTML('../app/views/perfil_view.php', $data);
    }

    public function modificarPerfilAction(){

        if(empty($_SESSION['id'])){
            header('Location: /login/');
            return;
        }


        $data['usuario'] = '';
        $data['notas'] = [];
        $data['nombre'] = $data['apellidos'] = $data['email'] = $data['resumen_perfil'] = $data['foto'] = '';
        $data['msjErrorNombre'] = $data['msjErrorApellidos'] = $data['msjErrorEmail'] = $data['msjErrorResumenPerfil'] = $data['msjErrorFoto'] = '';


        $lprocesaFormulario = false;
        // Obtener los datos del usuario logueado
        $usuarioModel = Usuarios::getInstancia();
        $data['usuario'] = $usuarioModel->get($_SESSION['id']);

        // Obtener los datos del formulario para modificar el usuario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data['nombre'] = $_POST['nombre'];
            $data['apellidos'] = $_POST['apellidos'];
            $data['email'] = $_POST['email'];
            $data['resumen_perfil'] = $_POST['resumen_perfil'];
            $data['foto'] = $_FILES['foto'];
            $img = false;

            $img = false;

            var_dump($data);

            $usuario1 = Usuarios::getInstancia();
            $lprocesaFormulario = true;

            // Validar los datos del formulario
            if (empty($data['nombre'])) {
                $data['msjErrorNombre'] = 'El nombre es obligatorio.';
                $lprocesaFormulario = false;
            }
            if (empty($data['apellidos'])) {
                $data['msjErrorApellidos'] = 'Los apellidos son obligatorios.';
                $lprocesaFormulario = false;
            }
            if (empty($data['email'])) {
                $data['msjErrorEmail'] = 'El email es obligatorio.';
                $lprocesaFormulario = false;
            }


            if ($data['foto'] && $data['foto']['error'] == 0) {
                // Comprobamos si el archivo subido es una imagen
                if ($data['foto']['type'] == 'image/jpeg' || $data['foto']['type'] == 'image/png') {
                    // Comprobamos si el archivo subido no supera los 2MB
                    if ($data['foto']['size'] <= 2000000) {
                        $img = true;
                    } else {
                        $lprocesaFormulario = false;
                        $data['msjErrorFoto'] = "* La imagen no puede superar los 2MB";
                    }
                } else {
                    $lprocesaFormulario = false;
                    $data['msjErrorFoto'] = "* El archivo subido no es una imagen";
                }
            }
            
        }
        if ($lprocesaFormulario) {
            if ($img) {
                // Subo la imagen
                $nombre = $data['foto']['name'];
                // Obtengo la extension de la imagen
                $ext = explode(".", $nombre);
                $name = end($ext);
                // Generamos un nombre para la imagen al azar
                $data['foto']['name'] = uniqid() . "." . $name;
                // Movemos el archivo a la carpeta de imágenes
                move_uploaded_file($data['foto']['tmp_name'], dirname(__DIR__, 2) . '/public/uploads/' . $data['foto']['name']);
                $foto = $data['foto']['name'];
            } else {
                $foto = "default.png";
            }

            $usuario1->setId($_SESSION['id']);
            $usuario1->setNombre($data['nombre']);
            $usuario1->setApellidos($data['apellidos']);
            $usuario1->setEmail($data['email']);
            $usuario1->setPassword($data['password']);
            $usuario1->setResumenPerfil($data['resumen_perfil']);
            $usuario1->setFoto($foto);

            $usuario1->edit();
            header('Location: /perfil/');
        } else {
            $this->renderHTML('../app/views/modificar_perfil_view.php', $data);
        }
    }
}