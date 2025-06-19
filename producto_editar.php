<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

$conexion = new mysqli("localhost", "root", "", "punto_venta");
$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: inventario.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];
    $imagenActual = $_POST['imagen_actual']; // Imagen anterior

    $nombreImagen = $imagenActual;

    // Si el usuario subió una nueva imagen
    if (!empty($_FILES['imagen']['name'])) {
        $carpeta = "imagenes/";
        if (!is_dir($carpeta)) mkdir($carpeta);

        // Eliminar la imagen anterior si existe
        if ($imagenActual && file_exists($carpeta . $imagenActual)) {
            unlink($carpeta . $imagenActual);
        }

        // Guardar nueva imagen
        $nombreImagen = uniqid() . "_" . basename($_FILES["imagen"]["name"]);
        move_uploaded_file($_FILES["imagen"]["tmp_name"], $carpeta . $nombreImagen);
    }

    // Actualizar base de datos
    $stmt = $conexion->prepare("UPDATE productos SET nombre=?, descripcion=?, precio=?, cantidad=?, imagen=? WHERE id=?");
    $stmt->bind_param("ssdiss", $nombre, $descripcion, $precio, $cantidad, $nombreImagen, $id);
    $stmt->execute();

    header("Location: inventario.php");
    exit;
} else {
    $result = $conexion->query("SELECT * FROM productos WHERE id = $id");
    $producto = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Producto</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
  <h2 class="mb-4">Editar Producto</h2>
  <form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="imagen_actual" value="<?= htmlspecialchars($producto['imagen']) ?>">

    <div class="mb-3">
      <label class="form-label">Nombre:</label>
      <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($producto['nombre']) ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Descripción:</label>
      <textarea name="descripcion" class="form-control" required><?= htmlspecialchars($producto['descripcion']) ?></textarea>
    </div>

    <div class="mb-3">
      <label class="form-label">Precio:</label>
      <input type="number" step="0.01" name="precio" class="form-control" value="<?= $producto['precio'] ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Cantidad:</label>
      <input type="number" name="cantidad" class="form-control" value="<?= $producto['cantidad'] ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Imagen actual:</label><br>
      <?php if ($producto['imagen']): ?>
        <img src="imagenes/<?= htmlspecialchars($producto['imagen']) ?>" width="100" class="img-thumbnail mb-2">
      <?php else: ?>
        <p class="text-muted">Sin imagen</p>
      <?php endif; ?>
    </div>

    <div class="mb-3">
      <label class="form-label">Nueva imagen (opcional):</label>
      <input type="file" name="imagen" class="form-control" accept="image/*">
    </div>

    <button type="submit" class="btn btn-primary">Actualizar</button>
    <a href="inventario.php" class="btn btn-secondary">Cancelar</a>
  </form>
</div>
</body>
</html>
