<?php
// procesar_devoluciones.php

include 'funciones.php';

function insertarCodigoDevolucion($numero_guia) {
    $db = obtenerBD(); 
    $sql = "INSERT INTO eliminar (numero_guia) VALUES (:numero_guia)";
    $stmt = $db->prepare($sql);

    try {
        $stmt->execute([':numero_guia' => $numero_guia]);
        return true;
    } catch (PDOException $e) {
        echo "Error en la inserción: " . $e->getMessage(); // Para depurar errores
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigos = json_decode(file_get_contents('php://input'), true);
    
    // Verifica si se recibieron los datos
    if (!$codigos || !isset($codigos['codigos'])) {
        echo "No se recibieron códigos.";
        exit();
    }

    $codigos = $codigos['codigos'];
    $errores = [];
    
    // Asegúrate de que $codigos sea un array
    if (!is_array($codigos)) {
        echo "Los códigos no son un array.";
        exit();
    }

    // Procesar cada código
    foreach ($codigos as $codigo) {
        $resultado = insertarCodigoDevolucion($codigo);
        if ($resultado !== true) {
            $errores[] = $resultado; 
        }
    }

    if (!empty($errores)) {
        echo implode(", ", $errores); // Muestra todos los errores
    } else {
        echo "Códigos guardados correctamente."; // Mensaje de éxito
    }
    exit(); // Evita la redirección para poder ver el mensaje
}
