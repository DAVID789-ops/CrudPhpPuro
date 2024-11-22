<?php include_once "encabezado.php"; ?>
<?php
include_once "funciones.php";

function obtenerGastos($offset, $limit) {
    $bd = obtenerBD();
    $sentencia = $bd->prepare("SELECT * FROM gastos ORDER BY fecha DESC LIMIT ? OFFSET ?");
    $sentencia->bindParam(1, $limit, PDO::PARAM_INT);
    $sentencia->bindParam(2, $offset, PDO::PARAM_INT);
    $sentencia->execute();
    return $sentencia->fetchAll(PDO::FETCH_ASSOC);
}

function contarGastos() {
    $bd = obtenerBD();
    $sentencia = $bd->query("SELECT COUNT(*) as total FROM gastos");
    return $sentencia->fetch(PDO::FETCH_ASSOC)['total'];
}

function eliminarGasto($gastoId) {
    $bd = obtenerBD();
    $sentencia = $bd->prepare("DELETE FROM gastos WHERE id = ?");
    return $sentencia->execute([$gastoId]);
}

$limit = 20;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['eliminar'])) {
    $gastoId = $_POST['gasto_id'];
    eliminarGasto($gastoId);
    // Redirigir para evitar reenvío del formulario
    header("Location: ver_gastos.php?page=$page");
    exit();
}

$gastos = obtenerGastos($offset, $limit);
$totalGastos = contarGastos();
$totalPages = ceil($totalGastos / $limit);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ver Gastos</title>
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
        .acciones button:hover {
            background-color: #e0e0e0;
        }
        .acciones button.eliminar {
            background-color: red;
            color: white;
        }
    </style>
</head>
<body>
    <h1>Listado de Gastos</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre del Gasto</th>
                <th>Descripción</th>
                <th>Total</th>
                <th>Acciones</th> <!-- Nueva columna para acciones -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($gastos as $gasto) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($gasto['id']); ?></td>
                    <td><?php echo htmlspecialchars($gasto['nombre_gasto']); ?></td>
                    <td><?php echo htmlspecialchars($gasto['descripcion']); ?></td>
                    <td><?php echo htmlspecialchars($gasto['total']); ?></td>
                    <td class="acciones">
                        <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] . '?page=' . $page; ?>">
                            <input type="hidden" name="gasto_id" value="<?php echo $gasto['id']; ?>">
                            <button type="submit" class="eliminar" name="eliminar">Eliminar</button>
                        </form>
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
