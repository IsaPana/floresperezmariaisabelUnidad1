<?php
include 'clases/class.conexion.php';
$conn = new Conexion();

$token = $_GET['token'] ?? null;
$alerta = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST['token'];
    $nueva_contra = password_hash($_POST['nueva_contra'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("UPDATE registro SET contra = ?, token_recuperacion = NULL WHERE token_recuperacion = ?");
    $stmt->bind_param("ss", $nueva_contra, $token);

    if ($stmt->execute()) {
        $alerta = '<div class="alert alert-success text-center">¡Contraseña actualizada con éxito!</div>';
    } else {
        $alerta = '<div class="alert alert-danger text-center">Error al actualizar la contraseña.</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Restablecer Contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #A8D5BA 0%, #E2F0CB 100%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .card {
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            background: white;
            width: 100%;
            max-width: 400px;
        }
        .btn-personalizado {
            border: 2px solid #d4af37;
            color: #d4af37;
            border-radius: 30px;
        }
        .btn-personalizado:hover {
            background-color: #d4af37;
            color: white;
        }
        .titulo {
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="card">
    <h2 class="titulo">Restablecer Contraseña</h2>

    <?php echo $alerta; ?>

    <?php if ($token): ?>
    <form method="POST">
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
        <div class="mb-3">
            <input type="password" class="form-control" id="nueva_contra" name="nueva_contra" placeholder="Nueva Contraseña" required>
        </div>
        <button type="submit" class="btn btn-personalizado w-100">Actualizar Contraseña</button>
    </form>
    <?php else: ?>
    <div class="alert alert-danger text-center">Token inválido o expirado.</div>
    <?php endif; ?>
</div>

</body>
</html>
