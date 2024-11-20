<?php
include_once "../../config.php";
$titulo = "productos";
include_once "../../estructura/headerSeguro.php";
$userRol = $session->getRol();
echo "<h1>Productos</h1>";
if (in_array(3, $rol) || in_array(2, $rol)) {
  include_once "prodAdmin.php";
} elseif (in_array(1, $rol)) {
  include_once "prodCliente.php";
}

?>

<?php
include_once "../../estructura/footer.php";
?>