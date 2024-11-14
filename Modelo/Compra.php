<?php

class Compra extends BaseDatos
{
  private $idcompra;
  private $cofecha;
  private $idusuario;

  private $mensajeoperacion;

  public function __construct()
  {
    parent::__construct();
    $this->idcompra = "";
    $this->cofecha = "";
    $this->idusuario = "";
    $this->mensajeoperacion = "";
  }

  public function setear($idcompra, $cofecha, $idusuario)
  {
    $this->setidcompra($idcompra);
    $this->setcofecha($cofecha);
    $this->setidusuario($idusuario);
  }

  public function getidcompra()
  {
    return $this->idcompra;
  }
  public function setidcompra($idcompra)
  {
    $this->idcompra = $idcompra;
  }

  public function getcofecha()
  {
    return $this->cofecha;
  }
  public function setcofecha($cofecha)
  {
    $this->cofecha = $cofecha;
  }

  public function getidusuario()
  {
    return $this->idusuario;
  }
  public function setidusuario($idusuario)
  {
    $this->idusuario = $idusuario;
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
    $sql = "SELECT * FROM compra WHERE idcompra = " . $this->getidcompra();
    if ($this->Iniciar()) {
      $res = $this->Ejecutar($sql);
      if ($res > -1) {
        if ($res > 0) {
          $row = $this->Registro();
          $this->setear($row['idcompra'], $row['cofecha'], $row['idusuario']);
          $resp = true;
        }
      }
    } else {
      $this->setmensajeoperacion("compra->cargar: " . $this->getError());
    }
    return $resp;
  }

  public function insertar()
  {
    $resp = false;
    $sql = "INSERT INTO compra (cofecha, idusuario) VALUES ('" . $this->getcofecha() . "', '" . $this->getidusuario() . "');";
    if ($this->Iniciar()) {
      if ($elid = $this->Ejecutar($sql)) {
        $this->setidcompra($elid);
        $resp = true;
      } else {
        $this->setmensajeoperacion("compra->insertar: " . $this->getError());
      }
    } else {
      $this->setmensajeoperacion("compra->insertar: " . $this->getError());
    }
    return $resp;
  }

  public function modificar()
  {
    $resp = false;
    $sql = "UPDATE compra SET cofecha='" . $this->getcofecha() . "', idusuario='" . $this->getidusuario() . "' WHERE idcompra=" . $this->getidcompra();
    if ($this->Iniciar()) {
      if ($this->Ejecutar($sql)) {
        $resp = true;
      } else {
        $this->setmensajeoperacion("compra->modificar: " . $this->getError());
      }
    } else {
      $this->setmensajeoperacion("compra->modificar: " . $this->getError());
    }
    return $resp;
  }

  public function eliminar()
  {
    $resp = false;
    $sql = "DELETE FROM compra WHERE idcompra=" . $this->getidcompra();
    if ($this->Iniciar()) {
      if ($this->Ejecutar($sql)) {
        $resp = true;
      } else {
        $this->setmensajeoperacion("compra->eliminar: " . $this->getError());
      }
    } else {
      $this->setmensajeoperacion("compra->eliminar: " . $this->getError());
    }
    return $resp;
  }

  public function listar($parametro = "")
  {
    $arreglo = array();
    $sql = "SELECT * FROM compra ";
    if ($parametro != "") {
      $sql .= "WHERE " . $parametro;
    }
    if ($this->Iniciar()) {
      $res = $this->Ejecutar($sql);
      if ($res > -1) {
        if ($res > 0) {
          while ($row = $this->Registro()) {
            $obj = new Compra();
            $obj->setear($row['idcompra'], $row['cofecha'], $row['idusuario']);
            array_push($arreglo, $obj);
          }
        }
      } else {
        $this->setmensajeoperacion("compra->listar: " . $this->getError());
      }
    }
    return $arreglo;
  }
}
