<?php
require_once "funciones.php";

// Iniciar sesión si no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener conexión a la base de datos
    $conn = obtenerBD();

    // Preparar la consulta SQL
    $sql = "INSERT INTO marketing (plataforma, importe_gastado, descripcion, horario, fecha, mensajes_recibidos, hora_pico, hora_baja)
            VALUES (:plataforma, :importe_gastado, :descripcion, :horario, :fecha, :mensajes_recibidos, :hora_pico, :hora_baja)";
    
    // Preparar la declaración
    $stmt = $conn->prepare($sql);

    // Enlazar los parámetros
    $stmt->bindParam(':plataforma', $_POST['plataforma']);
    $stmt->bindParam(':importe_gastado', $_POST['importe_gastado']);
    $stmt->bindParam(':descripcion', $_POST['descripcion']);
    $stmt->bindParam(':horario', $_POST['horario']);
    $stmt->bindParam(':fecha', $_POST['fecha']);
    $stmt->bindParam(':mensajes_recibidos', $_POST['mensajes_recibidos']);
    $stmt->bindParam(':hora_pico', $_POST['hora_pico']);
    $stmt->bindParam(':hora_baja', $_POST['hora_baja']);

    // Ejecutar la declaración
    if ($stmt->execute()) {
        // Redirigir a marketing.php
        header("Location: marketing.php");
        exit();
    } else {
        echo "Error al guardar el registro.";
    }

    // Cerrar la conexión
    $conn = null;
}
?>
