<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}
$conexion = new mysqli("localhost", "root", "", "punto_venta");
$id = $_GET['id'] ?? null;

if ($id) {
    $conexion->query("DELETE FROM productos WHERE id = $id");
}

header("Location: inventario.php");
exit;
