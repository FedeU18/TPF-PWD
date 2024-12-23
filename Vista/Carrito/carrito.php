<?php
include_once "../../config.php";
$titulo = "Carrito de compras";
include_once "../../estructura/headerSeguro.php";

$session = new Session();
$carrito = $session->obtenerProductosCarrito();

if ($rol != 1) {
  $mensaje = "Acceso denegado. Solo los Depositores pueden acceder.";
  echo "<script>location.href = '../perfil/index.php?msg=" . urlencode($mensaje) . "';</script>";
  exit; // detener ejecución
}

$objProducto = new ABMProducto();
?>

<div id="mensajeError" class="mb-3"></div>
<div id="mensajeExito" class="mb-3"></div>

<?php if (empty($carrito)) { ?>
  <p>No hay productos en el carrito.</p>
<?php } else { ?>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Producto</th>
        <th>Precio</th>
        <th>Cantidad</th>
        <th>Subtotal</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($carrito as $idProducto => $cantidad) {
        $producto = $objProducto->buscar(['idproducto' => $idProducto])[0];
      ?>
        <tr>
          <td><?php echo htmlspecialchars($producto->getpronombre()); ?></td>
          <td><?php echo htmlspecialchars($producto->getprecio()); ?></td>
          <td id="cantidad-<?php echo $idProducto; ?>"><?php echo $cantidad; ?></td>
          <td id="subtotal-<?php echo $idProducto; ?>"><?php echo '$' . ($producto->getprecio() * $cantidad); ?></td>
          <td>
            <button class="btn btn-warning btn-sm reducir" data-idproducto="<?php echo $idProducto; ?>" data-precio="<?php echo $producto->getprecio(); ?>">Reducir</button>
            <button class="btn btn-danger btn-sm eliminar" data-idproducto="<?php echo $idProducto; ?>">Eliminar</button>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>

  <p><strong>Total: $<?php echo $session->precioTotal(); ?></strong></p>
  <form method="post" id="pagar">
    <input type="submit" class="btn btn-info" value="Ir a Pagar" />
  </form>
<?php } ?>

<script>
  $(document).ready(function() {
    // Enviar el formulario de pago mediante AJAX
    $("#pagar").submit(function(event) {
      event.preventDefault();

      console.log("Formulario enviado");

      $.ajax({
        url: "pagar.php",
        type: "POST",
        dataType: "json",
        success: function(respuesta) {
          if (respuesta.success) {
            console.log("Redirigiendo a Stripe:", respuesta.url);
            window.location.href = respuesta.url;
          } else {
            console.error("Error al pagar:", respuesta.msg);
            $("#mensajeError").html('<div class="alert alert-danger">' + respuesta.msg + '</div>');
          }
        },
        error: function(xhr, status, error) {
          console.error("Error en AJAX:", xhr.responseText);
          alert("Error en la conexión al servidor.");
        }
      });
    });


    // Reducir cantidad
    $(".reducir").click(function() {
      var idProducto = $(this).data("idproducto");
      var precio = $(this).data("precio");

      $.ajax({
        url: "actionModificarCarrito.php",
        type: "POST",
        data: {
          accion: "reducirCantidad",
          idproducto: idProducto
        },
        dataType: "json",
        success: function(respuesta) {
          if (respuesta.success) {
            var nuevaCantidad = parseInt($("#cantidad-" + idProducto).text()) - 1;
            $("#cantidad-" + idProducto).text(nuevaCantidad);

            var nuevoSubtotal = precio * nuevaCantidad;
            $("#subtotal-" + idProducto).text('$' + nuevoSubtotal);

            $("p:contains('Total:')").html("<strong>Total: $" + respuesta.totalProductos + "</strong>");
            $("#mensajeExito").html('<div class="alert alert-info">' + respuesta.msg + '</div>');
          } else {
            $("#mensajeError").html('<div class="alert alert-danger">' + respuesta.msg + '</div>');
          }
        },
        error: function() {
          alert("Error en la conexión al servidor.");
        }
      });
    });

    // Eliminar del carrito
    $(".eliminar").click(function() {
      var idProducto = $(this).data("idproducto");

      $.ajax({
        url: "actionModificarCarrito.php",
        type: "POST",
        data: {
          accion: "eliminarDelCarrito",
          idproducto: idProducto
        },
        dataType: "json",
        success: function(respuesta) {
          if (respuesta.success) {
            $("button[data-idproducto='" + idProducto + "']").closest("tr").remove();
            $("p:contains('Total:')").html("<strong>Total: $" + respuesta.totalProductos + "</strong>");
            $("#mensajeExito").html('<div class="alert alert-info">' + respuesta.msg + '</div>');
          } else {
            $("#mensajeError").html('<div class="alert alert-danger">' + respuesta.msg + '</div>');
          }
        },
        error: function() {
          alert("Error en la conexión al servidor.");
        }
      });
    });
  });
</script>


<?php
include_once "../../estructura/footer.php";
