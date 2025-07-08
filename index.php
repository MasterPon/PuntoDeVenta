<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Iniciar Sesión</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- Estilos personalizados -->
  <style>
    body {
      background: linear-gradient(135deg, #74ebd5, #ACB6E5);
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .login-card {
      animation: slideIn 0.7s ease-out;
      border-radius: 1rem;
      box-shadow: 0 0.75rem 2rem rgba(0, 0, 0, 0.2);
      padding: 2rem;
      background-color: #ffffff;
      width: 100%;
      max-width: 400px;
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
      border-color: #007bff;
    }
    .btn-primary {
      transition: background-color 0.3s;
    }
    .btn-primary:hover {
      background-color: #0056b3;
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
      color: #007bff;
      text-decoration: none;
      transition: color 0.3s;
    }
    .footer-link a:hover {
      color: #0056b3;
    }
  </style>
</head>
<body>
  <div class="login-card">
    <h3 class="form-title"><i class="fas fa-user-lock"></i> Iniciar Sesión</h3>

    <?php
    session_start();
    if (isset($_SESSION['error'])) {
        echo '<div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> ' . $_SESSION['error'] . '</div>';
        unset($_SESSION['error']);
    }
    ?>

    <form action="validar_login.php" method="POST">
      <div class="mb-3">
        <label for="usuario" class="form-label">Usuario o Email</label>
        <div class="input-group">
          <span class="input-group-text"><i class="fas fa-user"></i></span>
          <input type="text" class="form-control" id="usuario" name="usuario" required autofocus>
        </div>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Contraseña</label>
        <div class="input-group">
          <span class="input-group-text"><i class="fas fa-lock"></i></span>
          <input type="password" class="form-control" id="password" name="password" required>
        </div>
      </div>
      <div class="d-grid">
        <button type="submit" class="btn btn-primary">
          <i class="fas fa-sign-in-alt"></i> Ingresar
        </button>
      </div>
    </form>

    <div class="footer-link">
      <i class="fas fa-user-plus"></i>
      <a href="registro.php">¿No tienes cuenta? Regístrate</a>
    </div>
  </div>

  <!-- Bootstrap y Font Awesome JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
