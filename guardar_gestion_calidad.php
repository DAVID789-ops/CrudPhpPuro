<?php
include_once "funciones.php";

// Recoger datos del formulario
$nombreCliente = $_POST['nombre_cliente'];
$fecha = $_POST['fecha'];
$valoracionProducto = $_POST['valoracion_producto'];
$porqueValoracion = $_POST['porque_valoracion'];
$mejoras = $_POST['mejoras'];
$recomendaria = $_POST['recomendaria'];
$porqueRecomendacion = $_POST['porque_recomendacion'];

// Insertar en la base de datos
$bd = obtenerBD();
$sentencia = $bd->prepare("INSERT INTO gestion_calidad (nombre_cliente, fecha, valoracion_producto, porque_valoracion, mejoras, recomendaria, porque_recomendacion) VALUES (?, ?, ?, ?, ?, ?, ?)");
$sentencia->execute([$nombreCliente, $fecha, $valoracionProducto, $porqueValoracion, $mejoras, $recomendaria, $porqueRecomendacion]);

// Redirigir al listado de gestión de calidad
header("Location: listar_gestion_calidad.php");
exit();
?>
