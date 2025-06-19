<?php
session_start();

// Conectar a la base de datos
$conexion = new mysqli("localhost", "root", "", "punto_venta");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$usuario = $_POST['usuario'] ?? '';
$password = $_POST['password'] ?? '';

$stmt = $conexion->prepare("SELECT * FROM usuarios WHERE usuario = ?");
$stmt->bind_param("s", $usuario);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 1) {
    $usuarioData = $resultado->fetch_assoc();

    // Verificamos la contraseña encriptada
    if (password_verify($password, $usuarioData['password'])) {
        $_SESSION['usuario'] = $usuarioData['usuario'];
        header("Location: principal.php"); // o tu página principal
        exit;
    } else {
        $_SESSION['error'] = "Usuario o contraseña incorrectos.";
    }
} else {
    $_SESSION['error'] = "Usuario o contraseña incorrectos.";
}

header("Location: index.php");
exit;
