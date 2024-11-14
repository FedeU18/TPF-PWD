<?php
class ABMUsuarioRol
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
    if (array_key_exists('idusuario', $param) && array_key_exists('idrol', $param)) {
      $obj = new UsuarioRol();
      $obj->setear($param['idusuario'], $param['idrol']);
    }
    return $obj;
  }

  private function cargarObjetoConClave($param)
  {
    $obj = null;
    if (isset($param['idusuario']) && isset($param['idrol'])) {
      $obj = new UsuarioRol();
      $obj->setear($param['idusuario'], $param['idrol']);
    }
    return $obj;
  }

  private function seteadosCamposClaves($param)
  {
    return isset($param['idusuario']) && isset($param['idrol']);
  }

  public function alta($param)
  {
    $resp = false;
    $elObjUsuarioRol = $this->cargarObjeto($param);
    if ($elObjUsuarioRol != null && $elObjUsuarioRol->insertar()) {
      $resp = true;
    }
    return $resp;
  }

  public function baja($param)
  {
    $resp = false;
    if ($this->seteadosCamposClaves($param)) {
      $elObjUsuarioRol = $this->cargarObjetoConClave($param);
      if ($elObjUsuarioRol != null && $elObjUsuarioRol->eliminar()) {
        $resp = true;
      }
    }
    return $resp;
  }

  public function modificacion($param)
  {
    // No se puede modificar un registro de UsuarioRol, ya que la combinación idusuario-idrol es única y no tiene campos adicionales para modificar
    return false;
  }

  public function buscar($param)
  {
    $where = "true";
    if ($param != null) {
      if (isset($param['idusuario']))
        $where .= " and idusuario = " . $param['idusuario'];
      if (isset($param['idrol']))
        $where .= " and idrol = " . $param['idrol'];
    }
    $obj = new UsuarioRol();
    $arreglo = $obj->listar($where);
    return $arreglo;
  }
}
