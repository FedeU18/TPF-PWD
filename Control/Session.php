<?php

class Session {

    //construct q inicia la sesion si no esta activa
    public function __construct() {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    //actualiza variables de sesion con el id del user
    public function iniciar($nombreUser, $psw) {
        $resp = false;
        $obj = new ABMUsuario();
    
        $param = [
            "usnombre" => $nombreUser,
            "uspass" => $psw,
            "usdeshabilitado" => NULL
        ];
    
        //buscar user
        $res = $obj->buscar($param);
        
        //Si el res no esta vacio, le asigna el id del user a la saesion
        if (!empty($res)) {
            $usuario = $res[0];
            $_SESSION['idUsuario'] = $usuario->getUsuarioId();
            $resp = true;
        } else {
            //si no encuentra al user se cierra la sesion
            $this->cerrar();
        }
    
        return $resp;
    }

    //valida si la sesion actual tiene un id de user valido
    public function validar() {
        return isset($_SESSION['idUsuario']);
    }

    //devolver true o false si la sesion esta activa o no
    public function activa() {
        return session_status() === PHP_SESSION_ACTIVE && $this->validar();
    }

    //devolver user logueado
    public function getUsuario() {
        return $this->validar() ? $_SESSION['idUsuario'] : null;
    }

    //devolver rol del user logueado
    public function getRol() {
        $rol = null;  //valor x defecto
        
        $idUsuario = $this->getUsuario();
        if ($idUsuario) {
            $abmUserRol = new ABMUsuarioRol();
            $usuarioRoles = $abmUserRol->buscar(['idusuario' => $idUsuario]);
    
            if (!empty($usuarioRoles)) {
                $rol = $usuarioRoles[0]->getidrol()->getidrol();  //asignar rol
            }
        }
        return $rol;
    }

    //cerrar sesion actual
    public function cerrar() {
        session_unset();
        session_destroy();
    }
}