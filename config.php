<?php 
session_start();
header('Content-Type: text/html; charset=utf-8');
header ("Cache-Control: no-cache, must-revalidate ");

/////////////////////////////
// CONFIGURACION APP//
/////////////////////////////

$PROYECTO ='TPF-PWD';

//variable que almacena el directorio del proyecto
$ROOT =$_SERVER['DOCUMENT_ROOT']."/$PROYECTO/";

include_once($ROOT.'Utils/funciones.php');

$PRINCIPAL = "Location:http://".$_SERVER['HTTP_HOST']."/$PROYECTO/index.php";
$LOGIN = "Location:http://".$_SERVER['HTTP_HOST']."/$PROYECTO/Vista/login.php";
$REGISTRO = "Location:http://".$_SERVER['HTTP_HOST']."/$PROYECTO/Vista/registro.php";
$VISTA = "Location:http://".$_SERVER['HTTP_HOST']."/$PROYECTO/Vista/";

$_SESSION['ROOT']=$ROOT;

$_SERVER['PRINCIPAL'] = $PRINCIPAL;
$_SERVER['LOGIN'] = $LOGIN;
$_SERVER['REGISTRO'] = $REGISTRO;
$_SERVER['VISTA'] = $LOGIN;

?>