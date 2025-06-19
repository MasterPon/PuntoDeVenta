<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Iniciar Sesión</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f8f9fa;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .login-card {
      border-radius: 1rem;
      box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.1);
      padding: 2rem;
      background-color: #ffffff;
      width: 100%;
      max-width: 400px;
    }
    .form-title {
      font-weight: bold;
      text-align: center;
      margin-bottom: 1.5rem;
    }
  </style>
</head>
<body>
  <div class="login-card">
    <h3 class="form-title">Iniciar Sesión</h3>
    <form action="validar_login.php" method="POST">
      <div class="mb-3">
        <label for="usuario" class="form-label">Usuario o Email</label>
        <input type="text" class="form-control" id="usuario" name="usuario" required autofocus>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Contraseña</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>
      <div class="d-grid">
        <button type="submit" class="btn btn-primary">Ingresar</button>
      </div>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
