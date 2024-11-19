<?php
if (basename($_SERVER['PHP_SELF']) === 'prodAdmin.php') {
  header("Location: Productos.php");
  exit;
}
$objProductos = new ABMProducto();
$productos = $objProductos->buscar(null);
?>
<div class="table-responsive">
  <table class="table table-striped table-bordered">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Detalle</th>
        <th>Precio</th>
        <th>Stock</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($productos)) { ?>
        <?php foreach ($productos as $producto) { ?>
          <tr>
            <td><?php echo htmlspecialchars($producto->getidproducto()); ?></td>
            <td><?php echo htmlspecialchars($producto->getpronombre()); ?></td>
            <td><?php echo htmlspecialchars($producto->getprodetalle()); ?></td>
            <td>$<?php echo htmlspecialchars($producto->getprecio()); ?></td>
            <td><?php echo htmlspecialchars($producto->getprocantstock()); ?></td>
            <td>
              <a href="detalleProducto.php?id=<?php echo $producto->getidproducto(); ?>" class="btn btn-info btn-sm">Ver</a>
              <a href="editarProducto.php?id=<?php echo $producto->getidproducto(); ?>" class="btn btn-warning btn-sm">Editar</a>
              <a href="eliminarProducto.php?id=<?php echo $producto->getidproducto(); ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar este producto?');">Eliminar</a>
            </td>
          </tr>
        <?php } ?>
      <?php } else { ?>
        <tr>
          <td colspan="6" class="text-center">No se encontraron productos.</td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>