<?php
include_once '../../config.php';
$session = new Session();
header('Content-Type: application/json');

$datos = data_submitted();
$idCompra = $datos['id'] ?? null;

$response = ["success" => false, "message" => "No se pudo cancelar la compra, comunicarse con Asistencia"];

if ($idCompra !== null) {
  $objCompraEstado = new ABMCompraEstado();
  $response = $objCompraEstado->cancelarCompra($idCompra);
}

echo json_encode($response);
