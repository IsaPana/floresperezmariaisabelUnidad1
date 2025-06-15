<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sección en Mantenimiento - Sabor y Arte</title>
  <link rel="icon" href="img/logo.png" type="image/png" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <style>
    body {
      background-color: #A8D5BA;
      font-family: 'Segoe UI', sans-serif;
      text-align: center;
      padding: 60px 15px;
    }

    .contenedor-mantenimiento {
      max-width: 700px;
      width: 100%;
      margin: auto;
      background: white;
      padding: 40px 25px;
      border-radius: 15px;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
      border: 3px dashed #d4af37;
    }

    .contenedor-mantenimiento h1 {
      font-size: 1.8rem;
      color: #d89e00;
      margin-bottom: 20px;
    }

    .contenedor-mantenimiento p {
      font-size: 1.1rem;
      color: #444;
    }

.contenedor-mantenimiento img {
  max-width: 190px;
  height: auto;
  margin-bottom: 20px;
  border-radius: 12px;
}


    .btn-volver {
      background-color: #70c98c;
      color: white;
      padding: 10px 25px;
      border-radius: 10px;
      text-decoration: none;
      font-weight: bold;
      display: inline-block;
    }

    .btn-volver:hover {
      background-color: #5bb37d;
    }

    @media (max-width: 576px) {
      .contenedor-mantenimiento {
        padding: 30px 15px;
      }

      .contenedor-mantenimiento h1 {
        font-size: 1.5rem;
      }

      .contenedor-mantenimiento p {
        font-size: 1rem;
      }
    }
  </style>
</head>

<body>
  <div class="contenedor-mantenimiento animate__animated animate__fadeIn">
   <img src="img/pinguino-construccion.gif" alt="GIF de mantenimiento">
    <h1>¡Oops! Esta sección está en mantenimiento</h1>
    <p>Estamos trabajando para mejorar esta sección. <br> Vuelve pronto para descubrir nuevas sorpresas de <strong>Sabor y Arte</strong>.</p>
    <a href="inicio.php" class="btn-volver mt-4">Volver al inicio</a>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
