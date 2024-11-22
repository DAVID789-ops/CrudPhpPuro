<?php include_once "encabezado.php"; ?>
<?php
include_once "funciones.php";

// Funciones de búsqueda
function buscarVentasPorNombre($nombre, $offset, $limit) {
    $bd = obtenerBD();
    $nombre = "%$nombre%";
    $sentencia = $bd->prepare("SELECT v.id, c.nombre AS nombre_cliente, c.telefono, v.monto, v.fecha, v.descripcion, v.tamaño, v.cantidad, v.ganancia, v.nombres_perfumes, v.mensajero, v.precio_envio, v.direccion_envio, v.hecho 
                              FROM ventas_clientes v
                              JOIN clientes c ON v.id_cliente = c.id
                              WHERE c.nombre LIKE ? 
                              ORDER BY v.id DESC LIMIT ? OFFSET ?");
    $sentencia->bindParam(1, $nombre, PDO::PARAM_STR);
    $sentencia->bindParam(2, $limit, PDO::PARAM_INT);
    $sentencia->bindParam(3, $offset, PDO::PARAM_INT);
    $sentencia->execute();
    return $sentencia->fetchAll(PDO::FETCH_ASSOC);
}

function buscarVentasPorTelefono($telefono, $offset, $limit) {
    $bd = obtenerBD();
    $telefono = "%$telefono%";
    $sentencia = $bd->prepare("SELECT v.id, c.nombre AS nombre_cliente, c.telefono, v.monto, v.fecha, v.descripcion, v.tamaño, v.cantidad, v.ganancia, v.nombres_perfumes, v.mensajero, v.precio_envio, v.direccion_envio, v.hecho 
                              FROM ventas_clientes v
                              JOIN clientes c ON v.id_cliente = c.id
                              WHERE c.telefono LIKE ? 
                              ORDER BY v.id DESC LIMIT ? OFFSET ?");
    $sentencia->bindParam(1, $telefono, PDO::PARAM_STR);
    $sentencia->bindParam(2, $limit, PDO::PARAM_INT);
    $sentencia->bindParam(3, $offset, PDO::PARAM_INT);
    $sentencia->execute();
    return $sentencia->fetchAll(PDO::FETCH_ASSOC);
}

function contarVentasPorNombre($nombre) {
    $bd = obtenerBD();
    $nombre = "%$nombre%";
    $sentencia = $bd->prepare("SELECT COUNT(*) as total FROM ventas_clientes v JOIN clientes c ON v.id_cliente = c.id WHERE c.nombre LIKE ?");
    $sentencia->bindParam(1, $nombre, PDO::PARAM_STR);
    $sentencia->execute();
    return $sentencia->fetch(PDO::FETCH_ASSOC)['total'];
}

function contarVentasPorTelefono($telefono) {
    $bd = obtenerBD();
    $telefono = "%$telefono%";
    $sentencia = $bd->prepare("SELECT COUNT(*) as total FROM ventas_clientes v JOIN clientes c ON v.id_cliente = c.id WHERE c.telefono LIKE ?");
    $sentencia->bindParam(1, $telefono, PDO::PARAM_STR);
    $sentencia->execute();
    return $sentencia->fetch(PDO::FETCH_ASSOC)['total'];
}

// Variables para paginación
$limit = 20;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Variables de búsqueda
$ventas = [];
$totalVentas = 0;
$buscarPor = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['hecho'])) {
    $ventaId = $_POST['venta_id'];
    $hecho = $_POST['hecho'] == 'true' ? 1 : 0;
    actualizarHecho($ventaId, $hecho);
    // Redirigir para evitar reenvío del formulario
    header("Location: ver_ventas.php?page=$page");
    exit();
}

if (isset($_GET['nombre_cliente']) && !empty($_GET['nombre_cliente'])) {
    $buscarPor = 'nombre_cliente';
    $nombre = $_GET['nombre_cliente'];
    $ventas = buscarVentasPorNombre($nombre, $offset, $limit);
    $totalVentas = contarVentasPorNombre($nombre);
} elseif (isset($_GET['telefono']) && !empty($_GET['telefono'])) {
    $buscarPor = 'telefono';
    $telefono = $_GET['telefono'];
    $ventas = buscarVentasPorTelefono($telefono, $offset, $limit);
    $totalVentas = contarVentasPorTelefono($telefono);
} else {
    $ventas = obtenerVentas($offset, $limit);
    $totalVentas = contarVentas();
}

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
        .acciones a, .acciones button {
            text-decoration: none;
            padding: 5px 10px;
            border: 1px solid #ccc;
            background-color: #f2f2f2;
            color: #333;
            cursor: pointer;
        }
        .acciones a:hover, .acciones button:hover {
            background-color: #e0e0e0;
        }
        .acciones button.eliminar {
            background-color: red;
            color: white;
        }
        .acciones button.editar {
            background-color: blue;
            color: white;
        }
    </style>
