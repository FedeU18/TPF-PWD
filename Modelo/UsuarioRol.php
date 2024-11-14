<?php

class UsuarioRol extends BaseDatos
{
  private $idusuario;
  private $idrol;

  private $mensajeoperacion;

  public function __construct()
  {
    parent::__construct();
    $this->idusuario = "";
    $this->idrol = "";
    $this->mensajeoperacion = "";
  }

  public function setear($idusuario, $idrol)
  {
    $this->setidusuario($idusuario);
    $this->setidrol($idrol);
  }

  public function getidusuario()
  {
    return $this->idusuario;
  }
  public function setidusuario($idusuario)
  {
    $this->idusuario = $idusuario;
  }

  public function getidrol()
  {
    return $this->idrol;
  }
  public function setidrol($idrol)
  {
    $this->idrol = $idrol;
  }

  public function getmensajeoperacion()
  {
    return $this->mensajeoperacion;
  }
  public function setmensajeoperacion($valor)
  {
    $this->mensajeoperacion = $valor;
  }

  public function cargar()
  {
    $resp = false;
    $sql = "SELECT * FROM usuariorol WHERE idusuario = " . $this->getidusuario() . " AND idrol = " . $this->getidrol();
    if ($this->Iniciar()) {
      $res = $this->Ejecutar($sql);
      if ($res > -1) {
        if ($res > 0) {
          $row = $this->Registro();
          $this->setear($row['idusuario'], $row['idrol']);
          $resp = true;
        }
      }
    } else {
      $this->setmensajeoperacion("usuariorol->cargar: " . $this->getError());
    }
    return $resp;
  }

  public function insertar()
  {
    $resp = false;
    $sql = "INSERT INTO usuariorol (idusuario, idrol) VALUES ('" . $this->getidusuario() . "', '" . $this->getidrol() . "');";
    if ($this->Iniciar()) {
      if ($this->Ejecutar($sql)) {
        $resp = true;
      } else {
        $this->setmensajeoperacion("usuariorol->insertar: " . $this->getError());
      }
    } else {
      $this->setmensajeoperacion("usuariorol->insertar: " . $this->getError());
    }
    return $resp;
  }

  public function eliminar()
  {
    $resp = false;
    $sql = "DELETE FROM usuariorol WHERE idusuario=" . $this->getidusuario() . " AND idrol=" . $this->getidrol();
    if ($this->Iniciar()) {
      if ($this->Ejecutar($sql)) {
        $resp = true;
      } else {
        $this->setmensajeoperacion("usuariorol->eliminar: " . $this->getError());
      }
    } else {
      $this->setmensajeoperacion("usuariorol->eliminar: " . $this->getError());
    }
    return $resp;
  }

  public function listar($parametro = "")
  {
    $arreglo = array();
    $sql = "SELECT * FROM usuariorol ";
    if ($parametro != "") {
      $sql .= "WHERE " . $parametro;
    }
    if ($this->Iniciar()) {
      $res = $this->Ejecutar($sql);
      if ($res > -1) {
        if ($res > 0) {
          while ($row = $this->Registro()) {
            $obj = new UsuarioRol();
            $obj->setear($row['idusuario'], $row['idrol']);
            array_push($arreglo, $obj);
          }
        }
      } else {
        $this->setmensajeoperacion("usuariorol->listar: " . $this->getError());
      }
    }
    return $arreglo;
  }
}
