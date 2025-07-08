<?php
session_start();

$conexion = new mysqli("localhost", "root", "", "punto_venta");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener y limpiar datos
$usuario = trim($_POST['usuario'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirmar_password = $_POST['confirmar_password'] ?? '';

if (empty($usuario) || empty($email) || empty($password) || empty($confirmar_password)) {
    $_SESSION['registro_error'] = "Todos los campos son obligatorios.";
    header("Location: registro.php");
    exit;
}

if ($password !== $confirmar_password) {
    $_SESSION['registro_error'] = "Las contraseñas no coinciden.";
    header("Location: registro.php");
    exit;
}

// Verificar si el usuario o email ya existen
$stmt = $conexion->prepare("SELECT id FROM usuarios WHERE usuario = ? OR email = ?");
$stmt->bind_param("ss", $usuario, $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $_SESSION['registro_error'] = "El usuario o correo ya están registrados.";
    header("Location: registro.php");
    exit;
}

// Encriptar contraseña
$password_hash = password_hash($password, PASSWORD_BCRYPT);

// Insertar nuevo usuario
$stmt = $conexion->prepare("INSERT INTO usuarios (usuario, password, email) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $usuario, $password_hash, $email);

if ($stmt->execute()) {
    $_SESSION['registro_exito'] = "Usuario registrado exitosamente.";
    header("Location: registro.php");
} else {
    $_SESSION['registro_error'] = "Error al registrar el usuario.";
    header("Location: registro.php");
}
exit;
?>
