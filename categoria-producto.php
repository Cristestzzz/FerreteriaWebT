<?php
/** Verificar si el ID enviado en la URL existe en la base de datos antes de mostrar los datos del producto */
try {
    require "inc/funciones/conexionbd.php";

    // Validar que el parámetro id_categoria sea un número
    if (!isset($_GET["id_categoria"]) || !is_numeric($_GET["id_categoria"])) {
        header("Location:404.php");
        exit;
    }

    $id_categoria = intval($_GET["id_categoria"]); // Convertir el parámetro a entero

    // Consulta para obtener los productos de la categoría
    $sql = "SELECT * FROM productos WHERE categoria_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_categoria);
    $stmt->execute();
    $respuesta = $stmt->get_result();

    // Consulta para obtener el nombre de la categoría
    $sql_categoria = "SELECT nombre_categoria FROM categorias WHERE id_categoria = ?";
    $stmt_categoria = $conn->prepare($sql_categoria);
    $stmt_categoria->bind_param("i", $id_categoria);
    $stmt_categoria->execute();
    $resultado_categoria = $stmt_categoria->get_result();
    $nombre_categoria = $resultado_categoria->fetch_assoc();

    // Verificar si la categoría existe
    if (!$nombre_categoria) {
        header("Location:404.php");
        exit;
    }

} catch (Exception $e) {
    // Redirigir a la página 404 si ocurre algún error
    header("Location:404.php");
    exit;
}

require "inc/templates/header.php";
?>

<div style="background-image:url('img/categorias/bg.png');">
    <div class="bg-categoria-producto">
        <div class="title-categoria-producto">
            <p>Categoría</p>
            <h1><?php echo htmlspecialchars($nombre_categoria["nombre_categoria"]); ?></h1>
        </div>
    </div>
</div>

<div class="wrapper">
    <div class="productos">

        <?php if ($respuesta->num_rows > 0) { ?>
            <?php while ($producto = $respuesta->fetch_assoc()) { ?>
                <div class="card">
                    <img src="img/productos/<?php echo htmlspecialchars($producto["url_img"]); ?>" alt="">
                    <div class="descripcion">
                        <p><small><?php echo htmlspecialchars($nombre_categoria["nombre_categoria"]); ?></small></p>
                        <a href="detalles.php?id_producto=<?php echo $producto["id_producto"]; ?>" class="nombre-producto"><?php echo htmlspecialchars($producto["nombre_producto"]); ?></a>
                        <p><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></p>
                        <p><small>$<?php echo htmlspecialchars($producto["precio_producto"]); ?></small></p>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <img src="img/categorias/sin-productos.png" alt="" class="img-sin-productos">
            <div class="text-sin-productos">
                <p>¡Esta categoría aún no tiene productos!</p>
            </div>
        <?php } ?>

    </div>
</div>

<?php
require "inc/templates/footer.php";
?>
