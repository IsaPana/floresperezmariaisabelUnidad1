<?php
session_start();

// Palabra clave buscada
$busqueda = isset($_GET['q']) ? strtolower(trim($_GET['q'])) : "";

// Diccionario de redirecciones
$redirecciones = [
    "chocolate" => "pasteles.php#chocolates",
    "fresa" => "pasteles.php#terciopelorojo",
    "mango" => "pasteles.php#mango",
    "tres leches" => "pasteles.php#tresleches",
    "fruta" => "pasteles.php#frutas",
    "fiesta" => "pasteles.php#fiestas",
    "globos" => "globo.php#globos",
    "globo" => "globo.php#globos",
    "vela" => "accesorio.php#velas",
    "velas" => "accesorio.php#velas",
    "utensilios" => "accesorio.php#utensilios",
    "utensilio" => "accesorio.php#utensilios",
    "accesorio" => "accesorio.php",
    "pastel" => "pasteles.php",
    "buzon" => "buzon.php"
];

// Buscar si alguna palabra clave coincide
foreach ($redirecciones as $palabra => $destino) {
    if (strpos($busqueda, $palabra) !== false) {
        header("Location: $destino");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Sin resultados</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      padding: 40px;
      background-color: #fdfdfd;
      font-family: 'Segoe UI', sans-serif;
      text-align: center;
    }
    h2 {
      color: #333;
      margin-bottom: 20px;
    }
    p {
      font-size: 1.1rem;
      color: #666;
    }
    .btn-volver {
      margin-top: 20px;
      border: 2px solid #A8D5BA;
      color: #A8D5BA;
      background: white;
      border-radius: 10px;
      padding: 8px 25px;
      font-weight: bold;
    }
    .btn-volver:hover {
      background-color: #A8D5BA;
      color: white;
    }
  </style>
</head>
<body>

  <h2>Resultados de búsqueda para: <strong><?php echo htmlspecialchars($busqueda); ?></strong></h2>
  <p>No se encontraron coincidencias directas. Intenta con otra palabra clave como: <em>pastel</em>, <em>mango</em>, <em>globos</em>, <em>vela</em>, etc.</p>

  <a href="inicio.php" class="btn btn-volver">Volver al inicio</a>

</body>
</html>
