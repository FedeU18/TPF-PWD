<?php
include_once "../../config.php";

// Inicia la sesión y verifica permisos (opcional, si aplica en tu sistema)
$session = new Session();
if (!$session->activa()) {
    header("Content-Type: application/json");
    echo json_encode(["success" => false, "message" => "Sesión expirada. Por favor, inicia sesión nuevamente."]);
    exit;
}

// Encabezado JSON
header('Content-Type: application/json');

// Estructura base de la respuesta
$response = ["success" => false, "message" => "Acción no válida."];

// Obtener datos enviados
$datos = data_submitted();

// Validar campos obligatorios
function validarCampos($campos)
{
    foreach ($campos as $key => $value) {
        if ($value === null || $value === '' || $value === 'null') {
            return "El campo '$key' está vacío.";
        }
    }
    return true;
}

$validacion = validarCampos($datos);
if ($validacion !== true) {
    $response["message"] = $validacion;
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit;
}

// Verificar que el ID del producto exista
if (!isset($datos['id']) || empty($datos['id'])) {
    $response["message"] = "ID del producto no proporcionado.";
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit;
}

$objProducto = new ABMProducto();

// Estructura del producto para actualizar
$productoEditado = [
    "idproducto" => intval($datos['id']),
    "precio" => intval($datos['precio']),
    "pronombre" => $datos['pronombre'],
    "prodetalle" => $datos['prodetalle'],
    "procantstock" => intval($datos['procantstock'])
];


try {
    // Intentar editar el producto
    $resultado = $objProducto->modificacion($productoEditado);

    if ($resultado) {
        $response = ["success" => true, "message" => "Producto actualizado correctamente."];
    } else {
        $response = ["success" => false, "message" => "No se pudo actualizar el producto. Verifica los datos ingresados."];
    }
} catch (Exception $e) {
    // Manejo de errores
    // error_log("Error al editar producto: " . $e->getMessage(), 3, '/var/log/app_errors.log');
    $response = ["success" => false, "message" => "Error interno. Contacta al administrador."];
}

// Devolver respuesta en JSON
echo json_encode($response, JSON_UNESCAPED_UNICODE);
exit;
