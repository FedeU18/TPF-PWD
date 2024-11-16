<?php
include_once "../../config.php";
include_once("../../estructura/header.php");
$datos = data_submitted();
$resp = false;

if (isset($datos['accion'])) {
  $objTrans = new Session();

  if ($datos['accion'] == "login") {
    $resp = $objTrans->iniciar($datos['usnombre'], $datos['uspass']);
    if ($resp) {
      header("Location: ../productos/productos.php");
      exit;
    } else {
      $mensaje = "Usuario o contraseña incorrectos.";
      header("Location: login.php?msg=" . urlencode($mensaje));
      exit;
    }
  }

  if ($datos['accion'] == "cerrar") {
    $resp = $objTrans->cerrar();
    $mensaje = "Has cerrado sesión correctamente.";
    header("Location: ../inicio/inicio.php?msg=" . urlencode($mensaje));
    exit;
  }
}
