<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}
$usuario = $_SESSION['usuario'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel Principal - Punto de Venta</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background: #f4f6f9;
    }
    .card {
      border-radius: 15px;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
    }
    .navbar-brand, .navbar-text {
      font-weight: bold;
    }
    .btn {
      transition: 0.3s ease;
    }
    .btn:hover {
      transform: scale(1.05);
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
  <div class="container-fluid">
    <span class="navbar-brand">
      <i class="fas fa-store me-2"></i> Punto de Venta
    </span>
    <div class="ms-auto d-flex align-items-center">
      <span class="navbar-text text-white me-3">
        <i class="fas fa-user me-1"></i> <?php echo htmlspecialchars($usuario); ?>
      </span>
      <a href="perfil.php" class="btn btn-outline-light me-2">
        <i class="fas fa-user-cog"></i> Perfil
      </a>
      <a href="logout.php" class="btn btn-outline-danger">
        <i class="fas fa-sign-out-alt"></i> Cerrar sesión
      </a>
    </div>
  </div>
</nav>

<!-- Contenido principal -->
<div class="container py-5">
  <h1 class="text-center text-secondary mb-5 fw-bold">Bienvenido al Sistema</h1>

  <div class="row justify-content-center g-4">
    <!-- Inventario -->
    <div class="col-md-4">
      <div class="card text-center shadow-sm bg-white">
        <div class="card-body py-4">
          <i class="fas fa-boxes fa-3x mb-3 text-primary"></i>
          <h5 class="card-title text-secondary">Inventario</h5>
          <p class="card-text text-muted">Consulta y administra productos.</p>
          <a href="inventario.php" class="btn btn-outline-primary w-75">
            <i class="fas fa-arrow-right"></i> Ir a Inventario
          </a>
        </div>
      </div>
    </div>

    <!-- Ventas -->
    <div class="col-md-4">
      <div class="card text-center shadow-sm bg-white">
        <div class="card-body py-4">
          <i class="fas fa-cash-register fa-3x mb-3 text-success"></i>
          <h5 class="card-title text-secondary">Ventas</h5>
          <p class="card-text text-muted">Registra y consulta ventas.</p>
          <a href="ventas.php" class="btn btn-outline-success w-75">
            <i class="fas fa-arrow-right"></i> Ir a Ventas
          </a>
        </div>
      </div>
    </div>

    <!-- Admin -->
    <div class="col-md-4">
      <div class="card text-center shadow-sm bg-white">
        <div class="card-body py-4">
          <i class="fas fa-user-shield fa-3x mb-3 text-danger"></i>
          <h5 class="card-title text-secondary">Admin</h5>
          <p class="card-text text-muted">Gestiona usuarios y ajustes.</p>
          <a href="admin.php" class="btn btn-outline-danger w-75">
            <i class="fas fa-arrow-right"></i> Ir a Admin
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
