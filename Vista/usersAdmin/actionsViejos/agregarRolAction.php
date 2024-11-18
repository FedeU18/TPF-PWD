<?php
include_once("../../config.php");

$datos = data_submitted();
$abmUsuario = new ABMUsuario();
$mensaje = "";

if (isset($datos['idusuario']) && isset($datos['idrol'])) {
    if ($abmUsuario->nuevoRol($datos)) {
        $mensaje = "Rol asignado correctamente.";
    } else {
        $mensaje = "Error al asignar el rol.";
    }
} else {
    $mensaje = "Datos insuficientes para asignar el rol.";
}

echo "<script>location.href='./listaUsers.php?msg=" . htmlspecialchars($mensaje) . "';</script>";
?>