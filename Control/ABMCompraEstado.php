<?php
class ABMCompraEstado
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
    if (array_key_exists('idcompraestado', $param) && array_key_exists('idcompra', $param) && array_key_exists('idcompraestadotipo', $param) && array_key_exists('cefechaini', $param) && array_key_exists('cefechafin', $param)) {
      $obj = new CompraEstado();
      $obj->setear($param['idcompraestado'], $param['idcompra'], $param['idcompraestadotipo'], $param['cefechaini'], $param['cefechafin']);
    }
    return $obj;
  }

  private function cargarObjetoConClave($param)
  {
    $obj = null;
    if (isset($param['idcompraestado'])) {
      $obj = new CompraEstado();
      $obj->setear($param['idcompraestado'], null, null, null, null);
    }
    return $obj;
  }

  private function seteadosCamposClaves($param)
  {
    return isset($param['idcompraestado']);
  }

  public function alta($param)
  {
    $resp = false;
    $param['idcompraestado'] = null;
    $elObjCompraEstado = $this->cargarObjeto($param);
    if ($elObjCompraEstado != null && $elObjCompraEstado->insertar()) {
      $resp = true;
    }
    return $resp;
  }

  public function baja($param)
  {
    $resp = false;
    if ($this->seteadosCamposClaves($param)) {
      $elObjCompraEstado = $this->cargarObjetoConClave($param);
      if ($elObjCompraEstado != null && $elObjCompraEstado->eliminar()) {
        $resp = true;
      }
    }
    return $resp;
  }

  public function modificacion($param)
  {
    $resp = false;
    if ($this->seteadosCamposClaves($param)) {
      $elObjCompraEstado = $this->cargarObjeto($param);
      if ($elObjCompraEstado != null && $elObjCompraEstado->modificar()) {
        $resp = true;
      }
    }
    return $resp;
  }

  public function buscar($param)
  {
    $where = "true";
    if ($param != null) {
      if (isset($param['idcompraestado']))
        $where .= " and idcompraestado = " . $param['idcompraestado'];
      if (isset($param['idcompra']))
        $where .= " and idcompra = " . $param['idcompra'];
      if (isset($param['idcompraestadotipo']))
        $where .= " and idcompraestadotipo = " . $param['idcompraestadotipo'];
      if (isset($param['cefechaini']))
        $where .= " and cefechaini = '" . $param['cefechaini'] . "'";
      if (isset($param['cefechafin']))
        $where .= " and cefechafin = '" . $param['cefechafin'] . "'";
    }
    $obj = new CompraEstado();
    $arreglo = $obj->listar($where);
    return $arreglo;
  }
}
