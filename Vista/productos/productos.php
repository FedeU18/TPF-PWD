<?php
include_once "../../config.php";
$titulo = "productos";
include_once "../../estructura/headerSeguro.php";
$userRol = $session->getRol();
echo "<h1>Productos</h1>";

if ($userRol == 2) {
  include_once "prodAdmin.php";
} elseif ($userRol == 1) {
  include_once "prodCliente.php";
}

?>

<?php
include_once "../../estructura/footer.php";
?>