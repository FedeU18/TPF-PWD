<?php
class ABMCompra
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

  /**
   * Carga un objeto Compra con los datos proporcionados
   * @param array $param
   * @return Compra|null
   */
  private function cargarObjeto($param)
  {
    $obj = null;
    if (array_key_exists('idcompra', $param) && array_key_exists('cofecha', $param) && array_key_exists('idusuario', $param)) {
      $obj = new Compra();
      $obj->setear($param['idcompra'], $param['cofecha'], $param['idusuario']);
    }
    return $obj;
  }

  /**
   * Carga un objeto Compra usando solo el campo clave idcompra
   * @param array $param
   * @return Compra|null
   */
  private function cargarObjetoConClave($param)
  {
    $obj = null;
    if (isset($param['idcompra'])) {
      $obj = new Compra();
      $obj->setear($param['idcompra'], null, null);
    }
    return $obj;
  }

  /**
   * Verifica si los campos claves están seteados en el arreglo
   * @param array $param
   * @return boolean
   */
  private function seteadosCamposClaves($param)
  {
    return isset($param['idcompra']);
  }

  /**
   * Permite dar de alta un objeto Compra
   * @param array $param
   * @return boolean
   */
  public function alta($param)
  {
    $resp = false;
    $param['idcompra'] = null;  // Se inicializa el idcompra como null para que se genere automáticamente en la BD
    $elObjCompra = $this->cargarObjeto($param);
    if ($elObjCompra != null && $elObjCompra->insertar()) {
      $resp = true;
    }
    return $resp;
  }

  /**
   * Permite eliminar un objeto Compra
   * @param array $param
   * @return boolean
   */
  public function baja($param)
  {
    $resp = false;
    if ($this->seteadosCamposClaves($param)) {
      $elObjCompra = $this->cargarObjetoConClave($param);
      if ($elObjCompra != null && $elObjCompra->eliminar()) {
        $resp = true;
      }
    }
    return $resp;
  }

  /**
   * Permite modificar un objeto Compra
   * @param array $param
   * @return boolean
   */
  public function modificacion($param)
  {
    $resp = false;
    if ($this->seteadosCamposClaves($param)) {
      $elObjCompra = $this->cargarObjeto($param);
      if ($elObjCompra != null && $elObjCompra->modificar()) {
        $resp = true;
      }
    }
    return $resp;
  }

  /**
   * Permite buscar objetos Compra según criterios especificados
   * @param array $param
   * @return array
   */
  public function buscar($param)
  {
    $where = "true";
    if ($param != null) {
      if (isset($param['idcompra']))
        $where .= " and idcompra = " . $param['idcompra'];
      if (isset($param['cofecha']))
        $where .= " and cofecha = '" . $param['cofecha'] . "'";
      if (isset($param['idusuario']))
        $where .= " and idusuario = " . $param['idusuario'];
    }
    $obj = new Compra();
    $arreglo = $obj->listar($where);
    return $arreglo;
  }
}
