<?php
session_start();
$usuario = $_POST['usuario'] ?? '';
$password = $_POST['password'] ?? '';
$confirmar = $_POST['confirmar'] ?? '';

if ($password !== $confirmar) {
    $_SESSION['registro_error'] = "Las contraseñas no coinciden.";
    header("Location: registro.php");
    exit;
}

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "punto_venta");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Verificar si el usuario ya existe
$stmt = $conexion->prepare("SELECT * FROM usuarios WHERE usuario = ?");
$stmt->bind_param("s", $usuario);
$stmt->execute();
$resultado = $stmt->get_result();
if ($resultado->num_rows > 0) {
    $_SESSION['registro_error'] = "El usuario ya existe.";
    header("Location: registro.php");
    exit;
}

// Insertar nuevo usuario
$hash = password_hash($password, PASSWORD_DEFAULT);
$stmt = $conexion->prepare("INSERT INTO usuarios (usuario, password) VALUES (?, ?)");
$stmt->bind_param("ss", $usuario, $hash);
$stmt->execute();

$_SESSION['registro_exito'] = "Usuario creado con éxito. Ya puedes iniciar sesión.";
header("Location: index.php");
exit;