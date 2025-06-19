<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Login Animado</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    @keyframes pulseButton {
      0% { transform: scale(1); }
      50% { transform: scale(1.07); }
      100% { transform: scale(1); }
    }

    .btn-animated {
      animation: pulseButton 1s ease-in-out infinite;
      animation-delay: 0s;
      animation-iteration-count: infinite;
      animation-timing-function: ease-in-out;
    }

    /* Pausar animación y reiniciar cada 4 segundos */
    .btn-animated {
      animation-play-state: paused;
    }

    /* Trampa con JavaScript para "reactivar" cada 4s */
  </style>
</head>
<body class="bg-info-subtle d-flex align-items-center justify-content-center vh-100">

  <div class="card border-0 shadow-lg w-100" style="max-width: 400px;">
    <div class="card-body">
      <h3 class="text-center mb-4 text-info-emphasis">🎯 Acceso al Sistema</h3>

      <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <?= $_SESSION['error'] ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
        <?php unset($_SESSION['error']); ?>
      <?php endif; ?>

      <form action="login.php" method="POST">
        <div class="mb-3">
          <label for="usuario" class="form-label">Usuario</label>
          <div class="input-group">
            <span class="input-group-text bg-info-subtle"><i class="bi bi-person-fill text-info"></i></span>
            <input type="text" name="usuario" id="usuario" class="form-control" required>
          </div>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Contraseña</label>
          <div class="input-group">
            <span class="input-group-text bg-info-subtle"><i class="bi bi-lock-fill text-info"></i></span>
            <input type="password" name="password" id="password" class="form-control" required>
          </div>
        </div>
<div class="mt-3 text-center">
  <a href="registro.php" class="text-info">¿No tienes cuenta? Crea una aquí</a>
</div>
        <button type="submit" class="btn btn-info w-100 text-white fw-bold btn-animated" id="animatedBtn">
          <i class="bi bi-box-arrow-in-right me-2"></i> Entrar
        </button>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Activar animación cada 4 segundos durante 1 segundo
    setInterval(() => {
      const btn = document.getElementById('animatedBtn');
      btn.style.animationPlayState = 'running';
      setTimeout(() => {
        btn.style.animationPlayState = 'paused';
      }, 1000); // duración de la animación
    }, 4000);
  </script>
</body>
</html>
