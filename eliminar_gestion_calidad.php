<?php
include_once "funciones.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    if (eliminarGestionCalidad($id)) {
        // Éxito al eliminar el registro
        header("Location: listar_gestion_calidad.php"); // Redirigir a la página de listado
        exit();
    } else {
        // Error al eliminar el registro
        echo "Error al intentar eliminar el registro.";
    }
} else {
    // No se proporcionó un ID válido
    echo "ID no proporcionado para eliminar.";
}
?>
