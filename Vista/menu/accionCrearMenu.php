<?php
include_once "../../config.php";
$datos = data_submitted();
if ($datos) {
  $data = [
    'menombre' => $datos['menombre'],
    'medescripcion' => $datos['medescripcion'],
    'idpadre' => empty($datos['idpadre']) ? null : $datos['idpadre'],
    'medeshabilitado' => $datos['estado']
  ];

  $abmMenu = new ABMMenu();
  $resultado = $abmMenu->alta($data);

  if ($resultado) {
    header("Location: menu.php?mensaje=Menú creado con éxito");
  } else {
    header("Location: crearMenu.php?error=No se pudo crear el menú");
  }
  exit;
}
