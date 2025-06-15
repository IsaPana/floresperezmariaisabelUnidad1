<?php
session_start(); 
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sabor y Arte</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" href="img/logo.png" type="image/png" />
  <link rel="stylesheet" href="css/inicio.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<!-- Código de Chatbase -->
<script>
(function(){
  if(!window.chatbase || window.chatbase("getState") !== "initialized"){
    window.chatbase = (...arguments) => {
      if(!window.chatbase.q){ window.chatbase.q = [] }
      window.chatbase.q.push(arguments)
    };
    window.chatbase = new Proxy(window.chatbase, {
      get(target, prop){
        if(prop === "q"){ return target.q }
        return (...args) => target(prop, ...args)
      }
    });
  }
  const onLoad = function(){
    const script = document.createElement("script");
    script.src = "https://www.chatbase.co/embed.min.js";
    script.id = "TMVGyL6oce8olDjTkYxVO";  // Tu ID único
    script.domain = "www.chatbase.co";
    document.body.appendChild(script);
  };
  if(document.readyState === "complete"){
    onLoad();
  } else {
    window.addEventListener("load", onLoad);
  }
})();
</script>

<body>
<!-- Navbar -->
<nav class="navbar navbar-light custom-navbar fixed-top">
  <div class="container-fluid d-flex justify-content-between align-items-center">
    <a class="navbar-brand" href="#">
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
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
  </div>

  <!-- Offcanvas Menú -->
  <div class="offcanvas offcanvas-end custom-offcanvas" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
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
      <?php if (isset($_SESSION['usuario'])) echo htmlspecialchars($_SESSION['usuario']); ?>
    </a>
  </div>
</div>


        <!-- Menú Navegación -->
        <ul class="navbar-nav justify-content-start flex-grow-1 pe-3">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="pastelesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
            <a class="nav-link dropdown-toggle" href="#" id="accesoriosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Accesorios
            </a>
            <ul class="dropdown-menu" aria-labelledby="accesoriosDropdown">
              <li><a class="dropdown-item" href="accesorio.php#velas">Velas</a></li>
              <li><a class="dropdown-item" href="accesorio.php#utensilios">Utensilios en Promo</a></li>
            </ul>
          </li>
           <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="novedadesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Novedades
            </a>
            <ul class="dropdown-menu" aria-labelledby="novedadesDropdown">
              <li><a class="dropdown-item" href="globo.php#globos">Globos</a></li>
            </ul>
          </li>
          <li class="nav-item">
         <a class="nav-link" href="mantenimiento.php">Decoraciones</a> 
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="buzon.php" id="novedadesDropdown" role="button"  aria-expanded="false">
              Buzon
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#" onclick="mostrarMapaSitio()">Mapa del Sitio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#" onclick="mostrarAyuda()">Ayuda</a>
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
<!-- Fin Navbar -->
<!-- Categorías --><br><br><br>
<section class="seccion-categorias">
  <h2>Compra por categorías</h2>
  <div class="contenedor-categorias">
    <a href="pasteles.php#chocolates" class="categoria">
      <div class="circulo">
        <img src="img/chocolate.png" alt="Chocolate">
      </div>
      <p>Chocolate</p>
    </a>
    <a href="pasteles.php#terciopelorojo" class="categoria">
      <div class="circulo">
        <img src="img/fresa.png" alt="Terciopelo Rojo">
      </div>
      <p>Terciopelo Rojo</p>
    </a>
    <a href="pasteles.php#mango" class="categoria">
      <div class="circulo">
        <img src="img/mangos.png" alt="Mango">
      </div>
      <p>Mango</p>
    </a>
    <a href="pasteles.php#fiestas" class="categoria">
      <div class="circulo">
        <img src="img/fiestas.png" alt="Para Fiestas">
      </div>
      <p>Para Fiestas</p>
    </a>
  </div>
</section>

