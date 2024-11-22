<?php
include_once "funciones.php";

// Verificar si se ha enviado el formulario de edición
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $idCliente = $_POST['id_cliente'];
    $monto = $_POST['monto'];
    $fecha = $_POST['fecha'];
    // Aquí debes procesar la actualización en la base de datos utilizando una función como actualizarVenta()
    // Ejemplo:
    // $ok = actualizarVenta($id, $idCliente, $monto, $fecha);
    // if ($ok) {
    //     header("Location: ventas.php");
    //     exit();
    // } else {
    //     echo "Error al actualizar la venta";
    // }
}

// Obtener la información de la venta a editar
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
    <title>Editar Venta</title>
    <link rel="stylesheet" href="styles.css"> <!-- Incluye tu archivo CSS aquí -->
</head>
<body>
    <h1>Editar Venta</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="hidden" name="id" value="<?php echo $venta['id']; ?>">
        <div class="form-group">
            <label for="id_cliente">ID Cliente</label>
            <input type="text" class="form-control" name="id_cliente" id="id_cliente" value="<?php echo htmlspecialchars($venta['id_cliente']); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="monto">Monto</label>
            <input type="number" class="form-control" name="monto" id="monto" value="<?php echo htmlspecialchars($venta['monto']); ?>" required>
        </div>
        <div class="form-group">
            <label for="fecha">Fecha</label>
            <input type="date" class="form-control" name="fecha" id="fecha" value="<?php echo htmlspecialchars($venta['fecha']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="ver_ventas.php" class="btn btn-secondary">Cancelar</a>
    </form>
</body>
</html>
