<?php include_once "encabezado.php"; ?>

<?php
include_once "funciones.php";

$limit = 20;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$gestion_calidad = obtenerGestionCalidad($offset, $limit); // Obtener registros de gestión de calidad
$totalGestionCalidad = contarGestionCalidad(); // Función para contar el total de registros de gestión de calidad
$totalPages = ceil($totalGestionCalidad / $limit);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Gestión de Calidad</title>
    <link rel="stylesheet" href="styles.css"> <!-- Incluye tu archivo CSS aquí -->
    <style>
        /* Estilos adicionales para la tabla si los necesitas */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .acciones {
            text-align: center;
        }
        .acciones a {
            text-decoration: none;
            padding: 5px 10px;
            border: 1px solid #ccc;
            background-color: #f2f2f2;
            color: #333;
            cursor: pointer;
        }
        .acciones a:hover {
            background-color: #e0e0e0;
        }
    </style>
</head>
<body>
    <h1>Listado de Gestión de Calidad</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre del Cliente</th>
                <th>Fecha</th>
                <th>Valoración Producto</th>
                <th>Por qué Valoración</th>
                <th>Mejoras</th>
                <th>¿Recomendaría?</th>
                <th>Por qué Recomendación</th>
                <th>Acciones</th> <!-- Columna para acciones -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($gestion_calidad as $registro): ?>
                <tr>
                    <td><?php echo htmlspecialchars($registro['id']); ?></td>
                    <td><?php echo htmlspecialchars($registro['nombre_cliente']); ?></td>
                    <td><?php echo htmlspecialchars($registro['fecha']); ?></td>
                    <td><?php echo htmlspecialchars($registro['valoracion_producto']); ?></td>
                    <td><?php echo htmlspecialchars($registro['porque_valoracion']); ?></td>
                    <td><?php echo htmlspecialchars($registro['mejoras']); ?></td>
                    <td><?php echo htmlspecialchars($registro['recomendaria'] == 'si' ? 'Sí' : 'No'); ?></td>
                    <td><?php echo htmlspecialchars($registro['porque_recomendacion']); ?></td>
                    <td class="acciones">
                        <a href="eliminar_gestion_calidad.php?id=<?php echo $registro['id']; ?>">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=<?php echo $page - 1; ?>">&laquo; Anterior</a>
        <?php endif; ?>
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?php echo $i; ?>" class="<?php echo $i === $page ? 'active' : ''; ?>"><?php echo $i; ?></a>
        <?php endfor; ?>
        <?php if ($page < $totalPages): ?>
            <a href="?page=<?php echo $page + 1; ?>">Siguiente &raquo;</a>
        <?php endif; ?>
    </div>
</body>
</html>

<?php include_once "pie.php"; ?>
