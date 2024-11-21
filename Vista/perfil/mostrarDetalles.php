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
            'subtotal' => $item->getCiCantidad() * $producto[0]->getprecio() // Cálculo del subtotal
        ];
    }
}
?>


  <div class="container mt-5">
    <h1 class="text-center">Detalle de la Compra #<?= htmlspecialchars($idCompra); ?></h1>
    <div id="toast" class="toast"></div>

    <div class="table-responsive mt-4">
      <table class="table table-striped table-bordered table-hover">
        <thead class="thead-dark">
          <tr>
            <th scope="col">Producto</th>
            <th scope="col">Descripción</th>
            <th scope="col">Cantidad</th>
            <th scope="col">Precio Unitario</th>
            <th scope="col">Subtotal</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($listaProductos)): ?>
            <?php 
            $total = 0;
            foreach ($listaProductos as $detalle): 
                $producto = $detalle['producto'];
                $cantidad = $detalle['cantidad'];
                $subtotal = $detalle['subtotal'];
                $total += $subtotal;
            ?>
              <tr>
                <td><?= htmlspecialchars($producto->getProNombre()); ?></td>
                <td><?= htmlspecialchars($producto->getProDetalle()); ?></td>
                <td><?= htmlspecialchars($cantidad); ?></td>
                <td>$<?= number_format($producto->getprecio(), 2, ',', '.'); ?></td>
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

    <form action="cancelarCompra.php" mb-3>
    <button class="btn btn-danger btn-sm cancerlar-compra" id="btn-cancelarCompra" data-id="<?php echo $idCompra; ?>">Cancelar Compra</button>
    </form>

    <div class="text-center mt-4">
      <a href="index.php" class="btn btn-secondary">Volver al Historial</a>
    </div>
  </div>

  <script>
      function showToast(message, type = "success") {
        const toast = document.getElementById("toast");
        
        // Aplicar clase según el tipo de mensaje
        toast.className = `toast ${type} show`;
        toast.textContent = message;
        
        // Ocultar el mensaje después de 3 segundos
        setTimeout(() => {
          toast.className = "toast";
        }, 3000);
      }


    $(document).ready(function(){
      $('.cancerlar-compra').click(function(e) {
        e.preventDefault();
        $("mensaje").empty();

        let idCompra =  $(this).data('id')
        if (confirm('¿Estás seguro de que deseas cancelar la compra?')) {
        $.ajax({
          type: 'POST',
          url: 'cancelarCompra.php',
          data: { id: idCompra },
          dataType: 'json',
          success: function(respuesta) {
            console.log(respuesta)
            if (respuesta.success) {
              showToast(respuesta.message, "success");
              
            } else {
              showToast(respuesta.message, "error");
            }
          },
          error: function(error) {
            console.log(error)
            showToast("Error en la conexión al servidor.", "error");
          }
        });
      }
    });
});
  </script>

<?php include_once "../../estructura/footer.php"; ?>