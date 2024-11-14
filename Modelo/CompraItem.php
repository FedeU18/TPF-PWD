<?php

class CompraItem extends BaseDatos
{
  private $idcompraitem;
  private $idproducto;
  private $idcompra;
  private $cicantidad;

  private $mensajeoperacion;

  public function __construct()
  {
    parent::__construct();
    $this->idcompraitem = "";
    $this->idproducto = "";
    $this->idcompra = "";
    $this->cicantidad = "";
    $this->mensajeoperacion = "";
  }

  public function setear($idcompraitem, $idproducto, $idcompra, $cicantidad)
  {
    $this->setidcompraitem($idcompraitem);
    $this->setidproducto($idproducto);
    $this->setidcompra($idcompra);
    $this->setcicantidad($cicantidad);
  }

  public function getidcompraitem()
  {
    return $this->idcompraitem;
  }
  public function setidcompraitem($idcompraitem)
  {
    $this->idcompraitem = $idcompraitem;
  }

  public function getidproducto()
  {
    return $this->idproducto;
  }
  public function setidproducto($idproducto)
  {
    $this->idproducto = $idproducto;
  }

  public function getidcompra()
  {
    return $this->idcompra;
  }
  public function setidcompra($idcompra)
  {
    $this->idcompra = $idcompra;
  }

  public function getcicantidad()
  {
    return $this->cicantidad;
  }
  public function setcicantidad($cicantidad)
  {
    $this->cicantidad = $cicantidad;
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
    $sql = "SELECT * FROM compraitem WHERE idcompraitem = " . $this->getidcompraitem();
    if ($this->Iniciar()) {
      $res = $this->Ejecutar($sql);
      if ($res > -1) {
        if ($res > 0) {
          $row = $this->Registro();
          $this->setear($row['idcompraitem'], $row['idproducto'], $row['idcompra'], $row['cicantidad']);
          $resp = true;
        }
      }
    } else {
      $this->setmensajeoperacion("compraitem->cargar: " . $this->getError());
    }
    return $resp;
  }

  public function insertar()
  {
    $resp = false;
    $sql = "INSERT INTO compraitem (idproducto, idcompra, cicantidad) VALUES ('" . $this->getidproducto() . "', '" . $this->getidcompra() . "', '" . $this->getcicantidad() . "');";
    if ($this->Iniciar()) {
      if ($elid = $this->Ejecutar($sql)) {
        $this->setidcompraitem($elid);
        $resp = true;
      } else {
        $this->setmensajeoperacion("compraitem->insertar: " . $this->getError());
      }
    } else {
      $this->setmensajeoperacion("compraitem->insertar: " . $this->getError());
    }
    return $resp;
  }

  public function modificar()
  {
    $resp = false;
    $sql = "UPDATE compraitem SET idproducto='" . $this->getidproducto() . "', idcompra='" . $this->getidcompra() . "', cicantidad='" . $this->getcicantidad() . "' WHERE idcompraitem=" . $this->getidcompraitem();
    if ($this->Iniciar()) {
      if ($this->Ejecutar($sql)) {
        $resp = true;
      } else {
        $this->setmensajeoperacion("compraitem->modificar: " . $this->getError());
      }
    } else {
      $this->setmensajeoperacion("compraitem->modificar: " . $this->getError());
    }
    return $resp;
  }

  public function eliminar()
  {
    $resp = false;
    $sql = "DELETE FROM compraitem WHERE idcompraitem=" . $this->getidcompraitem();
    if ($this->Iniciar()) {
      if ($this->Ejecutar($sql)) {
        $resp = true;
      } else {
        $this->setmensajeoperacion("compraitem->eliminar: " . $this->getError());
      }
    } else {
      $this->setmensajeoperacion("compraitem->eliminar: " . $this->getError());
    }
    return $resp;
  }

  public function listar($parametro = "")
  {
    $arreglo = array();
    $sql = "SELECT * FROM compraitem ";
    if ($parametro != "") {
      $sql .= "WHERE " . $parametro;
    }
    if ($this->Iniciar()) {
      $res = $this->Ejecutar($sql);
      if ($res > -1) {
        if ($res > 0) {
          while ($row = $this->Registro()) {
            $obj = new CompraItem();
            $obj->setear($row['idcompraitem'], $row['idproducto'], $row['idcompra'], $row['cicantidad']);
            array_push($arreglo, $obj);
          }
        }
      } else {
        $this->setmensajeoperacion("compraitem->listar: " . $this->getError());
      }
    }
    return $arreglo;
  }
}
