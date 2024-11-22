<?php
include_once '../../config.php';

$response = ['exito' => false, 'mensaje' => 'Ocurrió un error inesperado.'];
$datos = data_submitted();
if ($datos) {
  $nombre = $datos['nombreMenu'] ?? '';
  $descripcion = $datos['descripcionMenu'] ?? '';
  $estado = $datos['estadoMenu'] ?? '';
  $menuPadre = $datos['menuPadre'] ?? null;

  if ($nombre && $descripcion && $estado) {
    $abmMenu = new ABMMenu();

    $estado = $estado === 'habilitado' ? 1 : 0;

    $param = [
      'menombre' => $nombre,
      'medescripcion' => $descripcion,
      'idpadre' => $menuPadre,
      'medeshabilitado' => null,
    ];

    if ($abmMenu->alta($param)) {
      $response['exito'] = true;
      $response['mensaje'] = 'Menú creado exitosamente.';
    } else {
      $response['mensaje'] = 'No se pudo crear el menú.';
    }
  } else {
    $response['mensaje'] = 'Todos los campos son obligatorios.';
  }
}

header('Content-Type: application/json');
echo json_encode($response);
