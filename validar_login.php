<?php
session_start();

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "punto_venta");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$usuario_input = trim($_POST['usuario'] ?? '');
$password_input = $_POST['password'] ?? '';

// Buscar por usuario o correo
$sql = "SELECT * FROM usuarios WHERE usuario = ? OR email = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ss", $usuario_input, $usuario_input);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 1) {
    $usuario = $resultado->fetch_assoc();
    if (password_verify($password_input, $usuario['password'])) {
        $_SESSION['usuario'] = $usuario['usuario'];
        header("Location: principal.php");
        exit;
    } else {
        $_SESSION['error'] = "Contraseña incorrecta.";
    }
} else {
    $_SESSION['error'] = "Usuario no encontrado.";
}

header("Location: login.php");
exit;
?>
