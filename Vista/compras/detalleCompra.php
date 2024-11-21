<?php
include_once "../../config.php";
$titulo = "Detalle de Compra";
include_once "../../estructura/headerSeguro.php";

if (!in_array(3, $rol)) {
  $mensaje = "Acceso denegado. Solo los Depositores pueden acceder.";
  echo "<script>location.href = '../perfil/index.php?msg=" . urlencode($mensaje) . "';</script>";
  exit; // detener ejecución
}
$datos = data_submitted();
// Verificar que se haya proporcionado el ID de la compra
$idCompra = isset($datos['idcompra']) ? intval($datos['idcompra']) : 0;

if ($idCompra <= 0) {
  echo "<div class='alert alert-danger'>ID de compra no válido.</div>";
  include_once "../../estructura/footer.php";
  exit;
}
// Crear instancias de ABMCompraItem y ABMProducto
$objAbmCompraItem = new ABMCompraItem();
$objAbmProducto = new ABMProducto();

// Buscar ítems relacionados con la compra
$param = ['idcompra' => $idCompra];
$listadoItems = $objAbmCompraItem->buscar($param);

$precioTotal = 0; // Variable para calcular el precio total
?>

<div class="container mt-4">
  <h2>Detalle de Compra #<?php echo $idCompra; ?></h2>

  <?php if (!empty($listadoItems)): ?>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Producto</th>
          <th>Precio Unitario</th>
          <th>Cantidad</th>
          <th>Subtotal</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($listadoItems as $item): ?>
          <?php
          // Obtener información del producto
          $producto = $objAbmProducto->buscar(['idproducto' => $item->getIdproducto()]);
          if (!empty($producto)) {
            $producto = $producto[0]; // Obtener el primer resultado
            $nombreProducto = $producto->getPronombre();
            $precioUnitario = $producto->getPrecio();
            $cantidad = $item->getCicantidad();
            $subtotal = $precioUnitario * $cantidad;
            $precioTotal += $subtotal;
          } else {
            $nombreProducto = "Producto no encontrado";
            $precioUnitario = $cantidad = $subtotal = 0;
          }
          ?>
          <tr>
            <td><?php echo $nombreProducto; ?></td>
            <td><?php echo "$" . number_format($precioUnitario, 2); ?></td>
            <td><?php echo $cantidad; ?></td>
            <td><?php echo "$" . number_format($subtotal, 2); ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
      <tfoot>
        <tr>
          <th colspan="3" class="text-end">Total</th>
          <th><?php echo "$" . number_format($precioTotal, 2); ?></th>
        </tr>
      </tfoot>
    </table>
  <?php else: ?>
    <div class="alert alert-warning">No hay ítems para esta compra.</div>
  <?php endif; ?>

  <a href="compras.php" class="btn btn-secondary mt-3">Volver al Listado de Compras</a>
</div>

<?php
include_once "../../estructura/footer.php";
?>