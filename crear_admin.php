<?php
// Nombre del archivo: crear_admin.php

include_once "funciones.php";

$usuario = 'admin';
$contraseña = 'ELEFANTErosado13';

$hash = password_hash($contraseña, PASSWORD_DEFAULT);

$bd = obtenerBD();
$sentencia = $bd->prepare("INSERT INTO usuarios (username, password_hash) VALUES (?, ?)");
$sentencia->execute([$usuario, $hash]);

echo "Usuario administrador creado con éxito.";
?>
