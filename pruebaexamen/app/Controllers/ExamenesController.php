<?php
namespace App\Controllers;
use App\Models\Usuarios;
use App\Models\Notas;
use App\Models\Examenes;
use App\Models\Preguntas;

class ExamenesController extends BaseController
{
    public function MostrarExamenAction()
    {
        $examenes = Examenes::getInstancia();
        $preguntasModel = Preguntas::getInstancia();

        $data['examenes'] = $examenes->get();
        $data['preguntas'] = '';
        $data['preguntasexamen'] = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['realizarexamen'])) {
                $data['id_examen'] = $_POST['id_examen'];

                if (empty($data['id_examen'])) {
                    $data['eId_examen'] = 'El examen es obligatorio';
                } else {
                    $data['preguntas'] = $preguntasModel->getByExamen($data['id_examen']);
                }
            } elseif (isset($_POST['enviarexamen'])) {
                $data['id_examen'] = $_POST['id_examen'];
                $data['preguntas'] = $preguntasModel->getByExamen($data['id_examen']);

                // Contar respuestas correctas e incorrectas
                $correctas = 0;
                $incorrectas = 0;
                $respuestas = $_POST['respuesta'];
                $preguntas = $_POST['id_pregunta'];

                foreach ($preguntas as $id_pregunta) {
                    $respuesta = $respuestas[$id_pregunta];
                    //  var_dump($respuesta);
                    $pregunta = $preguntasModel->getById($id_pregunta);

                    if ($respuesta == $pregunta['respuesta_correcta']) {
                        $correctas++;
                    } else {
                        $incorrectas++;
                    }
                }

                $data['correctas'] = $correctas;
                $data['incorrectas'] = $incorrectas;

                $data['nota'] = $correctas * 10 / count($preguntas);

                $notas = Notas::getInstancia();
                $notas->setIdUsuario($_SESSION['id']);
                $notas->setIdExamen($data['id_examen']);
                $notas->setNota($data['nota']);
                $notas->set();
            }
        }

        $this->renderHTML('../app/views/examenes_view.php', $data);
    }
}