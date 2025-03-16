<?php

require_once('config/config.php');
require_once('lib/function.php');

$procesaFormulario = false;

$preguntasAcertadas = array();

if (isset($_POST['send'])){
    $procesaFormulario = true;
    $indExamen = $_POST['indExamen'];
} else {
    $indExamen = array_rand($aExamenes);
}

$examen = $aExamenes[$indExamen];
$numeroPreguntas = count($examen['preguntas']);

$valExamen = array();

foreach($examen['preguntas']as $key=>$item){
    $valExamen[$key] = $item['tipo'] == 'cb' ? array() : '';
}

if ($procesaFormulario){
    $valExamen = clearData($_POST['pregunta']);
    $nota = 0;

    foreach($examen['preguntas'] as $key=>$item){
        switch($item['tipo']){
            case "text":
                $respuestas = explode(';',$item['respuesta']);
                $respuestas = array_map(function($cadena){return strtoupper(trim($cadena));},
                                        $respuestas);

                if (in_array(strtoupper(trim($valExamen[$key])), $respuestas)) {
                    $nota++;
                    $preguntasAcertadas[]=$key;
                };
                break;
            case "cb":
                if ($item['respuesta'] === ($valExamen[$key] ?? [])) {
                    $nota++;
                    $preguntasAcertadas[] = $key;
                };
                break;
            case "vf":
                if ($item['respuesta'] === ($valExamen[$key] ?? '')) {
                    $nota++;
                    $preguntasAcertadas[] = $key;
                };
                break;
        }
    }
$porcentajeAciertos = round(($nota/$numeroPreguntas) * 100,2);
switch (true) {
    case ($porcentajeAciertos>= 80):
        $resultadoCualitativo = "Excelente"; // Excelente desempeño
        break;

    case ($porcentajeAciertos >= 50):
        $resultadoCualitativo = "Aceptable"; // Buen desempeño
        break;

    default:
        $resultadoCualitativo = "Bajo"; // Necesita mejorar
        break;
    }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="css/css.css">
</head>
<body>
    <h1>Ejercicio</h1>
    <h2><?php echo $examen['titulo']?></h2>
    <form action="" method="post">
        <?php
            echo "<br/>";
            foreach ($examen['preguntas'] as $key=>$item){
                $resultadoPregunta='';
                if($procesaFormulario){
                    $resultadoPregunta = in_array($key, $preguntasAcertadas) ? ALEGRE : TRISTE;
                }
            echo ($key+1) . ".-" . $item['pregunta']." ".$resultadoPregunta;
                echo "<br/>";
                switch ($item['tipo']){
                    case 'text':
                        $feedBack = (!$procesaFormulario)?'':$item['respuesta'];
                        echo "<input type=\"text\" name=\"pregunta[$key]\" value=\"$valExamen[$key]\"/> <br/>";
                        break;
                    case 'cb':
                        foreach ($item['opciones'] as $value) {
                            $check = (in_array($value, ($valExamen[$key]??[]))) ? 'checked' : '';
                            $feedBack = ($procesaFormulario && in_array($value, ($item['respuesta']??[]))) ? '&#10003;' : '';
                            echo "<input type=\"checkbox\" name=\"pregunta[$key][]\" value=\"".$value."\"" . $value>"
                        }
                        break;

                    case 'vf':
                        foreach(['Verdadero','Falso'] as $value){
                            $check = (in_array($value, ($valExamen[$key]??[]))) ? 'checked' : '';
                            $feedBack = ($procesaFormulario && $value == $item['respuesta']) ? '&#10003;':'';
                            echo "<input type=\"radio\" name=\"pregunt[$key]\" value=\"$value\" >".$value."<br/>";
                        }
                        break;
                }
            }
        ?>
    </form>

</body>
</html>
