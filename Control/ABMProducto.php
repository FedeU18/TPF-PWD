<?php
class ABMProducto
{
  public function abm($datos)
  {
    $resp = false;
    if ($datos['accion'] == 'editar') {
      if ($this->modificacion($datos)) {
        $resp = true;
      }
    }
    if ($datos['accion'] == 'borrar') {
      if ($this->baja($datos)) {
        $resp = true;
      }
    }
    if ($datos['accion'] == 'nuevo') {
      if ($this->alta($datos)) {
        $resp = true;
      }
    }
    return $resp;
  }

  private function cargarObjeto($param)
  {
    $obj = null;
    if (
      array_key_exists('idproducto', $param) &&
      array_key_exists('precio', $param) && // Nueva columna
      array_key_exists('pronombre', $param) &&
      array_key_exists('prodetalle', $param) &&
      array_key_exists('procantstock', $param)
    ) {
      $obj = new Producto();
      $obj->setear($param['idproducto'], $param['precio'], $param['pronombre'], $param['prodetalle'], $param['procantstock']);
    }
    return $obj;
  }

  private function cargarObjetoConClave($param)
  {
    $obj = null;
    if (isset($param['idproducto'])) {
      $obj = new Producto();
      $obj->setear($param['idproducto'], null, null, null, null);
    }
    return $obj;
  }

  private function seteadosCamposClaves($param)
  {
    return isset($param['idproducto']);
  }

  public function alta($param)
  {
    $resp = false;
    $param['idproducto'] = null; // El id se genera automáticamente
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
      if (isset($param['idproducto']))
        $where .= " and idproducto = " . $param['idproducto'];
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
