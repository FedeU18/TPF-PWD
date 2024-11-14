<?php
class ABMMenu
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
    if (array_key_exists('idmenu', $param) && array_key_exists('menombre', $param) && array_key_exists('medescripcion', $param) && array_key_exists('idpadre', $param) && array_key_exists('medeshabilitado', $param)) {
      $obj = new Menu();
      $obj->setear($param['idmenu'], $param['menombre'], $param['medescripcion'], $param['idpadre'], $param['medeshabilitado']);
    }
    return $obj;
  }

  private function cargarObjetoConClave($param)
  {
    $obj = null;
    if (isset($param['idmenu'])) {
      $obj = new Menu();
      $obj->setear($param['idmenu'], null, null, null, null);
    }
    return $obj;
  }

  private function seteadosCamposClaves($param)
  {
    return isset($param['idmenu']);
  }

  public function alta($param)
  {
    $resp = false;
    $param['idmenu'] = null;
    $elObjMenu = $this->cargarObjeto($param);
    if ($elObjMenu != null && $elObjMenu->insertar()) {
      $resp = true;
    }
    return $resp;
  }

  public function baja($param)
  {
    $resp = false;
    if ($this->seteadosCamposClaves($param)) {
      $elObjMenu = $this->cargarObjetoConClave($param);
      if ($elObjMenu != null && $elObjMenu->eliminar()) {
        $resp = true;
      }
    }
    return $resp;
  }

  public function modificacion($param)
  {
    $resp = false;
    if ($this->seteadosCamposClaves($param)) {
      $elObjMenu = $this->cargarObjeto($param);
      if ($elObjMenu != null && $elObjMenu->modificar()) {
        $resp = true;
      }
    }
    return $resp;
  }

  public function buscar($param)
  {
    $where = "true";
    if ($param != null) {
      if (isset($param['idmenu']))
        $where .= " and idmenu = " . $param['idmenu'];
      if (isset($param['menombre']))
        $where .= " and menombre = '" . $param['menombre'] . "'";
      if (isset($param['medescripcion']))
        $where .= " and medescripcion = '" . $param['medescripcion'] . "'";
      if (isset($param['idpadre']))
        $where .= " and idpadre = " . $param['idpadre'];
      if (isset($param['medeshabilitado']))
        $where .= " and medeshabilitado = '" . $param['medeshabilitado'] . "'";
    }
    $obj = new Menu();
    $arreglo = $obj->listar($where);
    return $arreglo;
  }
}
