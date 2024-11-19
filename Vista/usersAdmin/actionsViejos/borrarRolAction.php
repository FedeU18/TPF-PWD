<?php
include_once("../../config.php");

$datos = data_submitted();
$abmUsuario = new ABMUsuario();
$mensaje = "";

if (isset($datos['idusuario']) && isset($datos['idrol'])) {
    if ($abmUsuario->borrarRol($datos)) {
        $mensaje = "Rol eliminado correctamente.";
    } else {
        $mensaje = "Error al eliminar el rol.";
    }
} else {
    $mensaje = "Datos insuficientes para eliminar el rol.";
}

echo "<script>location.href='./listaUsers.php?msg=" . htmlspecialchars($mensaje) . "';</script>";
?>