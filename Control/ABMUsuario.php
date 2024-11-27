<?php
class ABMUsuario
{
  public function abm($datos)
  {
    $resp = false;
    if ($datos['accion'] == 'editar') {
      if ($this->modificacion($datos)) {
        $resp = true;
      }
    }
    if ($datos['accion'] == 'borrar') {
      if ($this->baja($datos)) {
        $resp = true;
      }
    }
    if ($datos['accion'] == 'nuevo') {
      if ($this->alta($datos)) {
        $resp = true;
      }
    }
    if($datos['accion']=='borrarRol'){
      if($this->borrarRol($datos)){
            $resp =true;
      }
    }
    if($datos['accion']=='nuevoRol'){
      if($this->nuevoRol($datos)){
            $resp =true;
      }
    } 

    return $resp;
  }

  public function actualizarContrasena($idUsuario, $datos) {
    $resp = ['success' => false, 'message' => ''];

    // Verificar que los campos estén completos
    if (empty($datos['uspassactual']) || empty($datos['uspassnueva']) || empty($datos['uspassconfirmar'])) {
        $resp['message'] = 'Por favor, complete todos los campos.';
        return $resp;
    }

    // Verificar que las nuevas contraseñas coincidan
    if ($datos['uspassnueva'] !== $datos['uspassconfirmar']) {
        $resp['message'] = 'Las contraseñas no coinciden.';
        return $resp;
    }

    // Buscar el usuario por ID
    $usuario = $this->buscar(['idusuario' => $idUsuario]);
    if (empty($usuario)) {
        $resp['message'] = 'Usuario no encontrado.';
        return $resp;
    }

    $usuario = $usuario[0]; // Obtener el objeto Usuario

    // Verificar la contraseña actual
    if (!password_verify($datos['uspassactual'], $usuario->getuspass())) {
        $resp['message'] = 'La contraseña actual es incorrecta.';
        return $resp;
    }

    // Encriptar la nueva contraseña
    $nuevaContrasenaHash = password_hash($datos['uspassnueva'], PASSWORD_DEFAULT);

    // Preparar los datos para la actualización
    $modUsuario = [
        'idusuario' => $idUsuario,
        'usnombre' => $usuario->getusnombre(),
        'uspass' => $nuevaContrasenaHash,
        'usmail' => $usuario->getusmail(),
        'usdeshabilitado' => $usuario->getusdeshabilitado(),
    ];

    // Intentar modificar la contraseña
    if ($this->modificacion($modUsuario)) {
        $resp['success'] = true;
        $resp['message'] = 'Contraseña actualizada con éxito.';
    } else {
        $resp['message'] = 'Error al intentar actualizar la contraseña.';
    }

    return $resp;
}


  public function actualizarPerfil($idUsuario, $datos) {
    $resp = ['success' => false, 'message' => ''];
    
    // Validar que el usuario exista
    $usuarioActual = $this->buscar(['idusuario' => $idUsuario]);
    if (empty($usuarioActual)) {
        $resp['message'] = 'El usuario no existe.';
        return $resp;
    }
    

    
    $usuarioActual = $usuarioActual[0]; // Obtén el objeto Usuario
    
    // Validar campos obligatorios
    if (empty($datos['usnombre']) || empty($datos['usmail'])) {
        $resp['message'] = 'Los campos Nombre de Usuario y Correo Electrónico son obligatorios.';
        return $resp;
    }

    // Validar duplicados (correo)
    if ($this->esCorreoDuplicado($datos['usmail'], $idUsuario)) {
        $resp['message'] = 'El correo ya está registrado para otro usuario.';
        return $resp;
    }

    // Normalizar correo
    $correoNormalizado = trim(strtolower($datos['usmail']));

    // Preparar datos para modificación
    $modUsuario = [
        'idusuario' => $idUsuario,
        'usnombre' => trim($datos['usnombre']),
        'uspass' => $usuarioActual->getuspass(), // Mantener la contraseña actual
        'usmail' => $correoNormalizado,
        'usdeshabilitado' => null,
    ];

    // Intentar modificar
    if ($this->modificacion($modUsuario)) {
        $resp['success'] = true;
        $resp['message'] = 'Perfil actualizado con éxito.';
    } else {
        $resp['message'] = 'No se realizaron cambios en el perfil.';
    }

    return $resp;
}



  private function cargarObjeto($param)
  {
    $obj = null;
    if (array_key_exists('idusuario', $param) && array_key_exists('usnombre', $param) && array_key_exists('uspass', $param) && array_key_exists('usmail', $param) && array_key_exists('usdeshabilitado', $param)) {
      $obj = new Usuario();
      $obj->setear($param['idusuario'], $param['usnombre'], $param['uspass'], $param['usmail'], $param['usdeshabilitado']);
    }
    return $obj;
  }

  private function cargarObjetoConClave($param)
  {
    $obj = null;
    if (isset($param['idusuario'])) {
      $obj = new Usuario();
      $obj->setear($param['idusuario'], null, null, null, null);
    }
    return $obj;
  }

  private function seteadosCamposClaves($param)
  {
    return isset($param['idusuario']);
  }

