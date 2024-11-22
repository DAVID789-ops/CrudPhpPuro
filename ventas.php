<?php include_once "encabezado.php";
include_once "funciones.php";
$clientes = obtenerClientes();
?>

<div class="row">
    <div class="col-12">
    <br><br><br><br>
        <h1>Registrar venta</h1>
        <a href="ver_ventas.php" class="btn btn-primary">Ver Ventas</a>
        <form action="guardar_venta.php" method="post">
            <div class="form-group">
                <label for="id_cliente">Cliente</label>
                <select required name="id_cliente" id="id_cliente" class="form-control">
                    <?php foreach ($clientes as $cliente) { ?>
                        <option value="<?php echo $cliente->id ?>"><?php echo $cliente->nombre ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="monto">Monto</label>
                <input required type="number" class="form-control" placeholder="Monto" name="monto" id="monto">
            </div>
            <div class="form-group">
                <label for="fecha">Fecha</label>
                <input required type="date" value="<?php echo date("Y-m-d") ?>" class="form-control" placeholder="Fecha" name="fecha" id="fecha">
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <input type="text" id="descripcion" name="descripcion" class="form-control">
            </div>
        
            <div class="form-group">
                <label for="tamaño">Tamaño:</label>
                <input type="number" id="tamaño" name="tamaño" class="form-control">
            </div>
        
            <div class="form-group">
                <label for="cantidad">Cantidad:</label>
                <input type="number" id="cantidad" name="cantidad" class="form-control">
            </div>
        
            <div class="form-group">
                <label for="ganancia">Ganancia:</label>
                <input type="number" step="0.01" id="ganancia" name="ganancia" class="form-control">
            </div>
        
            <div class="form-group">
                <label for="nombres_perfumes">Nombres de Perfumes:</label>
                <input type="text" id="nombres_perfumes" name="nombres_perfumes" class="form-control">
            </div>
        
            <div class="form-group">
                <label for="mensajero">Mensajero:</label>
                <input type="text" id="mensajero" name="mensajero" class="form-control">
            </div>
        
            <div class="form-group">
                <label for="precio_envio">Precio Envío:</label>
                <input type="number" step="0.01" id="precio_envio" name="precio_envio" class="form-control">
            </div>
        
            <div class="form-group">
                <label for="direccion_envio">Dirección Envío:</label>
                <input type="text" id="direccion_envio" name="direccion_envio" class="form-control">
            </div>
            
            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="text" id="telefono" name="telefono" class="form-control">
            </div>

            <div class="form-group">
                <button class="btn btn-success">Guardar</button>
            </div>
        </form>
    </div>
</div>
<?php include_once "pie.php"; ?>
