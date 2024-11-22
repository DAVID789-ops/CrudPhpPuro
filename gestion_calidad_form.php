<?php include_once "encabezado.php"; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Calidad - Nuevo Registro</title>
    <style>
        /* Estilos adicionales para el formulario si los necesitas */
    </style>
</head>
<body>
<br><br><br><br>
    <h1>Formulario de Gestión de Calidad</h1>
    <a href="listar_gestion_calidad.php" class="boton-verde">Listar</a>
    <form action="guardar_gestion_calidad.php" method="POST">
        <label for="nombre_cliente">Nombre del Cliente:</label>
        <input type="text" id="nombre_cliente" name="nombre_cliente" required><br><br>

        <label for="fecha">Fecha:</label>
        <input type="date" id="fecha" name="fecha" value="<?php echo date('Y-m-d'); ?>" required><br><br>

        <label for="valoracion_producto">Valoración del Producto (1-10):</label>
        <input type="number" id="valoracion_producto" name="valoracion_producto" min="1" max="10" required><br><br>

        <label for="porque_valoracion">Por qué da esa valoración:</label><br>
        <textarea id="porque_valoracion" name="porque_valoracion" rows="4" cols="50" required></textarea><br><br>

        <label for="mejoras">En qué podemos mejorar (máx. 300 caracteres):</label><br>
        <textarea id="mejoras" name="mejoras" rows="4" cols="50" maxlength="300"></textarea><br><br>

        <label for="recomendaria">¿Nos recomendaría?</label>
        <select id="recomendaria" name="recomendaria" required>
            <option value="si">Sí</option>
            <option value="no">No</option>
        </select><br><br>

        <label for="porque_recomendacion">Por qué recomendaría o no:</label><br>
        <textarea id="porque_recomendacion" name="porque_recomendacion" rows="4" cols="50" required></textarea><br><br>

        <input class="solo" type="submit" value="Guardar">
    </form>
</body>
</html>

<?php include_once "pie.php"; ?>
