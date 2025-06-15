<?php
include 'clases/class.conexion.php';
$conn = new Conexion();

$alerta = '';
$redireccion = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar reCAPTCHA
    $captcha = $_POST['g-recaptcha-response'];
    if (!$captcha) {
        $alerta = "<script>
        Toast.fire({
            icon: 'error',
            title: 'Por favor, verifica que no eres un robot.'
        });
        </script>";
    } else {
        $secret = '6LcwclwrAAAAAMJywnNYPQvgFQFNZ8hkXwJUqKcZ';
        $respuesta = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha");
        $resultado = json_decode($respuesta);

        if (!$resultado->success) {
            $alerta = "<script>
            Toast.fire({
                icon: 'error',
                title: 'Verificación fallida. Intenta de nuevo.'
            });
            </script>";
        } else {
            // Si pasó el captcha, continuar con registro
            $nombre = trim($_POST['nombre']);
            $apellido = trim($_POST['apellido']);
            $nusuario = trim($_POST['nusuario']);
            $correo = trim($_POST['correo']);
            $contra_sin_hash = trim($_POST['contra']);

            $longitud = strlen($contra_sin_hash) >= 8;
            $mayuscula = preg_match('/[A-Z]/', $contra_sin_hash);
            $numero = preg_match('/[0-9]/', $contra_sin_hash);
            $especial = preg_match('/[\W]/', $contra_sin_hash);
            $no_secuencial = !preg_match('/(?:012|123|234|345|456|567|678|789|890)/', $contra_sin_hash);

            if (!$longitud || !$mayuscula || !$numero || !$especial || !$no_secuencial) {
                $alerta = "<script>
                Toast.fire({
                    icon: 'error',
                    title: 'La contraseña debe tener mínimo 8 caracteres, una mayúscula, un número, un carácter especial y no contener secuencias numéricas.'
                });
                </script>";
            }
            else if (!preg_match('/^[a-zA-Z0-9]+$/', $nusuario)) {
                $alerta = "<script>
                Toast.fire({
                    icon: 'error',
                    title: 'El nombre de usuario solo debe contener letras y números.'
                });
                </script>";
            } else {
                $stmt = $conn->prepare("SELECT * FROM registro WHERE nusuario = ?");
                $stmt->bind_param("s", $nusuario);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $alerta = "<script>
                    Toast.fire({
                        icon: 'error',
                        title: 'El nombre de usuario ya está registrado.'
                    });
                    </script>";
                } else {
                    $contra = password_hash($contra_sin_hash, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("INSERT INTO registro (nombre, apellido, nusuario, correo, contra) VALUES (?, ?, ?, ?, ?)");
                    $stmt->bind_param("sssss", $nombre, $apellido, $nusuario, $correo, $contra);

                    if ($stmt->execute()) {
                        $alerta = "<script>
                        Toast.fire({
                            icon: 'success',
                            title: 'Registro exitoso.'
                        });
                        </script>";
                        $redireccion = "<script>
                        setTimeout(function(){
                            window.location.href = 'sesion.php';
                        }, 3000);
                        </script>";
                        $_POST = array();
                    } else {
                        $alerta = "<script>
                        Toast.fire({
                            icon: 'error',
                            title: 'Error al registrar.'
                        });
                        </script>";
                    }
                }
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
  <title>REGISTRARSE</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" href="img/logo.png" type="image/png" />
  <link rel="stylesheet" href="css/index.css" />
  <link rel="stylesheet" href="css/sesion.css" />
  <link rel="stylesheet" href="css/registro.css" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <script>
    const Toast = Swal.mixin({
      toast: true,
      position: "top-end",
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
      }
    });
  </script>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #A8D5BA; border-bottom: 3px solid #d4af37; height: 90px;">
  <a class="navbar-brand" href="index.php">
    <img src="img/logo.png" alt="Logo" width="80" height="85">
  </a>
</nav>

<?php 
  if (!empty($alerta)) { echo $alerta; }
  if (!empty($redireccion)) { echo $redireccion; }
?>

<div id="contenedor">
  <div id="contenedorcentrado">
    <div id="login">
      <h2 class="titulo">REGÍSTRATE</h2>
      <form id="registro-form" action="" method="POST">
        <input type="text" id="nombre" name="nombre" placeholder="Nombre" required value="<?php echo isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : ''; ?>">
        <input type="text" id="apellido" name="apellido" placeholder="Apellido" required value="<?php echo isset($_POST['apellido']) ? htmlspecialchars($_POST['apellido']) : ''; ?>">
        <input type="text" id="nusuario" name="nusuario" placeholder="Nombre de Usuario" required value="<?php echo isset($_POST['nusuario']) ? htmlspecialchars($_POST['nusuario']) : ''; ?>">
        <input type="email" id="correo" name="correo" placeholder="Correo electrónico" required value="<?php echo isset($_POST['correo']) ? htmlspecialchars($_POST['correo']) : ''; ?>">
        <input type="password" id="contra" name="contra" placeholder="Contraseña" required>
        <div class="g-recaptcha my-3" data-sitekey="6LcwclwrAAAAABJq6EPYPNMPg88sQMwm562FzdHW"></div>
        <center><button type="submit">Registrarse</button></center>
      </form>
      <div class="mt-3 text-center">
        <a href="sesion.php">¿Ya tienes una cuenta? Iniciar sesión</a>
      </div>
    </div>
  </div>
</div>

</body>
</html>
