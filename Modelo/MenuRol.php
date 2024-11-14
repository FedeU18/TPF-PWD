<?php

class MenuRol extends BaseDatos
{
  private $idmenu;
  private $idrol;

  private $mensajeoperacion;

  public function __construct()
  {
    parent::__construct();
    $this->idmenu = "";
    $this->idrol = "";
    $this->mensajeoperacion = "";
  }

  public function setear($idmenu, $idrol)
  {
    $this->setidmenu($idmenu);
    $this->setidrol($idrol);
  }

  public function getidmenu()
  {
    return $this->idmenu;
  }
  public function setidmenu($idmenu)
  {
    $this->idmenu = $idmenu;
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
    $sql = "SELECT * FROM menurol WHERE idmenu = " . $this->getidmenu() . " AND idrol = " . $this->getidrol();
    if ($this->Iniciar()) {
      $res = $this->Ejecutar($sql);
      if ($res > -1) {
        if ($res > 0) {
          $row = $this->Registro();
          $this->setear($row['idmenu'], $row['idrol']);
          $resp = true;
        }
      }
    } else {
      $this->setmensajeoperacion("menurol->cargar: " . $this->getError());
    }
    return $resp;
  }

  public function insertar()
  {
    $resp = false;
    $sql = "INSERT INTO menurol (idmenu, idrol) VALUES ('" . $this->getidmenu() . "', '" . $this->getidrol() . "');";
    if ($this->Iniciar()) {
      if ($this->Ejecutar($sql)) {
        $resp = true;
      } else {
        $this->setmensajeoperacion("menurol->insertar: " . $this->getError());
      }
    } else {
      $this->setmensajeoperacion("menurol->insertar: " . $this->getError());
    }
    return $resp;
  }

  public function modificar()
  {
    $resp = false;
    $sql = "UPDATE menurol SET idrol='" . $this->getidrol() . "' WHERE idmenu=" . $this->getidmenu();
    if ($this->Iniciar()) {
      if ($this->Ejecutar($sql)) {
        $resp = true;
      } else {
        $this->setmensajeoperacion("menurol->modificar: " . $this->getError());
      }
    } else {
      $this->setmensajeoperacion("menurol->modificar: " . $this->getError());
    }
    return $resp;
  }

  public function eliminar()
  {
    $resp = false;
    $sql = "DELETE FROM menurol WHERE idmenu=" . $this->getidmenu() . " AND idrol=" . $this->getidrol();
    if ($this->Iniciar()) {
      if ($this->Ejecutar($sql)) {
        $resp = true;
      } else {
        $this->setmensajeoperacion("menurol->eliminar: " . $this->getError());
      }
    } else {
      $this->setmensajeoperacion("menurol->eliminar: " . $this->getError());
    }
    return $resp;
  }

  public function listar($parametro = "")
  {
    $arreglo = array();
    $sql = "SELECT * FROM menurol ";
    if ($parametro != "") {
      $sql .= "WHERE " . $parametro;
    }
    if ($this->Iniciar()) {
      $res = $this->Ejecutar($sql);
      if ($res > -1) {
        if ($res > 0) {
          while ($row = $this->Registro()) {
            $obj = new MenuRol();
            $obj->setear($row['idmenu'], $row['idrol']);
            array_push($arreglo, $obj);
          }
        }
      } else {
        $this->setmensajeoperacion("menurol->listar: " . $this->getError());
      }
    }
    return $arreglo;
  }
}
