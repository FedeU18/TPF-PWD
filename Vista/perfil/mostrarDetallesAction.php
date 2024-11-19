<?php 

include_once "../../config.php";
include_once "../../estructura/headerSeguro.php";

// Obtener el ID del usuario desde la sesión
$idUsuario = $session->getUsuario();


?>
<h1 class="text-center mb-4">Detalles de la compra</h1>
<table class="table table-striped">
    <thead>
      <tr>
        <th>Producto</th>
        <th>Detalle</th>
        <th>Cantidad</th>
        
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
            
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>