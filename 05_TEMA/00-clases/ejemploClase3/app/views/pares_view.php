<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modelo Vista Controlador</title>
</head>
<body>
    <h1>Modelo Vista Controlador</h1>
    <p><?php foreach ($data['message'] as $par) {
        echo $par . "<br/>";
    }
    ?></p>
</body>
</html>