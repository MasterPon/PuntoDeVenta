<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$usuario = $_SESSION['usuario'];

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "punto_venta");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener el correo del usuario desde la base de datos
$stmt = $conexion->prepare("SELECT email FROM usuarios WHERE usuario = ?");
$stmt->bind_param("s", $usuario);
$stmt->execute();
$resultado = $stmt->get_result();
$email = '';

if ($fila = $resultado->fetch_assoc()) {
    $email = $fila['email'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Perfil de Usuario</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-dark bg-dark">
  <div class="container-fluid">
    <a href="index.php" class="navbar-brand">
      <i class="fas fa-store"></i> Punto de Venta
    </a>
    <div class="ms-auto">
      <a href="logout.php" class="btn btn-outline-danger">
        <i class="fas fa-sign-out-alt"></i> Cerrar sesión
      </a>
    </div>
  </div>
</nav>

<!-- Contenido -->
<div class="container pt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-body text-center">
          <i class="fas fa-user-circle fa-5x text-secondary mb-3"></i>
          <h3 class="text-secondary mb-3">Perfil del Usuario</h3>
          <p class="text-muted"><strong>Nombre de usuario:</strong> <?php echo htmlspecialchars($usuario); ?></p>
          <p class="text-muted"><strong>Correo electrónico:</strong> <?php echo htmlspecialchars($email); ?></p>
          <a href="index.php" class="btn btn-primary mt-3">
            <i class="fas fa-arrow-left"></i> Volver al panel
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
