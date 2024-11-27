<?php
include_once "../../config.php";

$datos = data_submitted();
$response = ["success" => false, "msg" => "Datos insuficientes."];

if (isset($datos['idcompra']) && isset($datos['accion'])) {
  $objAbmCompraEstado = new ABMCompraEstado();
  $response = $objAbmCompraEstado->cambiarEstado($datos['idcompra'], $datos['accion']);
}

header('Content-Type: application/json');
echo json_encode($response);
exit;
