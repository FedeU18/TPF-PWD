<?php 

include_once "../../config.php";

// Este archivo recibe los datos del formulario
// Chequea que el usuario y el correo no esten registrados ya para otro usuario
// Verifica que el correo sea válido
// Verifica que el usuario tenga al menos 8 caracteres
// Si todo esta bien realiza un hash de la contraseña para luego setear el nuevo usuario
// Si todo esta bien, redirige a la página de inicio
// Si no todo esta bien, muestra un mensaje de error y redirige a la página de registro

$datos = data_submitted();

$objUsuario = new ABMUsuario;
$usuarios = $objUsuario->buscar(null);
$encontrado = false;

foreach($usuarios as $usuario){
    if($usuario->getusnombre() == $datos['usnombre']) {
        $mensaje = "El usuario ya existe";
        $encontrado = true;
        header("Location: index.php?mensaje=$mensaje");
        exit;
    }
    if($usuario->getusmail() == $datos['email']) {
        $mensaje = "El correo ya existe";
        $encontrado = true;
        header("Location: index.php?mensaje=$mensaje");
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
            $nuevoUsuario = [
                "idusuario" => null,
                "usnombre" => $datos['usnombre'],
                "uspass" => $pass,
                "usmail" => $datos['email'],
                "usdeshabilitado" => null
            ];
            
            // Registrar el usuario
            $usuarioCreado = $objUsuario->alta($nuevoUsuario);

            if ($usuarioCreado) {
                // Asignar el rol al usuario recién creado
                $objUsuarioRol = new ABMUsuarioRol;

                // Obtiene el id del usuario recién creado
                $idUsuarioCreado = $objUsuario->buscar(["usnombre" => $datos['usnombre']])[0]->getIdUsuario();

                
                $idRolCliente = 2; 

                // Crear el registro en usuariorol
                $nuevoUsuarioRol = [
                    "idusuario" => $idUsuarioCreado,
                    "idrol" => $idRolCliente
                ];
                
                $objUsuarioRol->alta($nuevoUsuarioRol);
            }
            
            $exito = header("Location: ../index.php");
            exit;
        }
    }
}
echo $err;
?>


