<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Conectar a la base de datos
    require "inc/funciones/conexionbd.php"; // Asegúrate de que la ruta sea correcta

    // Consulta para verificar las credenciales y el tipo de usuario
    $sql = "SELECT id_usuario, pass_usuario FROM usuarios WHERE nombre_usuario = ? AND tipo_usuario = 'vendedor'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();
        $pass_hashed = $usuario['pass_usuario'];

        // Verificar la contraseña
        if (password_verify($password, $pass_hashed)) {
            $_SESSION['LoggedIn'] = true;
            $_SESSION['id_usuario'] = $usuario['id_usuario']; // Guardar el ID del usuario en la sesión
            $_SESSION['tipo_usuario'] = $usuario['tipo_usuario']; // Almacenar el tipo de usuario en la sesión
            header('Location: index.php'); // Redirigir al dashboard
            exit();
        } else {
            $error_message = "Usuario o contraseña incorrectos.";
        }
    } else {
        $error_message = "Usuario o contraseña incorrectos.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="css/login.css"> <!-- Asegúrate de que la ruta sea correcta -->
</head>
<body>
    <div class="wrapper">
        <div class="form-wrapper sign-in">
            <form method="POST" action="login.php">
                <h2>Iniciar Sesión</h2>
                <div class="input-group">
                    <input type="text" id="username" name="username" required>
                    <label for="username">Usuario</label>
                </div>
                <div class="input-group">
                    <input type="password" id="password" name="password" required>
                    <label for="password">Contraseña</label>
                </div>
                <button type="submit">Iniciar Sesión</button>
                <?php if (isset($error_message)) echo "<p style='color: red;'>$error_message</p>"; ?>
            </form>
        </div>
    </div>
</body>
</html>