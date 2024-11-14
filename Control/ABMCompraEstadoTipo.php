<?php
class ABMCompraEstadoTipo
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
    if (array_key_exists('idcompraestadotipo', $param) && array_key_exists('cetdescripcion', $param) && array_key_exists('cetdetalle', $param)) {
      $obj = new CompraEstadoTipo();
      $obj->setear($param['idcompraestadotipo'], $param['cetdescripcion'], $param['cetdetalle']);
    }
    return $obj;
  }

  private function cargarObjetoConClave($param)
  {
    $obj = null;
    if (isset($param['idcompraestadotipo'])) {
      $obj = new CompraEstadoTipo();
      $obj->setear($param['idcompraestadotipo'], null, null);
    }
    return $obj;
  }

  private function seteadosCamposClaves($param)
  {
    return isset($param['idcompraestadotipo']);
  }

  public function alta($param)
  {
    $resp = false;
    $param['idcompraestadotipo'] = null;
    $elObjCompraEstadoTipo = $this->cargarObjeto($param);
    if ($elObjCompraEstadoTipo != null && $elObjCompraEstadoTipo->insertar()) {
      $resp = true;
    }
    return $resp;
  }

  public function baja($param)
  {
    $resp = false;
    if ($this->seteadosCamposClaves($param)) {
      $elObjCompraEstadoTipo = $this->cargarObjetoConClave($param);
      if ($elObjCompraEstadoTipo != null && $elObjCompraEstadoTipo->eliminar()) {
        $resp = true;
      }
    }
    return $resp;
  }

  public function modificacion($param)
  {
    $resp = false;
    if ($this->seteadosCamposClaves($param)) {
      $elObjCompraEstadoTipo = $this->cargarObjeto($param);
      if ($elObjCompraEstadoTipo != null && $elObjCompraEstadoTipo->modificar()) {
        $resp = true;
      }
    }
    return $resp;
  }

  public function buscar($param)
  {
    $where = "true";
    if ($param != null) {
      if (isset($param['idcompraestadotipo']))
        $where .= " and idcompraestadotipo = " . $param['idcompraestadotipo'];
      if (isset($param['cetdescripcion']))
        $where .= " and cetdescripcion = '" . $param['cetdescripcion'] . "'";
      if (isset($param['cetdetalle']))
        $where .= " and cetdetalle = '" . $param['cetdetalle'] . "'";
    }
    $obj = new CompraEstadoTipo();
    $arreglo = $obj->listar($where);
    return $arreglo;
  }
}
