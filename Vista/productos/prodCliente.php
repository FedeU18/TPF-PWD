<?php
if (basename($_SERVER['PHP_SELF']) === 'prodCliente.php') {
  header("Location: Productos.php");
  exit;
}

$objProductos = new ABMProducto();
$productos = $objProductos->buscar(null);
// Verificar si se accede directamente
?>

<div id="mensajeError" class="mb-3"></div>
<div id="mensajeExito" class="mb-3"></div>

<div>
  <p>Productos agregados al carrito: <?php echo $session->totalProductosCarrito(); ?></p>
  <a href="../Carrito/carrito.php">Ver Carrito</a>
</div>
<div class="row">
  <?php foreach ($productos as $producto) { ?>
    <div class="col-md-4 mb-4">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title"><?php echo htmlspecialchars($producto->getpronombre()); ?></h5>
          <p class="card-text"><?php echo htmlspecialchars($producto->getprodetalle()); ?></p>
          <p class="card-text"><strong>Precio:</strong> $<?php echo htmlspecialchars($producto->getprecio()); ?></p>
          <p class="card-text"><strong>Stock:</strong> <?php echo htmlspecialchars($producto->getprocantstock()); ?></p>
          <form id="formAgregarCarrito" name="formAgregarCarrito" method="post">
            <input type="hidden" id="accion" name="accion" value="agregarCarrito">
            <input type="hidden" id="idproducto" name="idproducto" value="<?php echo $producto->getidproducto(); ?>">
            <input type="hidden" id="cantidad" name="cantidad" value="1">
            <button type="button" class="btn btn-success btnAgregarCarrito">Agregar al carrito</button>
          </form>
        </div>
      </div>
    </div>
  <?php } ?>
</div>
<script>
  $(document).ready(function() {
    $(".btnAgregarCarrito").click(function(e) {
      e.preventDefault();

      // Obtener los datos del formulario
      let formulario = $(this).closest("form");
      let datosFormulario = {
        accion: formulario.find("#accion").val(),
        idproducto: formulario.find("#idproducto").val(),
        cantidad: formulario.find("#cantidad").val(),
      };

      // Validar que el ID del producto exista
      if (!datosFormulario.idproducto) {
        $("#mensajeError").html(
          '<div class="alert alert-danger">ID de producto no válido</div>'
        );
        return;
      }

      // Enviar datos mediante AJAX
      $.ajax({
        url: "actionManejoCarrito.php",
        type: "POST",
        data: datosFormulario,
        dataType: "json",
        success: function(respuesta) {
          if (respuesta.success) {
            $("#mensajeExito").html(
              '<div class="alert alert-info">' + respuesta.msg + '</div>'
            );

            // Actualizar el contador de productos en el carrito
            $("p:contains('Productos agregados al carrito')").html(
              "Productos agregados al carrito: " + respuesta.totalProductos
            );
          } else {
            $("#mensajeError").html(
              '<div class="alert alert-danger">Error: ' + respuesta.msg + '</div>'
            );
          }
        },
        error: function() {
          alert("Error en la conexión al servidor.");
        },
      });
    });
  });
</script>