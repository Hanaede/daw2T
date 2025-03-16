<?php
namespace App\Controllers;
use App\Models\Usuarios;
use App\Models\Notas;

class UsuariosController extends BaseController
{
    public function AddAction()
    {
        $lprocesaFormulario = false;
        $data = array();
        $data['nombre'] = $data['apellidos'] = $data['email'] = $data['password'] = $data['resumen_perfil'] = $data['foto'] =  $data['passwordConfirm'] = $data['captcha'] = $data['num1'] = $data['num2']= '';

        $data['eNombre'] = $data['eApellidos'] = $data['eEmail'] = $data['ePassword'] = $data['eResumen_perfil'] = $data['eFoto'] =  $data['ePasswordConfirm'] = $data['eCaptcha'] = $data['eCaptchaLetras'] = '';

        $data['nota'] = $data['id_examen']='';
        $data['eNota'] = $data['eId_examen'] = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $lprocesaFormulario = true;
            $data['nombre'] = $_POST['nombre'];
            $data['apellidos'] = $_POST['apellidos'];
            $data['email'] = $_POST['email'];
            $data['password'] = $_POST['password'];
            $data['resumen_perfil'] = $_POST['resumen_perfil'];
            $data['foto'] = $_FILES['foto'];
            $data['passwordConfirm'] = $_POST['passwordConfirm'];

            $captcha = $_POST['captcha'];
            $num1 = $_POST['num1'];
            $num2 = $_POST['num2'];
            $captcha_letras = $_POST['captcha_letras'];
            $captcha_letras_original = $_POST['captcha_letras_original'];

            $data['nota'] = $_POST['nota'];
            $data['id_examen'] = $_POST['id_examen'];

            $img = false;

            $usuario1 = Usuarios::getInstancia();
            $lprocesaFormulario = true;


            if (empty($data['nombre'])) {
                $data['eNombre'] = 'El nombre es obligatorio';
                $lprocesaFormulario = false;
            }

            if (empty($data['apellidos'])) {
                $data['eApellidos'] = 'Los apellidos son obligatorios';
                $lprocesaFormulario = false;
            }

            if (empty($data['email'])) {
                $data['eEmail'] = 'El email es obligatorio';
                $lprocesaFormulario = false;
            }

            if (empty($data['password'])) {
                $data['ePassword'] = 'La contraseña es obligatoria';
                $lprocesaFormulario = false;
            }

            if (empty($data['resumen_perfil'])) {
                $data['eResumen_perfil'] = 'El resumen de perfil es obligatorio';
                $lprocesaFormulario = false;
            }

            if (empty($data['foto'])) {
                $data['eFoto'] = 'La foto es obligatoria';
                $lprocesaFormulario = false;
            }

            if (empty($data['nota'])) {
                $data['eNota'] = 'La nota es obligatoria';
                $lprocesaFormulario = false;
            }

            if (empty($data['id_examen'])) {
                $data['eId_examen'] = 'El id del examen es obligatorio';
                $lprocesaFormulario = false;
            }

            if ($data['password'] != $data['passwordConfirm']) {
                $data['ePasswordConfirm'] = 'Las contraseñas no coinciden';
                $lprocesaFormulario = false;
            }

                // Validar captcha
            if ($captcha != $num1 + $num2) {
                $data['eCaptcha'] = 'La respuesta del captcha es incorrecta';
                $lprocesaFormulario = false;
            }

            
            if ($captcha_letras != $captcha_letras_original) {
                $data['eCaptchaLetras'] = 'El captcha de letras no es correcto';
                $lprocesaFormulario = false;
            }
            // Comprobamos si se ha subido una imagen
            if ($data['foto'] && $data['foto']['error'] == 0) {
                // Comprobamos si el archivo subido es una imagen
                if ($data['foto']['type'] == 'image/jpeg' || $data['foto']['type'] == 'image/png') {
                    // Comprobamos si el archivo subido no supera los 2MB
                    if ($data['foto']['size'] <= 2000000) {
                        $img = true;
                    } else {
                        $lprocesaFormulario = false;
                        $data['eFoto'] = "* La imagen no puede superar los 2MB";
                    }
                } else {
                    $lprocesaFormulario = false;
                    $data['eFoto'] = "* El archivo subido no es una imagen";
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
                // Movemos el archivo a la carpeta de imágenes
                move_uploaded_file($data['foto']['tmp_name'], dirname(__DIR__, 2) . '/public/uploads/' . $data['foto']['name']);
                $foto = $data['foto']['name'];
            } else {
                $foto = "default.png";
            }

            $usuario1->setNombre($data['nombre']);
            $usuario1->setApellidos($data['apellidos']);
            $usuario1->setEmail($data['email']);
            $usuario1->setPassword($data['password']);
            $usuario1->setResumenPerfil($data['resumen_perfil']);
            $usuario1->setFoto($foto);
            $usuario1->setVisible(1);

            if(!empty($data['nota']) && !empty($data['id_examen'])){
                $nota = new Notas();
                $nota->setNota($data['nota']);
                $nota->setIdExamen($data['id_examen']);
                $nota->setFechaRealizacion(date('Y-m-d H:i:s'));
                $usuario1->addNotas($nota);
            }

            $usuario1->set();
            header('Location: /');
        } else {
            $this->renderHTML('../app/views/register_view.php', $data);
        }
    }

    //Login
    public function LoginAction() {
        $data = array();
        $data['email'] = $data['password'] = '';
        $data['error'] = '';

        // Verificar si se ha enviado el formulario
        if (!empty($_POST)) {
            // Asignar los datos del formulario a las variables
            $data['email'] = $_POST['email'];
            $data['password'] = $_POST['password'];

            $oUsuario = Usuarios::getInstancia();
            $usuario = $oUsuario->getByEmail($data['email']);

            // Verificar si el usuario existe y la contraseña es correcta
            if ($usuario) {
                if ($data['password'] == $usuario['password']) {
                    // Iniciar sesión
            
                    $_SESSION['id'] = $usuario['id'];
                    $_SESSION['rol'] = "usuario";

                    // Redirigir a la página principal
                    header("Location: /");
                    exit();
                } else {
                    $data['error'] = 'Contraseña incorrecta';
                }
            } else {
                $data['error'] = 'Usuario incorrecto';
            }
        }

        // Renderizar la vista de inicio de sesión con los datos
        $this->renderHTML('../app/views/index_view.php', $data);
    }

    // Método para cerrar sesión
    public function LogoutAction(){
        // Cerrar la sesión y redirigir a la página principal
        $data = [];
        session_start();
        session_unset();
        session_destroy();
        header('Location: /');
    }

    public function EliminarUsuarioAction() {
        if(empty($_SESSION['id'])){
            header('Location: /login/');
            return;
        }

        $usuario = Usuarios::getInstancia();
        $usuario->delete($_SESSION['id']);
        session_destroy();
        header('Location: /');
    }
    
}