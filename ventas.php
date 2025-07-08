<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

$conexion = new mysqli("localhost", "root", "", "punto_venta");
date_default_timezone_set('America/Mexico_City');

// Inicializar carrito
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Agregar producto al carrito
if (isset($_POST['agregar'])) {
    $id_producto = $_POST['id_producto'];
    $cantidad = $_POST['cantidad'];

    $encontrado = false;
    foreach ($_SESSION['carrito'] as &$item) {
        if ($item['id'] == $id_producto) {
            $item['cantidad'] += $cantidad;
            $encontrado = true;
            break;
        }
    }

    if (!$encontrado) {
        $_SESSION['carrito'][] = [
            'id' => $id_producto,
            'cantidad' => $cantidad
        ];
    }

    header("Location: ventas.php");
    exit;
}

// Confirmar venta
if (isset($_POST['confirmar'])) {
    $ventas_realizadas = 0;
    foreach ($_SESSION['carrito'] as $item) {
        $id = $item['id'];
        $cantidad = $item['cantidad'];

        $res = $conexion->query("SELECT precio, cantidad FROM productos WHERE id = $id");
        if ($res && $prod = $res->fetch_assoc()) {
            if ($prod['cantidad'] >= $cantidad) {
                $precio = $prod['precio'];
                $total = $precio * $cantidad;

                $conexion->query("INSERT INTO ventas (id_producto, cantidad_vendida, precio_unitario, total) 
                                  VALUES ($id, $cantidad, $precio, $total)");
                $conexion->query("UPDATE productos SET cantidad = cantidad - $cantidad WHERE id = $id");

                $ventas_realizadas++;
            }
        }
    }

    $_SESSION['carrito'] = [];
    $mensaje = "✅ Se registraron $ventas_realizadas ventas correctamente.";
    $tipo_mensaje = "success";
}

// Vaciar carrito
if (isset($_GET['vaciar'])) {
    $_SESSION['carrito'] = [];
    header("Location: ventas.php");
    exit;
}

$productos = $conexion->query("SELECT * FROM productos");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito de Ventas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-dark bg-dark px-3">
    <span class="navbar-brand"><i class="fas fa-cash-register"></i> Punto de Venta</span>
    <div class="d-flex flex-wrap gap-2">
        <a href="resumen_ventas.php?periodo=dia" class="btn btn-outline-light btn-sm">
            <i class="fas fa-calendar-day"></i> Día
        </a>
        <a href="resumen_ventas.php?periodo=semana" class="btn btn-outline-light btn-sm">
            <i class="fas fa-calendar-week"></i> Semana
        </a>
        <a href="resumen_ventas.php?periodo=mes" class="btn btn-outline-light btn-sm">
            <i class="fas fa-calendar-alt"></i> Mes
        </a>
        <a href="principal.php" class="btn btn-outline-light btn-sm">
            <i class="fas fa-home"></i> Panel
        </a>
        <a href="logout.php" class="btn btn-outline-danger btn-sm">
            <i class="fas fa-sign-out-alt"></i> Salir
        </a>
    </div>
</nav>

<div class="container py-5">
    <h3 class="mb-4 text-success"><i class="fas fa-shopping-cart"></i> Carrito de Ventas</h3>

    <?php if (isset($mensaje)): ?>
        <div class="alert alert-<?= $tipo_mensaje ?>"><?= $mensaje ?></div>
    <?php endif; ?>

    <!-- Agregar al carrito -->
    <form method="post" class="row g-3 mb-4">
        <div class="col-md-5">
            <label class="form-label">Producto</label>
            <select name="id_producto" class="form-select" required>
                <option value="" disabled selected>Selecciona producto</option>
                <?php while ($p = $productos->fetch_assoc()): ?>
                    <option value="<?= $p['id'] ?>"><?= $p['nombre'] ?> (Stock: <?= $p['cantidad'] ?>)</option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Cantidad</label>
            <input type="number" name="cantidad" class="form-control" min="1" required>
        </div>
        <div class="col-md-4 d-flex align-items-end">
            <button name="agregar" type="submit" class="btn btn-primary w-100">
                <i class="fas fa-plus"></i> Agregar al Carrito
            </button>
        </div>
    </form>

    <!-- Carrito -->
    <form method="post">
        <div class="card shadow">
            <div class="card-header bg-primary text-white d-flex justify-content-between">
                <strong><i class="fas fa-list"></i> Productos en Carrito</strong>
                <span><?= count($_SESSION['carrito']) ?> producto(s)</span>
            </div>
            <div class="card-body p-0">
                <?php if (count($_SESSION['carrito']) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Producto</th>
                                <th>Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($_SESSION['carrito'] as $item):
                                $id = $item['id'];
                                $res = $conexion->query("SELECT nombre FROM productos WHERE id = $id");
                                $nombre = $res->fetch_assoc()['nombre'] ?? 'Desconocido';
                            ?>
                            <tr>
                                <td><?= $id ?></td>
                                <td><?= htmlspecialchars($nombre) ?></td>
                                <td><?= $item['cantidad'] ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="text-end p-3 d-flex justify-content-end flex-wrap gap-2">
                    <button name="confirmar" type="submit" class="btn btn-success">
                        <i class="fas fa-check-circle"></i> Confirmar Venta
                    </button>
                    <a href="ventas.php?vaciar=1" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Vaciar Carrito
                    </a>
                </div>
                <?php else: ?>
                    <div class="p-4 text-center text-muted">
                        <i class="fas fa-info-circle"></i> No hay productos en el carrito.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </form>
</div>
</body>
</html>
