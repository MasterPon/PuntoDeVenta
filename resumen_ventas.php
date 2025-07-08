<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

$conexion = new mysqli("localhost", "root", "", "punto_venta");

date_default_timezone_set('America/Mexico_City');
$periodo = $_GET['periodo'] ?? 'dia';

switch ($periodo) {
    case 'semana':
        $inicio = date('Y-m-d', strtotime('monday this week')) . " 00:00:00";
        $fin = date('Y-m-d', strtotime('sunday this week')) . " 23:59:59";
        $titulo = "Resumen Semanal";
        break;
    case 'mes':
        $inicio = date('Y-m-01') . " 00:00:00";
        $fin = date('Y-m-t') . " 23:59:59";
        $titulo = "Resumen Mensual";
        break;
    default:
        $inicio = date('Y-m-d') . " 00:00:00";
        $fin = date('Y-m-d') . " 23:59:59";
        $titulo = "Resumen del Día";
        break;
}

$sql = "SELECT v.id, p.nombre, v.cantidad_vendida, v.precio_unitario, v.total, v.fecha_venta
        FROM ventas v
        JOIN productos p ON v.id_producto = p.id
        WHERE v.fecha_venta BETWEEN '$inicio' AND '$fin'
        ORDER BY v.fecha_venta DESC";

$resultado = $conexion->query($sql);
$ganancia_total = 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title><?= $titulo ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-primary"><?= $titulo ?></h3>
        <a href="ventas.php" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left"></i> Volver a Ventas
        </a>
    </div>

    <?php if ($resultado->num_rows > 0): ?>
    <div class="table-responsive">
        <table class="table table-striped table-hover bg-white">
            <thead class="table-secondary">
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Total</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($fila = $resultado->fetch_assoc()): 
                    $ganancia_total += $fila['total'];
                ?>
                <tr>
                    <td><?= htmlspecialchars($fila['nombre']) ?></td>
                    <td><?= $fila['cantidad_vendida'] ?></td>
                    <td>$<?= number_format($fila['precio_unitario'], 2) ?></td>
                    <td>$<?= number_format($fila['total'], 2) ?></td>
                    <td><?= $fila['fecha_venta'] ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
            <tfoot>
                <tr class="table-success">
                    <td colspan="3"><strong>Total de Ganancias</strong></td>
                    <td colspan="2"><strong>$<?= number_format($ganancia_total, 2) ?></strong></td>
                </tr>
            </tfoot>
        </table>
    </div>
    <?php else: ?>
        <div class="alert alert-warning text-center">
            No hay ventas registradas para este período.
        </div>
    <?php endif; ?>
</div>
</body>
</html>
