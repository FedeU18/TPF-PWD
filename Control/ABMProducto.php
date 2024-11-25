<?php
class ABMProducto
{
  public function abm($datos) {
    $respuesta = ['success' => false, 'message' => ''];

    // Validar que la acción esté definida
    if (!isset($datos['accion'])) {
        $respuesta['message'] = "No se especificó la acción a realizar.";
        return $respuesta;
    }

    // Validar campos obligatorios según la acción
    $validacion = $this->validarCamposPorAccion($datos);
    // var_dump ($datos);
    // exit;
    if ($validacion !== true) {
        $respuesta['message'] = $validacion;
        return $respuesta;
    }

    // Ejecutar la acción correspondiente
    switch ($datos['accion']) {
        case 'nuevo':
            if ($this->alta($datos)) {
                $respuesta['success'] = true;
                $respuesta['message'] = "Producto creado correctamente.";
            } else {
                $respuesta['message'] = "Error al crear el producto.";
            }
            break;

        case 'editar':
            if ($this->modificacion($datos)) {
                $respuesta['success'] = true;
                $respuesta['message'] = "Producto actualizado correctamente.";
            } else {
                $respuesta['message'] = "Error al actualizar el producto.";
            }
            break;

        case 'borrar':
            if ($this->baja($datos)) {
                $respuesta['success'] = true;
                $respuesta['message'] = "Producto eliminado correctamente.";
            } else {
                $respuesta['message'] = "Error al eliminar el producto.";
            }
            break;

        default:
            $respuesta['message'] = "Acción no válida.";
            break;
    }

    return $respuesta;
}

private function validarCamposPorAccion($datos) {
  $errores = [];

  // Validar campos comunes
  if (!isset($datos['accion']) || empty($datos['accion'])) {
      $errores[] = "La acción es obligatoria.";
  }

  if ($datos['accion'] === 'editar' || $datos['accion'] === 'borrar') {
      if (!isset($datos['idProducto']) || empty($datos['idProducto'])) {
          $errores[] = "El ID del producto es obligatorio.";
      }
  }

  if ($datos['accion'] === 'nuevo' || $datos['accion'] === 'editar') {
      if (!isset($datos['pronombre']) || empty($datos['pronombre'])) {
          $errores[] = "El nombre del producto es obligatorio.";
      }

      if (!isset($datos['precio']) || !is_numeric($datos['precio'])) {
          $errores[] = "El precio es obligatorio y debe ser numérico.";
      }

      if (!isset($datos['procantstock']) || !is_numeric($datos['procantstock'])) {
          $errores[] = "La cantidad de stock es obligatoria y debe ser numérica.";
      }
  }

  return empty($errores) ? true : implode(' ', $errores);
}



  private function cargarObjeto($param)
  {
    $obj = null;
    if (
      array_key_exists('idProducto', $param) &&
      array_key_exists('precio', $param) && // Nueva columna
      array_key_exists('pronombre', $param) &&
      array_key_exists('prodetalle', $param) &&
      array_key_exists('procantstock', $param)
    ) {
      $obj = new Producto();
      $obj->setear($param['idProducto'], $param['precio'], $param['pronombre'], $param['prodetalle'], $param['procantstock']);
    }
    return $obj;
  }

  private function cargarObjetoConClave($param)
  {
    $obj = null;
    if (isset($param['idProducto'])) {
      $obj = new Producto();
      $obj->setear($param['idProducto'], null, null, null, null);
    }
    return $obj;
  }

  private function seteadosCamposClaves($param)
  {
    return isset($param['idProducto']);
  }

  public function alta($param)
  {
    $resp = false;
    $param['idProducto'] = null; // El id se genera automáticamente
    $elObjProducto = $this->cargarObjeto($param);
    if ($elObjProducto != null && $elObjProducto->insertar()) {
      $resp = true;
    }
    return $resp;
  }

  public function baja($param)
  {
    $resp = false;
    if ($this->seteadosCamposClaves($param)) {
      $elObjProducto = $this->cargarObjetoConClave($param);
      if ($elObjProducto != null && $elObjProducto->eliminar()) {
        $resp = true;
      }
    }
    return $resp;
  }

  public function modificacion($param)
  {
    $resp = false;
    if ($this->seteadosCamposClaves($param)) {
      $elObjProducto = $this->cargarObjeto($param);
      if ($elObjProducto != null && $elObjProducto->modificar()) {
        $resp = true;
      }
    }
    return $resp;
  }

  public function buscar($param)
  {
    $where = "true";
    if ($param != null) {
      if (isset($param['idProducto']))
        $where .= " and idProducto = " . $param['idProducto'];
      if (isset($param['precio'])) // Nueva condición para precio
        $where .= " and precio = " . $param['precio'];
      if (isset($param['pronombre']))
        $where .= " and pronombre = '" . $param['pronombre'] . "'";
      if (isset($param['prodetalle']))
        $where .= " and prodetalle = '" . $param['prodetalle'] . "'";
      if (isset($param['procantstock']))
        $where .= " and procantstock = " . $param['procantstock'];
    }
    $obj = new Producto();
    $arreglo = $obj->listar($where);
    return $arreglo;
  }
}
