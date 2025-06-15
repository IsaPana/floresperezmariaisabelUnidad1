<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sabor y Arte - Pasteles</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" href="img/logo.png" type="image/png" />
  <link rel="stylesheet" href="css/pasteles.css">
  <link rel="stylesheet" href="css/inicio.css">
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-light custom-navbar fixed-top">
  <div class="container-fluid d-flex justify-content-between align-items-center">
    <a class="navbar-brand" href="inicio.php">
      <img src="img/logo.png" alt="Logo">
    </a>

    <div class="navbar-icons-search d-flex align-items-center">
      <a href="compras.php"><img src="img/carro.png" alt="carro" class="mx-2"></a>
      <!-- Formulario Búsqueda -->
      <form action="buscar.php" method="GET" class="d-flex align-items-center">
        <input class="form-control me-2" type="search" placeholder="Buscar..." aria-label="Buscar" name="q">
        <button class="btn btn-outline-success" type="submit">Buscar</button>
      </form>
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
  </div>
  <div class="offcanvas offcanvas-end custom-offcanvas" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menú</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body d-flex flex-column justify-content-between">
      <div>
<div class="offcanvas-icons mb-4">
  <div class="user-navbar d-flex align-items-center">
    <img src="img/usuario.png" alt="usuario">
    <a href="usuario.php" class="username ms-2">
      <?php if (isset($_SESSION['usuario'])) echo htmlspecialchars($_SESSION['usuario']); ?>
    </a>
  </div>
</div>
        <!-- Menú Navegación -->
        <ul class="navbar-nav justify-content-start flex-grow-1 pe-3">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="pastelesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Pasteles
            </a>
            <ul class="dropdown-menu" aria-labelledby="pastelesDropdown">
              <li><a class="dropdown-item" href="pasteles.php#chocolates">Chocolates</a></li>
              <li><a class="dropdown-item" href="pasteles.php#frutas">Frutas</a></li>
              <li><a class="dropdown-item" href="pasteles.php#tresleches">Tres Leches</a></li>
              <li><a class="dropdown-item" href="pasteles.php#mango">Mango</a></li>
              <li><a class="dropdown-item" href="pasteles.php#terciopelorojo">Terciopelo Rojo</a></li>
              <li><a class="dropdown-item" href="pasteles.php#fiestas">Fiestas</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="accesoriosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Accesorios
            </a>
            <ul class="dropdown-menu" aria-labelledby="accesoriosDropdown">
              <li><a class="dropdown-item" href="accesorio.php#velas">Velas</a></li>
              <li><a class="dropdown-item" href="accesorio.php#utensilios">Utensilios en Promo</a></li>
            </ul>
          </li>
           <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="novedadesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Novedades
            </a>
            <ul class="dropdown-menu" aria-labelledby="novedadesDropdown">
              <li><a class="dropdown-item" href="globo.php#globos">Globos</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="buzon.php" id="novedadesDropdown" role="button"  aria-expanded="false">
              Buzon
            </a>
          </li>
        </ul>
      </div>
      
        <!-- Botón cerrar sesión bonito -->
        <?php if (isset($_SESSION['usuario'])): ?>
          <form action="cerrar.php" method="post" class="mt-4">
            <button type="submit" class="btn btn-outline-danger w-100">Cerrar Sesión</button>
          </form>
        <?php endif; ?>
      </div>
    </div>
  </div>
    </div>
