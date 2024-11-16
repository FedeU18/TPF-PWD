<?php
include_once "../../config.php";
$titulo = "Iniciar sesión";
include_once "../../estructura/header.php";
?>

<?php if (isset($_GET['msg'])): ?>
  <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['msg']); ?></div>
<?php endif; ?>

<form method="post" action="action.php" name="formulario" id="formulario">
  <input id="accion" name="accion" value="login" type="hidden">
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
  <input type="submit" class="btn btn-primary btn-block" value="Validar">
</form>