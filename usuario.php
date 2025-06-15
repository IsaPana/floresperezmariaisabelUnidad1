<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit();
}

require_once 'clases/class.conexion.php';

$conexion = new Conexion();

$usuario = $_SESSION['usuario'];


$sql = "SELECT nombre, apellido, correo FROM registro WHERE nusuario = ? LIMIT 1";


$stmt = $conexion->prepare($sql);

if ($stmt === false) {
    die('Error al preparar la consulta: ' . $conexion->error);
}


$stmt->bind_param('s', $usuario);

$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $nombre = $user['nombre'];
    $apellido = $user['apellido'];
    $correo = $user['correo'];
} else {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sabor y Arte - Perfil</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" href="img/logo.png" type="image/png" />
  <link rel="stylesheet" href="css/usuario.css">
  <link rel="stylesheet" href="css/inicio.css">
</head>
<body>
  <!-- Navbar -->
<nav class="navbar navbar-light custom-navbar fixed-top">
  <div class="container-fluid d-flex justify-content-between align-items-center">
    <a class="navbar-brand" href="#">
      <img src="img/logo.png" alt="Logo">
    </a>

    <div class="navbar-icons-search d-flex align-items-center">
      <!-- Ícono Carrito -->
      <a href="compras.php"><img src="img/carro.png" alt="carro" class="mx-2"></a>

      <!-- Formulario Búsqueda -->
      <form action="buscar.php" method="GET" class="d-flex align-items-center">
        <input class="form-control me-2" type="search" placeholder="Buscar..." aria-label="Buscar" name="q">
        <button class="btn btn-outline-success" type="submit">Buscar</button>
      </form>

      <!-- Botón Hamburguesa -->
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
  </div>

  <!-- Offcanvas Menú -->
  <div class="offcanvas offcanvas-end custom-offcanvas" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menú</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body d-flex flex-column justify-content-between">
      <div>
<div class="offcanvas-icons mb-4">
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
          <li class="nav-item">
            <a class="nav-link" href="#" onclick="mostrarAyuda()">Ayuda</a>
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
<!-- Fin Navbar --><br><br><br>
<!-- Mostrar datos del usuario -->
<div class="perfil-box">
  <div class="perfil-header">
    <img src="img/usuario.png" alt="Foto de perfil" class="perfil-img">
    <h3 class="mt-3"><?= htmlspecialchars($nombre) ?> <?= htmlspecialchars($apellido) ?></h3>
    <p class="text-muted">Usuario: <?= htmlspecialchars($usuario) ?></p>
  </div>

  <div class="perfil-info">
    <p><strong>Correo electrónico:</strong> <?= htmlspecialchars($correo) ?></p>
    <p><strong>Fecha de registro:</strong> 01/06/2025</p> <!-- Este campo lo puedes modificar si tienes esa fecha en la base de datos -->
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
