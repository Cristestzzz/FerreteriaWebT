<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--Google Font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;800&family=Open+Sans:wght@400;700;800&display=swap" rel="stylesheet">

    <!--FontAwesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="css/main.css">        

    <title>FERRETERIA</title>
</head>
<body>
    <header>
        <div class="side-header">
            <div class="logo">
                <img class="logo-img" src="img/logo.png" alt="Logo">
                <a href="index.php" class="logo-title">FERRETERIA - <small>Administracion</small></a>
            </div>
            <a href="#" id="btnCerrarSesion" class="btn-out"><i class="fa-solid fa-right-to-bracket"></i> Cerrar Sesión</a>
        </div>

        
    </header>
    <main>
    <div class="navegacion">
    <h2><i class="fa fa-user"></i> Admin</h2>
    <div id="nav-menu">
        <?php
        $path = $_SERVER["PHP_SELF"];
        $archivo = basename($path, ".php");

        $isUsuarios = str_contains($archivo, "usuarios");
        $isProductos = str_contains($archivo, "productos");
        $isCategorias = str_contains($archivo, "categorias");
        $isVentas = str_contains($archivo, "ventas"); // Agregar esta línea para verificar si estamos en la página de ventas
        ?>

        <a class="<?php echo str_contains($archivo, "index")? "active" : "";?>" href="index.php">Dashboard</a>
        <a id="btn-ventas" class="<?php echo ($isVentas)? "active" : "";?>" href="ventas.php">Realizar Venta <i class="fa-solid fa-caret-left <?php echo ($isVentas)? "rotate" : "";?>" id="ventasArrow"></i></a>
        <a id="btn-usuarios" class="<?php echo ($isUsuarios)? "active" : "";?>" href="#">Usuarios <i class="fa-solid fa-caret-left <?php echo ($isUsuarios)? "rotate" : "";?>" id="usuariosArrow"></i></a>
        <ul id="sub-usuarios" class="<?php echo ($isUsuarios)? "show" : "";?>">
            <li><a href="usuarios-lista.php">Lista de usuarios</a></li>
            <li><a href="usuarios-crear.php">Crear usuarios</a></li>
        </ul>

        <a id="btn-productos" class="<?php echo ($isProductos)? "active" : "";?>" href="#">Productos <i class="fa-solid fa-caret-left <?php echo ($isProductos)? "rotate" : "";?>" id="productosArrow"></i></a>
        <ul id="sub-productos" class="<?php echo ($isProductos)? "show" : "";?>">
            <li><a href="productos-lista.php">Lista de productos</a></li>
            <li><a href="productos-crear.php">Crear productos</a></li>
        </ul>

        <a id="btn-categorias" class="<?php echo ($isCategorias)? "active" : "";?>" href="#">Categorias <i class="fa-solid fa-caret-left <?php echo ($isCategorias)? "rotate" : "";?>" id="categoriasArrow"></i></a>
        <ul id="sub-categorias" class="<?php echo ($isCategorias)? "show" : "";?>">
            <li><a href="categorias-lista.php">Lista de categorias</a></li>
            <li><a href="categorias-crear.php">Crear categorias</a></li>
        </ul>

        
        
        <a id="btn-reportes" class="<?php echo ($isReportes) ? "active" : ""; ?>" href="#">Generar Reportes <i class="fa-solid fa-caret-left <?php echo ($isReportes) ? "rotate" : ""; ?>" id="reportesArrow"></i></a>
        <ul id="sub-reportes" class="<?php echo ($isReportes) ? "show" : ""; ?>">
            <li><a href="fpd/PruebaV.php">De Productos</a></li>
            <li><a href="fpd/PruebaH.php">De Categorias</a></li>
            <li><a href="fpd/PruebaH.php">De Usuarios</a></li>
            <li><a href="fpd/PruebaH.php">De Ventas</a></li>
        </ul>
    </div>
</div>