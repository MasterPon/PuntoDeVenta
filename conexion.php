<?php
$conn = new mysqli("localhost", "root", "", "punto_venta");

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
