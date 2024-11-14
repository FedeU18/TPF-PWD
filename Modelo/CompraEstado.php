<?php

class CompraEstado extends BaseDatos
{
  private $idcompraestado;
  private $idcompra;
  private $idcompraestadotipo;
  private $cefechaini;
  private $cefechafin;

  private $mensajeoperacion;

  public function __construct()
  {
    parent::__construct();
    $this->idcompraestado = "";
    $this->idcompra = "";
    $this->idcompraestadotipo = "";
    $this->cefechaini = "";
    $this->cefechafin = "";
    $this->mensajeoperacion = "";
  }

  public function setear($idcompraestado, $idcompra, $idcompraestadotipo, $cefechaini, $cefechafin)
  {
    $this->setidcompraestado($idcompraestado);
    $this->setidcompra($idcompra);
    $this->setidcompraestadotipo($idcompraestadotipo);
    $this->setcefechaini($cefechaini);
    $this->setcefechafin($cefechafin);
  }

  public function getidcompraestado()
  {
    return $this->idcompraestado;
  }
  public function setidcompraestado($idcompraestado)
  {
    $this->idcompraestado = $idcompraestado;
  }

  public function getidcompra()
  {
    return $this->idcompra;
  }
  public function setidcompra($idcompra)
  {
    $this->idcompra = $idcompra;
  }

  public function getidcompraestadotipo()
  {
    return $this->idcompraestadotipo;
  }
  public function setidcompraestadotipo($idcompraestadotipo)
  {
    $this->idcompraestadotipo = $idcompraestadotipo;
  }

  public function getcefechaini()
  {
    return $this->cefechaini;
  }
  public function setcefechaini($cefechaini)
  {
    $this->cefechaini = $cefechaini;
  }

  public function getcefechafin()
  {
    return $this->cefechafin;
  }
  public function setcefechafin($cefechafin)
  {
    $this->cefechafin = $cefechafin;
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
    $sql = "SELECT * FROM compraestado WHERE idcompraestado = " . $this->getidcompraestado();
    if ($this->Iniciar()) {
      $res = $this->Ejecutar($sql);
      if ($res > -1) {
        if ($res > 0) {
          $row = $this->Registro();
          $this->setear($row['idcompraestado'], $row['idcompra'], $row['idcompraestadotipo'], $row['cefechaini'], $row['cefechafin']);
          $resp = true;
        }
      }
    } else {
      $this->setmensajeoperacion("compraestado->cargar: " . $this->getError());
    }
    return $resp;
  }

  public function insertar()
  {
    $resp = false;
    $sql = "INSERT INTO compraestado (idcompra, idcompraestadotipo, cefechaini, cefechafin) VALUES ('" . $this->getidcompra() . "', '" . $this->getidcompraestadotipo() . "', '" . $this->getcefechaini() . "', '" . $this->getcefechafin() . "');";
    if ($this->Iniciar()) {
      if ($elid = $this->Ejecutar($sql)) {
        $this->setidcompraestado($elid);
        $resp = true;
      } else {
        $this->setmensajeoperacion("compraestado->insertar: " . $this->getError());
      }
    } else {
      $this->setmensajeoperacion("compraestado->insertar: " . $this->getError());
    }
    return $resp;
  }

  public function modificar()
  {
    $resp = false;
    $sql = "UPDATE compraestado SET idcompra='" . $this->getidcompra() . "', idcompraestadotipo='" . $this->getidcompraestadotipo() . "', cefechaini='" . $this->getcefechaini() . "', cefechafin='" . $this->getcefechafin() . "' WHERE idcompraestado=" . $this->getidcompraestado();
    if ($this->Iniciar()) {
      if ($this->Ejecutar($sql)) {
        $resp = true;
      } else {
        $this->setmensajeoperacion("compraestado->modificar: " . $this->getError());
      }
    } else {
      $this->setmensajeoperacion("compraestado->modificar: " . $this->getError());
    }
    return $resp;
  }

  public function eliminar()
  {
    $resp = false;
    $sql = "DELETE FROM compraestado WHERE idcompraestado=" . $this->getidcompraestado();
    if ($this->Iniciar()) {
      if ($this->Ejecutar($sql)) {
        $resp = true;
      } else {
        $this->setmensajeoperacion("compraestado->eliminar: " . $this->getError());
      }
    } else {
      $this->setmensajeoperacion("compraestado->eliminar: " . $this->getError());
    }
    return $resp;
  }

  public function listar($parametro = "")
  {
    $arreglo = array();
    $sql = "SELECT * FROM compraestado ";
    if ($parametro != "") {
      $sql .= "WHERE " . $parametro;
    }
    if ($this->Iniciar()) {
      $res = $this->Ejecutar($sql);
      if ($res > -1) {
        if ($res > 0) {
          while ($row = $this->Registro()) {
            $obj = new CompraEstado();
            $obj->setear($row['idcompraestado'], $row['idcompra'], $row['idcompraestadotipo'], $row['cefechaini'], $row['cefechafin']);
            array_push($arreglo, $obj);
          }
        }
      } else {
        $this->setmensajeoperacion("compraestado->listar: " . $this->getError());
      }
    }
    return $arreglo;
  }
}
