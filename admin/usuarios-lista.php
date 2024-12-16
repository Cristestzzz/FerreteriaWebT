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
        <h2>Lista de Usuarios</h2>

        <!-- Tabla de Usuarios -->
        <h3>Usuarios</h3>
        <div class="contenedor-lista" id="contenedor-lista">
            <table>
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Correo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    try {
                        require "inc/funciones/conexionbd.php";
                        $sql = "SELECT * FROM usuarios WHERE tipo_usuario = 'usuario'";
                        $respuesta = $conn->query($sql);

                        while ($usuario = $respuesta->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?php echo $usuario["nombre_usuario"] ?></td>
                                <td><?php echo $usuario["correo_usuario"] ?></td>
                                <td>
                                    <a class="btn-editar" href="usuarios-editar.php?id=<?php echo $usuario["id_usuario"] ?>"><i class="fa-solid fa-pen"></i></a>
                                </td>
                            </tr>
                            <?php
                        }
                    } catch (Exception $e) {
                        echo "Error: " . $e->getMessage();
                    }
                ?>
                </tbody>
            </table>
        </div>

        <!-- Tabla de Vendedores -->
        <h3>Vendedores</h3>
        <div class="contenedor-lista" id="contenedor-lista">
            <table>
                <thead>
                    <tr>
                        <th>Vendedor</th>
                        <th>Correo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    try {
                        require "inc/funciones/conexionbd.php";
                        $sql = "SELECT * FROM usuarios WHERE tipo_usuario = 'vendedor'";
                        $respuesta = $conn->query($sql);

                        while ($vendedor = $respuesta->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?php echo $vendedor["nombre_usuario"] ?></td>
                                <td><?php echo $vendedor["correo_usuario"] ?></td>
                                <td>
                                    <a class="btn-editar" href="usuarios-editar.php?id=<?php echo $vendedor["id_usuario"] ?>"><i class="fa-solid fa-pen"></i></a>
                                </td>
                            </tr>
                            <?php
                        }
                    } catch (Exception $e) {
                        echo "Error: " . $e->getMessage();
                    }
                ?>
                </tbody>
            </table>
        </div>

        <!-- Tabla de Administradores -->
        <h3>Administradores</h3>
        <div class="contenedor-lista" id="contenedor-lista">
            <table>
                <thead>
                    <tr>
                        <th>Administrador</th>
                        <th>Correo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    try {
                        require "inc/funciones/conexionbd.php";
                        $sql = "SELECT * FROM usuarios WHERE tipo_usuario = 'administrador'";
                        $respuesta = $conn->query($sql);

                        while ($administrador = $respuesta->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?php echo $administrador["nombre_usuario"] ?></td>
                                <td><?php echo $administrador["correo_usuario"] ?></td>
                                <td>
                                    <a class="btn-editar" href="usuarios-editar.php?id=<?php echo $administrador["id_usuario"] ?>"><i class="fa-solid fa-pen"></i></a>
                                </td>
                            </tr>
                            <?php
                        }
                    } catch (Exception $e) {
                        echo "Error: " . $e->getMessage();
                    }
                ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<?php
require "inc/templates/footer.php";
?>