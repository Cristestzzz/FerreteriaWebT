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
        <h2>Lista de productos</h2>
        <div class="contenedor-lista" id="contenedor-lista">
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Stock</th> <!-- Nueva columna para el stock -->
                        <th>Categoria</th>
                        <th>Imagen</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    try {
                        require "inc/funciones/conexionbd.php";
                        $sql = "SELECT productos.id_producto, productos.nombre_producto, productos.precio_producto, productos.stock, productos.url_img, categorias.nombre_categoria 
                                FROM productos 
                                INNER JOIN categorias ON productos.categoria_id = categorias.id_categoria";
                        $respuesta = $conn->query($sql);
                    } catch (Exception $e) {
                        echo "Error: ".$e->getMessage();
                    }
                ?>
                <?php while($producto = $respuesta->fetch_assoc()){ ?>
                    <tr>
                        <td><?php echo $producto["nombre_producto"]?></td>
                        <td><?php echo $producto["precio_producto"]?></td>
                        <td><?php echo $producto["stock"]?></td> <!-- Mostrar stock -->
                        <td><?php echo $producto["nombre_categoria"]?></td>
                        <td><img src="../img/productos/<?php echo $producto["url_img"]?>" alt=""></td>
                        <td>
                            <a class="btn-editar" href="productos-editar.php?id=<?php echo $producto["id_producto"]?>"><i class="fa-solid fa-pen"></i></a>
                            <a href="#" class="btn-borrar" id_registro="<?php echo $producto["id_producto"]?>" tipoOpcion="productos"><i class="fa-solid fa-trash-can"></i></a>
                        </td>
                    </tr>
                <?php }
                    $conn->close();
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // Manejo de evento para el botón de borrar
    document.querySelectorAll('.btn-borrar').forEach(boton => {
        boton.addEventListener('click', function(e) {
            e.preventDefault();
            const idRegistro = this.getAttribute('id_registro');
            const tipoOpcion = this.getAttribute('tipoOpcion');

            if (confirm('¿Estás seguro de que deseas borrar este producto?')) {
                // Realizar la petición AJAX para borrar el producto
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'modelo-productos.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    const respuesta = JSON.parse(this.responseText);
                    if (respuesta.respuesta === 'exito') {
                        alert('Producto borrado exitosamente');
                        location.reload(); // Recargar la página para ver los cambios
                    } else {
                        alert('Error al borrar el producto');
                    }
                };
                xhr.send('tipoAccion=borrar&id_registro=' + idRegistro);
            }
        });
    });
</script>

<?php
require "inc/templates/footer.php";
?>