<?php
include_once "funciones.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $bd = obtenerBD();
    $sentencia = $bd->prepare("UPDATE ventas_clientes SET numero_guia = NULL WHERE id = ?");
    $sentencia->execute([$id]);
    header("Location: repartidores.php");
    exit;
} else {
    header("Location: repartidores.php");
    exit;
}
?>