</nav>
<!-- Fin Navbar -->
<!-- Secciones de Categorías -->
<section class="seccion-categorias" id="chocolates">
  <h2>Área de Chocolates</h2>
  <div class="contenedor-categorias">
    <?php $pasteles_chocolates = [
      ["cho1.png", "Pastel 3 leches", "$400.00 MXN"],
      ["cho2.png", "Chocolate Carlos V", "$450.00 MXN"],
      ["cho3.png", "Selva Negra", "$420.00 MXN"],
    ];
    foreach ($pasteles_chocolates as $pastel): ?>
    <div class="categoria">
      <div class="circulo"><img src="img/<?= $pastel[0] ?>" alt="<?= $pastel[1] ?>"></div>
      <div class="card-info">
        <p class="nombre-pastel"><?= $pastel[1] ?></p>
        <p class="precio"><?= $pastel[2] ?></p>
        <a href="agregar.php?producto=<?= urlencode($pastel[1]) ?>&precio=<?= urlencode($pastel[2]) ?>&imagen=img/<?= $pastel[0] ?>&descuento=<?= isset($descuento) ? $descuento : 0 ?>" class="btn btn-success">Comprar</a>
          <img src="img/carro.png" alt="Agregar al carrito" width="30" height="30">
        </a>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<section class="seccion-categorias" id="frutas">
  <h2>Área de Frutas</h2>
  <div class="contenedor-categorias">
    <?php $pasteles_frutas = [
      ["fru1.png", "3 Leches Frutas", "$430.00 MXN"],
      ["fru2.png", "Queso Crema de Frutas", "$450.00 MXN"],
      ["fru3.png", "Crema Frutti di Bosco", "$480.00 MXN"],
    ];
    foreach ($pasteles_frutas as $pastel): ?>
    <div class="categoria">
      <div class="circulo"><img src="img/<?= $pastel[0] ?>" alt="<?= $pastel[1] ?>"></div>
      <div class="card-info">
        <p class="nombre-pastel"><?= $pastel[1] ?></p>
        <p class="precio"><?= $pastel[2] ?></p>
        <a href="agregar.php?producto=<?= urlencode($pastel[1]) ?>&precio=<?= urlencode($pastel[2]) ?>&imagen=img/<?= $pastel[0] ?>&descuento=<?= isset($descuento) ? $descuento : 0 ?>" class="btn btn-success">Comprar</a>
          <img src="img/carro.png" alt="Agregar al carrito" width="30" height="30">
        </a>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</section>
    <!--Categoria 3 leches -->
<section class="seccion-categorias" id="tresleches">
  <h2>Área de Tres Leches</h2>
  <div class="contenedor-categorias">
    <?php $pasteles_tresleches = [
      ["tartafresa.png", "Tarta de Fresas", "$390.00 MXN"],
      ["tartafr.png", "Tarta de Frutas", "$410.00 MXN"],
      ["tarta.png", "Tarta Tradicional", "$400.00 MXN"],
    ];
    foreach ($pasteles_tresleches as $pastel): ?>
    <div class="categoria">
      <div class="circulo"><img src="img/<?= $pastel[0] ?>" alt="<?= $pastel[1] ?>"></div>
      <div class="card-info">
        <p class="nombre-pastel"><?= $pastel[1] ?></p>
        <p class="precio"><?= $pastel[2] ?></p>
        <a href="agregar.php?producto=<?= urlencode($pastel[1]) ?>&precio=<?= urlencode($pastel[2]) ?>&imagen=img/<?= $pastel[0] ?>&descuento=<?= isset($descuento) ? $descuento : 0 ?>" class="btn btn-success">Comprar</a>
          <img src="img/carro.png" alt="Agregar al carrito" width="30" height="30">
        </a>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</section>
<!--Categoria de mango -->
<section class="seccion-categorias" id="mango">
  <h2>Área de Mango</h2>
  <div class="contenedor-categorias">
    <?php 
    $pasteles_mango = [
      ["mangoketo.png", "Mango Keto", "$460.00 MXN"],
      ["rollomango.png", "Rollo de Mango", "$440.00 MXN"],
      ["paymango.png", "Pay de Mango", "$420.00 MXN"],
    ];
    foreach ($pasteles_mango as $pastel): ?>
    <div class="categoria">
      <div class="cinta-descuento">15% OFF</div> <!-- Banda -->
      <div class="circulo">
        <img src="img/<?= $pastel[0] ?>" alt="<?= $pastel[1] ?>">
      </div>
      <div class="card-info">
        <p class="nombre-pastel"><?= $pastel[1] ?></p>
        <p class="precio"><?= $pastel[2] ?></p>
