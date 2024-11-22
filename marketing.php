<?php
include_once "encabezado.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Marketing</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div class="row">
        <div class="col-12">
            <h1>Marketing</h1>
            <a href="listar_marketing.php" class="boton-verde">Ver Lista</a>
            <form action="guardar_marketing.php" method="post">
                <div class="form-group">
                    <label for="plataforma">Marketing Digital</label>
                    <select class="form-control" name="plataforma" id="plataforma" required>
                        <option value="meta">Meta</option>
                        <option value="google">Google</option>
                        <option value="tiktok">TikTok</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="importe_gastado">Importe Gastado</label>
                    <input type="number" step="0.01" class="form-control" name="importe_gastado" id="importe_gastado" required>
                </div>
                
                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <textarea class="form-control" name="descripcion" id="descripcion" maxlength="300" required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="horario">Horario</label>
                    <input type="time" class="form-control" name="horario" id="horario" required>
                </div>
                
                <div class="form-group">
                    <label for="fecha">Fecha</label>
                    <input type="date" class="form-control" name="fecha" id="fecha" value="<?php echo date('Y-m-d'); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="mensajes_recibidos">Cantidad de Mensajes Recibidos</label>
                    <input type="number" class="form-control" name="mensajes_recibidos" id="mensajes_recibidos" required>
                </div>
                
                <div class="form-group">
                    <label for="hora_pico">Hora Pico</label>
                    <input type="time" class="form-control" name="hora_pico" id="hora_pico" required>
                </div>
                
                <div class="form-group">
                    <label for="hora_baja">Hora Baja</label>
                    <input type="time" class="form-control" name="hora_baja" id="hora_baja" required>
                </div>
                
                <div class="form-group">
                    <button class="solo">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <?php include_once "pie.php"; ?>
</body>
</html>
