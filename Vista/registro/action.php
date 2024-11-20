<?php
include_once "../../config.php";

$datos = data_submitted();
$response = ["success" => false, "message" => ""];

$objUsuario = new ABMUsuario;
$usuarios = $objUsuario->buscar(null);
$encontrado = false;

// Verificar si el nombre de usuario o el correo ya existen
foreach ($usuarios as $usuario) {
    if ($usuario->getusnombre() === $datos['usnombre']) {
        $response["message"] = "El usuario ya existe";
        echo json_encode($response);
        exit;
    }
    if ($usuario->getusmail() === $datos['email']) {
        $response["message"] = "El correo ya existe";
        echo json_encode($response);
        exit;
    }
}

if (!$encontrado) {
    if (!filter_var($datos['email'], FILTER_VALIDATE_EMAIL)) {
        $response["message"] = "El correo no es válido.";
        echo json_encode($response);
        exit;
    }

    if (strlen($datos['usnombre']) < 8) {
        $pass = password_hash($datos['pass'], PASSWORD_DEFAULT);
        $nuevoUsuario = [
            "idusuario" => null,
            "usnombre" => $datos['usnombre'],
            "uspass" => $pass,
            "usmail" => $datos['email'],
            "usdeshabilitado" => null,
        ];

        // Registrar el usuario
        $usuarioCreado = $objUsuario->alta($nuevoUsuario);

        if ($usuarioCreado) {
            $objUsuarioRol = new ABMUsuarioRol;

            // Obtener el ID del usuario recién creado
            $idUsuarioCreado = $objUsuario->buscar(["usnombre" => $datos['usnombre']])[0]->getIdUsuario();
            $idRolCliente = 1;

            // Crear el registro en usuariorol
            $nuevoUsuarioRol = [
                "idusuario" => $idUsuarioCreado,
                "idrol" => $idRolCliente,
            ];
            $objUsuarioRol->alta($nuevoUsuarioRol);

            $response["success"] = true;
            $response["message"] = "Se ha registrado correctamente, inicie sesión con sus credenciales.";
        } else {
            $response["message"] = "Error al registrar el usuario.";
        }
    } else {
        $response["message"] = "El nombre de usuario debe tener menos de 8 caracteres.";
    }
}

echo json_encode($response);
