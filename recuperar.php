<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

$alerta = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];

    include 'clases/class.conexion.php';
    $conn = new Conexion();

    if ($conn->connect_error) {
        $alerta = '<div class="alert alert-danger fade show alerta-fija" role="alert">
        Error de conexión a la base de datos.
        </div>';
    } else {
        $stmt = $conn->prepare("SELECT * FROM registro WHERE correo = ?");
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $alerta = '<div class="alert alert-danger fade show alerta-fija" role="alert">
            Correo no registrado. Por favor, ingrese el correo con el que se registró.
            </div>';
        } else {
            $token = bin2hex(random_bytes(50));

            $stmt = $conn->prepare("UPDATE registro SET token_recuperacion = ? WHERE correo = ?");
            $stmt->bind_param("ss", $token, $correo);
            $stmt->execute();

            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'mariaisabelfp175@gmail.com';
                $mail->Password   = 'dsubkxoyeecejrgc';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

                $mail->setFrom('mariaisabelfp175@gmail.com', 'Sabor y Arte');
                $mail->addAddress($correo);

                $mail->isHTML(true);
                $mail->Subject = '=?UTF-8?B?' . base64_encode('🔐 Restablece tu contraseña con Sabor y Arte') . '?=';

                $mail->Body = '
                <!DOCTYPE html>
                <html lang="es">
                <head>
                  <meta charset="UTF-8">
                  <style>
                    .container {
                      font-family: Arial, sans-serif;
                      background: linear-gradient(135deg, #eafaf1, #d3f3e0);
                      padding: 25px;
                      border-radius: 10px;
                      border: 1px solid #ccc;
                      max-width: 600px;
                      margin: auto;
                      text-align: center;
                      color: #333;
                    }
                    .btn {
                      background-color: #A8D5BA;
                      color: #000;
                      padding: 12px 20px;
                      text-decoration: none;
                      border-radius: 30px;
                      border: 2px solid #d4af37;
                      font-weight: bold;
                      display: inline-block;
                      margin-top: 25px;
                    }
                    .logo {
                      max-width: 90px;
                      margin-bottom: 10px;
                    }
                    .extra-img {
                      width: 100px;
                      margin-top: 10px;
                    }
                    .footer {
                      font-size: 12px;
                      color: #777;
                      margin-top: 30px;
                    }
                  </style>
                </head>
                <body>
                  <div class="container">
                    <img src="https://devisa.mx/pasteles/img/logo.png" class="logo" alt="Logo Sabor y Arte">
                    <img src="https://cdn-icons-png.flaticon.com/512/5957/5957120.png" class="extra-img" alt="Recuperación de contraseña">
                    <h2>¿Olvidaste tu contraseña?</h2>
                    <p>Hola, recibimos una solicitud para restablecer tu contraseña.</p>
                    <p>Haz clic en el siguiente botón para establecer una nueva:</p>
                    <a class="btn" href="https://devisa.mx/pasteles/restablecer.php?token=' . $token . '">Restablecer contraseña</a>
                    <p class="footer">Si no solicitaste este cambio, puedes ignorar este mensaje.</p>
                  </div>
                </body>
                </html>';

                $mail->send();
                $alerta = '<div class="alert alert-success fade show alerta-fija" role="alert">
                Correo de recuperación enviado con éxito.
                </div>';
            } catch (Exception $e) {
                $alerta = '<div class="alert alert-danger fade show alerta-fija" role="alert">
                Error al enviar el correo: ' . $mail->ErrorInfo . '
                </div>';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Recuperar Contraseña</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" href="img/logo.png" type="image/png" />
  <link rel="stylesheet" href="css/index.css" />
  <link rel="stylesheet" href="css/sesion.css" />
  <style>
    .alerta-fija {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1050;
        opacity: 1;
        transition: opacity 0.5s ease-out;
    }
    .alerta-fija.hide {
        opacity: 0;
        transition: opacity 0.5s ease-out;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #A8D5BA; border-bottom: 3px solid #d4af37; height: 90px;">
  <a class="navbar-brand" href="sesion.php">
      <img src="img/logo.png" alt="Logo" width="80" height="85">
  </a>
</nav>

<!-- Mostrar alerta -->
<?php if (!empty($alerta)) { echo $alerta; } ?>

<!-- Formulario -->
<div id="contenedor">
    <div id="contenedorcentrado">
        <div id="login">
            <h2 class="titulo">Recupera tu cuenta</h2>

            <form id="login-form" action="#" method="POST">
                <h5 class="subtitulo">Introduce tu correo electrónico para buscar tu cuenta.</h5>
                <label for="correo">&nbsp;</label>
                <input type="email" id="correo" name="correo" placeholder="ejemplo@gmail.com" required>
                <br>
                <div class="d-flex justify-content-between mt-3">
                    <a href="sesion.php" class="btn border-2 border-warning text-warning w-50 rounded-pill">Cancelar</a>
                    <button type="submit" class="btn border-2 border-warning text-warning w-50 rounded-pill">Buscar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    setTimeout(function() {
        let alerta = document.querySelector('.alerta-fija');
        if(alerta){
            alerta.classList.add('hide');
            setTimeout(function() {
                alerta.remove();
            }, 500);
        }
    }, 8000);
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
