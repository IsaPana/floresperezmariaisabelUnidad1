<?php
session_start();
include 'clases/class.conexion.php'; 

$conexion = new Conexion(); 

$alerta = ''; // Variable para guardar el script del Toast

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['nusuario'];
    $contrasena = $_POST['contra'];

    $sql = "SELECT * FROM registro WHERE nusuario = '$usuario'";
    $result = mysqli_query($conexion, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($contrasena, $row['contra'])) {
            // Login correcto
            $_SESSION['usuario'] = $usuario;
            header("Location: inicio.php");
            exit();
        } else {
            $alerta = "<script>
            Toast.fire({
                icon: 'error',
                title: 'Contraseña incorrecta.'
            });
            </script>";
        }
    } else {
        $alerta = "<script>
        Toast.fire({
            icon: 'error',
            title: 'Usuario no encontrado.'
        });
        </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>INICIAR SESIÓN</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" href="img/logo.png" type="image/png" />
  <link rel="stylesheet" href="css/index.css" />
  <link rel="stylesheet" href="css/sesion.css" />

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
      <img src="img/logo.png" alt="" width="80" height="85">
  </a>
</nav>

<!-- Mostrar Alerta (SweetAlert2) -->
<?php 
  if (!empty($alerta)) echo $alerta; 
?>

<div id="contenedor">
    <div id="contenedorcentrado">
        <div id="login">
            <h2 class="titulo">SABOR & ARTE</h2>
            <form id="login-form" action="" method="POST">
                <label for="nusuario">&nbsp;</label>
                <input type="text" id="nusuario" name="nusuario" placeholder="Usuario">
                
                <label for="contra">&nbsp;</label>
                <input type="password" id="contra" name="contra" placeholder="Contraseña">
                <br>
                <center>
                    <button type="submit" id="btn-login">Iniciar sesión</button>
                </center>
            </form>
            <a href="recuperar.php">¿Olvidé mi contraseña?</a>
        </div>
    </div>
</div>
<script>
document.getElementById('login-form').addEventListener('submit', function(event) {
    let usuario = document.getElementById('nusuario').value.trim();
    let contra = document.getElementById('contra').value.trim();

    if (usuario === '' && contra === '') {
        event.preventDefault();
        Swal.fire({
            icon: 'warning',
            title: 'Campos vacíos',
            text: 'Por favor, ingresa tu usuario y contraseña.',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        });
    } else if (usuario === '') {
        event.preventDefault();
        Swal.fire({
            icon: 'warning',
            title: 'Campo vacío',
            text: 'Por favor, ingresa tu usuario.',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        });
    } else if (contra === '') {
        event.preventDefault();
        Swal.fire({
            icon: 'warning',
            title: 'Campo vacío',
            text: 'Por favor, ingresa tu contraseña.',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        });
    }
});
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="mein.js"></script>
</body>
</html>
