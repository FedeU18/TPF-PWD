<?php
include_once "../../config.php";
$datos = data_submitted();
$resp = false;
$response = ["success" => false, "msg" => "Acción no válida."];

if (isset($datos['accion'])) {
  $objTrans = new Session();

  if ($datos['accion'] == "login") {
    $resp = $objTrans->iniciar($datos['usnombre'], $datos['uspass']);
    if ($resp) {
      $response = [
        "success" => true,
        "redirect" => "../productos/productos.php"
      ];
    } else {
      $response["msg"] = "Usuario o contraseña incorrectos.";
    }
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
  } else if ($datos['accion'] == "cerrar") {
    $resp = $objTrans->cerrar();
    $mensaje = "Has cerrado sesión correctamente.";
    header("Location: ../inicio/inicio.php?msg=" . urlencode($mensaje));
    exit;
  }
}
