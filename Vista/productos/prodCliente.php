<?php

$objProductos = new ABMProducto();
$productos = $objProductos->buscar(null);
?>

<h1 class="text-center mb-4">Listado de Productos</h1>
<div class="row">
  <?php foreach ($productos as $producto) { ?>
    <div class="col-md-4 mb-4">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title"><?php echo htmlspecialchars($producto->getpronombre()); ?></h5>
          <p class="card-text"><?php echo htmlspecialchars($producto->getprodetalle()); ?></p>
          <p class="card-text"><strong>Stock:</strong> <?php echo htmlspecialchars($producto->getprocantstock()); ?></p>
          <a class="btn btn-success">Agregar al carrito</a>
        </div>
      </div>
    </div>
  <?php } ?>
</div>