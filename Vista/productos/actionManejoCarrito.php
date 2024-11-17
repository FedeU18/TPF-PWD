<?php
include_once "../../config.php";

$datos = data_submitted();
$response = ["success" => false, "msg" => "Acción no válida."];

if (isset($datos['accion'])) {
  $session = new Session();

  if ($datos['accion'] === "agregarCarrito") {
    $idProducto = isset($datos['idproducto']) ? intval($datos['idproducto']) : null;
    $cantidad = isset($datos['cantidad']) ? intval($datos['cantidad']) : 1;

    if ($idProducto) {
      $session->agregarAlCarrito($idProducto, $cantidad);
      $response = [
        "success" => true,
        "msg" => "Producto agregado al carrito correctamente.",
        "totalProductos" => $session->totalProductosCarrito(),
      ];
    } else {
      $response["msg"] = "ID de producto inválido.";
    }
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
  } elseif ($datos['accion'] === "eliminarProducto") {
    $idProducto = isset($datos['idproducto']) ? intval($datos['idproducto']) : null;

    if ($idProducto) {
      $session->eliminarDelCarrito($idProducto);
      $response = [
        "success" => true,
        "msg" => "Producto eliminado del carrito correctamente.",
      ];
    } else {
      $response["msg"] = "ID de producto inválido.";
    }
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
  }
}

header('Content-Type: application/json');
echo json_encode($response);
exit;
