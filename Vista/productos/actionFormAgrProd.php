<?php


include_once "../../config.php";

$session =new Session();
// Indicamos que la respuesta será JSON
header('Content-Type: application/json');

$response = ["success" => false, "message" => "Acción no válida."];

$datos = data_submitted();
// var_dump($datos);
// exit;
foreach ($datos as $key => $value) {
    if ($value === null || $value === '' || $value === 'null') {
        $response["message"] = "Todos los campos deben estar completos. El campo '$key' está vacío.";
        echo json_encode($response);
        exit;
    }
}




$objProducto = new ABMProducto();
// $usuarios = $objProducto->buscar(null);
$nuevoProd = [
    // "idproducto" => null,
    "precio" => $datos['precio'],
    "pronombre" => $datos['pronombre'],
    "prodetalle" => $datos['prodetalle'],
    "procantstock" => $datos['procantstock']
];
// var_dump($nuevoProd);
try {
    // Intentar actualizar el usuario
    $productoCargado = $objProducto->alta($nuevoProd);
    
    if ($productoCargado) {
        $response = ["success" => true, "message" => "Producto cargado con exito."];
    } else {
        $response = ["success" => false, "message" => "No se realizo la carga del producto."];
    }
    
    echo json_encode($response);
    exit;
} catch (Exception $e) {
    $response = ["success" => false, "message" => "Error al cargar el dato: " . $e->getMessage()];
    
    echo json_encode($response);
    exit;
}

