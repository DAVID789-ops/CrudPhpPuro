<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="CRM">
    <title>CRM</title>
    <!-- Cargar el CSS de Bootstrap -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css"> <!-- Tu archivo CSS personalizado -->
    <!-- Cargar estilos propios y otros CSS necesarios -->
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.9.55/css/materialdesignicons.min.css" rel="stylesheet">
    <style>
        .nav-link {
            font-size: 1.2rem;
        }
    </style>
</head>

<body>
    <!-- Definición del menú -->
    <nav class="navbar navbar-expand-md navbar-dark bg-success">
        <a class="navbar-brand" href="#"><h1><?php echo htmlspecialchars($_SESSION['username']); ?></h1></a>
        <button class="navbar-toggler" type="button" id="navbarToggler" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="miNavbar">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="clientes.php"><span class="mdi mdi-account-multiple"></span> Clientes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="ventas.php"><span class="mdi mdi-store"></span> Ventas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php"><span class="mdi mdi-desktop-mac-dashboard"></span> Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="repartidores.php"><span class="mdi mdi-information"></span> Repartidores</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="gastos_formulario.php"><span class="mdi mdi-information"></span> Gastos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="marketing.php"><span class="mdi mdi-information"></span> Marketing</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="gestion_calidad_form.php"><span class="mdi mdi-information"></span> Calidad</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="crear_usuario.php"><span class="mdi mdi-information"></span> Usuario</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="devoluciones.php"><span class="mdi mdi-information"></span> Devoluciones</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="terminado.php"><span class="mdi mdi-information"></span>Terminado</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="eliminado.php"><span class="mdi mdi-information"></span>eliminar</a>
                </li>
                
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="logout.php"><span class="mdi mdi-handshake-outline"></span> Cerrar</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Cargar Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <!-- Script personalizado para el menú hamburguesa -->
    <script src="./js/custom.js"></script>