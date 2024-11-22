<?php


date_default_timezone_set("America/Mexico_City");

function obtenerDepartamentos()
{
    return [
        "Guatemala",
        "Baja Verapaz",
        "Alta Verapaz",
        "El Progreso",
        "Izabal",
        "Zacapa",
        "Chiquimula",
        "Santa Rosa",
        "Jalapa",
        "Jutiapa",
        "Sacatepéquez",
        "Chimaltenango",
        "Escuintla",
        "Sololá",
        "Totonicapán",
        "Quetzaltenango",
        "Suchitepéquez",
        "Retalhuleu",
        "San Marcos",
        "Huehuetenango",
        "Quiché",
        "Petén",
    ];
}

function obtenerBD()
{
    $password = "tF)4l&[;_cV2";
    $user = "kjycupmy_david";
    $dbName = "kjycupmy_crm2";
    $database = new PDO('mysql:host=50.87.172.242;dbname=' . $dbName, $user, $password);
    $database->query("set names utf8;");
    $database->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
    $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $database->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    return $database;
}

function agregarCliente($nombre, $edad, $departamento, $direccion, $sexo, $telefono)
{
    $bd = obtenerBD();
    $fechaRegistro = date("Y-m-d");
    $sentencia = $bd->prepare("INSERT INTO clientes(nombre, edad, departamento, fecha_registro, direccion, sexo, telefono) VALUES (?, ?, ?, ?, ?, ?, ?)");
    return $sentencia->execute([$nombre, $edad, $departamento, $fechaRegistro, $direccion, $sexo, $telefono]);
}

function obtenerClientes()
{
    $bd = obtenerBD();
    $sentencia = $bd->query("SELECT id, nombre, edad, departamento, fecha_registro, direccion, sexo, telefono FROM clientes");
    return $sentencia->fetchAll();
}

function buscarClientes($nombre)
{
    $bd = obtenerBD();
    $sentencia = $bd->prepare("SELECT id, nombre, edad, departamento, fecha_registro, direccion, sexo, telefono FROM clientes WHERE nombre LIKE ?");
    $sentencia->execute(["%$nombre%"]);
    return $sentencia->fetchAll();
}


function eliminarCliente($id)
{
    $bd = obtenerBD();
    $sentencia = $bd->prepare("DELETE FROM clientes WHERE id = ?");
    return $sentencia->execute([$id]);
}

function obtenerClientePorId($id)
{
    $bd = obtenerBD();
    $sentencia = $bd->prepare("SELECT id, nombre, edad, departamento, fecha_registro, direccion, sexo, telefono FROM clientes WHERE id = ?");
    $sentencia->execute([$id]);
    return $sentencia->fetchObject();
}

function actualizarCliente($nombre, $edad, $departamento, $direccion, $sexo, $telefono, $id)
{
    $bd = obtenerBD();
    $sentencia = $bd->prepare("UPDATE clientes SET nombre = ?, edad = ?, departamento = ?, direccion = ?, sexo = ?, telefono = ? WHERE id = ?");
    return $sentencia->execute([$nombre, $edad, $departamento, $direccion, $sexo, $telefono, $id]);
}

