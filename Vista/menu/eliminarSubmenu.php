<?php
include_once '../../config.php';
$datos = data_submitted();
// Verifica si se ha recibido el ID del submenú
if (isset($datos['id']) && $datos['id'] !== '') {
  $idSubmenu = $datos['id'];

  // Instancia el ABMMenu para realizar la eliminación
  $abmMenu = new ABMMenu();

  // Intenta eliminar el submenú
  if ($abmMenu->baja(['idmenu' => $idSubmenu])) {
    // Respuesta exitosa
    $response = ['exito' => true, 'mensaje' => 'Submenú eliminado exitosamente.'];
  } else {
    // Respuesta de error si no se pudo eliminar
    $response = ['exito' => false, 'mensaje' => 'No se pudo eliminar el submenú.'];
  }
} else {
  // Si no se recibe el ID
  $response = ['exito' => false, 'mensaje' => 'ID de submenú no proporcionado.'];
}

// Devuelve la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($response);
