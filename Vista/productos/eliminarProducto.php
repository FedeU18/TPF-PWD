<?php
include_once "../../config.php";
$session = new Session();
header('Content-Type: application/json');

$response = ["success" => false, "message" => "Acción no completada."];
$datos = data_submitted();

if (isset($datos['accion'])) {
    $objProductos = new ABMProducto();
    $resultado = $objProductos->abm($datos);
    $response["success"] = $resultado['success'];
    $response["message"] = $resultado['message'];
} else {
    $response["message"] = "Acción no especificada.";
}

echo json_encode($response);