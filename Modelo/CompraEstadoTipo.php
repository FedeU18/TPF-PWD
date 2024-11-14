<?php

class CompraEstadoTipo extends BaseDatos
{
  private $idcompraestadotipo;
  private $cetdescripcion;
  private $cetdetalle;

  private $mensajeoperacion;

  public function __construct()
  {
    parent::__construct();
    $this->idcompraestadotipo = "";
    $this->cetdescripcion = "";
    $this->cetdetalle = "";
    $this->mensajeoperacion = "";
  }

  public function setear($idcompraestadotipo, $cetdescripcion, $cetdetalle)
  {
    $this->setidcompraestadotipo($idcompraestadotipo);
    $this->setcetdescripcion($cetdescripcion);
    $this->setcetdetalle($cetdetalle);
  }

  public function getidcompraestadotipo()
  {
    return $this->idcompraestadotipo;
  }
  public function setidcompraestadotipo($idcompraestadotipo)
  {
    $this->idcompraestadotipo = $idcompraestadotipo;
  }

  public function getcetdescripcion()
  {
    return $this->cetdescripcion;
  }
  public function setcetdescripcion($cetdescripcion)
  {
    $this->cetdescripcion = $cetdescripcion;
  }

  public function getcetdetalle()
  {
    return $this->cetdetalle;
  }
  public function setcetdetalle($cetdetalle)
  {
    $this->cetdetalle = $cetdetalle;
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
    $sql = "SELECT * FROM compraestadotipo WHERE idcompraestadotipo = " . $this->getidcompraestadotipo();
    if ($this->Iniciar()) {
      $res = $this->Ejecutar($sql);
      if ($res > -1) {
        if ($res > 0) {
          $row = $this->Registro();
          $this->setear($row['idcompraestadotipo'], $row['cetdescripcion'], $row['cetdetalle']);
          $resp = true;
        }
      }
    } else {
      $this->setmensajeoperacion("compraestadotipo->cargar: " . $this->getError());
    }
    return $resp;
  }

  public function insertar()
  {
    $resp = false;
    $sql = "INSERT INTO compraestadotipo (cetdescripcion, cetdetalle) VALUES ('" . $this->getcetdescripcion() . "', '" . $this->getcetdetalle() . "');";
    if ($this->Iniciar()) {
      if ($elid = $this->Ejecutar($sql)) {
        $this->setidcompraestadotipo($elid);
        $resp = true;
      } else {
        $this->setmensajeoperacion("compraestadotipo->insertar: " . $this->getError());
      }
    } else {
      $this->setmensajeoperacion("compraestadotipo->insertar: " . $this->getError());
    }
    return $resp;
  }

  public function modificar()
  {
    $resp = false;
    $sql = "UPDATE compraestadotipo SET cetdescripcion='" . $this->getcetdescripcion() . "', cetdetalle='" . $this->getcetdetalle() . "' WHERE idcompraestadotipo=" . $this->getidcompraestadotipo();
    if ($this->Iniciar()) {
      if ($this->Ejecutar($sql)) {
        $resp = true;
      } else {
        $this->setmensajeoperacion("compraestadotipo->modificar: " . $this->getError());
      }
    } else {
      $this->setmensajeoperacion("compraestadotipo->modificar: " . $this->getError());
    }
    return $resp;
  }

  public function eliminar()
  {
    $resp = false;
    $sql = "DELETE FROM compraestadotipo WHERE idcompraestadotipo=" . $this->getidcompraestadotipo();
    if ($this->Iniciar()) {
      if ($this->Ejecutar($sql)) {
        $resp = true;
      } else {
        $this->setmensajeoperacion("compraestadotipo->eliminar: " . $this->getError());
      }
    } else {
      $this->setmensajeoperacion("compraestadotipo->eliminar: " . $this->getError());
    }
    return $resp;
  }

  public function listar($parametro = "")
  {
    $arreglo = array();
    $sql = "SELECT * FROM compraestadotipo ";
    if ($parametro != "") {
      $sql .= "WHERE " . $parametro;
    }
    if ($this->Iniciar()) {
      $res = $this->Ejecutar($sql);
      if ($res > -1) {
        if ($res > 0) {
          while ($row = $this->Registro()) {
            $obj = new CompraEstadoTipo();
            $obj->setear($row['idcompraestadotipo'], $row['cetdescripcion'], $row['cetdetalle']);
            array_push($arreglo, $obj);
          }
        }
      } else {
        $this->setmensajeoperacion("compraestadotipo->listar: " . $this->getError());
      }
    }
    return $arreglo;
  }
}
