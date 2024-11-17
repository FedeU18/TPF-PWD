<?php

include_once "../../config.php";
$titulo = "Carrito de compras";
include_once "../../estructura/headerSeguro.php";

$session = new Session();
$carrito = $session->obtenerProductosCarrito();

$objProducto = new ABMProducto();
?>

<h1 class="text-center mb-4">Carrito de Compras</h1>

<?php if (empty($carrito)): ?>
  <div class="alert alert-info">Tu carrito está vacío.</div>
<?php else: ?>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Producto</th>
        <th>Detalle</th>
        <th>Cantidad</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($carrito as $idProducto => $cantidad): ?>
        <?php
        $producto = $objProducto->buscar(['idproducto' => $idProducto])[0];
        ?>
        <tr>
          <td><?php echo htmlspecialchars($producto->getpronombre()); ?></td>
          <td><?php echo htmlspecialchars($producto->getprodetalle()); ?></td>
          <td><?php echo htmlspecialchars($cantidad); ?></td>
          <td>
            <form action="../productos/actionManejoCarrito.php" method="post" class="d-inline">
              <input type="hidden" name="accion" value="eliminarProducto">
              <input type="hidden" name="idproducto" value="<?php echo $idProducto; ?>">
              <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php endif; ?>

<?php include_once "../../estructura/footer.php"; ?>