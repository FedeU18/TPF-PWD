<?php
include_once "../../config.php";

// Inicia la sesión y verifica permisos (opcional, si aplica en tu sistema)
$session = new Session();
if (!$session->activa()) {
    header("Content-Type: application/json");
    echo json_encode(["success" => false, "message" => "Sesión expirada. Por favor, inicia sesión nuevamente."]);
    exit;
}

// Encabezado JSON
header('Content-Type: application/json');

// Obtener datos enviados
$datos = data_submitted();

// Instanciar el controlador
$objProducto = new ABMProducto();

// Validar y ejecutar la acción
$resultado = $objProducto->abm($datos);

// Responder al cliente
echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
exit;
