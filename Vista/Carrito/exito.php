<?php
include_once "../../config.php";
include_once "../../estructura/headerSeguro.php";
require '../../vendor/autoload.php'; // Para cargar PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$titulo = "Compra realizada";
$session = new Session();
$objProducto = new ABMProducto();
$usuario = $session->getUsuario();
$carrito = $session->obtenerProductosCarrito();

$fechaActual = date("Y-m-d H:i:s");
$paramCompra = [
  "idcompra" => null,
  "cofecha" => $fechaActual,
  "idusuario" => $usuario,
];
$compra = new ABMCompra();
$compraEstado = new ABMCompraEstado();
$compraItem = new ABMCompraItem();
$msg = "";

if (($idcompra = $compra->alta($paramCompra)) > 0) {
  $msg = "Compra realizada con éxito";
  $paramCompraEstado = [
    "idcompraestado" => null,
    "idcompra" => $idcompra,
    "idcompraestadotipo" => 1,
    "cefechaini" => $fechaActual,
    "cefechafin" => null,
  ];
  if ($compraEstado->alta($paramCompraEstado)) {
    $msg = "Compra realizada con éxito";
  } else {
    $msg = "No se pudo concretar la compra";
  }

  foreach ($carrito as $idProducto => $cantidad) {
    $paramCompraItem = [
      "idcompraitem" => null,
      "idproducto" => $idProducto,
      "idcompra" => $idcompra,
      "cicantidad" => $cantidad,
    ];
    if ($compraItem->alta($paramCompraItem)) {
      $msg = "Compra realizada con éxito";
    } else {
      $msg = "No se pudo concretar la compra";
    }
  }

  // Obtener detalles del usuario
  $abmUsuario = new ABMUsuario();
  $usuarioInfo = $abmUsuario->buscar(["idusuario" => $usuario])[0];
  $correoUsuario = $usuarioInfo->getusmail();
  $nombreUsuario = $usuarioInfo->getusnombre();

  // Enviar correo de confirmación
  $mail = new PHPMailer(true);
  try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'gruposi797@gmail.com';
    $mail->Password = 'xtfb fvdw zwic sttw'; // Cambia a tu contraseña real
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('gruposi797@gmail.com', 'Notificacion de Compra');
    $mail->addAddress($correoUsuario, $nombreUsuario);

    $mail->isHTML(true);
    $mail->Subject = 'Gracias por tu compra!';
    $mail->Body = "
    <h1>¡Gracias por tu compra, $nombreUsuario!</h1>
    <p>Tu pedido ha sido registrado exitosamente.</p>
    <p>Detalles de la compra:</p>
    <ul>
    ";

    foreach ($carrito as $idProducto => $cantidad) {
        $producto = $objProducto->buscar(["idproducto" => $idProducto])[0];
        if ($producto) {
            $nombreProducto = $producto->getpronombre() ?: "Nombre no disponible";
            $mail->Body .= "<li>$nombreProducto - Cantidad: $cantidad</li>";
        } else {
            $mail->Body .= "<li>Producto ID: $idProducto - Información no disponible</li>";
        }
    }

    $mail->Body .= "
        </ul>
        <p>¡Gracias por confiar en nosotros!</p>
        <p>Saludos,<br>El equipo de Soporte</p>
    ";
    $mail->AltBody = 'Gracias por tu compra. 
    Tu pedido ha sido registrado exitosamente.';

    $mail->send();
  } catch (Exception $e) {
    $msg .= " Sin embargo, no se pudo enviar el correo de confirmación.";
  }
} else {
  $msg = "No se pudo concretar la compra";
}

$session->vaciarCarrito();
echo "<h1>$msg</h1>";

include_once "../../estructura/footer.php";