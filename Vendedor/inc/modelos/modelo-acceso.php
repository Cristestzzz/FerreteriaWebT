<?php
require "../funciones/conexionbd.php";

// Manejo del cierre de sesión
if ($_POST['tipoAccion'] === "loginOut") {
    session_start();

    // Restablecer todas las variables de sesión a sus valores predeterminados
    $_SESSION = array();

    // Destruir la sesión actual
    session_destroy();

    $respuesta = array(
        "respuesta" => "exito"
    );
    echo json_encode($respuesta);
}

// Manejo del inicio de sesión
else if ($_POST["tipoAccion"] === "login") {
    $nombre_usuario = $_POST["nombre_usuario"];
    $pass_usuario = $_POST["pass_usuario"];
    
    try {
        // Consulta para verificar que el usuario es un vendedor
        $sql = "SELECT id_usuario, nombre_usuario, pass_usuario, total_usuario FROM usuarios WHERE nombre_usuario = ? AND tipo_usuario = 'vendedor'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $nombre_usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 0) { // El usuario no existe o no es vendedor
            $respuesta = array(
                "respuesta" => "error",
                "accion" => "login"
            );
            die(json_encode($respuesta));
        }
        $usuario = $resultado->fetch_assoc();

        $pass_hashed = $usuario["pass_usuario"];

        if (password_verify($pass_usuario, $pass_hashed)) {
            $respuesta = array(
                "respuesta" => "exito",
                "accion" => "login",
                "id" => $usuario["id_usuario"]
            );
            /* Iniciamos sesión */
            session_start();
            $_SESSION["id_usuario"] = $usuario["id_usuario"];
            $_SESSION["nombre_usuario"] = $usuario["nombre_usuario"];
            $_SESSION["total_actual_usuario"] = $usuario["total_usuario"];
        } else {
            $respuesta = array(
                "respuesta" => "error",
                "accion" => "login"
            );
        }

        $conn->close();
        
    } catch (Exception $e) {
        $respuesta = array(
            "respuesta" => $e->getMessage()
        );
    }
    echo json_encode($respuesta);
}
?>