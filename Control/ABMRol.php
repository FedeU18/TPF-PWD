<?php
class ABMRol
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
    if (array_key_exists('idrol', $param) && array_key_exists('rodescripcion', $param)) {
      $obj = new Rol();
      $obj->setear($param['idrol'], $param['rodescripcion']);
    }
    return $obj;
  }

  private function cargarObjetoConClave($param)
  {
    $obj = null;
    if (isset($param['idrol'])) {
      $obj = new Rol();
      $obj->setear($param['idrol'], null);
    }
    return $obj;
  }

  private function seteadosCamposClaves($param)
  {
    return isset($param['idrol']);
  }

  public function alta($param)
  {
    $resp = false;
    $param['idrol'] = null; // El id se genera automáticamente
    $elObjRol = $this->cargarObjeto($param);
    if ($elObjRol != null && $elObjRol->insertar()) {
      $resp = true;
    }
    return $resp;
  }

  public function baja($param)
  {
    $resp = false;
    if ($this->seteadosCamposClaves($param)) {
      $elObjRol = $this->cargarObjetoConClave($param);
      if ($elObjRol != null && $elObjRol->eliminar()) {
        $resp = true;
      }
    }
    return $resp;
  }

  public function modificacion($param)
  {
    $resp = false;
    if ($this->seteadosCamposClaves($param)) {
      $elObjRol = $this->cargarObjeto($param);
      if ($elObjRol != null && $elObjRol->modificar()) {
        $resp = true;
      }
    }
    return $resp;
  }

  public function buscar($param)
  {
    $where = "true";
    if ($param != null) {
      if (isset($param['idrol']))
        $where .= " and idrol = " . $param['idrol'];
      if (isset($param['rodescripcion']))
        $where .= " and rodescripcion = '" . $param['rodescripcion'] . "'";
    }
    $obj = new Rol();
    $arreglo = $obj->listar($where);
    return $arreglo;
  }
}
