<?php
include_once "funciones.php";

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];
    $bd = obtenerBD();
    $sentencia = $bd->prepare("SELECT numero_guia FROM ventas_clientes WHERE id = ?");
    $sentencia->execute([$id]);
    $venta = $sentencia->fetch(PDO::FETCH_ASSOC);

    if (!$venta) {
        echo "Venta no encontrada.";
        exit();
    }
} elseif ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];
    if (isset($_POST['numero_guia'])) {
        $numero_guia = $_POST['numero_guia'];
        $bd = obtenerBD();
        $sentencia = $bd->prepare("UPDATE ventas_clientes SET numero_guia = ? WHERE id = ?");
        if ($sentencia->execute([$numero_guia, $id])) {
            header("Location: repartidores.php");
            exit();
        } else {
            echo "Error al actualizar el número de guía.";
            exit();
        }
    } elseif (isset($_POST['eliminar'])) {
        $bd = obtenerBD();
        $sentencia = $bd->prepare("UPDATE ventas_clientes SET numero_guia = NULL WHERE id = ?");
        if ($sentencia->execute([$id])) {
            header("Location: repartidores.php");
            exit();
        } else {
            echo "Error al eliminar el número de guía.";
            exit();
        }
    }
} else {
    echo "Solicitud no válida.";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Número de Guía</title>
    <link rel="stylesheet" href="styles.css"> <!-- Incluye tu archivo CSS aquí -->
</head>
<body>
    <h1>Editar Número de Guía</h1>
    <form action="editar_numero_guia.php" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
        <label for="numero_guia">Número de Guía:</label>
        <input type="text" id="numero_guia" name="numero_guia" value="<?php echo htmlspecialchars($venta['numero_guia']); ?>" required>
        <button type="submit">Guardar</button>
        <button type="submit" name="eliminar" onclick="return confirm('¿Estás seguro de que deseas eliminar el número de guía?');">Eliminar</button>
    </form>
</body>
</html>
