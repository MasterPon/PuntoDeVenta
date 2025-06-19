<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $conexion = new mysqli("localhost", "root", "", "punto_venta");
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];

    // Manejo de imagen
    $nombreImagen = null;
    if (!empty($_FILES['imagen']['name'])) {
        $carpeta = "imagenes/";
        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0777, true);
        }
        $nombreImagen = uniqid() . "_" . basename($_FILES["imagen"]["name"]);
        move_uploaded_file($_FILES["imagen"]["tmp_name"], $carpeta . $nombreImagen);
    }

    // Guardar producto
    $stmt = $conexion->prepare("INSERT INTO productos (nombre, descripcion, precio, cantidad, imagen) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("ssdis", $nombre, $descripcion, $precio, $cantidad, $nombreImagen);    $stmt->execute();

    header("Location: inventario.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Agregar Producto</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
  <h2 class="mb-4">Agregar Nuevo Producto</h2>

  <form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label class="form-label">Nombre:</label>
      <input type="text" name="nombre" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Descripción:</label>
      <textarea name="descripcion" class="form-control" required></textarea>
    </div>

    <div class="mb-3">
      <label class="form-label">Precio:</label>
      <input type="number" step="0.01" name="precio" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Cantidad:</label>
      <input type="number" name="cantidad" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Imagen del producto:</label>
      <input type="file" name="imagen" class="form-control" accept="image/*">
    </div>

    <button type="submit" class="btn btn-success">Guardar</button>
    <a href="inventario.php" class="btn btn-secondary">Cancelar</a>
  </form>
</div>
</body>
</html>
