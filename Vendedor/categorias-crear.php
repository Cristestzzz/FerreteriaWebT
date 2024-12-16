<?php
session_start(); // Iniciar la sesión

// Verificar si el usuario está logueado
if (isset($_SESSION['LoggedIn']) && isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === 'vendedor') {
    header('Location: index.php'); // Redirigir al dashboard si ya está logueado como vendedor
    exit();
}
require "inc/funciones/sesiones.php";

require "inc/templates/header.php";
?>
    <div class="container">
        <div class="contenedor-option">

            <h2>Crea una nueva categoria</h2>

            <div class="contenedor-añadir" id="contenedor-añadir">
                <form id="formulario-admin" enctype="multipart/form-data">
                    
                    <label for="input-nombre">Nombre: </label>
                    <input type="text" name="nombre_categoria" id="input-nombre" class="form-field" placeholder="Nombre de la categoria" required>
                    
                    <label for="input-file">Imagen: </label>
                    <div class="container-input-file">
                        <input type="file" name="imagen_categoria" id="input-file" class="input-file" accept="image/png, image/gif, image/jpg, image/jpeg, image/webp">
                    </div>
                 
                    <input type="hidden" name="tipoAccion" value="añadir">
                    <input type="hidden" name="tipoOpcion" value="categorias">

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