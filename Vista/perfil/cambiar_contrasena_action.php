<?php
include_once "../../config.php";
// include_once "../../estructura/headerSeguro.php";
$session =new Session();

// Aseguramos que la respuesta sea en formato JSON
header('Content-Type: application/json');

// Inicializamos la respuesta por defecto
$response = ["success" => false, "message" => "Acción no válida."];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = data_submitted();

    $idUsuario = $session->getUsuario();
    if (!$idUsuario) {
        $response["message"] = "Error: Usuario no autenticado.";
        echo json_encode($response);
        exit;
    }

    if (empty($datos['uspassactual']) || empty($datos['uspassnueva']) || empty($datos['uspassconfirmar'])) {
        $response["message"] = "Por favor, complete todos los campos.";
        echo json_encode($response);
        exit;
    }

    if ($datos['uspassnueva'] !== $datos['uspassconfirmar']) {
        $response["message"] = "Las contraseñas no coinciden.";
        echo json_encode($response);
        exit;
    }

    // Obtener el usuario actual
    $objUsuario = new ABMUsuario();
    $usuario = $objUsuario->buscar(['idusuario' => $idUsuario])[0];

    // Verificar la contraseña actual
    if (!password_verify($datos['uspassactual'], $usuario->getuspass())) {
        $response["message"] = "La contraseña actual es incorrecta.";
        echo json_encode($response);
        exit;
    }

    // Actualizar la contraseña
    $nuevaContrasenaHash = password_hash($datos['uspassnueva'], PASSWORD_DEFAULT);
    $modUsuario = [
        'idusuario' => $idUsuario,
        "usnombre" => $usuario->getusnombre(),
        'uspass' => $nuevaContrasenaHash,
        "usmail" => $usuario->getusmail(),
        "usdeshabilitado" => null,
    ];

    try {
        $usuarioActualizado = $objUsuario->modificacion($modUsuario);

        if ($usuarioActualizado) {
            $response = [
                "success" => true,
                "message" => "Contraseña actualizada con éxito."
            ];
        } else {
            $response["message"] = "Error al actualizar la contraseña.";
        }
    } catch (Exception $e) {
        $response["message"] = "Error interno: " . $e->getMessage();
    }
} else {
    $response["message"] = "Acceso no permitido.";
}

echo json_encode($response);
exit;
