<?php
include_once "encabezado.php";
include_once "funciones.php";

$limit = 20;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$marketing = obtenerMarketing($offset, $limit);
$totalMarketing = contarMarketing();
$totalPages = ceil($totalMarketing / $limit);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Listado de Marketing</title>
    <link rel="stylesheet" href="styles.css"> <!-- Incluir tu archivo CSS aquí -->
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
    <h1>Listado de Marketing</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Plataforma</th>
                <th>Importe Gastado</th>
                <th>Descripción</th>
                <th>Horario</th>
                <th>Fecha</th>
                <th>Mensajes Recibidos</th>
                <th>Hora Pico</th>
                <th>Hora Baja</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($marketing as $entry) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($entry['id']); ?></td>
                    <td><?php echo htmlspecialchars($entry['plataforma']); ?></td>
                    <td><?php echo htmlspecialchars($entry['importe_gastado']); ?></td>
                    <td><?php echo htmlspecialchars($entry['descripcion']); ?></td>
                    <td><?php echo htmlspecialchars($entry['horario']); ?></td>
                    <td><?php echo htmlspecialchars($entry['fecha']); ?></td>
                    <td><?php echo htmlspecialchars($entry['mensajes_recibidos']); ?></td>
                    <td><?php echo htmlspecialchars($entry['hora_pico']); ?></td>
                    <td><?php echo htmlspecialchars($entry['hora_baja']); ?></td>
                    <td class="acciones">
                        <a href="eliminar_marketing.php?id=<?php echo $entry['id']; ?>">Eliminar</a>
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
