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
</head>
<?php
$session = new Session();
$resp = $session->validar();
if ($resp) {
} else {
  $mensaje = "Error, vualva a intentarlo";
  echo "<script>location.href = '../login/login.php?msg=" . $mensaje . "';</script>";
}
?>

<body class="d-flex flex-column min-vh-100">
  <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
    <div class="col-md-3 mb-2 mb-md-0">
      <a href="../productos/productos.php">ACÁ IRÍA EL LOGO</a>
    </div>
    <div class="col-md-3 d-flex flex-row text-end">
      <a href="../perfil/" type="button" class="btn btn-outline-primary mr-2">Mi Perfil</a>
      <form action="../login/action.php" method="get">
        <input type="hidden" name="accion" value="cerrar">
        <input href="../login/login.php" type="submit" class="btn btn-primary" value="Cerrar Sesión">
      </form>
    </div>
  </header>
  <div class="container mb-5">