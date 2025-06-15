<?php
session_start();

// Limpiar valores recibidos
$nombre = isset($_GET['producto']) ? urldecode($_GET['producto']) : 'Producto';
$precio = isset($_GET['precio']) ? floatval(preg_replace('/[^0-9.]/', '', $_GET['precio'])) : 0;
$imagen = isset($_GET['imagen']) ? urldecode($_GET['imagen']) : 'img/default.png';
$descuento = isset($_GET['descuento']) ? intval($_GET['descuento']) : 0;

// Crear producto
$producto = [
    'nombre' => $nombre,
    'precio' => $precio,
    'imagen' => $imagen,
    'descuento' => $descuento
];

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}
$_SESSION['carrito'][] = $producto;

header('Location: compras.php');
exit();
