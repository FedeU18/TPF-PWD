<?php
include_once "../../config.php";

// Iniciar sesión para manejar mensajes
session_start();

// Validar que el usuario haya enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = data_submitted();

    // Obtener el ID del usuario autenticado
    $idUsuario = $_SESSION['idusuario'];

    // Crear instancia de ABMUsuario
    $objUsuario = new ABMUsuario();

    // Validar que el correo no esté en uso por otro usuario
    $usuarios = $objUsuario->buscar(null);
    foreach ($usuarios as $u) {
        if ($u->getusmail() == $datos['usmail'] && $u->getIdUsuario() != $idUsuario) {
            header("Location: perfil.php?mensaje=El correo ya está registrado para otro usuario.");
            exit;
        }
    }

    // Si la contraseña está vacía, no se actualiza
    if (empty($datos['uspass'])) {
        unset($datos['uspass']);
    } else {
        // Realizar hash de la contraseña nueva
        $datos['uspass'] = password_hash($datos['uspass'], PASSWORD_DEFAULT);
    }

    // Actualizar el perfil del usuario
    $datos['idusuario'] = $idUsuario; // Asegurar que se actualice solo el usuario autenticado
    $usuarioActualizado = $objUsuario->modificacion($datos);

    if ($usuarioActualizado) {
        header("Location: perfil.php?mensaje=Perfil actualizado con éxito.");
    } else {
        header("Location: perfil.php?mensaje=Error al actualizar el perfil.");
    }
    exit;
}
?>
