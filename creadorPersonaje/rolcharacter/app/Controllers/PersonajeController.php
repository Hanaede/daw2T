<?php
namespace App\Controllers;
use App\Models\Personajes;
use App\Models\Habilidades;

use App\Core\EmailSender;

class PersonajeController extends BaseController
{
    // Método para mostrar la página principal con la lista de usuarios
    public function IndexAction(){
        $personajeModel = Personajes::getInstancia();
        $data['personajes'] = [];

        // Obtener todos los personajes visibles
        $personajes = $personajeModel->getVisiblePersonajes();

        // Obtener habilidades para cada personaje
        foreach ($personajes as &$personaje) {
            $personaje['habilidades'] = $personajeModel->getHabilidades($personaje['personaje_id']);
        }

        $data['personajes'] = $personajes;

        // Verificar si no se han encontrado personajes
        if(empty($data['personajes'])){
            $data['error'] = 'No se han encontrado personajes';
        }
        
        // Renderizar la vista principal con los datos de los personajes
        $this->renderHTML('../app/views/index_view.php', $data);
    }


    public function AddAction()
    {
        $lprocesaFormulario = false;
        $img = false;
        $data = array();

        // Inicializar variables para almacenar datos del formulario
        $data['nombre'] = $data['email'] = $data['contrasena'] = $data['foto'] = $data['clase'] = $data['raza'] = $data['armas'] =  $data['passwordConfirm'] = '';
        $data['eNombre'] = $data['eEmail'] = $data['eContrasena'] = $data['eFoto'] = $data['eClase'] = $data['eRaza'] = $data['eArmas'] = $data['ePasswordConfirm'] = '';

        $oPersonaje = Personajes::getInstancia();

        // Verificar si se ha enviado el formulario
        if (!empty($_POST)) {
            // Asignar los datos del formulario a las variables
            $data['nombre'] = $_POST['nombre'] ?? '';
            $data['email'] = $_POST['email'] ?? '';
            $data['contrasena'] = $_POST['contrasena'] ?? '';
            $data['passwordConfirm'] = $_POST['passwordConfirm'] ?? '';
            $data['clase'] = $_POST['clase'] ?? '';
            $data['raza'] = $_POST['raza'] ?? '';
            $data['armas'] = $_POST['armas'] ?? '';
            $data['foto'] = $_FILES['foto'] ?? null;

            $lprocesaFormulario = true;

            // Validar nombre
            if (empty($data['nombre'])) {
                $data['eNombre'] = 'El nombre no puede estar vacío';
                $lprocesaFormulario = false;
            }

            // Validar email
            if (empty($data['email'])) {
                $data['eEmail'] = 'El email no puede estar vacío';
                $lprocesaFormulario = false;
            }

            // Validar contraseña
            if (empty($data['contrasena'])) {
                $data['eContrasena'] = 'La contraseña no puede estar vacía';
                $lprocesaFormulario = false;
            }

            // Validar confirmación de contraseña
            if (empty($data['passwordConfirm'])) {
                $data['ePasswordConfirm'] = 'La confirmación de contraseña no puede estar vacía';
                $lprocesaFormulario = false;
            }

            // Validar clase
            if (empty($data['clase'])) {
                $data['eClase'] = 'La clase no puede estar vacía';
                $lprocesaFormulario = false;
            }

            // Validar raza
            if (empty($data['raza'])) {
                $data['eRaza'] = 'La raza no puede estar vacía';
                $lprocesaFormulario = false;
            }

            // Validar armas
            if (empty($data['armas'])) {
                $data['eArmas'] = 'Las armas no pueden estar vacías';
                $lprocesaFormulario = false;
            }

            // Validar que contrasena y passwordConfirm sean iguales
            if ($data['contrasena'] != $data['passwordConfirm']) {
                $data['ePasswordConfirm'] = 'Las contraseñas no coinciden';
                $lprocesaFormulario = false;
            }

             // Validar foto
             if ($data['foto']['error'] == 0) {
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
        }

        // Procesar el formulario si es válido
        if ($lprocesaFormulario) {
            // Asegurarse de que el directorio de subida existe
            $uploadDir = dirname(__DIR__, 2) . '/public/img/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // Subir la imagen
            if($img){
                $nombre = $data['foto']['name'];
                $extension = explode('.',$nombre);
                $nombreExt = end($extension);

                $data['foto']['name'] = uniqid() . "." . $nombreExt;

                move_uploaded_file($data['foto']['tmp_name'], $uploadDir . $data['foto']['name']);
            }


            // Generar un token seguro
            $random = random_bytes(32);
            $token = base64_encode($random);
            $secureToken = uniqid("", true) . $token;
            
            // Guardar el personaje en el objeto personaje y luego en la base de datos
            if(empty($data['foto']['name'])){
                $oPersonaje->setFoto('default.jpeg');
            } else {
                $oPersonaje->setFoto($data['foto']['name']);
            }
            $oPersonaje->setNombre($data['nombre']);
            $oPersonaje->setEmail($data['email']);
            $oPersonaje->setClase($data['clase']);
            $oPersonaje->setRaza($data['raza']);
            $oPersonaje->setArmas($data['armas']);
            $oPersonaje->setContrasena($data['contrasena']);
            $oPersonaje->setToken($secureToken);

            // Subir a la base de datos
            $oPersonaje->set();

            // Enviar correo de confirmación
            $emailSender = new EmailSender;
            $emailSender->sendConfirmationMail($data['nombre'], $data['apellidos'], $data['email'], $secureToken);

                        
            // Redirigir a la página principal
            header("Location: /");
        }

        // Renderizar la vista de registro con los datos
        $this->renderHTML('../app/views/register_view.php', $data);
    }

    // Método para iniciar sesión
    public function LoginAction() {
        $data = array();
        $data['email'] = $data['contrasena'] = '';
        $data['error'] = '';

        // Verificar si se ha enviado el formulario
        if (!empty($_POST)) {
            // Asignar los datos del formulario a las variables
            $data['email'] = $_POST['email'];
            $data['contrasena'] = $_POST['contrasena'];

            $oPersonaje = Personajes::getInstancia();
            $personaje = $oPersonaje->getByEmail($data['email']);

            // Verificar si el usuario existe y la contraseña es correcta
            if ($personaje) {
                if ($data['contrasena'] == $personaje['contrasena'] && $personaje['cuenta_activa'] == 1) {
                    // Iniciar sesión
                    $_SESSION['id'] = $personaje['personaje_id'];
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
        $this->renderHTML('../app/views/login_view.php', $data);
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

    // Método para verificar la cuenta del usuario
    public function VerificarAction()
    {
        // Obtener el token desde la URL
        $tokenArray = explode('/', $_SERVER['REQUEST_URI']);
        $token = implode('/', array_slice($tokenArray, 2));
        $personaje = Personajes::getInstancia();
        $personaje->verificarToken($token);

        // Verificar si el usuario ha sido verificado
        if ($personaje->getMensaje() == 'Personaje verificado') {
            header('Location: /login/');
        } else {
            echo "<h2>" . $personaje->getMensaje() . "</h2>";
            header('Location: /login/');
        }
    }

    public function EliminarPersonajeAction() {
        $personaje = Personajes::getInstancia();
        $personaje->delete($_SESSION['id']);
        session_start();
        session_unset();
        session_destroy();
        header('Location: /');
    }
    public function CambiarVisibilidadPerfilAction() {
        $personaje = Personajes::getInstancia();
        $personaje->cambiarVisibilidad($_SESSION['id']);
        header('Location: /');
    }


    // Método para mostrar el perfil del usuario logueado
    // Método para ver el perfil del usuario
    public function VerPerfilAction() {
        $personaje = Personajes::getInstancia();
        $data['personaje'] = $personaje->get($_SESSION['id']);
        
        $habilidades = Habilidades::getInstancia();
        $data['habilidades'] = $habilidades->getByPersonajeId($_SESSION['id']);
        
        $this->renderHTML('../app/views/perfil_view.php', $data);
    }

}