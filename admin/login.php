<?php
session_start();

// Verificar si el usuario ya está logueado
if (isset($_SESSION['LoggedIn'])) {
    header('Location: index.php'); // Redirigir al dashboard si ya está logueado
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Aquí deberías verificar las credenciales con la base de datos
    // Ejemplo de credenciales (esto debería ser reemplazado con una consulta a la base de datos)
    if ($username === 'admin' && $password === '1234') { // Cambia esto por tu lógica de autenticación
        $_SESSION['LoggedIn'] = true;
        header('Location: index.php'); // Redirigir al dashboard
        exit();
    } else {
        $error_message = "Usuario o contraseña incorrectos.";
    }
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
