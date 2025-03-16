<?php
namespace App\Controllers;
use App\Models\Usuarios;
use App\Models\Publicaciones;

class UsuariosController extends BaseController
{
    // Método para mostrar la página principal con la lista de usuarios
    public function IndexAction(){
        $usuarioModel = Usuarios::getInstancia();
        $publicacionModel = Publicaciones::getInstancia();
        $data['usuarios'] = [];

        // Obtener todos los usuarios visibles
        $usuarios = $usuarioModel->getVisibleUsuarios();

        // Asegurarse de que $usuarios sea un array
        if (!is_array($usuarios)) {
            $usuarios = [];
        }

        // Obtener publicaciones para cada usuario
        foreach ($usuarios as &$usuario) {
            $usuario['publicaciones'] = $publicacionModel->getPublicaciones($usuario['id']);
        }

        $data['usuarios'] = $usuarios;

        // Verificar si no se han encontrado usuarios
        if(empty($data['usuarios'])){
            $data['error'] = 'No se han encontrado usuarios';
        }
        
        // Renderizar la vista principal con los datos de los usuarios
        $this->renderHTML('../app/views/index_view.php', $data);
    }

    //registrar un usuario
    public function AddAction() {
        $lprocesaFormulario = false;
        $img = false;
        $data = array();

        //Inicializamos variables para almacenar datos formularios
        $data['nombre'] = $data['apellidos'] = $data['email'] = $data['password'] =  $data['foto'] =  $data['passwordConfirm'] = $data['titulo'] = $data['contenido'] = $data['imagen'] = $data['captcha'] = $data['num1'] = $data['num2'] = '';
        //Inicializamos variables para almacenar errores
        $data['eNombre'] = $data['eApellidos'] = $data['eEmail'] = $data['ePassword'] = $data['eFoto'] = $data['ePasswordConfirm'] = $data['eCaptcha'] =  $data['eImagen'] = $data['eCaptcha'] =  '';

        $oUsuario = Usuarios::getInstancia();

        //Verificamos si se ha enviado el formulario
        if (!empty($_POST)) {
            $data['nombre'] = $_POST['nombre'];
            $data['apellidos'] = $_POST['apellidos'];
            $data['email'] = $_POST['email'];
            $data['password'] = $_POST['password'];
            $data['passwordConfirm'] = $_POST['passwordConfirm'];
            $data['titulo'] = $_POST['titulo'];
            $data['contenido'] = $_POST['contenido'];
            $captcha = $_POST['captcha'];
            $num1 = $_POST['num1'];
            $num2 = $_POST['num2'];

            $lprocesaFormulario = true;

            //Validamos los datos
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

            if ($data['password'] != $data['passwordConfirm']) {
                $data['ePasswordConfirm'] = 'Las contraseñas no coinciden';
                $lprocesaFormulario = false;
            }

            // Validamos foto
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
                $data['foto'] = $_FILES['foto'];
                // Comprobar si el archivo subido es una imagen
                if ($data['foto']['type'] == 'image/jpeg' || $data['foto']['type'] == 'image/png') {
                    // Comprobar si el archivo subido no supera los 2MB
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

            // Validar captcha
            if ($captcha != $num1 + $num2) {
                $data['eCaptcha'] = 'La respuesta del captcha es incorrecta';
                $lprocesaFormulario = false;
            }

        }

        // Procesar el formulario si es válido
        if ($lprocesaFormulario) {
            // Asegurarse de que el directorio de subida existe
            $uploadDir = dirname(__DIR__, 2) . '/public/img/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // Subir la imagen del usuario
            if ($img) {
                $nombre = $data['foto']['name'];
                $extension = explode('.', $nombre);
                $nombreExt = end($extension);

                $data['foto']['name'] = uniqid() . "." . $nombreExt;

                if (!move_uploaded_file($data['foto']['tmp_name'], $uploadDir . $data['foto']['name'])) {
                    $data['eFoto'] = "* Error al subir la imagen";
                    $lprocesaFormulario = false;
                }
            }

            // Guardar el usuario en el objeto usuario y luego en la base de datos
            if (empty($data['foto']['name'])) {
                $oUsuario->setFoto('default.jpeg');
            } else {
                $oUsuario->setFoto($data['foto']['name']);
            }
            $oUsuario->setNombre($data['nombre']);
            $oUsuario->setEmail($data['email']);
            $oUsuario->setPassword($data['password']);
            $oUsuario->setApellidos($data['apellidos']);
            $oUsuario->setVisible(1);

            // Subir la imagen de la publicación
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
                $data['imagen'] = $_FILES['imagen'];
                // Comprobar si el archivo subido es una imagen
                if ($data['imagen']['type'] == 'image/jpeg' || $data['imagen']['type'] == 'image/png') {
                    // Comprobar si el archivo subido no supera los 2MB
                    if ($data['imagen']['size'] <= 2000000) {
                        $nombre = $data['imagen']['name'];
                        $extension = explode('.', $nombre);
                        $nombreExt = end($extension);

                        $data['imagen']['name'] = uniqid() . "." . $nombreExt;

                        if (!move_uploaded_file($data['imagen']['tmp_name'], $uploadDir . $data['imagen']['name'])) {
                            $data['eImagen'] = "* Error al subir la imagen de la publicación";
                            $lprocesaFormulario = false;
                        }
                    } else {
                        $data['eImagen'] = "* La imagen de la publicación no puede superar los 2MB";
                        $lprocesaFormulario = false;
                    }
                } else {
                    $data['eImagen'] = "* El archivo subido no es una imagen";
                    $lprocesaFormulario = false;
                }
            }

            // Guardar la publicación en el objeto publicación y luego en la base de datos
            if (!empty($data['titulo']) && !empty($data['contenido'])) {
                $publicacion = new Publicaciones();
                $publicacion->setTitulo($data['titulo']);
                $publicacion->setContenido($data['contenido']);
                if (empty($data['imagen']['name'])) {
                    $publicacion->setImagen(null);
                } else {
                    $publicacion->setImagen($data['imagen']['name']);
                }
                $oUsuario->addPublicaciones($publicacion);
            }

            // Subir a la base de datos
            $oUsuario->set();

            // Redirigir a la página principal
            header("Location: /");
        }

        // Renderizar la vista de registro con los datos
        $this->renderHTML('../app/views/register_view.php', $data);
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
                    session_start();
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
}