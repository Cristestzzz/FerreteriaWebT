<?php


require "inc/funciones/sesiones.php";
require "inc/templates/header.php";

// Inicializar variable para los productos
$productos = [];

// Verificar si se ha enviado una búsqueda
if (isset($_GET['query'])) {
    $query = htmlspecialchars($_GET['query']); // Obtener la consulta de búsqueda

    try {
        require "inc/funciones/conexionbd.php";
        // Consulta para buscar productos que coincidan con la búsqueda
        $sql = "SELECT * FROM productos WHERE nombre_producto LIKE ?";
        $stmt = $conn->prepare($sql);
        $likeQuery = "%" . $query . "%"; // Para buscar coincidencias
        $stmt->bind_param("s", $likeQuery);
        $stmt->execute();
        $respuesta = $stmt->get_result();

        // Obtener los productos
        while ($producto = $respuesta->fetch_assoc()) {
            $productos[] = $producto; // Agregar producto al array
        }

        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<div class="container">
    <h2>Realizar Venta</h2>

    <!-- Formulario de búsqueda de productos -->
    <div id="buscador" style="margin-bottom: 20px;">
        <form action="ventas.php" method="GET">
            <input type="text" name="query" placeholder="Buscar productos..." required>
            <button type="submit"><i class="fa-solid fa-search"></i> Buscar</button>
        </form>
    </div>

    <!-- Tabla de productos -->
    <?php if (!empty($productos)): ?>
        <table>
            <thead>
                <tr>
                    <th>Nombre del Producto</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($productos as $producto): ?>
                <tr>
                    <td><?php echo htmlspecialchars($producto['nombre_producto']); ?></td>
                    <td>$<?php echo htmlspecialchars($producto['precio_producto']); ?></td>
                    <td><?php echo htmlspecialchars($producto['stock']); ?></td>
                    <td>
                        <form action='inc/modelos/modelo-carritos.php' method='POST' style='display:inline;'>
                            <input type='hidden' name='id_producto' value='<?php echo $producto['id_producto']; ?>'>
                            <input type='number' name='cantidad' min='1' value='1' required style='width: 60px;'>
                            <input type='hidden' name='tipoAccion' value='añadir'>
                            <button type='submit' class='btn-vender'>Vender</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No se encontraron productos que coincidan con tu búsqueda.</p>
    <?php endif; ?>
</div>

<?php
require "inc/templates/footer.php";
?>