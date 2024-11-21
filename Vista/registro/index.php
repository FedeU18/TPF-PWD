<?php
$titulo = "Registro";
include_once "../../config.php";
include_once "../../estructura/header.php"
?>


<div class="container mt-5">
    <h1 class="text-center">Registro nuevo usuario</h1>
    
    <div class="d-flex justify-content-center mt-4">
        <form action="action.php" class="w-50">
            <div class="mb-1">
                <label for="usnombre" class="form-label">Nombre de usuario:</label><br>
                <input type="text" class="form-control" id="usnombre" name="usnombre" required><br><br>
            </div>
            <div class="mb-1">
                <label for="pass" class="form-label">Contraseña:</label><br>
                <input type="password" class="form-control" id="pass" name="pass" required><br><br>
            </div>
            <div class="mb-1">
                <label for="email" class="form-label">E-mail:</label><br>
                <input type="text" id="email" class="form-control" name="email" required><br><br>
            </div>
            <div id="mensaje" class="mb-3"></div>
            <input type="submit" id="btn-registro" value="Enviar" class="btn btn-primary">
        </form>
    </div>
</div>


<script>
  $(document).ready(function() {
    $("#btn-registro").click(function(e) {
      e.preventDefault();
      // Limpiar mensajes previos
      $("#mensaje").empty();

      let datosFormulario = {
        usnombre: $("#usnombre").val(),
        pass: $("#pass").val(), // Clave ajustada
        email: $("#email").val(), // Clave ajustada
      };

      // Enviar solicitud AJAX
      $.ajax({
        type: 'POST',
        url: 'action.php',
        data: datosFormulario,
        dataType: 'json',
        success: function(respuesta) {
          console.log(respuesta);
          if (respuesta.success) {
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