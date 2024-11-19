<?php

class Session
{

  //construct q inicia la sesion si no esta activa
  public function __construct()
  {
    if (session_status() !== PHP_SESSION_ACTIVE) {
      session_start();
    }
  }

  //actualiza variables de sesion con el id del user
  public function iniciar($nombreUser, $psw)
  {
    $resp = false;
    $obj = new ABMUsuario();
    $param = [
      "usnombre" => $nombreUser,
      "usdeshabilitado" => NULL
    ];

    //buscar user
    $res = $obj->buscar($param);

    //Si el res no esta vacio, le asigna el id del user a la sesion
    if (!empty($res)) {
      $usuario = $res[0];
      if (password_verify($psw, $usuario->getuspass())) {
        $_SESSION['idUsuario'] = $usuario->getidusuario();
        $resp = true;
      }
    } else {
      //si no encuentra al user se cierra la sesion
      $this->cerrar();
    }

    return $resp;
  }

  //valida si la sesion actual tiene un id de user valido
  public function validar()
  {
    return isset($_SESSION['idUsuario']);
  }

  //devolver true o false si la sesion esta activa o no
  public function activa()
  {
    return session_status() === PHP_SESSION_ACTIVE && $this->validar();
  }

  //devolver user logueado
  public function getUsuario()
  {
    return $this->validar() ? $_SESSION['idUsuario'] : null;
  }

  //devolver rol del user logueado
  public function getRol()
  {
    $rol = null;  //valor x defecto

    $idUsuario = $this->getUsuario();
    if ($idUsuario) {
      $abmUserRol = new ABMUsuarioRol();
      $usuarioRoles = $abmUserRol->buscar(['idusuario' => $idUsuario]);

      if (!empty($usuarioRoles)) {
        $rol = $usuarioRoles[0]->getidrol();  //asignar rol
      }
    }
    return $rol;
  }

  //cerrar sesion actual
  public function cerrar()
  {
    session_unset();
    session_destroy();
  }

  //funcionalidades del Carrito 

  //agregar un producto al carrito
  public function agregarAlCarrito($idProducto, $cantidad)
  {
    if (!isset($_SESSION['carrito'])) {
      $_SESSION['carrito'] = [];
    }

    if (isset($_SESSION['carrito'][$idProducto])) {
      $_SESSION['carrito'][$idProducto] += $cantidad;
    } else {
      $_SESSION['carrito'][$idProducto] = $cantidad;
    }
  }

  public function reducirCantidad($idProducto)
  {
    $resp = false;
    if (isset($_SESSION['carrito'][$idProducto])) {
      $cantidad = $_SESSION['carrito'][$idProducto];
      if ($cantidad > 1) {
        $cantidad--;
        $_SESSION['carrito'][$idProducto] = $cantidad;
        $resp = true;
      } else if ($cantidad == 1) {
        $resp = $this->eliminarDelCarrito($idProducto);
      }
    }
    return $resp;
  }

  //eliminar un producto del carrito
  public function eliminarDelCarrito($idProducto)
  {
    $resp = false;
    if (isset($_SESSION['carrito'][$idProducto])) {
      unset($_SESSION['carrito'][$idProducto]);
      $resp = true;
    }
    return $resp;
  }

  //vaciar el carrito
  public function vaciarCarrito()
  {
    $_SESSION['carrito'] = [];
  }

  //obtener los productos del carrito
  public function obtenerProductosCarrito()
  {
    return $_SESSION['carrito'] ?? []; // Devuelve el carrito o un array vacío
  }

  //actualizar todo el carrito con nuevos datos
  public function actualizarProductosCarrito($nuevoCarrito)
  {
    if (is_array($nuevoCarrito)) {
      $_SESSION['carrito'] = $nuevoCarrito;
    }
  }

  //obtener el total de productos en el carrito
  public function totalProductosCarrito()
  {
    if (!isset($_SESSION['carrito'])) {
      return 0;
    }

    $total = 0;
    foreach ($_SESSION['carrito'] as $cantidad) {
      $total += $cantidad;
    }

    return $total;
  }

  //obtener la cantidad de un producto específico en el carrito
  public function cantidadProductoEnCarrito($idProducto)
  {
    return $_SESSION['carrito'][$idProducto] ?? 0;
  }
}