</head>
<body>
    <h1>Listado de Ventas</h1>
    <form method="GET" action="ver_ventas.php">
        <input type="text" name="nombre_cliente" placeholder="Buscar por nombre" value="<?php echo isset($_GET['nombre_cliente']) ? htmlspecialchars($_GET['nombre_cliente']) : ''; ?>">
        <input type="text" name="telefono" placeholder="Buscar por teléfono" value="<?php echo isset($_GET['telefono']) ? htmlspecialchars($_GET['telefono']) : ''; ?>">
        <button type="submit">Buscar</button>
    </form>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre Cliente</th>
                <th>Teléfono</th>
                <th>Monto</th>
                <th>Fecha</th>
                <th>Descripción</th>
                <th>Tamaño</th>
                <th>Cantidad</th>
                <th>Ganancia</th>
                <th>Nombres de Perfumes</th>
                <th>Mensajero</th>
                <th>Precio Envío</th>
                <th>Dirección Envío</th>
                <th>Hecho</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ventas as $venta) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($venta['id']); ?></td>
                    <td><?php echo htmlspecialchars($venta['nombre_cliente']); ?></td>
                    <td><?php echo htmlspecialchars($venta['telefono']); ?></td>
                    <td><?php echo htmlspecialchars($venta['monto']); ?></td>
                    <td><?php echo htmlspecialchars($venta['fecha']); ?></td>
                    <td><?php echo htmlspecialchars($venta['descripcion']); ?></td>
                    <td><?php echo htmlspecialchars($venta['tamaño']); ?></td>
                    <td><?php echo htmlspecialchars($venta['cantidad']); ?></td>
                    <td><?php echo htmlspecialchars($venta['ganancia']); ?></td>
                    <td><?php echo htmlspecialchars($venta['nombres_perfumes']); ?></td>
                    <td><?php echo htmlspecialchars($venta['mensajero']); ?></td>
                    <td><?php echo htmlspecialchars($venta['precio_envio']); ?></td>
                    <td><?php echo htmlspecialchars($venta['direccion_envio']); ?></td>
                    <td>
                        <form method="POST" action="ver_ventas.php" style="display:inline;">
                            <input type="hidden" name="venta_id" value="<?php echo htmlspecialchars($venta['id']); ?>">
                            <input type="hidden" name="hecho" value="<?php echo $venta['hecho'] == 1 ? 'false' : 'true'; ?>">
                            <button type="submit" class="<?php echo $venta['hecho'] == 1 ? 'no-realizado' : 'realizado'; ?>">
                                <?php echo $venta['hecho'] == 1 ? 'No Hecho' : 'Hecho'; ?>
                            </button>
                        </form>
                    </td>
                    <td class="acciones">
                        <a href="editar_venta.php?id=<?php echo htmlspecialchars($venta['id']); ?>" class="editar">Editar</a>
                        <a href="eliminar_venta.php?id=<?php echo htmlspecialchars($venta['id']); ?>" class="eliminar" onclick="return confirm('¿Estás seguro de que deseas eliminar esta venta?');">Eliminar</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="pagination">
        <?php if ($page > 1) { ?>
            <a href="ver_ventas.php?page=<?php echo $page - 1; ?>&<?php echo $buscarPor ? "$buscarPor=" . urlencode($_GET[$buscarPor]) : ''; ?>">« Anterior</a>
        <?php } ?>
        <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
            <a href="ver_ventas.php?page=<?php echo $i; ?>&<?php echo $buscarPor ? "$buscarPor=" . urlencode($_GET[$buscarPor]) : ''; ?>" class="<?php echo $i == $page ? 'active' : ''; ?>"><?php echo $i; ?></a>
        <?php } ?>
        <?php if ($page < $totalPages) { ?>
            <a href="ver_ventas.php?page=<?php echo $page + 1; ?>&<?php echo $buscarPor ? "$buscarPor=" . urlencode($_GET[$buscarPor]) : ''; ?>">Siguiente »</a>
        <?php } ?>
    </div>
</body>
</html>
