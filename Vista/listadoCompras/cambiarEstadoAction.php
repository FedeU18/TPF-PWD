<?php
include_once ('../../config.php');

$datos = data_submitted();

if (!empty($datos['idCompraEstado']) && !empty($datos['estado'])) {
    $idCompraEstado = $datos['idCompraEstado'];
    $nuevoEstado = $datos['estado'];

    $abmCompraEstado = new ABMCompraEstado();

    //buscar compra a modificar
    $compra = $abmCompraEstado->buscar(['idcompraestado' => $idCompraEstado])[0];

    if ($compra) {
        //verificar que el cambio de estado sea valido
        $estadoActual = $compra->getidcompraestadotipo();
        if (($estadoActual == 1 && in_array($nuevoEstado, [2, 4])) || //iniciada -> aceptada/cancelada
            ($estadoActual == 2 && $nuevoEstado == 3) ||             //aceptada -> Enviada
            ($nuevoEstado == 4)) {                                   //cancelar en cualquier estado
            //actualizar estado de compra
            $compra->setidcompraestadotipo($nuevoEstado);
            $compra->modificar();

            echo "Estado actualizado correctamente.";
        } else {
            echo "Cambio de estado no permitido.";
        }
    } else {
        echo "Compra no encontrada.";
    }
} else {
    echo "Datos inválidos.";
}
?>