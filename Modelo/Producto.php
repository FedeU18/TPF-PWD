<?php

class Producto extends BaseDatos
{
  private $idproducto;
  private $pronombre;
  private $prodetalle;
  private $procantstock;

  private $mensajeoperacion;

  public function __construct()
  {
    parent::__construct();
    $this->idproducto = "";
    $this->pronombre = "";
    $this->prodetalle = "";
    $this->procantstock = "";
    $this->mensajeoperacion = "";
  }

  public function setear($idproducto, $pronombre, $prodetalle, $procantstock)
  {
    $this->setidproducto($idproducto);
    $this->setpronombre($pronombre);
    $this->setprodetalle($prodetalle);
    $this->setprocantstock($procantstock);
  }

  public function getidproducto()
  {
    return $this->idproducto;
  }
  public function setidproducto($idproducto)
  {
    $this->idproducto = $idproducto;
  }

  public function getpronombre()
  {
    return $this->pronombre;
  }
  public function setpronombre($pronombre)
  {
    $this->pronombre = $pronombre;
  }

  public function getprodetalle()
  {
    return $this->prodetalle;
  }
  public function setprodetalle($prodetalle)
  {
    $this->prodetalle = $prodetalle;
  }

  public function getprocantstock()
  {
    return $this->procantstock;
  }
  public function setprocantstock($procantstock)
  {
    $this->procantstock = $procantstock;
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
    $sql = "SELECT * FROM producto WHERE idproducto = " . $this->getidproducto();
    if ($this->Iniciar()) {
      $res = $this->Ejecutar($sql);
      if ($res > -1) {
        if ($res > 0) {
          $row = $this->Registro();
          $this->setear($row['idproducto'], $row['pronombre'], $row['prodetalle'], $row['procantstock']);
          $resp = true;
        }
      }
    } else {
      $this->setmensajeoperacion("producto->cargar: " . $this->getError());
    }
    return $resp;
  }

  public function insertar()
  {
    $resp = false;
    $sql = "INSERT INTO producto (pronombre, prodetalle, procantstock) VALUES ('" . $this->getpronombre() . "', '" . $this->getprodetalle() . "', '" . $this->getprocantstock() . "');";
    if ($this->Iniciar()) {
      if ($elid = $this->Ejecutar($sql)) {
        $this->setidproducto($elid);
        $resp = true;
      } else {
        $this->setmensajeoperacion("producto->insertar: " . $this->getError());
      }
    } else {
      $this->setmensajeoperacion("producto->insertar: " . $this->getError());
    }
    return $resp;
  }

  public function modificar()
  {
    $resp = false;
    $sql = "UPDATE producto SET pronombre='" . $this->getpronombre() . "', prodetalle='" . $this->getprodetalle() . "', procantstock='" . $this->getprocantstock() . "' WHERE idproducto=" . $this->getidproducto();
    if ($this->Iniciar()) {
      if ($this->Ejecutar($sql)) {
        $resp = true;
      } else {
        $this->setmensajeoperacion("producto->modificar: " . $this->getError());
      }
    } else {
      $this->setmensajeoperacion("producto->modificar: " . $this->getError());
    }
    return $resp;
  }

  public function eliminar()
  {
    $resp = false;
    $sql = "DELETE FROM producto WHERE idproducto=" . $this->getidproducto();
    if ($this->Iniciar()) {
      if ($this->Ejecutar($sql)) {
        $resp = true;
      } else {
        $this->setmensajeoperacion("producto->eliminar: " . $this->getError());
      }
    } else {
      $this->setmensajeoperacion("producto->eliminar: " . $this->getError());
    }
    return $resp;
  }

  public function listar($parametro = "")
  {
    $arreglo = array();
    $sql = "SELECT * FROM producto ";
    if ($parametro != "") {
      $sql .= "WHERE " . $parametro;
    }
    if ($this->Iniciar()) {
      $res = $this->Ejecutar($sql);
      if ($res > -1) {
        if ($res > 0) {
          while ($row = $this->Registro()) {
            $obj = new Producto();
            $obj->setear($row['idproducto'], $row['pronombre'], $row['prodetalle'], $row['procantstock']);
            array_push($arreglo, $obj);
          }
        }
      } else {
        $this->setmensajeoperacion("producto->listar: " . $this->getError());
      }
    }
    return $arreglo;
  }
}
