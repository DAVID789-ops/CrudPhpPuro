<?php
include_once "funciones.php";

if (!isset($_POST["id"]) || !isset($_POST["campo"]) || !isset($_POST["estado"])) {
    echo "Error: Parámetros incorrectos.";
    exit;
}

$id = $_POST["id"];
$campo = $_POST["campo"];
$estado = $_POST["estado"];

// Verificación adicional para prevenir inyecciones SQL
if (!in_array($campo, ['entregado', 'pagado'])) {
    echo "Error: Campo incorrecto.";
    exit;
}

$bd = obtenerBD();
$sentencia = $bd->prepare("UPDATE ventas_clientes SET $campo = ? WHERE id = ?");
$resultado = $sentencia->execute([$estado, $id]);

if ($resultado) {
    header("Location: repartidores.php");
    exit;
} else {
    echo "Error: No se pudo actualizar el estado.";
    exit;
}
?>
