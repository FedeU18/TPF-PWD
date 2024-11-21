<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo isset($titulo) ? $titulo : "TPF"; ?></title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="CSS/alertas.css">

</head>
<?php
$session = new Session();
$resp = $session->validar();
if ($resp) {
  $rol = $session->getRol();
} else {
  $mensaje = "Error, vuelva a intentarlo";
  echo "<script>location.href = '../login/login.php?msg=" . $mensaje . "';</script>";
}
?>

<body class="d-flex flex-column min-vh-100">
  <header class="d-flex flex-wrap align-items-center justify-content-between py-3 mb-4 border-bottom">
    <div class="col-md-3 mb-2 mb-md-0">
      <a href="../productos/productos.php">ACÁ IRÍA EL LOGO</a>
    </div>
    <div class="col-5 d-flex flex-row text-end">
      <?php
      if (in_array(3, $rol)) { //verificar q tenga el rol 2
      ?>
        <a href="../compras/compras.php" type="button" class="btn btn-outline-primary mr-2">Compras</a>
      <?php
      }
      ?>
      <?php
      if (in_array(2, $rol)) { //verificar q tenga el rol 2
      ?>
        <a href="../usersAdmin/listaUsers.php" type="button" class="btn btn-outline-primary mr-2">Usuarios</a>
      <?php
      }
      ?>
      <a href="../productos/productos.php" type="button" class="btn btn-outline-primary mr-2">Productos</a>
      <a href="../perfil/" type="button" class="btn btn-outline-primary mr-2">Mi Perfil</a>
      <form action="../login/action.php" method="get">
        <input type="hidden" name="accion" value="cerrar">
        <input href="../login/login.php" type="submit" class="btn btn-primary" value="Cerrar Sesión">
      </form>
    </div>
  </header>
  <div class="container mb-5">