<?php
require_once 'funciones.php';




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verificar si el nombre de usuario ya existe
    $db = obtenerBD();
    $stmt = $db->prepare("SELECT COUNT(*) AS count FROM usuarios WHERE username = ?");
    $stmt->execute([$username]);
    $count = $stmt->fetch()->count;

    if ($count > 0) {
        $mensaje = "El nombre de usuario ya está en uso.";
    } else {
        // Insertar el nuevo usuario en la base de datos
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $db->prepare("INSERT INTO usuarios (username, password) VALUES (?, ?)");
        $resultado = $stmt->execute([$username, $hashedPassword]);

        if ($resultado) {
            $mensaje = "Usuario creado exitosamente.";
        } else {
            $mensaje = "Error al crear el usuario.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Usuario</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include_once 'encabezado.php'; ?>

    <div class="container">
        <div class="form-container"><br><br><br><br>
            <h1>Crear Nuevo Usuario</h1>
            <?php if (isset($mensaje)): ?>
                <p class="message"><?php echo htmlspecialchars($mensaje); ?></p>
            <?php endif; ?>
            <form action="crear_usuario.php" method="post">
                <div class="form-group">
                    <label for="username">Nombre de usuario:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary">Crear Usuario</button>
            </form>
        </div>
    </div>

    <?php include_once 'pie.php'; ?>
</body>
</html>
