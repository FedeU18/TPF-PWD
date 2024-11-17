<?php
include_once "../../config.php";
include_once "../../estructura/headerSeguro.php"; 

function normalizarCorreo($correo) {
    return trim(strtolower($correo));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = data_submitted();
    $idUsuario = $session->getUsuario(); 

    if (!$idUsuario) {
        $mensaje = "Error: No se pudo identificar al usuario autenticado.";
        header("Location: index.php?mensaje=" . urlencode($mensaje));
        exit;
    }

    if (empty($datos['usnombre']) || empty($datos['usmail'])) {
        $mensaje = "Los campos Nombre de Usuario y Correo Electrónico son obligatorios.";
        header("Location: index.php?mensaje=" . urlencode($mensaje));
        exit;
    }

    $objUsuario = new ABMUsuario();
    $usuarios = $objUsuario->buscar(null);

    
    foreach($usuarios as $usuarioPass){
        if($usuarioPass->getidusuario() == $idUsuario){
            $passActual = $usuarioPass->getuspass(); // Obtener la contraseña actual del usuario al principio
        }
    }

    foreach ($usuarios as $u) {
        if (normalizarCorreo($u->getusmail()) == normalizarCorreo($datos['usmail']) && $u->getidusuario() != $idUsuario) {
            $mensaje = "El correo ya está registrado para otro usuario.";
            header("Location: index.php?mensaje=" . urlencode($mensaje));
            exit;
        }
    }
    
    // Preparar el arreglo para la actualización
    $modUsuario = [
        "idusuario" => $idUsuario,
        "usnombre" => trim($datos['usnombre']),
        "uspass" => $passActual, // Mantener la contraseña actual
        "usmail" => normalizarCorreo($datos['usmail']),
        "usdeshabilitado" => null,
    ];
    
    // Llamar al método de modificación
    $usuarioActualizado = $objUsuario->modificacion($modUsuario);
    
    if ($usuarioActualizado) {
        $mensaje = "Perfil actualizado con éxito.";
        header("Location: index.php?mensaje=" . urlencode($mensaje));
    } else {
        $mensaje = "Error al actualizar el perfil.";
        header("Location: index.php?mensaje=" . urlencode($mensaje));
    }
    exit;
    

    try {
        $usuarioActualizado = $objUsuario->modificacion($modUsuario);
        if ($usuarioActualizado) {
            $mensaje = "Perfil actualizado con éxito.";
        } else {
            $mensaje = "No se realizaron cambios en el perfil.";
        }
    } catch (Exception $e) {
        $mensaje = "Error al actualizar el perfil: " . $e->getMessage();
    }

    header("Location: index.php?mensaje=" . urlencode($mensaje));
    exit;
} else {
    $mensaje = "Acceso no permitido.";
    header("Location: index.php?mensaje=" . urlencode($mensaje));
    exit;
}
