<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registrar Usuario</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- Estilos personalizados -->
  <style>
    body {
      background: linear-gradient(135deg, #ACB6E5, #74ebd5);
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .register-card {
      animation: slideIn 0.7s ease-out;
      border-radius: 1rem;
      box-shadow: 0 0.75rem 2rem rgba(0, 0, 0, 0.2);
      padding: 2rem;
      background-color: #ffffff;
      width: 100%;
      max-width: 420px;
    }
    .form-title {
      font-weight: bold;
      text-align: center;
      margin-bottom: 1.5rem;
      color: #333;
    }
    .input-group-text {
      background-color: #f0f0f0;
      border: none;
    }
    .form-control:focus {
      box-shadow: none;
      border-color: #198754;
    }
    .btn-success {
      transition: background-color 0.3s;
    }
    .btn-success:hover {
      background-color: #146c43;
    }
    @keyframes slideIn {
      from { transform: translateY(-30px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }
    .footer-link {
      text-align: center;
      margin-top: 1rem;
    }
    .footer-link a {
      color: #198754;
      text-decoration: none;
      transition: color 0.3s;
    }
    .footer-link a:hover {
      color: #146c43;
    }
  </style>
</head>
<body>
  <div class="register-card">
    <h3 class="form-title"><i class="fas fa-user-plus"></i> Registrar Usuario</h3>

    <?php
    session_start();
    if (isset($_SESSION['registro_error'])) {
        echo '<div class="alert alert-danger"><i class="fas fa-exclamation-circle me-1"></i> ' . $_SESSION['registro_error'] . '</div>';
        unset($_SESSION['registro_error']);
    } elseif (isset($_SESSION['registro_exito'])) {
        echo '<div class="alert alert-success"><i class="fas fa-check-circle me-1"></i> ' . $_SESSION['registro_exito'] . '</div>';
        unset($_SESSION['registro_exito']);
    }
    ?>

    <form action="guardar_registro.php" method="POST">
      <div class="mb-3">
        <label for="usuario" class="form-label">Usuario</label>
        <div class="input-group">
          <span class="input-group-text"><i class="fas fa-user"></i></span>
          <input type="text" class="form-control" id="usuario" name="usuario" required>
        </div>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Correo electrónico</label>
        <div class="input-group">
          <span class="input-group-text"><i class="fas fa-envelope"></i></span>
          <input type="email" class="form-control" id="email" name="email" required>
        </div>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Contraseña</label>
        <div class="input-group">
          <span class="input-group-text"><i class="fas fa-lock"></i></span>
          <input type="password" class="form-control" id="password" name="password" required>
        </div>
      </div>
      <div class="mb-3">
        <label for="confirmar_password" class="form-label">Confirmar Contraseña</label>
        <div class="input-group">
          <span class="input-group-text"><i class="fas fa-lock"></i></span>
          <input type="password" class="form-control" id="confirmar_password" name="confirmar_password" required>
        </div>
      </div>
      <div class="d-grid">
        <button type="submit" class="btn btn-success">
          <i class="fas fa-user-check me-1"></i> Registrarse
        </button>
      </div>
    </form>

    <!-- Enlace hacia login -->
    <div class="footer-link mt-3">
      <i class="fas fa-sign-in-alt text-success me-2"></i>
      <a href="index.php">¿Ya tienes cuenta? <u>Inicia sesión aquí</u></a>
    </div>
  </div>

  <!-- Bootstrap y Font Awesome JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
