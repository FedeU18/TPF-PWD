<?php
include_once "../../config.php";
header('Content-Type: application/json');

$datos = data_submitted();
$response = ["success" => false, "message" => ""];

$objUsuario = new ABMUsuario;

// Intentar registrar al usuario
$resultado = $objUsuario->alta($datos);

if ($resultado['success']) {
    // Asignar rol al usuario recién creado
    $objUsuarioRol = new ABMUsuarioRol;

    $idUsuarioCreado = $objUsuario->buscar(["usnombre" => $datos['usnombre']])[0]->getIdUsuario();
    $idRolCliente = 1;

    $nuevoUsuarioRol = [
        "idusuario" => $idUsuarioCreado,
        "idrol" => $idRolCliente,
    ];

    $objUsuarioRol->alta($nuevoUsuarioRol);

    $response["success"] = true;
    $response["message"] = "Se ha registrado correctamente, inicie sesión con sus credenciales.";
} else {
    // Mostrar errores
    $response["message"] = implode(" ", $resultado['errores']);
}

echo json_encode($response);
