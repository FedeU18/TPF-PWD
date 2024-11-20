<?php

include_once "../../config.php";
include_once("../../estructura/headerSeguro.php");

// Indicamos que la respuesta será JSON
header('Content-Type: application/json');

$response = ["success" => false, "message" => "Acción no válida."];

function normalizarCorreo($correo) {
    return trim(strtolower($correo));
}

$datos = data_submitted();
$idUsuario = $session->getUsuario();

if (!$idUsuario) {
    $response = ["success" => false, "message" => "Error: No se pudo identificar al usuario autenticado."];
    echo json_encode($response);
    exit;
}

if (empty($datos['usnombre']) || empty($datos['usmail'])) {
    $response = ["success" => false, "message" => "Los campos Nombre de Usuario y Correo Electrónico son obligatorios."];
    echo json_encode($response);
    exit;
}

$objUsuario = new ABMUsuario();
$usuarios = $objUsuario->buscar(null);

// Obtener la contraseña actual del usuario
foreach ($usuarios as $usuarioPass) {
    if ($usuarioPass->getidusuario() == $idUsuario) {
        $passActual = $usuarioPass->getuspass();
    }
}

// Verificar si el correo ya está registrado
foreach ($usuarios as $u) {
    if (normalizarCorreo($u->getusmail()) == normalizarCorreo($datos['usmail']) && $u->getidusuario() != $idUsuario) {
        $response = ["success" => false, "message" => "El correo ya está registrado para otro usuario."];
        echo json_encode($response);
        exit;
    }
}

// Preparar los datos para la modificación
$modUsuario = [
    "idusuario" => $idUsuario,
    "usnombre" => trim($datos['usnombre']),
    "uspass" => $passActual,
    "usmail" => normalizarCorreo($datos['usmail']),
    "usdeshabilitado" => null,
];

try {
    // Intentar actualizar el usuario
    $usuarioActualizado = $objUsuario->modificacion($modUsuario);
    
    if ($usuarioActualizado) {
        $response = ["success" => true, "message" => "Perfil actualizado con éxito."];
    } else {
        $response = ["success" => false, "message" => "No se realizaron cambios en el perfil."];
    }
    
    echo json_encode($response);
    exit;
} catch (Exception $e) {
    $response = ["success" => false, "message" => "Error al actualizar el perfil: " . $e->getMessage()];
    echo json_encode($response);
    exit;
}