  public function alta($param) {
    $resp = ['success' => false, 'errores' => []];

    // Validar datos antes de crear el usuario
    $errores = $this->validarDatosUsuario($param);

    if (!empty($errores)) {
        $resp['errores'] = $errores;
    } else {
        // $param['idusuario'] = null;
            // Construir el array con el formato requerido
        $nuevoUsuario = [
          "idusuario" => null,
          "usnombre" => $param['usnombre'],
          "uspass" => password_hash($param['pass'], PASSWORD_BCRYPT), // Encriptar la contraseña
          "usmail" => $param['email'],
          "usdeshabilitado" => null,
      ];

        $elObjUsuario = $this->cargarObjeto($nuevoUsuario);
      
        if ($elObjUsuario != null && $elObjUsuario->insertar()) {
            $resp['success'] = true;
            $resp['errores'] = []; // Limpio los errores, ya que fue exitoso
        } else {
            $resp['errores'][] = "Error al intentar insertar el usuario en la base de datos.";
        }
    }

    // Si no hay errores, asegúrate de tener un mensaje claro
    if (!$resp['success'] && empty($resp['errores'])) {
        $resp['errores'][] = "Ocurrió un error desconocido.";
    }

    return $resp;
}



  public function baja($param)
  {
    $resp = false;
    if ($this->seteadosCamposClaves($param)) {
      $elObjUsuario = $this->cargarObjetoConClave($param);
      if ($elObjUsuario != null && $elObjUsuario->eliminar()) {
        $resp = true;
      }
    }
    return $resp;
  }

  public function modificacion($param)
  {
    $resp = false;
    if ($this->seteadosCamposClaves($param)) {
      $elObjUsuario = $this->cargarObjeto($param);
      if ($elObjUsuario != null && $elObjUsuario->modificar()) {
        $resp = true;
      }
    }
    return $resp;
  }

  public function borrarRol($param){
        $resp = false;
        if(isset($param['idusuario']) && isset($param['idrol'])){
            $elObjtTabla = new UsuarioRol();
            $elObjtTabla->setearConClave($param['idusuario'],$param['idrol']);
            $resp = $elObjtTabla->eliminar();
        }
        return $resp;
    }

    public function nuevoRol($param){
        $resp = false;
        if(isset($param['idusuario']) && isset($param['idrol'])){
            $elObjtTabla = new UsuarioRol();
            $elObjtTabla->setearConClave($param['idusuario'],$param['idrol']);
            $resp = $elObjtTabla->insertar();
        }
        return $resp;
    }

    public function darRoles($param){
        $where = " true ";
        if ($param<>NULL){
            if  (isset($param['idusuario']))
                $where.=" and idusuario =".$param['idusuario'];
            if  (isset($param['idrol']))
                 $where.=" and idrol ='".$param['idrol']."'";
        }
        $obj = new UsuarioRol();
        $arreglo = $obj->listar($where);
        return $arreglo;
    }

    public function arrayUser($param = "")
    {
        $arrayAbm = $this->buscar($param);
        $listar = [];
        if (count($arrayAbm) > 0) {
            foreach ($arrayAbm as $objAbm) {
              //if ($objAbm->getusdeshabilitado() === null) {  
              $arrayAbmUsuario = [
                    'idusuario' => $objAbm->getidusuario(),
                    'usnombre' => $objAbm->getusnombre(),
                    'uspass' => $objAbm->getuspass(),
                    'usmail' => $objAbm->getusmail(),
                    'usdeshabilitado' => $objAbm->getusdeshabilitado()
                ];

                array_push($listar, $arrayAbmUsuario);
              //}
            }
        }
        return  $listar;
    }

  public function buscar($param)
  {
    $where = "true";
    if ($param != null) {
      if (isset($param['idusuario']))
        $where .= " and idusuario = " . $param['idusuario'];
      if (isset($param['usnombre']))
        $where .= " and usnombre = '" . $param['usnombre'] . "'";
      if (isset($param['uspass']))
        $where .= " and uspass = " . $param['uspass'];
      if (isset($param['usmail']))
        $where .= " and usmail = '" . $param['usmail'] . "'";
      if (isset($param['usdeshabilitado']))
        $where .= " and usdeshabilitado = '" . $param['usdeshabilitado'] . "'";
    }
    $obj = new Usuario();
    $arreglo = $obj->listar($where);
    return $arreglo;
  }

  public function esCorreoDuplicado($email, $idExcluido = null) {
    $usuarios = $this->buscar(null);
    $resp= false;
    foreach ($usuarios as $usuario) {
        if ($usuario->getusmail() === $email && $usuario->getidusuario() != $idExcluido) {
          $resp= true; // El correo ya existe para otro usuario
        }
    }
    return $resp;
}

public function esNombreDeUsuarioDuplicado($usnombre, $idExcluido = null) {
    $usuarios = $this->buscar(null);
    $resp = false;
    foreach ($usuarios as $usuario) {
        if ($usuario->getusnombre() === $usnombre && $usuario->getidusuario() != $idExcluido) {
          $resp= true; // El nombre ya existe para otro usuario
        }
    }
    return $resp;
}


public function validarDatosUsuario($datos) {
    $errores = [];

    // Validar nombre de usuario duplicado
    if ($this->esNombreDeUsuarioDuplicado($datos['usnombre'])) {
        $errores[] = "El usuario ya existe.";
    }

    // Validar correo duplicado
    if ($this->esCorreoDuplicado($datos['email'])) {
        $errores[] = "El correo ya existe.";
    }

    // Validar formato del correo
    if (!filter_var($datos['email'], FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El correo no es válido.";
    }

    // Validar longitud del nombre de usuario
    if (strlen($datos['usnombre']) >= 8) {
        $errores[] = "El nombre de usuario debe tener menos de 8 caracteres.";
    }

    return $errores;
}

}