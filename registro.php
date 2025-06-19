<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Crear Cuenta</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">

  <div class="card shadow w-100" style="max-width: 400px;">
    <div class="card-body">
      <h3 class="text-center text-primary mb-4">Crear Usuario</h3>

      <?php if (isset($_SESSION['registro_error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['registro_error'] ?></div>
        <?php unset($_SESSION['registro_error']); ?>
      <?php endif; ?>

      <form action="guardar_usuario.php" method="POST">
        <div class="mb-3">
          <label for="usuario" class="form-label">Usuario</label>
          <input type="text" name="usuario" id="usuario" class="form-control" required>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Contraseña</label>
          <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <div class="mb-3">
          <label for="confirmar" class="form-label">Confirmar Contraseña</label>
          <input type="password" name="confirmar" id="confirmar" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100 fw-bold">
          <i class="bi bi-person-plus-fill me-2"></i> Registrarse
        </button>

        <div class="mt-3 text-center">
          <a href="index.php" class="text-decoration-none">Volver al login</a>
        </div>
      </form>
    </div>
  </div>

</body>
</html>