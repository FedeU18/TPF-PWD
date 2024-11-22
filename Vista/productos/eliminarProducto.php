<?php 
include_once "../../config.php";
$session = new Session();
header('Content-Type: application/json');

$response = ["success" => false, "message" => "Acción no completada."];
$datos = data_submitted();

if (isset($datos['id'])) {
    $idProducto = $datos['id'];

    $objProductos = new ABMProducto();
    $producto = $objProductos->buscar(['idproducto' => $idProducto])[0] ?? null;

    if ($producto) {
        // Crear un array con los parámetros que se van a modificar
        $param = [
            "idproducto" => $idProducto,
            "precio" => $producto->getprecio(), // Suponiendo que quieres mantener el precio actual
            "pronombre" => $producto->getpronombre(), // Suponiendo que quieres mantener el nombre actual
            "prodetalle" => $producto->getprodetalle(), // Suponiendo que quieres mantener el detalle actual
            "procantstock" => ($producto->getprocantstock() != -1) ? -1 : 1 // Cambiar el stock según la condición
        ];

        if ($producto->getprocantstock() != -1) {
            // "Eliminar" el producto (poner stock en -1)
            if ($objProductos->modificacion($param)) {
                $response["success"] = true;
                $response["message"] = "Producto eliminado correctamente (stock cambiado a -1).";
            } else {
                $response["message"] = "No se pudo eliminar el producto.";
            }
        } else {
            // "Habilitar" el producto (restaurar stock a 1)
            $param["procantstock"] = 1; // Restaurar el stock a 1
            if ($objProductos->modificacion($param)) {
                $response["success"] = true;
                $response["message"] = "Producto habilitado correctamente.";
            } else {
                $response["message"] = "No se pudo habilitar el producto.";
            }
        }
    } else {
        $response["message"] = "Producto no encontrado.";
    }
} else {
    $response["message"] = "ID de producto no válido.";
}

echo json_encode($response);