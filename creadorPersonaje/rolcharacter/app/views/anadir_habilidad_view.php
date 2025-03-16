<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Habilidad</title>
    <style>
        body {
            background-color: #1f1f1f;
            font-family: Arial, sans-serif;
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }
        h1 {
            color: #f39c12;
        }
        form {
            background-color: #333;
            border: 1px solid #444;
            border-radius: 10px;
            padding: 20px;
            margin: 10px;
            width: 300px;
            text-align: center;
        }
        label, input, select {
            display: block;
            width: 100%;
            margin: 10px 0;
        }
        input[type="submit"] {
            background-color: #f39c12;
            border: none;
            border-radius: 5px;
            padding: 10px;
            color: #fff;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #e67e22;
        }
    </style>
</head>
<body>
    <h1>Añadir Habilidad</h1>
    <form method="post">
        <label for="nombre_habilidad">Nombre de la Habilidad:</label>
        <input type="text" id="nombre_habilidad" name="nombre_habilidad" required>

        <label for="descripcion">Descripción:</label>
        <input type="text" id="descripcion" name="descripcion" required>

        <label for="elemento">Elemento:</label>
        <input type="text" id="elemento" name="elemento" required>

        <label for="nivel_habilidad">Nivel de Habilidad:</label>
        <input type="number" id="nivel_habilidad" name="nivel_habilidad" required>

        <label for="visible">Visible:</label>
        <select id="visible" name="visible" required>
            <option value="1">Sí</option>
            <option value="0">No</option>
        </select>

        <label for="personaje_id">ID del Personaje:</label>
        <input type="number" id="personaje_id" name="personaje_id" required>

        <input type="submit" value="Añadir Habilidad">
    </form>
</body>
</html>