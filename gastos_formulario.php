<?php include_once "encabezado.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <title>Registro de Gastos</title>
    <style>

        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold; /* Añadir negrita a los labels */
        }
        input, textarea, select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            font-size: 14px;
        }
        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #0056b3;
        }

        .boton-verde {
    display: inline-block;
    padding: 10px 20px;
    background-color: green;
    color: white;
    text-decoration: none;
    border-radius: 5px;
}

.boton-verde:hover {
    background-color: darkgreen;
}
    </style>
</head>
<body>
<br><br><br><br>
    <h2>Registro de Gastos</h2><br>
    <a href="ver_gastos.php" class="boton-verde">Lista</a><br><br>


    <form action="insertar_gasto.php" method="post">
        <label for="fecha">Fecha:</label>
        <input type="date" id="fecha" name="fecha" value="<?php echo date('Y-m-d'); ?>" required>

        <label for="nombre_gasto">Nombre del Gasto:</label>
        <input type="text" id="nombre_gasto" name="nombre_gasto" required>

        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" rows="4"></textarea>

        <label for="total">Total:</label>
        <input type="number" id="total" name="total" step="0.01" required>

        <label for="persona_gasto">Persona que realizó el gasto:</label>
        <select id="persona_gasto" name="persona_gasto" required>
            <option value="veronica">Veronica</option>
            <option value="david">David</option>
            <option value="edgar">Edgar</option>
            <option value="daniel">Daniel</option>
        </select>

        <button type="submit">Guardar Gasto</button>
    </form>
</body>
</html>

<?php include_once "pie.php"; ?>
