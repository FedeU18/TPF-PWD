<?php
$titulo = "Nuevo Producto";

include_once "../../config.php";
include_once "../../estructura/headerSeguro.php";
if ($rol == 1) {
  $mensaje = "Acceso denegado.";
  echo "<script>location.href = '../perfil/index.php?msg=" . urlencode($mensaje) . "';</script>";
  exit; //detener ejec
}
?>



<div class="container mt-5">
    <h1 class="text-center">Cargar Nuevo Producto</h1>

    <div class="d-flex justify-content-center mt-4">
        <form id="formProducto" class="w-50">
        <div class="mb-0">
            <label for="pronombre">Nombre del Producto:</label>
            <input type="text" id="pronombre"class="form-control" name="pronombre" required><br><br>
        </div>
        <div class="mb-0">
            <label for="prodetalle">Detalle del Producto:</label>
            <textarea id="prodetalle"class="form-control" name="prodetalle" required></textarea><br><br>
        </div>
        <div class="mb-0">
            <label for="procantstock">Cantidad en Stock:</label>
            <input type="number" id="procantstock"class="form-control" name="procantstock" min="0" required><br><br>
        </div>
        <div class="mb-0">
            <label for="precio">Precio:</label>
            <input type="number" id="precio"class="form-control" name="precio" step="0.01" required><br><br>
        </div>
        <button type="submit" id="btn-cargar" value="Cargar" class="btn btn-primary">Cargar Producto</button>
        <div id="mensaje" style="margin-top: 20px;"></div>
            <hr class="mt-4">
             <a href="prodCliente.php" class="btn btn-danger">Volver al perfil</a>
        </form>

  </div>
</div>
<script>
  $(document).ready(function() {
    $("#btn-cargar").click(function(e) {
      e.preventDefault();
      // Limpiar mensajes previos
      $("#mensaje").empty();

      let datosFormulario = {
        pronombre: $("#pronombre").val(),
        prodetalle: $("#prodetalle").val(),
        procantstock: $("#procantstock").val(),
        precio: $("#precio").val(),
      };
      // Enviar solicitud AJAX
      $.ajax({
        type: 'POST',
        url: 'actionFormAgrProd.php',
        data: datosFormulario,
        dataType: 'json',
        success: function(respuesta) {
          //   console.log(respuesta);
          if (respuesta.success) {
            // window.location.href = response.redirect;
            $("#mensaje").html(
              `<div class="alert alert-success">${respuesta.message}</div>`
            );
          } else {
            $("#mensaje").html(
              `<div class="alert alert-danger">${respuesta.message}</div>`
            );
          }
        },
        error: function(error) {
          $("#mensaje").html(
            '<div class="alert alert-danger">Error en la conexión al servidor.</div>'
          );
          console.log(error);
        },
      });
    });
  });
</script>


<?php include_once "../../estructura/footer.php"; ?>