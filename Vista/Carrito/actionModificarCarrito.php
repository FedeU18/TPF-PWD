<?php
include_once "../../config.php";
$datos = data_submitted();

// Verificamos si se ha enviado una acción válida
if (isset($datos['accion'])) {
  $session = new Session();
  $response = ['success' => false, 'msg' => 'Acción no válida.'];

  // Acciones para reducir la cantidad o eliminar un producto del carrito
  if ($datos['accion'] == 'reducirCantidad' && isset($datos['idproducto'])) {
    $idProducto = intval($datos['idproducto']);
    if ($session->reducirCantidad($idProducto)) {
      $response = [
        'success' => true,
        'msg' => 'Cantidad reducida correctamente.',
        'totalProductos' => $session->precioTotal()
      ];
    } else {
      $response['msg'] = 'No se pudo reducir la cantidad del producto.';
    }
  }

  if ($datos['accion'] == 'eliminarDelCarrito' && isset($datos['idproducto'])) {
    $idProducto = intval($datos['idproducto']);
    if ($session->eliminarDelCarrito($idProducto)) {
      $response = [
        'success' => true,
        'msg' => 'Producto eliminado correctamente.',
        'totalProductos' => $session->precioTotal()
      ];
    } else {
      $response['msg'] = 'No se pudo eliminar el producto del carrito.';
    }
  }

  // Enviamos la respuesta en formato JSON
  header('Content-Type: application/json');
  echo json_encode($response);
  exit;
} else {
  echo json_encode(['success' => false, 'msg' => 'Acción no válida.']);
  exit;
}
