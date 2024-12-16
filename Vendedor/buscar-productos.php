<?php
require "inc/funciones/conexionbd.php"; // Asegúrate de incluir la conexión a la base de datos

if (isset($_GET['query'])) {
    $query = $_GET['query'];
    $query = $conn->real_escape_string($query); // Escapar caracteres especiales para evitar inyecciones SQL

    // Consulta para buscar productos
    $sql = "SELECT * FROM productos WHERE nombre_producto LIKE '%$query%'";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows > 0) {
        // Mostrar los productos encontrados
        while ($producto = $resultado->fetch_assoc()) {
            echo "<div class='producto'>";
            echo "<h3>" . htmlspecialchars($producto['nombre_producto']) . "</h3>";
            echo "<p>Precio: $" . htmlspecialchars($producto['precio_producto']) . "</p>";
            echo "<img src='img/productos/" . htmlspecialchars($producto['url_img']) . "' alt='" . htmlspecialchars($producto['nombre_producto']) . "'>";
            echo "</div>";
        }
    } else {
        echo "<p>No se encontraron productos que coincidan con tu búsqueda.</p>";
    }
} else {
    echo "<p>No se ha realizado ninguna búsqueda.</p>";
}

$conn->close(); // Cerrar la conexión a la base de datos
?>