<BR><BR><BR>
<!-- Servicios -->
<section class="seccion-servicios">
  <div class="contenedor-servicios">
    <div class="servicio">
      <img src="img/moto.png" alt="Envío a domicilio">
      <p><span>ENVÍO</span><br>A DOMICILIO</p>
    </div>
    <div class="servicio">
      <img src="img/tarjeta.png" alt="Pagos con tarjeta">
      <p><span>PAGOS CON</span><br>TARJETA</p>
    </div>
    <div class="servicio">
      <img src="img/descuento.png" alt="Descuentos Arte CLUB">
      <p><span>DESCUENTOS</span><br>ARTE CLUB</p>
    </div>
  </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function mostrarMapaSitio() {
  Swal.fire({
    title: '<div style="color: #333;">Mapa del Sitio</div>',
    html: `
    <div class="mapa-sitio-container">
      <div class="mapa-sitio-titulo">Sabor y Arte</div>
      <ul class="mapa-sitio-lista">
        <li>
          <span>Pasteles</span>
          <ul>
            <li><a href="pasteles.php#chocolates">Chocolates</a></li>
            <li><a href="pasteles.php#frutas">Frutas</a></li>
            <li><a href="pasteles.php#tresleches">Tres Leches</a></li>
            <li><a href="pasteles.php#mango">Mango</a></li>
            <li><a href="pasteles.php#terciopelorojo">Terciopelo Rojo</a></li>
            <li><a href="pasteles.php#fiestas">Fiestas</a></li>
          </ul>
        </li>
        <li>
          <span>Accesorios</span>
          <ul>
            <li><a href="accesorio.php#velas">Velas</a></li>
            <li><a href="accesorio.php#utensilios">Utensilios en Promo</a></li>
          </ul>
        </li>
        <li>
          <span>Novedades</span>
          <ul>
            <li><a href="globo.php#globos">Globos</a></li>
          </ul>
        </li>
        <li>
          <span><a href="buzon.php">Buzón</a></span>
        </li>
      </ul>
    </div>
    `,
    showConfirmButton: true,
    confirmButtonText: 'Cerrar',
    confirmButtonColor: '#d4af37',
    background: '#B7E1CD',
    customClass: {
      popup: 'border-gold'
    }
  });
}
</script>
<script>
function mostrarAyuda() {
  Swal.fire({
    title: '¿Necesitas ayuda?',
    html: `
      <div style="text-align: left;">
        <p><strong>¿Cómo navegar en el sitio?</strong></p>
        <p>- Usa el menú para buscar productos: Pasteles, Accesorios y Novedades.</p>
        <p>- Usa el buscador para encontrar productos por nombre.</p>
        <p>- El <strong>Mapa del Sitio</strong> muestra todas las secciones disponibles.</p>
        <p>- El chatbot en la esquina inferior derecha te puede responder dudas.</p>
        <p><strong>¿Cómo contacto soporte?</strong></p>
        <p>- Escríbenos por WhatsApp o utiliza el buzón de comentarios.</p>
      </div>
    `,
    showConfirmButton: true,
    confirmButtonText: 'Entendido',
    confirmButtonColor: '#d4af37',
    background: '#B7E1CD',
    customClass: {
      popup: 'border-gold'
    }
  });
}
</script>
<style>
.swal2-popup.border-gold {
  border: 5px solid #FFD700;
  border-radius: 15px;
}
@import url('https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css');
</style>
<!-- Footer-->
<footer class="footer-new">
  <div class="footer-animation"></div> 
  <div class="footer-content">
    <div class="footer-column">
      <h4>Contacto</h4>
      <p>Lun-Sáb: 9:00 am a 7:00 pm</p>
      <p>WhatsApp: +52 844 2744584</p>
      <p>Correo: <strong> </strong></p>
    </div>
    <div class="footer-column">
      <h4>Legales</h4>
      <a href="#">Aviso de privacidad</a>
      <a href="#">Términos y condiciones</a>
      <a href="#">Preguntas frecuentes</a>
    </div>
    <div class="footer-column">
      <h4>Nosotros</h4>
      <a href="#">Nuestra historia</a>
      <a href="#">Responsabilidad social</a>
      <a href="#">Blog</a>
    </div>
<div class="footer-column">
  <h4>Buzón</h4>
  <form class="subscribe-form" method="POST" action="buzon.php">
    <textarea name="comentario" placeholder="Escribe tu comentario..." required></textarea>
    <button type="submit">Enviar</button>
  </form>
</div>
  </div>

  <div class="footer-bottom">
    <p>Sabor y Arte © 2025 Todos los derechos reservados.</p>
  </div>
</footer>


</body>
<!-- Modal de Contacto -->
<div class="modal fade" id="modalContacto" tabindex="-1" aria-labelledby="modalContactoLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content p-4">
      <div class="modal-header">
        <h5 class="modal-title fw-bold text-primary" id="modalContactoLabel">Contáctanos</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form method="POST" action="guardar_comentario.php">
        <div class="modal-body row g-3">
          <div class="col-md-6">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" placeholder="Tu nombre" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Teléfono</label>
            <input type="tel" name="telefono" class="form-control" placeholder="Tu teléfono" required>
          </div>
          <div class="col-12">
            <label class="form-label">Correo electrónico</label>
            <input type="email" name="correo" class="form-control" placeholder="tuemail@ejemplo.com" required>
          </div>
          <div class="col-12">
            <label class="form-label">Mensaje</label>
            <textarea name="mensaje" class="form-control" rows="3" placeholder="Escribe tu mensaje..." required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary w-100">Enviar</button>
        </div>
      </form>
    </div>
  </div>
</div>

</html>
