<?php
include_once "../../config.php";
header('Content-Type: application/json');

$session = new Session();
$response = ["success" => false, "message" => "Acción no válida."];
$datos = data_submitted();
$idUsuario = $session->getUsuario();

if (!$idUsuario) {
    $response = ["success" => false, "message" => "Error: No se pudo identificar al usuario autenticado."];
    echo json_encode($response);
    exit;
}

$objUsuario = new ABMUsuario();
$response = $objUsuario->actualizarPerfil($idUsuario, $datos);
echo json_encode($response);
exit;