<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

$conexion = new mysqli("localhost", "root", "", "punto_venta");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id_producto'], $_POST['cantidad_nueva'])) {
    $id_producto = intval($_POST['id_producto']);
    $cantidad_nueva = intval($_POST['cantidad_nueva']);
    $stmt = $conexion->prepare("UPDATE productos SET cantidad = ? WHERE id = ?");
    $stmt->bind_param("ii", $cantidad_nueva, $id_producto);
    $stmt->execute();
    header("Location: inventario.php");
    exit;
}

$productos = null;
$id_buscar = $_GET['buscar_id'] ?? '';

if ($id_buscar !== '') {
    $id_buscar = intval($id_buscar);
    $stmt = $conexion->prepare("SELECT * FROM productos WHERE id = ?");
    $stmt->bind_param("i", $id_buscar);
    $stmt->execute();
    $result = $stmt->get_result();
    $productos = $result;
} else {
    $productos = $conexion->query("SELECT * FROM productos");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Inventario</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <style>
    body {
      background: #f8f9fa;
    }
    header {
      background: rgb(78, 96, 124);
      color: white;
      padding: 1.5rem 0;
      margin-bottom: 2rem;
      border-radius: 0.5rem;
      box-shadow: 0 4px 12px rgb(13 110 253 / 0.25);
    }
    table.table {
      border-radius: 0.5rem;
      overflow: hidden;
      box-shadow: 0 0.125rem 0.25rem rgb(0 0 0 / 0.075);
      background: white;
    }
    table.table thead {
      background-color: #0d6efd;
      color: white;
    }
    table.table tbody tr:hover {
      background-color: #e9f0ff;
      transition: background-color 0.3s ease;
    }
    .btn-sm {
      min-width: 70px;
    }
    .input-cantidad {
      max-width: 80px;
    }
    .img-thumbnail {
      border-radius: 0.375rem;
    }
    form.search-form input[type="search"] {
      border-top-right-radius: 0;
      border-bottom-right-radius: 0;
    }
    form.search-form button {
      border-top-left-radius: 0;
      border-bottom-left-radius: 0;
    }
  </style>
</head>
<body>
  <div class="container">
    <header class="text-center">
      <h2>Gestión de Inventario</h2>
    </header>

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
      <a href="producto_alta.php" class="btn btn-primary shadow-sm">
        <i class="fas fa-plus me-2"></i>Agregar Producto
      </a>

      <form method="GET" action="inventario.php" class="d-flex search-form" role="search" style="max-width: 320px; flex-grow: 1;">
        <input
          class="form-control"
          type="search"
          name="buscar_id"
          placeholder="Buscar por ID"
          aria-label="Buscar por ID"
          value="<?= htmlspecialchars($id_buscar) ?>"
          pattern="\d*"
        />
        <button class="btn btn-outline-light border border-primary" type="submit" title="Buscar">
          <i class="fas fa-search"></i>
        </button>
        <?php if ($id_buscar !== ''): ?>
          <a href="inventario.php" class="btn btn-outline-danger ms-2" title="Limpiar búsqueda">
            <i class="fas fa-times"></i>
          </a>
        <?php endif; ?>
      </form>
    </div>
 <a href="principal.php" class="btn btn-secondary shadow-sm">
    <i class="fas fa-arrow-left me-2"></i>Regresar a Principal
  </a>
    <div class="table-responsive shadow-sm rounded">
      <table class="table table-bordered table-hover align-middle mb-0">
        <thead>
          <tr>
            <th scope="col" class="text-center">ID</th>
            <th scope="col" class="text-center" style="width: 90px;">Imagen</th>
            <th scope="col">Nombre</th>
            <th scope="col">Descripción</th>
            <th scope="col" class="text-end">Precio</th>
            <th scope="col" class="text-center" style="width: 140px;">Cantidad</th>
            <th scope="col" class="text-center" style="width: 130px;">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($productos && $productos->num_rows > 0): ?>
            <?php while ($row = $productos->fetch_assoc()): ?>
            <tr>
              <td class="text-center"><?= $row['id'] ?></td>
              <td class="text-center">
                <?php if ($row['imagen'] && file_exists("imagenes/" . $row['imagen'])): ?>
                  <img src="imagenes/<?= htmlspecialchars($row['imagen']) ?>" alt="Imagen" class="img-thumbnail" style="max-width: 70px; max-height: 70px;" />
                <?php else: ?>
                  <span class="text-muted fst-italic small">Sin imagen</span>
                <?php endif; ?>
              </td>
              <td><?= htmlspecialchars($row['nombre']) ?></td>
              <td><?= htmlspecialchars($row['descripcion']) ?></td>
              <td class="text-end">$<?= number_format($row['precio'], 2) ?></td>
              <td class="text-center">
                <form method="POST" class="d-flex justify-content-center align-items-center gap-2 m-0">
                  <input type="hidden" name="id_producto" value="<?= $row['id'] ?>" />
                  <input
                    type="number"
                    name="cantidad_nueva"
                    value="<?= $row['cantidad'] ?>"
                    min="0"
                    class="form-control form-control-sm input-cantidad"
                    required
                  />
                  <button type="submit" class="btn btn-success btn-sm" title="Actualizar cantidad">
                    <i class="fas fa-check"></i>
                  </button>
                </form>
              </td>
              <td class="text-center" style="width: 130px;">
                <a href="producto_editar.php?id=<?= $row['id'] ?>" 
                   class="btn btn-warning btn-sm me-3" 
                   title="Editar producto" 
                   data-bs-toggle="tooltip" 
                   data-bs-placement="top">
                  <i class="fas fa-edit"></i>
                </a>
                <a href="producto_eliminar.php?id=<?= $row['id'] ?>" 
                   class="btn btn-danger btn-sm" 
                   onclick="return confirm('¿Eliminar este producto?')" 
                   title="Eliminar producto" 
                   data-bs-toggle="tooltip" 
                   data-bs-placement="top">
                  <i class="fas fa-trash"></i>
                </a>
              </td>
            </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="7" class="text-center fst-italic text-muted py-4">No se encontraron productos.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
  </script>
</body>
</html>
