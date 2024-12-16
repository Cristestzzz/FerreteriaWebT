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
        <h2>Crea un nuevo usuario, vendedor o administrador</h2> <!-- Cambiado el texto -->
        <div class="contenedor-añadir" id="contenedor-añadir">
            <form id="formulario-admin" method="POST" action="inc/modelos/modelo-usuarios.php">
                <label for="input-nombre">Usuario: </label>
                <input type="text" name="nombre_usuario" id="input-nombre" class="form-field" placeholder="Nombre de usuario" required>

                <label for="input-correo">Correo: </label>
                <input type="email" name="correo_usuario" id="input-correo" class="form-field" placeholder="Correo del usuario" required>

                <label for="input-password">Contraseña: </label>
                <input type="password" name="pass_usuario" id="input-password" class="form-field" placeholder="Contraseña" required>

                <label for="select-tipo">Tipo de usuario: </label>
                <select name="tipo_usuario" id="select-tipo" class="form-field" required>
                    <option value="usuario">Usuario</option>
                    <option value="vendedor">Vendedor</option>
                    <option value="administrador">Administrador</option> <!-- Nueva opción añadida -->
                </select>

                <input type="hidden" name="tipoAccion" value="añadir">
                <div class="container-input-submit">
                    <input type="submit" value="Añadir">
                </div>
            </form>
        </div>
    </div>
</div>

<?php
require "inc/templates/footer.php";
?>

<!-- Agregar el código JavaScript aquí -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const formularioAdmin = document.querySelector("#formulario-admin");
    
    if (formularioAdmin) {
        formularioAdmin.addEventListener('submit', function(e) {
            e.preventDefault(); // Evitar el envío normal del formulario

            let datos = new FormData(formularioAdmin);

            fetch('inc/modelos/modelo-usuarios.php', {
                method: 'POST',
                body: datos
            })
            .then(response => response.json())
            .then(data => {
                if (data.respuesta === "exito") {
                    alert("Usuario creado con éxito");
                    // Redirigir o actualizar la página si es necesario
                    window.location.href = "usuarios-lista.php"; // Redirigir a la lista de usuarios
                } else {
                    alert("Error al crear el usuario: " + data.respuesta);
                }
            })
            .catch(error => {
                console.error("Error:", error);
            });
        });
    }
});
</script>