<?php
class ABMCompraEstado
{
  public function cambiarEstado($idCompra, $accion)
  {
    $response = ["success" => false, "msg" => "Acción no válida."];
    $objAbmUsuario = new ABMUsuario();
    $objAbmCompra = new ABMCompra();
    $objAbmProducto = new ABMProducto();
    $objAbmCompraItem = new ABMCompraItem();

    // Buscar estado actual de la compra
    $estadoActual = $this->buscar(['idcompra' => $idCompra]);
    if (empty($estadoActual)) {
      $response["msg"] = "No hay estado.";
      return $response;
    }

    $ultimoEstado = end($estadoActual);
    $items = $objAbmCompraItem->buscar(['idcompra' => $idCompra]);
    $productos = [];

    // Validar stock de productos
    $cantidadValida = true;
    foreach ($items as $item) {
      $producto = $objAbmProducto->buscar(["idproducto" => $item->getidproducto()])[0];
      if ($producto->getprocantstock() < $item->getcicantidad()) {
        $cantidadValida = false;
      }
      $productos[] = [
        'idproducto' => $producto->getidproducto(),
        'precio' => $producto->getprecio(),
        'pronombre' => $producto->getpronombre(),
        'prodetalle' => $producto->getprodetalle(),
        'procantstock' => $producto->getprocantstock(),
        'cantidad' => $item->getcicantidad(),
      ];
    }

    $compra = $objAbmCompra->buscar(['idcompra' => $idCompra])[0];
    $usuario = $objAbmUsuario->buscar(["idusuario" => $compra->getidusuario()])[0];
    $nombre = $usuario->getusnombre();
    $email = $usuario->getusmail();

    switch ($accion) {
      case 'aceptar':
        if ($cantidadValida && $this->actualizarEstado($ultimoEstado, $idCompra, 2)) {
          foreach ($productos as $prod) {
            $paramProd = [
              'idproducto' => $prod['idproducto'],
              'precio' => $prod['precio'],
              'pronombre' => $prod['pronombre'],
              'prodetalle' => $prod['prodetalle'],
              'procantstock' => $prod['procantstock'] - $prod["cantidad"],
            ];
            $objAbmProducto->modificacion($paramProd);
          }
          $response = ["success" => true, "msg" => "Estado actualizado a aceptado."];
          enviarCorreo($email, $nombre, 'Compra Aceptada', 'Tu compra ha sido aceptada.');
        } else {
          $response["msg"] = "No hay suficiente stock.";
        }
        break;

      case 'enviar':
        if ($this->actualizarEstado($ultimoEstado, $idCompra, 3)) {
          $response = ["success" => true, "msg" => "Estado actualizado a enviado."];
          enviarCorreo($email, $nombre, 'Compra Enviada', 'Tu compra ha sido enviada.');
        } else {
          $response["msg"] = "No se pudo actualizar el estado.";
        }
        break;

      case 'cancelar':
        if ($this->actualizarEstado($ultimoEstado, $idCompra, 4)) {
          foreach ($productos as $prod) {
            $paramProd = [
              'idproducto' => $prod['idproducto'],
              'precio' => $prod['precio'],
              'pronombre' => $prod['pronombre'],
              'prodetalle' => $prod['prodetalle'],
              'procantstock' => $prod['procantstock'] + $prod["cantidad"],
            ];
            $objAbmProducto->modificacion($paramProd);
          }
          $response = ["success" => true, "msg" => "Estado actualizado a cancelado."];
          enviarCorreo($email, $nombre, 'Compra Cancelada', 'Tu compra ha sido cancelada.');
        } else {
          $response["msg"] = "No se pudo actualizar el estado.";
        }
        break;

      default:
        $response["msg"] = "Acción no reconocida.";
        break;
    }

    return $response;
  }

  private function actualizarEstado($ultimoEstado, $idCompra, $nuevoEstado)
  {
    $paramModificacion = [
      'idcompraestado' => $ultimoEstado->getidcompraestado(),
      "idcompra" => $idCompra,
      'idcompraestadotipo' => $ultimoEstado->getidcompraestadotipo(),
      'cefechaini' => $ultimoEstado->getcefechaini(),
      'cefechafin' => date('Y-m-d H:i:s'),
    ];
    $resultadoMod = $this->modificacion($paramModificacion);

    $paramNuevoEstado = [
      'idcompra' => $idCompra,
      'idcompraestadotipo' => $nuevoEstado,
      'cefechaini' => date('Y-m-d H:i:s'),
      'cefechafin' => null,
    ];
    $resultadoAlta = $this->alta($paramNuevoEstado);

    return $resultadoMod && $resultadoAlta;
  }

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
