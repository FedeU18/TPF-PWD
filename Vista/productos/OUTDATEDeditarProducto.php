<?php

include_once "../../config.php";
include_once "../../estructura/headerSeguro.php";
$idUsuario = $session->getUsuario();
$objProducto = new ABMProducto();

?>




  <div class="container mt-5">
    <h1 class="text-center">Modificar Producto</h1>

    <!-- Mostrar mensaje de éxito o error si existe -->
    

    <!-- Formulario para editar perfil -->
    <form action="actionEditarProducto.php" class="mt-4">
  <div class="mb-3">
    <label for="prodNombre" class="form-label">Nombre Producto</label>
    <input type="text" class="form-control" id="prodNombre" name="prodNombre" required>
  </div>
  <div class="mb-3">
    <label for="prodDetalle" class="form-label">Detalle Producto</label>
    <textarea type="text" class="form-control" id="prodDetalle" name="prodDetalle" required></textarea>
  </div>
  <div class="mb-3">
    <label for="prodPrecio" class="form-label">Precio</label>
    <input type="text" class="form-control" id="prodPrecio" name="prodPrecio" required>
  </div>
  <div class="mb-3">
    <label for="prodStock" class="form-label">Editar Stock</label>
    <input type="text" class="form-control" id="prodStock" name="prodStock" required>
  </div>
  <div id="mensaje" class="mb-3"></div>
  <button type="submit" id="btn-editarProd" class="btn btn-primary">Guardar Cambios</button>
</form>

<hr class="mt-4">
<a href="index.php" class="btn btn-danger">Volver al perfil</a>
  </div>

<script>
  $(document).ready(function() {
    $("#btn-editarProd").click(function(e) {
      e.preventDefault();
      // Limpiar mensajes previos
      $("#mensaje").empty();

      let datosFormulario = {
        // accion: $("#accion").val(),
        uspassactual: $("#uspass_actual").val(),
        uspassnueva: $("#uspass_nueva").val(),
        uspassconfirmar: $("#uspass_confirmar").val(),
      };
      // Enviar solicitud AJAX
      $.ajax({
        type: 'POST',
        url: 'cambiar_contrasena_action.php',
        data: datosFormulario,
        dataType: 'json',
        success: function(respuesta) {
          console.log(respuesta);
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
            error: function (error) {
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

<!-- </html> -->