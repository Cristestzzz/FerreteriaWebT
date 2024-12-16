<?php
session_start(); // Iniciar la sesión

// Verificar si el usuario está logueado
if (!isset($_SESSION['LoggedIn'])) {
    header('Location: login.php'); // Redirigir al formulario de inicio de sesión
    exit();
}
require "inc/funciones/sesiones.php";
require "inc/templates/header.php";
?>
<div class="container">
    <div class="contenedor-option">
        <h2>Editar usuario o vendedor</h2>
        <div class="contenedor-editar" id="contenedor-editar">
            <?php
            $id_registro = $_GET["id"];

            try {
                require "inc/funciones/conexionbd.php";
                $sql = "SELECT nombre_usuario, correo_usuario, tipo_usuario FROM usuarios WHERE id_usuario = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $id_registro);
                $stmt->execute();
                $respuesta = $stmt->get_result();

                $usuario = $respuesta->fetch_assoc();
                $conn->close();

            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
            ?>
            <form id="formulario-admin">

                <label for="input-nombre">Usuario: </label>
                <input type="text" name="nombre_usuario" id="input-nombre" class="form-field" placeholder="Nombre de usuario" value="<?php echo $usuario["nombre_usuario"] ?>" required>

                <label for="input-correo">Correo: </label>
                <input type="email" name="correo_usuario" id="input-correo" class="form-field" placeholder="Correo del usuario" value="<?php echo $usuario["correo_usuario"] ?>" required>

                <label for="input-password">Contraseña: </label>
                <input type="password" name="pass_usuario" id="input-password" class="form-field" placeholder="Contraseña (dejar en blanco si no se desea cambiar)">

                <label for="select-tipo">Tipo de usuario: </label>
                <select name="tipo_usuario" id="select-tipo" class="form-field" required>
                    <option value="usuario" <?php echo ($usuario["tipo_usuario"] === 'usuario') ? 'selected' : ''; ?>>Usuario</option>
                    <option value="vendedor" <?php echo ($usuario["tipo_usuario"] === 'vendedor') ? 'selected' : ''; ?>>Vendedor</option>
                    <option value="administrador" <?php echo ($usuario["tipo_usuario"] === 'administrador') ? 'selected' : ''; ?>>Administrador</option> <!-- Nueva opción añadida -->
                </select>

                <input type="hidden" name="tipoAccion" value="editar">
                <input type="hidden" name="tipoOpcion" value="usuarios">
                <input type="hidden" name="id_registro" value="<?php echo $id_registro; ?>">

                <div class="container-input-submit">
                    <input type="submit" value="Actualizar">
                </div>
            </form>
        </div>
    </div>
</div>

<?php
require "inc/templates/footer.php";
?>