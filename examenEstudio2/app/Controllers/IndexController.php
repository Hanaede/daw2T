<?php
namespace App\Controllers;
use App\Models\Usuarios;

class IndexController extends BaseController
{
    public function IndexAction() {
        $data = [];
        $data['usuario'] = $data['password'] = "";
        $data['error'] = "";
    
        // Verificamos si el formulario se ha enviado
        if (!empty($_POST)) {
            $data['usuario'] = $_POST['usuario'];
            $data['password'] = $_POST['password'];
            $captcha_input = intval($_POST['captcha']);
    
            // Verificar el resultado del CAPTCHA
            if ($captcha_input !== $_SESSION['captcha_result']) {
                $data['error'] = "CAPTCHA incorrecto";
            } else {
                $oUsuario = Usuarios::getInstancia();
                $usuario = $oUsuario->getByUsuario($data['usuario']);
    
                if ($usuario && $data['password'] == $usuario['password']) {
                    $_SESSION['id'] = $usuario['id'];
                    $_SESSION['perfil'] = $usuario['perfil'];
                    header("Location: /");
                    exit();
                } else {
                    $data['error'] = "Usuario o contraseña incorrectos";
                }
            }
        }
    
        // Generar números aleatorios para el CAPTCHA solo si no hay POST
        if (empty($_POST)) {
            $num1 = rand(1, 10);
            $num2 = rand(1, 10);
            $_SESSION['captcha_result'] = $num1 + $num2;
            $data['num1'] = $num1;
            $data['num2'] = $num2;
        }
    
        $this->renderHTML('../app/views/index_view.php', $data);
    }
    
    
    
    

    public function LogoutAction() {
        $_SESSION = [];
        session_destroy();
        header("Location: /");
        exit();
    }
}
?>