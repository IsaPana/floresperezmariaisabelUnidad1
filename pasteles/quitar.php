<?php
session_start();

if (isset($_POST['index'])) {
  $i = $_POST['index'];
  if (isset($_SESSION['carrito'][$i])) {
    unset($_SESSION['carrito'][$i]);
    $_SESSION['carrito'] = array_values($_SESSION['carrito']); // Reindexar
  }
}

header("Location: compras.php");
exit();
