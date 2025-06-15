<?php
session_start();
$_SESSION['carrito'] = [];
header("Location: compras.php");
exit;
