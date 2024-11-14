<?php
class ABMMenuRol
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
    if (array_key_exists('idmenu', $param) && array_key_exists('idrol', $param)) {
      $obj = new MenuRol();
      $obj->setear($param['idmenu'], $param['idrol']);
    }
    return $obj;
  }

  private function cargarObjetoConClave($param)
  {
    $obj = null;
    if (isset($param['idmenu']) && isset($param['idrol'])) {
      $obj = new MenuRol();
      $obj->setear($param['idmenu'], $param['idrol']);
    }
    return $obj;
  }

  private function seteadosCamposClaves($param)
  {
    return isset($param['idmenu']) && isset($param['idrol']);
  }

  public function alta($param)
  {
    $resp = false;
    $elObjMenuRol = $this->cargarObjeto($param);
    if ($elObjMenuRol != null && $elObjMenuRol->insertar()) {
      $resp = true;
    }
    return $resp;
  }

  public function baja($param)
  {
    $resp = false;
    if ($this->seteadosCamposClaves($param)) {
      $elObjMenuRol = $this->cargarObjetoConClave($param);
      if ($elObjMenuRol != null && $elObjMenuRol->eliminar()) {
        $resp = true;
      }
    }
    return $resp;
  }

  public function modificacion($param)
  {
    $resp = false;
    if ($this->seteadosCamposClaves($param)) {
      $elObjMenuRol = $this->cargarObjeto($param);
      if ($elObjMenuRol != null && $elObjMenuRol->modificar()) {
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
      if (isset($param['idrol']))
        $where .= " and idrol = " . $param['idrol'];
    }
    $obj = new MenuRol();
    $arreglo = $obj->listar($where);
    return $arreglo;
  }
}
