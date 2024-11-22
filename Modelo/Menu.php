<?php

class Menu extends BaseDatos
{
  private $idmenu;
  private $menombre;
  private $medescripcion;
  private $idpadre;
  private $medeshabilitado;

  private $mensajeoperacion;

  public function __construct()
  {
    parent::__construct();
    $this->idmenu = "";
    $this->menombre = "";
    $this->medescripcion = "";
    $this->idpadre = "";
    $this->medeshabilitado = "";
    $this->mensajeoperacion = "";
  }

  public function setear($idmenu, $menombre, $medescripcion, $idpadre, $medeshabilitado)
  {
    $this->setidmenu($idmenu);
    $this->setmenombre($menombre);
    $this->setmedescripcion($medescripcion);
    $this->setidpadre($idpadre);
    $this->setmedeshabilitado($medeshabilitado);
  }

  public function getidmenu()
  {
    return $this->idmenu;
  }
  public function setidmenu($idmenu)
  {
    $this->idmenu = $idmenu;
  }

  public function getmenombre()
  {
    return $this->menombre;
  }
  public function setmenombre($menombre)
  {
    $this->menombre = $menombre;
  }

  public function getmedescripcion()
  {
    return $this->medescripcion;
  }
  public function setmedescripcion($medescripcion)
  {
    $this->medescripcion = $medescripcion;
  }

  public function getidpadre()
  {
    return $this->idpadre;
  }
  public function setidpadre($idpadre)
  {
    $this->idpadre = $idpadre;
  }

  public function getmedeshabilitado()
  {
    return $this->medeshabilitado;
  }
  public function setmedeshabilitado($medeshabilitado)
  {
    $this->medeshabilitado = $medeshabilitado;
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
    $sql = "SELECT * FROM menu WHERE idmenu = " . $this->getidmenu();
    if ($this->Iniciar()) {
      $res = $this->Ejecutar($sql);
      if ($res > -1) {
        if ($res > 0) {
          $row = $this->Registro();
          $this->setear($row['idmenu'], $row['menombre'], $row['medescripcion'], $row['idpadre'], $row['medeshabilitado']);
          $resp = true;
        }
      }
    } else {
      $this->setmensajeoperacion("menu->cargar: " . $this->getError());
    }
    return $resp;
  }

  public function insertar()
  {
    $resp = false;
    $sql = "INSERT INTO menu (menombre, medescripcion, idpadre, medeshabilitado) VALUES ('" . $this->getmenombre() . "', '" . $this->getmedescripcion() . "', '" . $this->getidpadre() . "', '" . $this->getmedeshabilitado() . "');";
    if ($this->Iniciar()) {
      if ($elid = $this->Ejecutar($sql)) {
        $this->setidmenu($elid);
        $resp = true;
      } else {
        $this->setmensajeoperacion("menu->insertar: " . $this->getError());
      }
    } else {
      $this->setmensajeoperacion("menu->insertar: " . $this->getError());
    }
    return $resp;
  }

  public function modificar()
  {
    $resp = false;
    $sql = "UPDATE menu SET menombre='" . $this->getmenombre() . "', medescripcion='" . $this->getmedescripcion() . "', idpadre='" . $this->getidpadre() . "', medeshabilitado='" . $this->getmedeshabilitado() . "' WHERE idmenu=" . $this->getidmenu();
    if ($this->Iniciar()) {
      if ($this->Ejecutar($sql)) {
        $resp = true;
      } else {
        $this->setmensajeoperacion("menu->modificar: " . $this->getError());
      }
    } else {
      $this->setmensajeoperacion("menu->modificar: " . $this->getError());
    }
    return $resp;
  }

  public function eliminar()
  {
    $resp = false;
    $sql = "DELETE FROM menu WHERE idmenu=" . $this->getidmenu();
    if ($this->Iniciar()) {
      if ($this->Ejecutar($sql)) {
        $resp = true;
      } else {
        $this->setmensajeoperacion("menu->eliminar: " . $this->getError());
      }
    } else {
      $this->setmensajeoperacion("menu->eliminar: " . $this->getError());
    }
    return $resp;
  }

  public function listar($parametro = "")
  {
    $arreglo = array();
    $sql = "SELECT * FROM menu ";
    if ($parametro != "") {
      $sql .= "WHERE " . $parametro;
    }
    if ($this->Iniciar()) {
      $res = $this->Ejecutar($sql);
      if ($res > -1) {
        if ($res > 0) {
          while ($row = $this->Registro()) {
            $obj = new Menu();
            $obj->setear($row['idmenu'], $row['menombre'], $row['medescripcion'], $row['idpadre'], $row['medeshabilitado']);
            array_push($arreglo, $obj);
          }
        }
      } else {
        $this->setmensajeoperacion("menu->listar: " . $this->getError());
      }
    }
    return $arreglo;
  }
  public function asociarRol($idrol)
  {
    $menuRol = new MenuRol();
    $menuRol->setear($this->idmenu, $idrol);
    return $menuRol->insertar();
  }

  public function listarRoles()
  {
    $menuRol = new MenuRol();
    return $menuRol->listar("idmenu = " . $this->idmenu);
  }
}
