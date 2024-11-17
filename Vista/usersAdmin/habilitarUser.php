<?php
include_once("../../config.php");
$datos = data_submitted();

if (isset($datos['idusuario'])) {
    $objAbmUsuario = new ABMUsuario();

    $usuarios = $objAbmUsuario->arrayUser();

    $i = 0;
    $usuarioEncontrado = null;

    while ($i < count($usuarios) && $usuarioEncontrado === null) {
        if ($usuarios[$i]['idusuario'] == $datos['idusuario']) {
            $usuarioEncontrado = $usuarios[$i];
        }
        $i++;
    }

    if ($usuarioEncontrado) {
        $usuarioEncontrado['usdeshabilitado'] = '0000-00-00';

        if ($objAbmUsuario->modificacion($usuarioEncontrado)) {
            header("Location: ./listaUsers.php?mensaje=Usuario habilitado exitosamente");
            exit();
        } else {
            header("Location: ./listaUsers.php?mensaje=Error al habilitar el usuario");
            exit();
        }
    } else {
        header("Location: ./listaUsers.php?mensaje=Usuario no encontrado");
        exit();
    }
} else {
    header("Location: ./listaUsers.php?mensaje=ID de usuario no proporcionado");
    exit();
}
?>