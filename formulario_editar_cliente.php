<?php
include_once "encabezado.php";
include_once "funciones.php";

// Obtener datos del cliente por su ID
$cliente = obtenerClientePorId($_GET["id"]);
$departamentos = obtenerDepartamentos();

// Verificar si se ha enviado el formulario de actualización
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar que todos los campos requeridos estén presentes
    if (isset($_POST["id"], $_POST["nombre"], $_POST["edad"], $_POST["departamento"], $_POST["direccion"], $_POST["sexo"], $_POST["telefono"])) {
        // Obtener los datos del formulario
        $id = $_POST["id"];
        $nombre = $_POST["nombre"];
        $edad = $_POST["edad"];
        $departamento = $_POST["departamento"];
        $direccion = $_POST["direccion"];
        $sexo = $_POST["sexo"];
        $telefono = $_POST["telefono"];

        // Llamar a la función para actualizar el cliente
        $ok = actualizarCliente($nombre, $edad, $departamento, $direccion, $sexo, $telefono, $id);

        // Verificar si la actualización fue exitosa
        if ($ok) {
            header("Location: clientes.php"); // Redirigir a la página de clientes después de actualizar
            exit();
        } else {
            echo "Error al actualizar el cliente.";
        }
    } else {
        echo "Todos los campos son requeridos.";
    }
}
?>

<div class="row">
    <div class="col-12">
        <h1>Editar cliente</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=" . $cliente->id); ?>" method="post">
            <input type="hidden" name="id" value="<?php echo $cliente->id; ?>">
            
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input value="<?php echo $cliente->nombre; ?>" required type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre">
            </div>
            
            <div class="form-group">
                <label for="edad">Edad</label>
                <input value="<?php echo $cliente->edad; ?>" required type="number" class="form-control" name="edad" id="edad" placeholder="Edad">
            </div>
            
            <div class="form-group">
                <label for="direccion">Dirección</label>
                <input value="<?php echo $cliente->direccion; ?>" required type="text" class="form-control" name="direccion" id="direccion" placeholder="Dirección">
            </div>
            
            <div class="form-group">
                <label for="sexo">Sexo</label>
                <select class="form-control" name="sexo" id="sexo" required>
                    <option value="Femenino" <?php if ($cliente->sexo === 'Femenino') echo 'selected'; ?>>Femenino</option>
                    <option value="Masculino" <?php if ($cliente->sexo === 'Masculino') echo 'selected'; ?>>Masculino</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input value="<?php echo $cliente->telefono; ?>" required type="text" class="form-control" name="telefono" id="telefono" pattern="[0-9]{8}" title="Debe tener 8 dígitos">
            </div>
            
            <div class="form-group">
                <label for="departamento">Departamento</label>
                <select class="form-control" name="departamento" id="departamento">
                    <?php foreach ($departamentos as $depto) : ?>
                        <option value="<?php echo $depto; ?>" <?php if ($cliente->departamento === $depto) echo 'selected'; ?>><?php echo $depto; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <button class="btn btn-success">Guardar</button>
            </div>
        </form>
    </div>
</div>

<?php include_once "pie.php"; ?>