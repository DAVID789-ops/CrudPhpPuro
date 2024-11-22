<?php
include_once "encabezado.php";
include_once "funciones.php"; // Asegúrate de incluir funciones.php solo una vez

// Ya no es necesario definir la función obtenerVentas aquí
// Usa la función definida en funciones.php



$limit = 20;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$ventas = obtenerVentas($offset, $limit);
$totalVentas = contarVentas();
$totalPages = ceil($totalVentas / $limit);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ver Ventas</title>
    <link rel="stylesheet" href="styles.css"> <!-- Incluye tu archivo CSS aquí -->
    <style>
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
        .pagination {
            text-align: center;
            margin-top: 20px;
        }
        .pagination a {
            margin: 0 5px;
            text-decoration: none;
            padding: 8px 16px;
            background-color: #f2f2f2;
            border: 1px solid #ddd;
            color: #333;
        }
        .pagination a.active {
            background-color: #333;
            color: #fff;
            border: 1px solid #333;
        }
        .acciones {
            display: flex;
            justify-content: space-around;
        }
        .acciones a, .acciones form {
            text-decoration: none;
            padding: 5px 10px;
            border: 1px solid #ccc;
            color: #fff;
            cursor: pointer;
        }
        .acciones a.editar {
            background-color: #4CAF50; /* Verde */
        }
        .acciones a.eliminar {
            background-color: #f44336; /* Rojo */
        }
        .acciones form button {
            background-color: #4CAF50; /* Verde */
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
        .acciones form button.eliminar {
            background-color: #f44336; /* Rojo */
        }
        .acciones a:hover, .acciones form button:hover {
            background-color: #45a049;
        }
        .acciones a.eliminar:hover, .acciones form button.eliminar:hover {
            background-color: #d32f2f;
        }
        .acciones form {
            display: inline-block;
            margin: 0;
        }
    </style>
    <script>
        function confirmarEliminacion(event) {
            if (!confirm("¿Estás seguro de que deseas eliminar este registro?")) {
                event.preventDefault();
            }
        }
    </script>
</head>
<body>
    <h1>Listado de Ventas</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre Cliente</th>
                <th>Monto</th>
                <th>Descripción</th>
                <th>Cantidad</th>
                <th>Nombres de Perfumes</th>
                <th>Mensajero</th>
                <th>Precio Envío</th>
                <th>Dirección Envío</th>
                <th>Número de Guía</th>
                <th>Teléfono</th>
                <th>Entregado</th> <!-- Añadido -->
                <th>Pagado</th> <!-- Añadido -->
                <th>Acciones</th> <!-- Columna para acciones -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ventas as $venta) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($venta['id']); ?></td>
                    <td><?php echo htmlspecialchars($venta['nombre_cliente']); ?></td>
                    <td><?php echo htmlspecialchars($venta['monto']); ?></td>
                    <td><?php echo htmlspecialchars($venta['descripcion']); ?></td>
                    <td><?php echo htmlspecialchars($venta['cantidad']); ?></td>
                    <td><?php echo htmlspecialchars($venta['nombres_perfumes']); ?></td>
                    <td><?php echo htmlspecialchars($venta['mensajero']); ?></td>
                    <td><?php echo htmlspecialchars($venta['precio_envio']); ?></td>
                    <td><?php echo htmlspecialchars($venta['direccion_envio']); ?></td>
                    <td><?php echo htmlspecialchars($venta['numero_guia']); ?></td>
                    <td><?php echo htmlspecialchars($venta['telefono']); ?></td>
                    <td><?php echo htmlspecialchars($venta['entregado'] ? 'Sí' : 'No'); ?></td> <!-- Añadido -->
                    <td><?php echo htmlspecialchars($venta['pagado'] ? 'Sí' : 'No'); ?></td> <!-- Añadido -->
                    <td class="acciones">
                        <a href="editar_numero_guia.php?id=<?php echo $venta['id']; ?>" class="editar">Editar</a>
                        <form action="cambiar_estado.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $venta['id']; ?>">
                            <input type="hidden" name="campo" value="entregado">
                            <input type="hidden" name="estado" value="<?php echo $venta['entregado'] ? '0' : '1'; ?>">
                            <button type="submit"><?php echo $venta['entregado'] ? 'No Entregado' : 'Entregado'; ?></button>
                        </form>
                        <form action="cambiar_estado.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $venta['id']; ?>">
                            <input type="hidden" name="campo" value="pagado">
                            <input type="hidden" name="estado" value="<?php echo $venta['pagado'] ? '0' : '1'; ?>">
                            <button type="submit"><?php echo $venta['pagado'] ? 'No Pagado' : 'Pagado'; ?></button>
                        </form>
                        <a href="eliminar_numero_guia.php?id=<?php echo $venta['id']; ?>" class="eliminar" onclick="confirmarEliminacion(event)">Eliminar</a>
                    </td>
                </tr>
            <?php } ?>
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
