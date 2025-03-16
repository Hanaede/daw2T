<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Habilidad</title>
    <style>
        body {
            background-color: #1f1f1f;
            font-family: 'Arial', sans-serif;
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }
        h1 {
            color: #f39c12;
        }
        .form-container {
            background-color: #333;
            border: 1px solid #444;
            border-radius: 10px;
            padding: 20px;
            margin: 10px;
            width: 300px;
            text-align: center;
        }
        .form-container label {
            display: block;
            margin: 10px 0 5px;
        }
        .form-container input, .form-container textarea, .form-container select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #555;
            border-radius: 5px;
            background-color: #444;
            color: #fff;
        }
        .form-container button {
            background-color: #f39c12;
            border: none;
            border-radius: 5px;
            color: #fff;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #e67e22;
        }
    </style>
</head>
<body>
    <h1>Modificar Habilidad</h1>
    <div class="form-container">
        <?php if (isset($data['habilidad'])): ?>
            <form action="/modificarHabilidad/<?= htmlspecialchars($data['habilidad']['id']) ?>" method="post">
                <label for="nombre_habilidad">Nombre de la Habilidad</label>
                <input type="text" id="nombre_habilidad" name="nombre_habilidad" value="<?= htmlspecialchars($data['habilidad']['nombre_habilidad']) ?>" required>

                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion" required><?= htmlspecialchars($data['habilidad']['descripcion']) ?></textarea>

                <label for="elemento">Elemento</label>
                <input type="text" id="elemento" name="elemento" value="<?= htmlspecialchars($data['habilidad']['elemento']) ?>" required>

                <label for="nivel_habilidad">Nivel de Habilidad</label>
                <input type="number" id="nivel_habilidad" name="nivel_habilidad" value="<?= htmlspecialchars($data['habilidad']['nivel_habilidad']) ?>" required>

                <label for="visible">Visible</label>
                <select id="visible" name="visible" required>
                    <option value="1" <?= $data['habilidad']['visible'] == 1 ? 'selected' : '' ?>>Sí</option>
                    <option value="0" <?= $data['habilidad']['visible'] == 0 ? 'selected' : '' ?>>No</option>
                </select>

                <button type="submit">Guardar Cambios</button>
            </form>
        <?php else: ?>
            <p>No se ha encontrado la habilidad.</p>
        <?php endif; ?>
    </div>
</body>
</html>