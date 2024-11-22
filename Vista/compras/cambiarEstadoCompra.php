<?php
include_once "../../config.php";


$datos = data_submitted();
$response = ["success" => false, "msg" => "Acción no válida."];

if (isset($datos['idcompra']) && isset($datos['accion'])) {
  $idCompra = $datos['idcompra'];
  $accion = $datos['accion'];

  //instanciar abm
  $objAbmUsuario = new ABMUsuario();
  $objAbmCompra = new ABMCompra();
  $objAbmCompraEstado = new ABMCompraEstado();
  $objAbmProducto = new ABMProducto();
  $objAbmCompraItem = new ABMCompraItem();

  //buscar estado actual de la compra
  $estadoActual = $objAbmCompraEstado->buscar(['idcompra' => $idCompra]);
  $items = $objAbmCompraItem->buscar(['idcompra' => $idCompra]);
  $cantidadValida = false;
  $productos = [];
  foreach ($items as $item) {
    $producto = $objAbmProducto->buscar(["idproducto" => $item->getidproducto()])[0];
    if ($producto->getprocantstock() >= $item->getcicantidad()) {
      $cantidadValida = true;
    } else {
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

  //verificar si la compra tiene un estado y si es el estado correcto
  if (empty($estadoActual)) {
    $response["success"] = false;
    $response["msg"] = "No hay estado";
  }

  //obtener ultimo estado de la compra
  $ultimoEstado = end($estadoActual); //se asume que el ultimo estado es el estado actual

  //obtener el email y user de la compra
  $compra = $objAbmCompra->buscar(['idcompra' => $idCompra])[0];
  $usuario = $objAbmUsuario->buscar(["idusuario" => $compra->getidusuario()])[0];
  $nombre = $usuario->getusnombre();
  $email = $usuario->getusmail();


  //verificar si el estado actual es 'iniciada', 'aceptada' o 'enviada' para cambiar
  switch ($accion) {
    case 'aceptar':
      //si el estado actual es 'iniciada', cambiamos el estado a 'aceptada'
      if (($ultimoEstado->getcefechafin() == '0000-00-00 00:00:00' || $ultimoEstado->getcefechafin() == null) && $ultimoEstado->getcefechaini() != '0000-00-00 00:00:00') {
        //establecer fecha de inicio y dejar fecha fin NULL
        if ($cantidadValida) {
          $nuevoEstado = 2; //estado aceptada
          $paramNuevoEstado = [
            'idcompra' => $idCompra,
            'idcompraestadotipo' => $nuevoEstado,
            'cefechaini' => date('Y-m-d H:i:s'), //usamos la fecha y hora actual
            'cefechafin' => null
          ];
          $paramModificacion = [
            'idcompraestado' => $ultimoEstado->getidcompraestado(),
            "idcompra" => $idCompra,
            'idcompraestadotipo' => $ultimoEstado->getidcompraestadotipo(),
            'cefechaini' => $ultimoEstado->getcefechaini(),
            'cefechafin' => date('Y-m-d H:i:s')
          ];
          $resultado = $objAbmCompraEstado->modificacion($paramModificacion);
          $resultadoAlta = $objAbmCompraEstado->alta($paramNuevoEstado);
          //actualizar stock

          foreach ($productos as $prod) {
            $paramProd = [
              'idproducto' => $prod['idproducto'],
              'precio' => $prod['precio'],
              'pronombre' => $prod['pronombre'],
              'prodetalle' => $prod['prodetalle'],
              'procantstock' => $prod['procantstock'] - $prod["cantidad"],
            ];
            $responseProd = $objAbmProducto->modificacion($paramProd);
            if ($responseProd) {
              $response["success"] = true;
            } else {
              $response["success"] = false;
              $response["msg"] = "No se pudo actualizar el stock";
            }
          }

          if ($resultado && $resultadoAlta) {
            $response["success"] = true;
            $response["msg"] = "Estado Actualizado";
          } else {
            $response["success"] = false;
            $response["msg"] = "No se pudo actualizar el estado";
          }
        } else {
          $response["success"] = false;
          $response["msg"] = "No se pudo actualizar el estado, no hay suficiente stock en los productos solicitados";
        }
      }
      $subject = 'Compra Aceptada';
      $body = 'Tu compra ha sido aceptada. Pronto recibirás más detalles.';
      break;

    case 'enviar':
      //si el estado actual es 'aceptada', cambiamos el estado a 'enviada'
      if ($ultimoEstado->getcefechafin() == '0000-00-00 00:00:00' && $ultimoEstado->getcefechaini() != '0000-00-00 00:00:00') {
        //establecer fecha de inicio y fecha fin con el tiempo actual
        $nuevoEstado = 3; //estado enviada
        $paramNuevoEstado = [
          'idcompra' => $idCompra,
          'idcompraestadotipo' => $nuevoEstado,
          'cefechaini' => date('Y-m-d H:i:s'), //usamos la fecha y hora actual
          'cefechafin' => null
        ];
        $paramModificacion = [
          'idcompraestado' => $ultimoEstado->getidcompraestado(),
          "idcompra" => $idCompra,
          'idcompraestadotipo' => $ultimoEstado->getidcompraestadotipo(),
          'cefechaini' => $ultimoEstado->getcefechaini(),
          'cefechafin' => date('Y-m-d H:i:s')
        ];
        $resultado = $objAbmCompraEstado->modificacion($paramModificacion);
        $resultadoAlta = $objAbmCompraEstado->alta($paramNuevoEstado);
        if ($resultado && $resultadoAlta) {
          $response["success"] = true;
          $response["msg"] = "Estado Actualizado";
        } else {
          $response["success"] = false;
          $response["msg"] = "No se pudo actualizar el estado";
        }
      }
      $subject = 'Compra Enviada';
      $body = 'Tu compra ha sido enviada. Estará llegando pronto.';
      break;

case 'cancelar':
    //si el estado actual es 'iniciada' o 'aceptada', cambiamos el estado a 'cancelada'
    $nuevoEstado = 4;//estado cancelada
    $paramNuevoEstado = [
        'idcompra' => $idCompra,
        'idcompraestadotipo' => $nuevoEstado,
        'cefechaini' => date('Y-m-d H:i:s'), //usar fecha actual
        'cefechafin' => null
    ];
    $paramModificacion = [
        'idcompraestado' => $ultimoEstado->getidcompraestado(),
        "idcompra" => $idCompra,
        'idcompraestadotipo' => $ultimoEstado->getidcompraestadotipo(),
        'cefechaini' => $ultimoEstado->getcefechaini(),
        'cefechafin' => date('Y-m-d H:i:s')
    ];

    //actualizar estado de la compra
    $resultado = $objAbmCompraEstado->modificacion($paramModificacion);
    $resultadoAlta = $objAbmCompraEstado->alta($paramNuevoEstado);

    if ($resultado && $resultadoAlta) {
        //recuperar el stock de los productos asociados a la compra
        $recuperacionExitosa = true;
        foreach ($productos as $prod) {
            $paramProd = [
                'idproducto' => $prod['idproducto'],
                'precio' => $prod['precio'],
                'pronombre' => $prod['pronombre'],
                'prodetalle' => $prod['prodetalle'],
                'procantstock' => $prod['procantstock'] + $prod["cantidad"],//sumar cant del stock
            ];
            $responseProd = $objAbmProducto->modificacion($paramProd);
            if (!$responseProd) {
                $recuperacionExitosa = false;
                $response["msg"] = "No se pudo recuperar el stock del producto ID: " . $prod['idproducto'];
                break;
            }
        }

        if ($recuperacionExitosa) {
            $response["success"] = true;
            $response["msg"] = "Estado Actualizado y stock recuperado";
        } else {
            $response["success"] = false;
            $response["msg"] = "Estado cancelado, pero ocurrió un error al recuperar el stock.";
        }
    } else {
        $response["success"] = false;
        $response["msg"] = "No se pudo actualizar el estado a cancelado";
    }

    $subject = 'Compra Cancelada';
    $body = 'Lamentamos informarte que tu compra ha sido cancelada.';
    break;

    default:
      echo 'error3';
      exit;
  }
} else {
  $response["success"] = false;
  $response["msg"] = "Error al actualizar el estado";
}

enviarCorreo($email, $nombre, $subject, $body);
header('Content-Type: application/json');
echo json_encode($response);
exit;