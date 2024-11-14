<?php
class ABMCompraItem
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
    if (array_key_exists('idcompraitem', $param) && array_key_exists('idproducto', $param) && array_key_exists('idcompra', $param) && array_key_exists('cicantidad', $param)) {
      $obj = new CompraItem();
      $obj->setear($param['idcompraitem'], $param['idproducto'], $param['idcompra'], $param['cicantidad']);
    }
    return $obj;
  }

  private function cargarObjetoConClave($param)
  {
    $obj = null;
    if (isset($param['idcompraitem'])) {
      $obj = new CompraItem();
      $obj->setear($param['idcompraitem'], null, null, null);
    }
    return $obj;
  }

  private function seteadosCamposClaves($param)
  {
    return isset($param['idcompraitem']);
  }

  public function alta($param)
  {
    $resp = false;
    $param['idcompraitem'] = null;
    $elObjCompraItem = $this->cargarObjeto($param);
    if ($elObjCompraItem != null && $elObjCompraItem->insertar()) {
      $resp = true;
    }
    return $resp;
  }

  public function baja($param)
  {
    $resp = false;
    if ($this->seteadosCamposClaves($param)) {
      $elObjCompraItem = $this->cargarObjetoConClave($param);
      if ($elObjCompraItem != null && $elObjCompraItem->eliminar()) {
        $resp = true;
      }
    }
    return $resp;
  }

  public function modificacion($param)
  {
    $resp = false;
    if ($this->seteadosCamposClaves($param)) {
      $elObjCompraItem = $this->cargarObjeto($param);
      if ($elObjCompraItem != null && $elObjCompraItem->modificar()) {
        $resp = true;
      }
    }
    return $resp;
  }

  public function buscar($param)
  {
    $where = "true";
    if ($param != null) {
      if (isset($param['idcompraitem']))
        $where .= " and idcompraitem = " . $param['idcompraitem'];
      if (isset($param['idproducto']))
        $where .= " and idproducto = " . $param['idproducto'];
      if (isset($param['idcompra']))
        $where .= " and idcompra = " . $param['idcompra'];
      if (isset($param['cicantidad']))
        $where .= " and cicantidad = " . $param['cicantidad'];
    }
    $obj = new CompraItem();
    $arreglo = $obj->listar($where);
    return $arreglo;
  }
}
