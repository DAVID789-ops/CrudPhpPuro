<?php
// insertar_gasto.php

// Incluir el archivo de funciones para la conexión y otras funciones relacionadas
include 'funciones.php';

// Verificar si se ha enviado el formulario para insertar el gasto
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre_gasto = $_POST['nombre_gasto'];
    $descripcion = $_POST['descripcion'];
    $total = $_POST['total'];
    $persona_gasto = $_POST['persona_gasto'];
    
    // La fecha se coloca automáticamente en la fecha actual
    $fecha = date("Y-m-d");

    try {
        // Obtener la conexión a la base de datos
        $bd = obtenerBD();

        // Preparar la consulta SQL para insertar el gasto
        $sentencia = $bd->prepare("INSERT INTO gastos (fecha, nombre_gasto, descripcion, total, persona_gasto) VALUES (?, ?, ?, ?, ?)");
        
        // Ejecutar la consulta con los valores correspondientes
        $resultado = $sentencia->execute([$fecha, $nombre_gasto, $descripcion, $total, $persona_gasto]);

        // Verificar si la consulta se ejecutó correctamente
        if ($resultado) {
            echo "Gasto insertado correctamente.";
        } else {
            echo "Error al insertar el gasto.";
        }
    } catch (PDOException $e) {
        // Capturar y mostrar errores de la base de datos
        echo "Error al conectar a la base de datos: " . $e->getMessage();
    }
}
?>

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
    </style>
</head>
<body>
    <h2>Insertar Nuevo Gasto</h2>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="nombre_gasto"><strong>Nombre del Gasto:</strong></label><br>
        <input type="text" id="nombre_gasto" name="nombre_gasto" required><br><br>
        
        <label for="descripcion"><strong>Descripción:</strong></label><br>
        <textarea id="descripcion" name="descripcion" rows="4" cols="50"></textarea><br><br>
        
        <label for="total"><strong>Total:</strong></label><br>
        <input type="number" id="total" name="total" required><br><br>
        
        <label for="persona_gasto"><strong>Persona que realizó el gasto:</strong></label><br>
        <select id="persona_gasto" name="persona_gasto" required>
            <option value="veronica">Veronica</option>
            <option value="david">David</option>
            <option value="edgar">Edgar</option>
            <option value="daniel">Daniel</option>
        </select><br><br>
        
        <input type="submit" value="Insertar Gasto">
    </form>
</body>
</html>
