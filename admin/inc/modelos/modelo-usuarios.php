<?php
require "../funciones/conexionbd.php";

if ($_POST['tipoAccion'] === "añadir") {
    $nombre = $_POST['nombre_usuario'];
    $correo = $_POST['correo_usuario'];
    $pass = $_POST['pass_usuario'];
    $tipo_usuario = $_POST['tipo_usuario']; // Captura el tipo de usuario

    // Validar si el correo ya está registrado
    $sql = "SELECT * FROM usuarios WHERE correo_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $respuesta = array(
            "respuesta" => "El correo ya está registrado."
        );
        echo json_encode($respuesta);
        exit;
    }

    $opciones = array(
        "cost" => 12
    );

    $pass_hashed = password_hash($pass, PASSWORD_BCRYPT, $opciones);

    try {
        $stmt = $conn->prepare("INSERT INTO usuarios (nombre_usuario, correo_usuario, pass_usuario, tipo_usuario) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nombre, $correo, $pass_hashed, $tipo_usuario); // Asegúrate de incluir el tipo de usuario

        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $respuesta = array(
                "respuesta" => "exito",
                "accion" => "crear"
            );
        } else {
            $respuesta = array(
                "respuesta" => "error"
            );
        }
        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        $respuesta = array(
            "respuesta" => $e->getMessage()
        );
    }

    echo json_encode($respuesta);
}

else if ($_POST['tipoAccion'] === "editar") {
    $nombre = $_POST['nombre_usuario'];
    $correo = $_POST['correo_usuario'];
    $pass = $_POST['pass_usuario'];
    $tipo_usuario = $_POST['tipo_usuario']; // Captura el tipo de usuario
    $id_registro = $_POST['id_registro'];

    try {
        // Si la contraseña está vacía, no la actualizamos
        if (trim($pass) === "") {
            $stmt = $conn->prepare("UPDATE usuarios SET nombre_usuario = ?, correo_usuario = ?, tipo_usuario = ? WHERE id_usuario = ?");
            $stmt->bind_param("sssi", $nombre, $correo, $tipo_usuario, $id_registro); // Asegúrate de incluir el tipo de usuario
        } else {
            // Si hay una nueva contraseña, la actualizamos
            $opciones = array(
                "cost" => 12
            );
            $pass_hashed = password_hash($pass, PASSWORD_BCRYPT, $opciones);
            $stmt = $conn->prepare("UPDATE usuarios SET nombre_usuario = ?, correo_usuario = ?, pass_usuario = ?, tipo_usuario = ? WHERE id_usuario = ?");
            $stmt->bind_param("ssssi", $nombre, $correo, $pass_hashed, $tipo_usuario, $id_registro); // Asegúrate de incluir el tipo de usuario
        }

        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $respuesta = array(
                "respuesta" => "exito",
                "accion" => "editar"
            );
        } else {
            $respuesta = array(
                "respuesta" => "error"
            );
        }
        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        $respuesta = array(
            "respuesta" => $e->getMessage()
        );
    }

    echo json_encode($respuesta);
}
?>