<?php 
// include_once "../../Utils/funciones.php";
include_once "../../config.php";

// Este archivo recibe los datos del formulario
// Debe chequear que el usuario y el correo no esten registrados ya para otro usuario
// Debe verificar que el correo sea válido
// Debe verificar que el usuario tenga al menos 8 caracteres
// Si todo esta bien realiza un hash de la contraseña para luego setear el nuevo usuario
// Si todo esta bien, redirige a la página de inicio?
// Si no todo esta bien, muestra un mensaje de error y redirige a la página de registro



$datos = data_submitted();

$objUsuario = new ABMUsuario;
$usuarios = $objUsuario->buscar(null);
$encontrado = false;

foreach($usuarios as $usuario){
    if($usuario['usuario'] == $datos['usnombre']) {
        $mensaje = "El usuario ya existe";
        $encontrado = true;
        header("Location: registro.php?mensaje=$mensaje");
        exit;
    }
    if($usuario['correo'] == $datos['email']) {
        $mensaje = "El correo ya existe";
        $encontrado = true;
        header("Location: registro.php?mensaje=$mensaje");
        exit;
    }

}
$err = 0;
if($encontrado == false){
    if(filter_var($datos['email'], FILTER_VALIDATE_EMAIL)){
        $err = 1;
        if(strlen($datos['usnombre']) <= 8){
            $err = 2;
            $pass = password_hash($datos['pass'], PASSWORD_DEFAULT);
            $objUsuario->alta(null, $datos['usnombre'], $pass ,$datos['email'], null);
            header("Location: ../index.php");
            exit;
        }
    }
}
echo $err;

?>