<a href="agregar.php?producto=<?= urlencode($pastel[1]) ?>&precio=<?= urlencode($pastel[2]) ?>&imagen=img/<?= $pastel[0] ?>&descuento=15" class="btn btn-success">Comprar</a>
          <img src="img/carro.png" alt="Agregar al carrito" width="30" height="30">
        </a>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</section>
    <!--Categoria terciopelo  rojo-->
<section class="seccion-categorias" id="terciopelorojo">
  <h2>Área de Terciopelo Rojo</h2>
  <div class="contenedor-categorias">
    <?php $pasteles_terciopelo = [
      ["ter1.png", "Terciopelo Rojo", "$470.00 MXN"],
      ["ter2.png", "Pastel Terciopelo", "$490.00 MXN"],
      ["cupcake.png", "Cup Cake", "$50.00 MXN"],
    ];
    foreach ($pasteles_terciopelo as $pastel): ?>
    <div class="categoria">
      <div class="circulo"><img src="img/<?= $pastel[0] ?>" alt="<?= $pastel[1] ?>"></div>
      <div class="card-info">
        <p class="nombre-pastel"><?= $pastel[1] ?></p>
        <p class="precio"><?= $pastel[2] ?></p>
      <a href="agregar.php?producto=<?= urlencode($pastel[1]) ?>&precio=<?= urlencode($pastel[2]) ?>&imagen=img/<?= $pastel[0] ?>&descuento=<?= isset($descuento) ? $descuento : 0 ?>" class="btn btn-success">Comprar</a>
          <img src="img/carro.png" alt="Agregar al carrito" width="30" height="30">
        </a>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</section>
    <!--Categoria fiesta-->
<section class="seccion-categorias" id="fiestas">
  <h2>Área de Fiestas</h2>
  <div class="contenedor-categorias">
    <?php $pasteles_fiestas = [
      ["unicornio.png", "Unicornio", "$1200.00 MXN"],
      ["bodas.png", "Bodas", "$1500.00 MXN"],
      ["xv.png", "XV Años", "$1400.00 MXN"],
    ];
    foreach ($pasteles_fiestas as $pastel): ?>
    <div class="categoria">
      <div class="circulo"><img src="img/<?= $pastel[0] ?>" alt="<?= $pastel[1] ?>"></div>
      <div class="card-info">
        <p class="nombre-pastel"><?= $pastel[1] ?></p>
        <p class="precio"><?= $pastel[2] ?></p>
<a href="agregar.php?producto=<?= urlencode($pastel[1]) ?>&precio=<?= urlencode($pastel[2]) ?>&imagen=img/<?= $pastel[0] ?>&descuento=<?= isset($descuento) ? $descuento : 0 ?>" class="btn btn-success">Comprar</a>
          <img src="img/carro.png" alt="Agregar al carrito" width="30" height="30">
        </a>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Footer-->
<footer class="footer-new">
  <div class="footer-animation"></div> 
  <div class="footer-content">
    <div class="footer-column">
      <h4>Contacto</h4>
      <p>Lun-Sáb: 9:00 am a 7:00 pm</p>
      <p>WhatsApp: +52 844 2744584</p>
      <p>Correo: <strong>saboryarte@gmail.mx</strong></p>
    </div>
    <div class="footer-column">
      <h4>Legales</h4>
      <a href="#">Aviso de privacidad</a>
      <a href="#">Términos y condiciones</a>
      <a href="#">Preguntas frecuentes</a>
    </div>
    <div class="footer-column">
      <h4>Nosotros</h4>
      <a href="#">Nuestra historia</a>
      <a href="#">Responsabilidad social</a>
      <a href="#">Blog</a>
    </div>
<div class="footer-column">
  <h4>Buzón</h4>
  <form class="subscribe-form" method="POST" action="buzon.php">
    <textarea name="comentario" placeholder="Escribe tu comentario..." required></textarea>
    <button type="submit">Enviar</button>
  </form>
</div>
  </div>

  <div class="footer-bottom">
    <p>Sabor y Arte © 2025 Todos los derechos reservados.</p>
  </div>
</footer>
</body>
</html>
