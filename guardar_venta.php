<?php
include_once "funciones.php";

if (isset($_POST["id_cliente"]) && isset($_POST["monto"]) && isset($_POST["fecha"]) && isset($_POST["descripcion"]) && isset($_POST["tamaño"]) && isset($_POST["cantidad"]) && isset($_POST["ganancia"]) && isset($_POST["nombres_perfumes"]) && isset($_POST["mensajero"]) && isset($_POST["precio_envio"]) && isset($_POST["direccion_envio"]) && isset($_POST["telefono"])) {
    $idCliente = $_POST["id_cliente"];
    $monto = $_POST["monto"];
    $fecha = $_POST["fecha"];
    $descripcion = $_POST["descripcion"];
    $tamaño = $_POST["tamaño"];
    $cantidad = $_POST["cantidad"];
    $ganancia = $_POST["ganancia"];
    $nombresPerfumes = $_POST["nombres_perfumes"];
    $mensajero = $_POST["mensajero"];
    $precioEnvio = $_POST["precio_envio"];
    $direccionEnvio = $_POST["direccion_envio"];
    $telefono = $_POST["telefono"];

    guardarVenta($idCliente, $monto, $fecha, $descripcion, $tamaño, $cantidad, $ganancia, $nombresPerfumes, $mensajero, $precioEnvio, $direccionEnvio, $telefono);
    header("Location: ver_ventas.php");
} else {
    echo "Error: falta algún dato";
}
?>
