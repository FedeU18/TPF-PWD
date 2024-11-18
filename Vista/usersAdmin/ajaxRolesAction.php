<?php
include_once("../../config.php");

$datos = data_submitted();
$response = ['success' => false, 'message' => 'Acción no válida'];

if (isset($datos['accion'], $datos['idusuario'], $datos['idrol'])) {
    $abmUsuario = new ABMUsuario();

    if ($datos['accion'] === 'nuevoRol') {
        if ($abmUsuario->nuevoRol($datos)) {
            $response = ['success' => true, 'message' => 'Rol asignado correctamente.'];
        } else {
            $response['message'] = 'Error al asignar el rol.';
        }
    } elseif ($datos['accion'] === 'borrarRol') {
        if ($abmUsuario->borrarRol($datos)) {
            $response = ['success' => true, 'message' => 'Rol eliminado correctamente.'];
        } else {
            $response['message'] = 'Error al eliminar el rol.';
        }
    }
} else {
    $response['message'] = 'Datos insuficientes para procesar la solicitud.';
}

echo json_encode($response);