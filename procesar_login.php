<?php
session_start();
include_once "funciones.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $usuario = obtenerUsuarioPorUsername($username);

    if ($usuario && password_verify($password, $usuario->password)) {
        $_SESSION['usuario_id'] = $usuario->id;
        $_SESSION['username'] = $usuario->username;
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Usuario o contraseña incorrectos.";
    }
}
?>
