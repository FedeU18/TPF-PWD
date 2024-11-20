<?php
include_once "../../config.php";
$titulo = "Iniciar sesión";
$session = new Session();
$session->cerrar();
include_once "../../estructura/header.php";
?>

<?php if (isset($_GET['msg'])): ?>
  <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['msg']); ?></div>
<?php endif; ?>
<?php if (isset($_GET['mensaje'])): ?>
  <div class="alert alert-info"><?php echo htmlspecialchars($_GET['mensaje']); ?></div>
<?php endif; ?>
<form method="post" action="action.php" name="formulario" id="formulario">
  <input id="accion" name="accion" value="login" type="hidden">
  <div id="mensaje" class="mb-3"></div>
  <div class="row mb-3">
    <div class="col-sm-3 ">
      <div class="form-group has-feedback">
        <label for="nombre" class="control-label">Nombre:</label>
        <div class="input-group">
          <input id="usnombre" name="usnombre" type="text" class="form-control" value="" required>
        </div>
      </div>
    </div>
  </div>
  <div class="row mb-3">
    <div class="col-sm-3 ">
      <div class="form-group has-feedback">
        <label for="uspass" class="control-label">Pass:</label>
        <div class="input-group">
          <input id="uspass" name="uspass" type="password" class="form-control" required>
        </div>
      </div>
    </div>
  </div>
  <button type="button" id="btnLogin" class="btn btn-primary btn-block">Iniciar Sesión</button>
</form>
<script>
$(document).ready(function() {
  $("#btnLogin").click(function(e) {
    e.preventDefault();//prevenir q se recargue la pag

    //recopilar los datos del formulario
    let datosFormulario = {
      accion: $("#accion").val(),
      usnombre: $("#usnombre").val(),
      uspass: $("#uspass").val(),
    };

    //validar campos vacíos antes de enviar
    if (!datosFormulario.usnombre || !datosFormulario.uspass) {
      $("#mensaje").html(
        '<div class="alert alert-danger">Por favor, complete todos los campos.</div>'
      );
      return;
    }

    //vnviar datos con AJAX
    $.ajax({
      url: "action.php",
      type: "POST",
      data: datosFormulario,
      dataType: "json",
      success: function(respuesta) {
        if (respuesta.success) {
          //redirigir si es exitoso
          window.location.href = respuesta.redirect;
        } else {
          //mostrar mensaje de error (cuenta está deshabilitada, contraseña incorrecta)
          $("#mensaje").html(
            `<div class="alert alert-danger">${respuesta.msg}</div>`
          );
        }
      },
      error: function() {
        $("#mensaje").html(
          '<div class="alert alert-danger">Error en la conexión al servidor.</div>'
        );
      },
    });
  });
});
</script>

<?php include_once "../../estructura/footer.php"; ?>