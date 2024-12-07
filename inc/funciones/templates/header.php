<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;800&family=Open+Sans:wght@400;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/todos.css">    

  
    <title>Ferreteria</title>
    </head>
<body>
<header>

<!-- Encabezado: Logo y barra superior -->
<div class="top-header">
  <div class="top-links">
    <a href="#"><i class="fas fa-tools"></i> Nuestros servicios</a>
    <a href="#"><i class="fas fa-calculator"></i> Estimación de proyectos</a>
    <a href="#"><i class="fas fa-headset"></i> ¿Necesitas ayuda?</a>
  </div>
</div>

<!-- Encabezado principal con logo y barra de búsqueda -->
<div class="header-main">
  <div class="logo-container">
    <a href="index.php"><img src="img/logo.png" alt="Ferretería" class="logo"></a>
  </div>
  <div class="search-container">
    <input type="text" class="search-input" placeholder="Buscar...">
    <i class="fas fa-search search-icon"></i>
  </div>
  <div class="links-container">
    <a href="#" class="link-item"><i class="fas fa-store"></i><span>Localizador de sucursales</span></a>
    <a href="carrito.php" class="link-item"><i class="fas fa-shopping-cart"></i><span>Mi carrito </span></a>
    <a href="login.php"  class="link-item"><i class="fas fa-user"></i> <span> Iniciar sesión o registrarse</span></a>
  </div>
  <!-- Botón menú hamburguesa -->
  <button class="hamburger-menu" id="hamburger-menu">☰</button>
</div>

<!-- Barra de navegación principal -->
<nav class="main-nav">
  <div class="nav-container">
    <?php
    require_once 'inc/funciones/conexionbd.php';

    try {
        $sql = "SELECT id_categoria, nombre_categoria FROM categorias";
        $resultado = $conn->query($sql);

        while ($categoria = $resultado->fetch_assoc()) {
          echo '<a href="categoria-producto.php?id_categoria=' . $categoria["id_categoria"] . '" class="categoria-link" data-id="' . $categoria["id_categoria"] . '">' . htmlspecialchars($categoria["nombre_categoria"]) . '</a>';
        }
    } catch (Exception $e) {
        echo '<a href="#">Error al cargar categorías</a>';
    }
    ?>
  </div>
</nav>

<!-- Menú móvil -->
<div class="mobile-menu" id="mobile-menu">
  <ul class="menu-list">
    <li><a href="#"><i class="fas fa-tools"></i><span> Nuestros servicios</span></a></li>
    <li><a href="#"><i class="fas fa-calculator"></i><span> Estimación de proyectos</span></a></li>
    <li><a href="#"><i class="fas fa-headset"></i><span>¿Necesitas ayuda?</span></a></li>

    <h3 class="menu-title">Categorías</h3>
    <?php
    try {
        $sql = "SELECT id_categoria, nombre_categoria FROM categorias";
        $resultado = $conn->query($sql);

        while ($categoria = $resultado->fetch_assoc()) {
          echo '<a href="categoria-producto.php?id_categoria=' . $categoria["id_categoria"] . '" class="categoria-link" data-id="' . $categoria["id_categoria"] . '">' . htmlspecialchars($categoria["nombre_categoria"]) . '</a>';
        }
    } catch (Exception $e) {
        echo '<li><a href="#">Error al cargar categorías</a></li>';
    }
    ?>
  </ul>
</div>

<!-- Franja decorativa inferior -->
<div class="header-franja"></div>
</header>

<main>