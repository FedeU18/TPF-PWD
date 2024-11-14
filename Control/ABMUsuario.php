<?php
class ABMUsuario
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
    if (array_key_exists('idusuario', $param) && array_key_exists('usnombre', $param) && array_key_exists('uspass', $param) && array_key_exists('usmail', $param) && array_key_exists('usdeshabilitado', $param)) {
      $obj = new Usuario();
      $obj->setear($param['idusuario'], $param['usnombre'], $param['uspass'], $param['usmail'], $param['usdeshabilitado']);
    }
    return $obj;
  }

  private function cargarObjetoConClave($param)
  {
    $obj = null;
    if (isset($param['idusuario'])) {
      $obj = new Usuario();
      $obj->setear($param['idusuario'], null, null, null, null);
    }
    return $obj;
  }

  private function seteadosCamposClaves($param)
  {
    return isset($param['idusuario']);
  }

  public function alta($param)
  {
    $resp = false;
    $param['idusuario'] = null; // El id se genera automáticamente
    $elObjUsuario = $this->cargarObjeto($param);
    if ($elObjUsuario != null && $elObjUsuario->insertar()) {
      $resp = true;
    }
    return $resp;
  }

  public function baja($param)
  {
    $resp = false;
    if ($this->seteadosCamposClaves($param)) {
      $elObjUsuario = $this->cargarObjetoConClave($param);
      if ($elObjUsuario != null && $elObjUsuario->eliminar()) {
        $resp = true;
      }
    }
    return $resp;
  }

  public function modificacion($param)
  {
    $resp = false;
    if ($this->seteadosCamposClaves($param)) {
      $elObjUsuario = $this->cargarObjeto($param);
      if ($elObjUsuario != null && $elObjUsuario->modificar()) {
        $resp = true;
      }
    }
    return $resp;
  }

  public function buscar($param)
  {
    $where = "true";
    if ($param != null) {
      if (isset($param['idusuario']))
        $where .= " and idusuario = " . $param['idusuario'];
      if (isset($param['usnombre']))
        $where .= " and usnombre = '" . $param['usnombre'] . "'";
      if (isset($param['uspass']))
        $where .= " and uspass = " . $param['uspass'];
      if (isset($param['usmail']))
        $where .= " and usmail = '" . $param['usmail'] . "'";
      if (isset($param['usdeshabilitado']))
        $where .= " and usdeshabilitado = '" . $param['usdeshabilitado'] . "'";
    }
    $obj = new Usuario();
    $arreglo = $obj->listar($where);
    return $arreglo;
  }
}
