<?php
include_once("../../config.php");
$datos = data_submitted();

$response = ['success' => false, 'message' => 'Acción no válida'];

if (isset($datos['accion'], $datos['idusuario'])) {
    $objAbmUsuario = new ABMUsuario();
    $usuarios = $objAbmUsuario->arrayUser();
    
    $usuarioEncontrado = null;
    $i = 0;
    $totalUsuarios = count($usuarios);

    while ($i < $totalUsuarios && !$usuarioEncontrado) {
        if ($usuarios[$i]['idusuario'] == $datos['idusuario']) {
            $usuarioEncontrado = $usuarios[$i];
        }
        $i++;
    }

    if ($usuarioEncontrado) {
        if ($datos['accion'] == 'habilitar') {
            $usuarioEncontrado['usdeshabilitado'] = '0000-00-00';
            if ($objAbmUsuario->modificacion($usuarioEncontrado)) {
                $response = ['success' => true, 'message' => 'Usuario habilitado exitosamente'];
            }
        } elseif ($datos['accion'] == 'deshabilitar') {
            $usuarioEncontrado['usdeshabilitado'] = date('Y-m-d');
            if ($objAbmUsuario->modificacion($usuarioEncontrado)) {
                $response = ['success' => true, 'message' => 'Usuario deshabilitado exitosamente'];
            }
        }
    } else {
        $response['message'] = 'Usuario no encontrado';
    }
} else {
    $response['message'] = 'Datos incompletos';
}

echo json_encode($response);