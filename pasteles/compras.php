<?php
session_start();

if (!isset($_SESSION['usuario'])) {
  header('Location: index.php');
  exit();
}

date_default_timezone_set('America/Monterrey');
include 'librerias.php';

$carrito = $_SESSION['carrito'] ?? [];

function calcularTotal($carrito)
{
  $total = 0;
  foreach ($carrito as $item) {
    $precio = $item['precio'];
    if (!empty($item['descuento'])) {
      $precio -= ($precio * $item['descuento'] / 100);
    }
    $total += $precio;
  }
  return $total;
}

$totalFinal = calcularTotal($carrito);
$fecha = date('d/m/Y');
$hora = date('H:i');
$orden = strtoupper(substr(md5(uniqid()), 0, 8));
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Carrito de Compras</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <link rel="stylesheet" href="css/inicio.css">
  <link rel="stylesheet" href="css/compras.css">
  <link rel="icon" href="img/logo.png" type="image/png" />
</head>

<body>

  <nav class="navbar navbar-light custom-navbar fixed-top">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <a class="navbar-brand" href="inicio.php">
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
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
          aria-controls="offcanvasNavbar">
          <span class="navbar-toggler-icon"></span>
        </button>
      </div>
    </div>

    <!-- Offcanvas Menú -->
    <div class="offcanvas offcanvas-end custom-offcanvas" tabindex="-1" id="offcanvasNavbar"
      aria-labelledby="offcanvasNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menú</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>

      <div class="offcanvas-body d-flex flex-column justify-content-between">
        <div>
          <!-- Usuario + Nombre (MOVIDO AQUÍ) -->
          <div class="offcanvas-icons mb-4">
            <div class="user-navbar d-flex align-items-center">
              <img src="img/usuario.png" alt="usuario">
              <a href="usuario.php" class="username ms-2">
                <?php if (isset($_SESSION['usuario']))
                  echo htmlspecialchars($_SESSION['usuario']); ?>
              </a>
            </div>
          </div>


          <!-- Menú Navegación -->
          <ul class="navbar-nav justify-content-start flex-grow-1 pe-3">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="pastelesDropdown" role="button" data-bs-toggle="dropdown"
                aria-expanded="false">
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
              <a class="nav-link dropdown-toggle" href="#" id="accesoriosDropdown" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                Accesorios
              </a>
              <ul class="dropdown-menu" aria-labelledby="accesoriosDropdown">
                <li><a class="dropdown-item" href="accesorio.php#velas">Velas</a></li>
                <li><a class="dropdown-item" href="accesorio.php#utensilios">Utensilios en Promo</a></li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="novedadesDropdown" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                Novedades
              </a>
              <ul class="dropdown-menu" aria-labelledby="novedadesDropdown">
                <li><a class="dropdown-item" href="globo.php#globos">Globos</a></li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="buzon.php" id="novedadesDropdown" role="button"
                aria-expanded="false">
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
  <br><br>
  <div class="ticket-box">
    <h2>Carrito de Compras</h2>

    <?php if (empty($carrito)): ?>
      <p>No hay productos en el carrito.</p>
    <?php else: ?>
      <?php foreach ($carrito as $index => $item): ?>
        <div class="ticket-item">
          <p><strong>Producto:</strong> <?= htmlspecialchars($item['nombre']) ?></p>
          <p><strong>Precio:</strong> $<?= number_format($item['precio'], 2) ?> MXN</p>
          <?php if (!empty($item['descuento'])): ?>
            <p style="color: green;"><strong><?= $item['descuento'] ?>% de descuento aplicado</strong></p>
          <?php endif; ?>
          <form action="quitar.php" method="post">
            <input type="hidden" name="index" value="<?= $index ?>">
            <button type="submit" class="btn-quitar">Quitar</button>
          </form>
        </div>
      <?php endforeach; ?>

      <p class="total">Total Final: $<?= number_format($totalFinal, 2) ?> MXN</p>
      <button class="btn-pdf" onclick="generarYVaciar()">Sabor & Arte</button>
    <?php endif; ?>
  </div>
  <script>
    function generarYVaciar() {
      generarPDF();
      setTimeout(() => {
        window.location.href = "vaciar.php";
      }, 1000);
    }
  </script>
  <script>
    function generarPDF() {
      const { jsPDF } = window.jspdf;
      const doc = new jsPDF();

      // 🎨 Estilo tipo tarjeta
      doc.setFillColor(233, 246, 239);
      doc.rect(10, 10, 190, 270, 'F');

      let y = 30;
      const fecha = "<?= $fecha ?>";
      const hora = "<?= $hora ?>";
      const orden = "<?= $orden ?>";

      doc.setTextColor(40, 40, 40);
      doc.setFontSize(18);
      doc.setFont("helvetica", "bold");
      doc.text("Sabor y Arte", 105, y, { align: "center" });
      y += 10;

      doc.setFontSize(14);
      doc.setFont("helvetica", "normal");
      doc.text("Ticket de Compra", 105, y, { align: "center" });
      y += 10;

      doc.setFontSize(11);
      doc.text(`Fecha: ${fecha}`, 20, y);
      doc.text(`Hora: ${hora}`, 150, y);
      y += 7;
      doc.text(`Orden: ${orden}`, 20, y);
      y += 10;

      <?php foreach ($carrito as $item): ?>
        doc.setFontSize(12);
        doc.setTextColor(80, 80, 80);
        doc.text("Producto: <?= $item['nombre'] ?>", 20, y); y += 7;
        <?php if (!empty($item['descuento'])): ?>
          const precioOriginal = <?= $item['precio'] ?>;
          const descuento = <?= $item['descuento'] ?>;
          const precioFinal = (precioOriginal - (precioOriginal * descuento / 100)).toFixed(2);
          doc.text(`Precio original: $${precioOriginal.toFixed(2)} MXN`, 20, y); y += 7;
          doc.text(`Descuento: ${descuento}%`, 20, y); y += 7;
          doc.text(`Precio con descuento: $${precioFinal} MXN`, 20, y); y += 10;
        <?php else: ?>
          doc.text("Precio: $<?= number_format($item['precio'], 2) ?> MXN", 20, y); y += 10;
        <?php endif; ?>
      <?php endforeach; ?>

      doc.setFontSize(13);
      doc.setTextColor(0, 0, 0);
      doc.setFont("helvetica", "bold");
      doc.text("Total Final: $<?= number_format($totalFinal, 2) ?> MXN", 20, y + 10);
      doc.setFontSize(12);
      doc.setFont("helvetica", "italic");
      doc.setTextColor(60, 60, 60);
      doc.text("¡Gracias por tu compra!", 105, y + 25, { align: "center" });

      doc.save("ticket_compra.pdf");
    }
  </script>
</body>

</html>