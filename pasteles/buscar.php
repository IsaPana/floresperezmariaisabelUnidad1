<?php
session_start();
include 'clases/class.conexion.php';
$conn = new Conexion();

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$busqueda = "";
if (isset($_GET['q'])) {
    $busqueda = $conn->real_escape_string($_GET['q']);
}

$sql = "SELECT nombre_producto, descripcion, precio FROM productos WHERE nombre_producto LIKE '%$busqueda%' OR descripcion LIKE '%$busqueda%'";
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultados de búsqueda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding: 30px;
            background-color: #f7f7f7;
        }
        .resultado {
            background-color: white;
            padding: 20px;
            border: 2px solid #A8D5BA;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .resultado h3 {
            color: #FF5733;
        }
        .resultado p {
            margin: 5px 0;
        }
        .btn-volver {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Resultados de búsqueda para: <strong><?php echo htmlspecialchars($busqueda); ?></strong></h1>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='resultado'>";
            echo "<h3>" . htmlspecialchars($row['nombre_producto']) . "</h3>";
            echo "<p><strong>Descripción:</strong> " . htmlspecialchars($row['descripcion']) . "</p>";
            echo "<p><strong>Precio:</strong> $" . htmlspecialchars($row['precio']) . "</p>";
            echo "</div>";
        }
    } else {
        echo "<p>No se encontraron resultados para tu búsqueda.</p>";
    }
    ?>

    <a href="inicio.php" class="btn btn-outline-success btn-volver">Volver al Inicio</a>
</div>

</body>
</html>

<?php
$conn->close();
?>
