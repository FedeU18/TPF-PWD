<?php 

include_once "../../config.php";
$session = new Session();
header('Content-Type: application/json');
$response = ["success" => false, "message" => "No se pudo eliminar el producto."];
$datos = data_submitted();
// var_dump ($datos);
$idProducto = null;
if (isset($datos['id'])) {
    $idProducto = $datos['id'];
}

// var_dump ($idProducto);

// exit;
if (isset($idProducto)) {
    
    // var_dump ($idProducto);
    // exit;
    if ($idProducto) {
        $objProductos = new ABMProducto();
        $param = ["idproducto" => $idProducto];


        if ($objProductos->baja($param)) {
            $response["success"] = true;
            $response["message"] = "Producto eliminado con éxito.";
        } else {
            $response["message"] = "No se pudo eliminar el producto. Intente nuevamente.";
        }
    } else {
        $response["message"] = "ID de producto no válido.";
    }
}

echo json_encode($response);
