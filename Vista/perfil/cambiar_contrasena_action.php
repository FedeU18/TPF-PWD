    <?php
    include_once "../../config.php";
    include_once "../../estructura/headerSeguro.php";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $datos = data_submitted();

        $idUsuario = $session->getUsuario();
        if (!$idUsuario) {
            $mensaje = "Error: Usuario no autenticado.";
            header("Location: cambioContraseña.php?mensaje=" . urlencode($mensaje));
            exit;
        }

        if (empty($datos['uspass_actual']) || empty($datos['uspass_nueva']) || empty($datos['uspass_confirmar'])) {
            $mensaje = "Por favor, complete todos los campos.";
            header("Location: cambioContraseña.php?mensaje=" . urlencode($mensaje));
            exit;
        }

        if ($datos['uspass_nueva'] !== $datos['uspass_confirmar']) {
            $mensaje = "Las contraseñas no coinciden.";
            header("Location: cambioContraseña.php?mensaje=" . urlencode($mensaje));
            exit;
        }

        // Obtener el usuario actual
        $objUsuario = new ABMUsuario();
        $usuario = $objUsuario->buscar(['idusuario' => $idUsuario])[0];

        // Verificar la contraseña actual
        if (!password_verify($datos['uspass_actual'], $usuario->getuspass())) {
            $mensaje = "La contraseña actual es incorrecta.";
            header("Location: cambioContraseña.php?mensaje=" . urlencode($mensaje));
            exit;
        }



        // Actualizar la contraseña
        $nuevaContrasenaHash = password_hash($datos['uspass_nueva'], PASSWORD_DEFAULT);
        $modUsuario = [
            'idusuario' => $idUsuario,
            "usnombre" => $usuario->getusnombre(),
            'uspass' => $nuevaContrasenaHash,
            "usmail" => $usuario->getusmail(),
            "usdeshabilitado" => null,
        ];

        $usuarioActualizado = $objUsuario->modificacion($modUsuario);
        

        if ($usuarioActualizado) {
            $mensaje = "Contraseña actualizada con éxito.";
            header("Location: cambioContraseña.php?mensaje=" . urlencode($mensaje));
        } else {
            $mensaje = "Error al actualizar la contraseña.";
            header("Location: cambioContraseña.php?mensaje=" . urlencode($mensaje));
        }
        exit;
    } else {
        $mensaje = "Acceso no permitido.";
        header("Location: cambioContraseña.php?mensaje=" . urlencode($mensaje));
        exit;
    }
