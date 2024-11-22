<?php
include_once "../../config.php";
$titulo = "productos";
include_once "../../estructura/headerSeguro.php";
$userRol = $session->getRol();
echo "<h1>Productos</h1>";
if ($rol == 3 || $rol == 2) {
  include_once "prodAdmin.php";
} elseif ($rol == 1) {
  include_once "prodCliente.php";
}

?>

<?php
include_once "../../estructura/footer.php";
?>