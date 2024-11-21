<?php 
include_once '../../config.php';
$session = new Session();
header('Content-Type: application/json');
$response = ["success" => false, "message" => "No se pudo cancelar la compra, comunicarse con Asistencia"];
$datos = data_submitted();
$idCompra = null;

if (isset($datos['id'])) {
    $idCompra = $datos['id'];
}

if ($idCompra != null) {
    $objCompraEstado = new ABMCompraEstado();
    $compras = $objCompraEstado->buscar($idCompra);
    
    $compraEstado = null;

    foreach($compras as $compra) {
        if ($compra->getidcompra() == $idCompra) { 
            $compraEstado = [
                "idcompraestado" => $compra->getidcompraestado(), 
                "idcompra" => $compra->getidcompra(),
                "idcompraestadotipo" => $compra->getidcompraestadotipo(),
                "cefechaini" => $compra->getcefechaini(),
                "cefechafin" => $compra->getcefechafin(),
            ];
            break;
        }
    }
    
    if ($compraEstado !== null && $compraEstado['idcompraestadotipo'] != 4) {

        $compraEstado['idcompraestadotipo'] = 4;
        
   
        $modificacionExitosa = $objCompraEstado->modificacion($compraEstado); 
        
        if ($modificacionExitosa) {
            $response["success"] = true;
            $response["message"] = "Compra cancelada exitosamente.";
        } else {
            $response["message"] = "No se pudo modificar el estado de la compra.";
        }
    } else if ($compraEstado['idcompraestadotipo'] == 4) {
        $response["message"] = "La compra ya está cancelada.";
    } else {
        $response["message"] = "No se encontró el estado de la compra.";
    }
}

echo json_encode($response);
?>