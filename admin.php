<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

$usuario = $_SESSION['usuario'];
require 'conexion.php';

// Eliminar usuario
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: admin.php");
    exit;
}

// Obtener usuarios
$result = $conn->query("SELECT id, usuario, email FROM usuarios ORDER BY id");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Administrar Usuarios - Punto de Venta</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- Navbar (igual que el principal) -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <span class="navbar-brand">
      <i class="fas fa-store"></i> Punto de Venta
    </span>
    <div class="ms-auto">
      <span class="navbar-text text-white me-3">
        <i class="fas fa-user"></i> <?php echo htmlspecialchars($usuario); ?>
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
<div class="container mt-5">
  <h2 class="mb-4 text-center text-secondary">Administración de Usuarios</h2>

  <div class="table-responsive shadow-sm rounded">
    <table class="table table-hover table-bordered align-middle bg-white">
      <thead class="table-dark text-center">
        <tr>
          <th>ID</th>
          <th>Usuario</th>
          <th>Email</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody class="text-center">
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['usuario']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td>
              <a href="admin.php?eliminar=<?php echo $row['id']; ?>" 
                 class="btn btn-sm btn-danger" 
                 onclick="return confirm('¿Estás seguro de eliminar este usuario?');">
                <i class="fas fa-trash-alt"></i> Eliminar
              </a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>

  <div class="text-center mt-4">
    <a href="principal.php" class="btn btn-secondary">
      <i class="fas fa-arrow-left"></i> Volver al Panel Principal
    </a>
  </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
