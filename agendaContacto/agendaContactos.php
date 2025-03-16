<?php
/** 
* Ejemplo de uso de sesiones utilizando un array para manejo
* de una agenda de contactos
*/

// INICIAMOS SESIÓN
session_start();

if (isset($_POST["exportar_pdf"])) {
    // Cabeceras para forzar la descarga del archivo PDF
    header("Content-Type: application/pdf");
    header("Content-Disposition: attachment; filename=agenda.pdf");
    // Contenido básico del archivo PDF
    $pdfContent = "%PDF-1.4\n";
    $pdfContent .= "1 0 obj << /Type /Catalog /Pages 2 0 R >> endobj\n";
    $pdfContent .= "2 0 obj << /Type /Pages /Kids [3 0 R] /Count 1 >> endobj\n";
    $pdfContent .= "3 0 obj << /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Contents 4 0 R >> endobj\n";
    $pdfContent .= "4 0 obj << /Length 5 0 R >> stream\n";

    // Construcción del contenido del PDF
    $content = "BT /F1 24 Tf 50 750 Td (Agenda de Contactos) Tj ET\n";
    $yPosition = 700; // Posición inicial vertical
    foreach ($_SESSION["contacts"] as $contact) {
        $line = $contact["nombre"] . " - " . $contact["email"] . " - " . $contact["tfno"];
        $content .= "BT /F1 12 Tf 50 {$yPosition} Td (" . utf8_decode($line) . ") Tj ET\n";
        $yPosition -= 20; // Reducir la posición para la siguiente línea
    }

    // Agregar contenido al PDF
    $pdfContent .= $content . "endstream endobj\n";
    $pdfContent .= "5 0 obj " . strlen($content) . " endobj\n";
    $pdfContent .= "xref\n0 6\n0000000000 65535 f \n0000000010 00000 n \n0000000077 00000 n \n0000000179 00000 n \n0000000318 00000 n \n0000000458 00000 n \ntrailer << /Root 1 0 R /Size 6 >>\nstartxref\n503\n%%EOF";

    // Enviar contenido PDF al navegador
    echo $pdfContent;
    exit;
}

if (isset($_POST["exportar_txt"])) {
    // Cabeceras para forzar la descarga del archivo de texto
    header("Content-Type: text/plain");
    header("Content-Disposition: attachment; filename=agenda.txt");

    // Construcción del contenido del archivo de texto
    $txtContent = "Agenda de Contactos\n\n";
    foreach ($_SESSION["contacts"] as $contact) {
        $txtContent .= "Nombre: " . $contact["nombre"] . "\n";
        $txtContent .= "Email: " . $contact["email"] . "\n";
        $txtContent .= "Teléfono: " . $contact["tfno"] . "\n\n";
    }

    // Enviar contenido del archivo de texto al navegador
    echo $txtContent;
    exit;
}

// SI NO EXISTE LA VARIABLE DE SESIÓN, LA CREAMOS COMO ARRAY VACÍO
if (!isset($_SESSION["contacts"])) {
    $_SESSION["contacts"] = array();
}

$error = ""; // Variable para almacenar mensajes de error
if (isset($_POST["enviar"])) {
    $nombre = trim($_POST["nombre"]);
    $email = trim($_POST["email"]);
    $tfno = trim($_POST["tfno"]);

    // Validaciones
    if (empty($nombre) || empty($email) || empty($tfno)) {
        $error = "Todos los campos son obligatorios.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "El email no tiene un formato válido.";
    } else {
        // AÑADIMOS UN NUEVO ELEMENTO AL ARRAY
        $_SESSION["contacts"][] = array(
            "nombre" => $nombre,
            "email" => $email,
            "tfno" => $tfno
        );
        $error = ""; // Resetear error después de añadir
    }
}

$data = $_SESSION["contacts"];

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda de Contactos</title>
</head>
<body>
    <h1>Agenda</h1>
    <h2>Nuevo Contacto</h2>
    <?php if (!empty($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form action="" method="post">
        Nombre: <input type="text" name="nombre" id="nombre">
        Email: <input type="text" name="email" id="email">
        Teléfono: <input type="text" name="tfno" id="tfno">
        <input type="submit" value="Añadir Contacto" name="enviar">
        <input type="submit" value="Exportar a PDF" name="exportar_pdf">
        <input type="submit" value="Exportar a TXT" name="exportar_txt">
    </form>
    <h2>Lista de Contactos</h2>
    <?php
        foreach ($data as $clave => $valor) {
            echo $valor["nombre"] . " - " . $valor["email"] . " - " . $valor["tfno"];
            echo "<br/>";
        }
    ?>

    <br/>
    <a href="cierrasesion.php">Cerrar sesión</a>
</body>
</html>
