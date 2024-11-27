<?php
include_once "../../config.php";

header('Content-Type: application/json');

$session = new Session();
$response = ["success" => false, "message" => "Acción no válida."];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = data_submitted();
    $idUsuario = $session->getUsuario();

    if (!$idUsuario) {
        $response["message"] = "Error: Usuario no autenticado.";
        echo json_encode($response);
        exit;
    }

    $objABMUsuario = new ABMUsuario();
    $resultado = $objABMUsuario->actualizarContrasena($idUsuario, $datos);

    echo json_encode($resultado);
    exit;
}
