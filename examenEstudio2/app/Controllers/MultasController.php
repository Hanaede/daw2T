<?php
namespace App\Controllers;
use App\Models\Multas;
use App\Models\Usuarios;

class MultasController extends BaseController
{
    public function pagarMultasAction() {
        //Necesito el id de la multa a pagar
        $idMulta = explode('/', $_SERVER['REQUEST_URI'])[2];

        $data['multas'] = [];

        //Obtengo multa a través del id
        $multas = Multas::getInstancia();
        $multa = $multas->get($idMulta);

        //Si la multa existe
        if($multa) {
            $data['multas'] = $multa;
        }

        //Si el método es post
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $multas->pagarMulta($idMulta, 'Pagada');
            header('Location: /perfilconductor/');
            exit();
        }
        $this->renderHTML('../app/views/pagar_view.php', $data);
    }

    public function addMultasAction() {
        //Inicializamos las variables
        $data['nombreagente'] = $data['matricula'] = $data['descripcion'] = $data['fecha'] = $data['conductor'] = $data['itiposancion'] = '';
        $data['eNombreAgente'] = $data['eMatricula'] = $data['eDescripcion'] = $data['eFecha'] = $data['eConductor'] = $data['eTipoSancion'] = '';

        //Obtengo el nombre del agente y de los conductores
        $usuarios = Usuarios::getInstancia();
        $usuario = $usuarios->get($_SESSION['id']);
        var_dump($usuario);
        $data['nombreagente'] = $usuario[0]['nombre'];
        var_dump($data['nombreagente']);

        $usuarios = Usuarios::getInstancia();
        $data['conductores'] = $usuarios->getConductores();
        var_dump($data['conductores']);

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data['nombreagente'] = $_POST['nombreagente'] ?? '';
            $data['matricula'] = $_POST['matricula'] ?? '';
            $data['descripcion'] = $_POST['descripcion'] ?? '';
            $data['fecha'] = $_POST['fecha'] ?? '';
            $data['conductor'] = $_POST['conductor'] ?? '';
            $data['tiposancion'] = $_POST['tiposancion'] ?? '';

            //Validamos datos
            if(empty($data['nombreagente'])) {
                $data['eNombreAgente'] = 'El nombre del agente es obligatorio';
            }

            if(empty($data['matricula'])) {
                $data['eMatricula'] = 'La matrícula es obligatoria';
            }

            if(empty($data['descripcion'])) {
                $data['eDescripcion'] = 'La descripción es obligatoria';
            }

            if(empty($data['fecha'])) {
                $data['eFecha'] = 'La fecha es obligatoria';
            }

            if(empty($data['conductor'])) {
                $data['eConductor'] = 'El conductor es obligatorio';
            }
            
            if(empty($data['tiposancion'])) {
                $data['eTipoSancion'] = 'El tipo de sanción es obligatorio';
            }


            //Si no hay errores y los datos vacíos, añadimos la multa
            if($data['matricula'] && $data['descripcion'] && $data['fecha'] && $data['conductor'] && $data['tiposancion']) {
                $multas = Multas::getInstancia();
                $multas->setIdConductor($data['conductor']);
                $multas->setIdAgente($_SESSION['id']);
                $multas->setMatricula($data['matricula']);
                $multas->setDescripcion($data['descripcion']);
                $multas->setIdTipoSanciones($data['tiposancion']);

                //Formateamos la fecha
                $fecha = date_create_from_format('Y-m-d', $data['fecha']);
                $multas->setFecha($data['fecha']);

                //Comprobamos el tipo de sanción
                if($data['tiposancion'] == 1){
                    $multas->setImporte(100);
                }elseif($data['tiposancion'] == 2){
                    $multas->setImporte(200);
                }else{
                    $multas->setImporte(300);
                }
                $multas->setDescuento(0);

                $multas->setEstado('Pendiente');
                $multas->set();
                header('Location: /perfilagente/');
                exit();
            }
        }
        $this->renderHTML('../app/views/add_multa_view.php', $data);

    }
}