function guardarVenta($idCliente, $monto, $fecha, $descripcion, $tamaño, $cantidad, $ganancia, $nombresPerfumes, $mensajero, $precioEnvio, $direccionEnvio, $telefono) {
    $bd = obtenerBD();
    $sentencia = $bd->prepare("INSERT INTO ventas_clientes (id_cliente, monto, fecha, descripcion, tamaño, cantidad, ganancia, nombres_perfumes, mensajero, precio_envio, direccion_envio, telefono) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    return $sentencia->execute([$idCliente, $monto, $fecha, $descripcion, $tamaño, $cantidad, $ganancia, $nombresPerfumes, $mensajero, $precioEnvio, $direccionEnvio, $telefono]);
}

function totalAcumuladoVentasPorCliente($idCliente)
{
    $bd = obtenerBD();
    $sentencia = $bd->prepare("SELECT COALESCE(SUM(monto), 0) AS total FROM ventas_clientes WHERE id_cliente = ?");
    $sentencia->execute([$idCliente]);
    return $sentencia->fetchObject()->total;
}

function totalAcumuladoVentasPorClienteEnUltimoMes($idCliente)
{
    $inicio = date("Y-m-01");
    $bd = obtenerBD();
    $sentencia = $bd->prepare("SELECT COALESCE(SUM(monto), 0) AS total FROM ventas_clientes WHERE id_cliente = ? AND fecha >= ?");
    $sentencia->execute([$idCliente, $inicio]);
    return $sentencia->fetchObject()->total;
}
function totalAcumuladoVentasPorClienteEnUltimoAnio($idCliente)
{
    $inicio = date("Y-01-01");
    $bd = obtenerBD();
    $sentencia = $bd->prepare("SELECT COALESCE(SUM(monto), 0) AS total FROM ventas_clientes WHERE id_cliente = ? AND fecha >= ?");
    $sentencia->execute([$idCliente, $inicio]);
    return $sentencia->fetchObject()->total;
}
function totalAcumuladoVentasPorClienteAntesDeUltimoAnio($idCliente)
{
    $inicio = date("Y-01-01");
    $bd = obtenerBD();
    $sentencia = $bd->prepare("SELECT COALESCE(SUM(monto), 0) AS total FROM ventas_clientes WHERE id_cliente = ? AND fecha < ?");
    $sentencia->execute([$idCliente, $inicio]);
    return $sentencia->fetchObject()->total;
}

function obtenerNumeroTotalClientes()
{
    $bd = obtenerBD();
    $sentencia = $bd->query("SELECT COUNT(*) AS conteo FROM clientes");
    return $sentencia->fetchObject()->conteo;
}
function obtenerNumeroTotalClientesUltimos30Dias()
{
    $hace30Dias = date("Y-m-d", strtotime("-30 day"));
    $bd = obtenerBD();
    $sentencia = $bd->prepare("SELECT COUNT(*) AS conteo FROM clientes WHERE fecha_registro >= ?");
    $sentencia->execute([$hace30Dias]);
    return $sentencia->fetchObject()->conteo;
}

function obtenerNumeroTotalClientesUltimoAnio()
{
    $inicio = date("Y-01-01");
    $bd = obtenerBD();
    $sentencia = $bd->prepare("SELECT COUNT(*) AS conteo FROM clientes WHERE fecha_registro >= ?");
    $sentencia->execute([$inicio]);
    return $sentencia->fetchObject()->conteo;
}

function obtenerNumeroTotalClientesAniosAnteriores()
{
    $inicio = date("Y-01-01");
    $bd = obtenerBD();
    $sentencia = $bd->prepare("SELECT COUNT(*) AS conteo FROM clientes WHERE fecha_registro < ?");
    $sentencia->execute([$inicio]);
    return $sentencia->fetchObject()->conteo;
}

function obtenerTotalDeVentas()
{
    $bd = obtenerBD();
    $sentencia = $bd->query("SELECT COALESCE(SUM(monto), 0) AS total FROM ventas_clientes");
    return $sentencia->fetchObject()->total;
}

function obtenerClientesPorDepartamento()
{
    $bd = obtenerBD();
    $sentencia = $bd->query("SELECT departamento, COUNT(*) AS conteo FROM clientes GROUP BY departamento");
    return $sentencia->fetchAll();
}

function obtenerConteoClientesPorRangoDeEdad($inicio, $fin)
{
    $bd = obtenerBD();
    $sentencia = $bd->prepare("select count(*) AS conteo from clientes WHERE edad >= ? AND edad <= ?;");
    $sentencia->execute([$inicio, $fin]);
    return $sentencia->fetchObject()->conteo;
}

function obtenerVentasAnioActualOrganizadasPorMes()
{
    $bd = obtenerBD();
    $anio = date("Y");
    $sentencia = $bd->prepare("select MONTH(fecha) AS mes, COUNT(*) AS total from ventas_clientes WHERE YEAR(fecha) = ? GROUP BY MONTH(fecha);");
    $sentencia->execute([$anio]);
    return $sentencia->fetchAll();
}

function obtenerReporteClientesEdades()
{
    $rangos = [
        [1, 10],
        [11, 20],
        [20, 40],
        [40, 80],
    ];
    $resultados = [];
    foreach ($rangos as $rango) {
        $inicio = $rango[0];
        $fin = $rango[1];
        $conteo = obtenerConteoClientesPorRangoDeEdad($inicio, $fin);
        $dato = new stdClass;
        $dato->etiqueta = $inicio . " - " . $fin;
        $dato->valor = $conteo;
        array_push($resultados, $dato);
    }
    return $resultados;
}

// Función para obtener los detalles de una venta por su ID
function obtenerVentaPorId($id) {
    $bd = obtenerBD();
    $sentencia = $bd->prepare("SELECT * FROM ventas_clientes WHERE id = ?");
    $sentencia->execute([$id]);
    return $sentencia->fetch(PDO::FETCH_ASSOC);
}

// Función para eliminar una venta por su ID
function eliminarVenta($id) {
    $bd = obtenerBD();
    $sentencia = $bd->prepare("DELETE FROM ventas_clientes WHERE id = ?");
    return $sentencia->execute([$id]);
}





function obtenerMarketing($offset, $limit) {
    $bd = obtenerBD();
    $sentencia = $bd->prepare("SELECT * FROM marketing ORDER BY fecha DESC LIMIT ? OFFSET ?");
    $sentencia->bindParam(1, $limit, PDO::PARAM_INT);
    $sentencia->bindParam(2, $offset, PDO::PARAM_INT);
    $sentencia->execute();
    return $sentencia->fetchAll(PDO::FETCH_ASSOC);
}

function contarMarketing() {
    $bd = obtenerBD();
    $sentencia = $bd->query("SELECT COUNT(*) as total FROM marketing");
    return $sentencia->fetch(PDO::FETCH_ASSOC)['total'];
}
// funciones.php
function obtenerGestionCalidad($offset, $limit) {
    $bd = obtenerBD(); // Obtener la conexión a la base de datos

    // Preparar la consulta SQL
    $sql = "SELECT * FROM gestion_calidad LIMIT :limit OFFSET :offset";
    $stmt = $bd->prepare($sql);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    // Obtener los resultados
    $gestion_calidad = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    return $gestion_calidad;
}
function contarGestionCalidad() {
    $bd = obtenerBD();
    $sentencia = $bd->query("SELECT COUNT(*) as total FROM gestion_calidad");
    return $sentencia->fetch(PDO::FETCH_ASSOC)['total'];
}
function eliminarGestionCalidad($id) {
    $bd = obtenerBD();
    $sentencia = $bd->prepare("DELETE FROM gestion_calidad WHERE id = ?");
    return $sentencia->execute([$id]);
}
// login
function obtenerUsuarioPorUsername($username) {
    $db = obtenerBD();
    $stmt = $db->prepare("SELECT * FROM usuarios WHERE username = ?");
    $stmt->execute([$username]);
    return $stmt->fetch();
}

// buscador



function obtenerVentas($offset, $limit) {
    $bd = obtenerBD();
    $sentencia = $bd->prepare("SELECT v.id, c.nombre AS nombre_cliente, c.telefono, v.monto, v.fecha, v.descripcion, v.tamaño, v.cantidad, v.ganancia, v.nombres_perfumes, v.mensajero, v.precio_envio, v.direccion_envio, v.numero_guia, v.entregado, v.pagado, v.hecho
                              FROM ventas_clientes v
                              JOIN clientes c ON v.id_cliente = c.id
                              ORDER BY v.id DESC LIMIT ? OFFSET ?");
    $sentencia->bindParam(1, $limit, PDO::PARAM_INT);
    $sentencia->bindParam(2, $offset, PDO::PARAM_INT);
    $sentencia->execute();
    return $sentencia->fetchAll(PDO::FETCH_ASSOC);
}



function contarVentas() {
    $bd = obtenerBD();
    $sentencia = $bd->prepare("SELECT COUNT(*) as total FROM ventas_clientes");
    $sentencia->execute();
    return $sentencia->fetch(PDO::FETCH_ASSOC)['total'];
}

function actualizarHecho($id, $hecho) {
    $bd = obtenerBD();
    $sentencia = $bd->prepare("UPDATE ventas_clientes SET hecho = ? WHERE id = ?");
    $sentencia->bindParam(1, $hecho, PDO::PARAM_INT);
    $sentencia->bindParam(2, $id, PDO::PARAM_INT);
    $sentencia->execute();
}


?>
