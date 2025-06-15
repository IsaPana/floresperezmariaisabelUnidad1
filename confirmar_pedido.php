<?php
session_start();
$producto = $_SESSION['producto'] ?? 'Producto no definido';
$precio = $_SESSION['precio'] ?? '0.00';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Confirmar Pedido</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f7f7f7;
      padding: 40px;
      font-family: 'Segoe UI', sans-serif;
    }
    .formulario-envio {
      background-color: #fff;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
      max-width: 600px;
      margin: 0 auto;
      border: 2px solid #A8D5BA;
    }
    .formulario-envio h2 {
      margin-bottom: 20px;
    }
    .btn-completar {
      background-color: #d4af37;
      border: none;
      padding: 10px 25px;
      font-weight: bold;
      color: #fff;
      border-radius: 8px;
    }
    .btn-completar:hover {
      background-color: #b48f2e;
    }
  </style>
</head>
<body>
  <!-- Prueba GIt -->

<div class="formulario-envio">
  <h2>Confirmar Pedido</h2>
  <p><strong>Producto:</strong> <?php echo htmlspecialchars($producto); ?></p>
  <p><strong>Precio:</strong> $<?php echo htmlspecialchars($precio); ?> MXN</p>

  <form action="generar_pdf.php" method="POST">
    <div class="mb-3">
      <label for="nombre" class="form-label">Nombre completo</label>
      <input type="text" class="form-control" id="nombre" name="nombre" required>
    </div>
    <div class="mb-3">
      <label for="direccion" class="form-label">Dirección completa</label>
      <textarea class="form-control" id="direccion" name="direccion" rows="3" required></textarea>
    </div>
    <div class="mb-3">
      <label for="telefono" class="form-label">Teléfono de contacto</label>
      <input type="tel" class="form-control" id="telefono" name="telefono" required>
    </div>
    <div class="mb-3">
      <label for="comentarios" class="form-label">Comentarios para el repartidor (opcional)</label>
      <textarea class="form-control" id="comentarios" name="comentarios" rows="2"></textarea>
    </div>
    <button type="submit" class="btn-completar">Confirmar y Descargar PDF</button>
  </form>
</div>

</body>
</html>
