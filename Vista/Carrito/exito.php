<?php
include_once "../../config.php";
$titulo = "Compra realizada";
include_once "../../estructura/headerSeguro.php";
$session = new Session();
$objProducto = new ABMProducto();
$usuario = $session->getUsuario();
$carrito = $session->obtenerProductosCarrito();

$fechaActual = date("Y-m-d H:i:s");
$paramCompra = [
  "idcompra" => null,
  "cofecha" => $fechaActual,
  "idusuario" => $usuario,
];
$compra = new ABMCompra();
$compraEstado = new ABMCompraEstado();
$compraItem = new ABMCompraItem();
$msg = "";
if (($idcompra = $compra->alta($paramCompra)) > 0) {
  $msg = "Compra realizada con éxito";
  $paramCompraEstado = [
    "idcompraestado" => null,
    "idcompra" => $idcompra,
    "idcompraestadotipo" => 1,
    "cefechaini" => $fechaActual,
    "cefechafin" => null,
  ];
  if ($compraEstado->alta($paramCompraEstado)) {
    $msg = "Compra realizada con éxito";
  } else {
    $msg = "No se pudo concretar la compra";
  }

  foreach ($carrito as $idProducto => $cantidad) {
    $paramCompraItem = [
      "idcompraitem" => null,
      "idproducto" => $idProducto,
      "idcompra" => $idcompra,
      "cicantidad" => $cantidad
    ];
    if ($compraItem->alta($paramCompraItem)) {
      $msg = "Compra realizada con éxito";
    } else {
      $msg = "No se pudo concretar la compra";
    }
  }
} else {
  $msg = "No se pudo concretar la compra";
}
$session->vaciarCarrito();

echo "<h1>$msg</h1>";

include_once "../../estructura/footer.php";
