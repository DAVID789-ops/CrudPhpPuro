<?php
include_once "funciones.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $ok = eliminarVenta($id); // Implementa esta función en funciones.php para eliminar la venta por ID
    if ($ok) {
        header("Location: ventas.php");
        exit();
    } else {
        echo "Error al eliminar la venta.";
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $venta = obtenerVentaPorId($id); // Implementa esta función en funciones.php para obtener los detalles de la venta por ID
    if (!$venta) {
        die("Venta no encontrada.");
    }
} else {
    die("ID de venta no especificado.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Venta</title>
    <link rel="stylesheet" href="styles.css"> <!-- Incluye tu archivo CSS aquí -->
</head>
<body>
    <h1>Eliminar Venta</h1>
    <p>¿Estás seguro de que deseas eliminar la venta con ID <?php echo htmlspecialchars($venta['id']); ?>?</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="hidden" name="id" value="<?php echo $venta['id']; ?>">
        <button type="submit" class="btn btn-danger">Eliminar</button>
        <a href="ver_ventas.php" class="btn btn-secondary">Cancelar</a>
    </form>
</body>
</html>
