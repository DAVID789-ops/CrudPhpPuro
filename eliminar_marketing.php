<?php
include_once "funciones.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    eliminarMarketing($id);
    header("Location: listar_marketing.php");
    exit();
}

function eliminarMarketing($id) {
    $bd = obtenerBD();
    $sentencia = $bd->prepare("DELETE FROM marketing WHERE id = ?");
    return $sentencia->execute([$id]);
}
?>
