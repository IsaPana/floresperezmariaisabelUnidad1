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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<nav class="navbar navbar-light custom-navbar fixed-top">
  <div class="container-fluid d-flex justify-content-between align-items-center">
    <a class="navbar-brand" href="inicio.php">
      <img src="img/logo.png" alt="Logo">
    </a>
    <div class="navbar-icons-search d-flex align-items-center">
      <a href="compras.php"><img src="img/carro.png" alt="carro" class="mx-2"></a>
      <form action="buscar.php" method="GET" class="d-flex align-items-center">
        <input class="form-control me-2" type="search" placeholder="Buscar..." name="q">
        <button class="btn btn-outline-success" type="submit">Buscar</button>
      </form>
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
  </div>
  <div class="offcanvas offcanvas-end custom-offcanvas" tabindex="-1" id="offcanvasNavbar">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title">Menú</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body d-flex flex-column justify-content-between">
      <div>
        <div class="offcanvas-icons mb-4">
          <div class="user-navbar d-flex align-items-center">
            <img src="img/usuario.png" alt="usuario">
            <a href="usuario.php" class="username ms-2"><?= htmlspecialchars($_SESSION['usuario']); ?></a>
          </div>
        </div>
        <ul class="navbar-nav">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Pasteles</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="pasteles.php#chocolates">Chocolates</a></li>
              <li><a class="dropdown-item" href="pasteles.php#frutas">Frutas</a></li>
              <li><a class="dropdown-item" href="pasteles.php#tresleches">Tres Leches</a></li>
              <li><a class="dropdown-item" href="pasteles.php#mango">Mango</a></li>
              <li><a class="dropdown-item" href="pasteles.php#terciopelorojo">Terciopelo Rojo</a></li>
              <li><a class="dropdown-item" href="pasteles.php#fiestas">Fiestas</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Accesorios</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="accesorio.php#velas">Velas</a></li>
              <li><a class="dropdown-item" href="accesorio.php#utensilios">Utensilios en Promo</a></li>
            </ul>
          </li>
          <li class="nav-item"><a class="nav-link" href="globo.php#globos">Globos</a></li>
          <li class="nav-item"><a class="nav-link" href="buzon.php">Buzón</a></li>
        </ul>
      </div>
      <form action="cerrar.php" method="post" class="mt-4">
        <button type="submit" class="btn btn-outline-danger w-100">Cerrar Sesión</button>
      </form>
    </div>
  </div>
</nav>
<br><br><br>
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
    <button class="btn-pdf" onclick="mostrarModalDireccion()">Comprar</button>
  <?php endif; ?>
</div>

<!-- Modal Dirección + Método de Pago -->
<div class="modal fade" id="modalDireccion" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content border-3" style="border: 3px solid #d4af37;">
      <div class="modal-header">
        <h5 class="modal-title fw-bold">Confirmar pedido</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <label for="direccion">Dirección de entrega:</label>
        <textarea id="direccion" class="form-control mb-3" rows="3" placeholder="Calle, número, colonia..." required></textarea>

        <label for="metodo">Método de pago:</label>
        <select id="metodo" class="form-control mb-3" onchange="toggleCamposPago(this.value)">
          <option value="efectivo">Efectivo</option>
          <option value="tarjeta">Tarjeta</option>
        </select>

        <div id="campos-tarjeta" style="display:none;">
          <input type="text" id="numeroTarjeta" class="form-control mb-2" placeholder="Número de tarjeta (16 dígitos)">
          <input type="text" id="fechaExp" class="form-control mb-2" placeholder="Fecha de expiración (MM/AA)">
          <input type="text" id="cvv" class="form-control mb-2" placeholder="CVV (3 dígitos)">
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
        <button class="btn" style="background-color: #70c98c; color: white;" onclick="generarYVaciar()">Confirmar y Descargar</button>
      </div>
    </div>
  </div>
</div>

<script>
function mostrarModalDireccion() {
  var modal = new bootstrap.Modal(document.getElementById('modalDireccion'));
  modal.show();
}

function toggleCamposPago(valor) {
  document.getElementById('campos-tarjeta').style.display = valor === 'tarjeta' ? 'block' : 'none';
}

function generarYVaciar() {
  const direccion = document.getElementById('direccion').value.trim();
  const metodo = document.getElementById('metodo').value;

  if (!direccion) {
    Swal.fire({
      icon: 'warning',
      title: 'Dirección requerida',
      text: 'Por favor ingresa la dirección de entrega.',
      confirmButtonColor: '#d4af37'
    });
    return;
  }

  if (metodo === 'tarjeta') {
    const num = document.getElementById('numeroTarjeta').value.trim();
    const fecha = document.getElementById('fechaExp').value.trim();
    const cvv = document.getElementById('cvv').value.trim();
    const errores = [];

    if (!/^[0-9]{16}$/.test(num)) errores.push("Número de tarjeta inválido.");
    if (!/^\d{2}\/\d{2}$/.test(fecha)) errores.push("Formato de fecha inválido. Usa MM/AA.");
    if (!/^\d{3}$/.test(cvv)) errores.push("CVV inválido.");

    if (errores.length > 0) {
      Swal.fire({
        icon: 'error',
        title: 'Datos inválidos',
        html: errores.join("<br>"),
        confirmButtonColor: '#d33'
      });
      return;
    }
  }

  generarPDF();
  setTimeout(() => {
    window.location.href = "vaciar.php";
  }, 1000);
}
</script>

</body>
</html>