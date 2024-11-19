<?php

include_once "../../config.php";
include_once "../../estructura/headerSeguro.php";
$datos = data_submitted();

// Validar que se haya enviado un ID de compra
if (!isset($datos['idcompra']) || empty($datos['idcompra'])) {
    echo "No se especificó una compra.";
    exit;
}

$idCompra = intval($datos['idcompra']);

// Instanciar objetos necesarios
$objCompraItem = new ABMCompraItem();
$objProducto = new ABMProducto();

// Buscar los items de la compra
$compraItems = $objCompraItem->buscar(['idcompra' => $idCompra]);

// Crear lista para almacenar los detalles
$listaProductos = [];

// Obtener detalles de los productos
foreach ($compraItems as $item) {
    $producto = $objProducto->buscar(['idproducto' => $item->getIdProducto()]);
    if (!empty($producto)) {
        $listaProductos[] = [
            'producto' => $producto[0], // Producto encontrado
            'cantidad' => $item->getCiCantidad(), // Cantidad del producto
            // 'subtotal' => $item->getCiCantidad() * $item->getCiPrecioCompra() 
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detalle de Compra</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
</head>

<body>
  <div class="container mt-5">
    <h1 class="text-center">Detalle de la Compra #<?= htmlspecialchars($idCompra); ?></h1>

    <div class="table-responsive mt-4">
      <table class="table table-striped table-bordered table-hover">
        <thead class="thead-dark">
          <tr>
            <th scope="col">Producto</th>
            <th scope="col">Descripción</th>
            <th scope="col">Cantidad</th>
            <!-- <th scope="col">Precio Unitario</th>
            <th scope="col">Subtotal</th> -->
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($listaProductos)): ?>
            <?php 
            $total = 0;
            foreach ($listaProductos as $detalle): 
                $producto = $detalle['producto'];
                $cantidad = $detalle['cantidad'];
                // $subtotal = $detalle['subtotal'];
                // $total += $subtotal;
            ?>
              <tr>
                <td><?= htmlspecialchars($producto->getProNombre()); ?></td>
                <td><?= htmlspecialchars($producto->getProDetalle()); ?></td>
                <td><?= htmlspecialchars($cantidad); ?></td>
                <td>$<?= number_format($producto->getProPrecio(), 2, ',', '.'); ?></td>
                <td>$<?= number_format($subtotal, 2, ',', '.'); ?></td>
              </tr>
            <?php endforeach; ?>
            <tr>
              <td colspan="4" class="text-end"><strong>Total:</strong></td>
              <td><strong>$<?= number_format($total, 2, ',', '.'); ?></strong></td>
            </tr>
          <?php else: ?>
            <tr>
              <td colspan="5" class="text-center">No se encontraron productos en esta compra.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <div class="text-center mt-4">
      <a href="index.php" class="btn btn-secondary">Volver al Historial</a>
    </div>
  </div>
</body>

</html>
