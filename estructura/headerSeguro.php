<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo isset($titulo) ? $titulo : "TPF"; ?></title>
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
</head>
<?php
$session = new Session();
$resp = $session->validar();
if ($resp) {
  $abmMenu = new ABMMenu();
  $rol = $session->getRol()[0];
  $submenus = $abmMenu->buscar(["idpadre" => $rol]);
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
      foreach ($submenus as $submenu) {
        echo "<a href='{$submenu->getmedescripcion()}' class='mx-1 btn btn-outline-primary me-2'>{$submenu->getmenombre()}</a>";
      }
      ?>
      <a href=""></a>
      <form action="../login/action.php" method="get">
        <input type="hidden" name="accion" value="cerrar">
        <input href="../login/login.php" type="submit" class="mx-1 btn btn-primary" value="Cerrar Sesión">
      </form>
    </div>
  </header>
  <div class="container mb-5">