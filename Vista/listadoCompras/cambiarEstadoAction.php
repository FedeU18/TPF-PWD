<?php
// include_once('../../config.php');
// require '../../vendor/autoload.php';

// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

// $datos = data_submitted();

// if (!empty($datos['idCompraEstado']) && !empty($datos['estado'])) {
//   $idCompraEstado = $datos['idCompraEstado'];
//   $nuevoEstado = $datos['estado'];

//   $abmCompraEstado = new ABMCompraEstado();
//   $abmCompra = new ABMCompra();
//   $abmUsuario = new ABMUsuario();

//   //buscar estado de la compra
//   $compraEstado = $abmCompraEstado->buscar(['idcompraestado' => $idCompraEstado])[0];

//   if ($compraEstado) {
//     //estado actual
//     $estadoActual = $compraEstado->getidcompraestadotipo();

//     //validar cambios de estado
//     if (($estadoActual == 1 && in_array($nuevoEstado, [2, 4])) || //de iniciada a aceptada/cancelada
//       ($estadoActual == 2 && $nuevoEstado == 3) ||             //de aceptada a enviada
//       ($nuevoEstado == 4)
//     ) {                                   //de cancelado a cualquiera

//       //actualizar estado de la compra
//       $compraEstado->setidcompraestadotipo($nuevoEstado);
//       $compraEstado->modificar();

//       $idCompra = $compraEstado->getidcompra(); //id de la comrpa
//       $compra = $abmCompra->buscar(['idcompra' => $idCompra])[0]; //detales de la compra

//       if ($compra) {
//         $idUsuario = $compra->getidusuario(); //user asociado a la compra
//         $usuario = $abmUsuario->buscar(['idusuario' => $idUsuario])[0];

//         if ($usuario) {
//           $usMail = $usuario->getusmail();
//           $usNombre = $usuario->getusnombre();

//           //mandar el correo dependiendo dle estado
//           enviarCorreo($usMail, $usNombre, $nuevoEstado);
//           echo "Estado actualizado y correo enviado.";
//         } else {
//           echo "Estado actualizado, pero no se encontró el usuario.";
//         }
//       } else {
//         echo "Compra no encontrada.";
//       }
//     } else {
//       echo "Cambio de estado no permitido.";
//     }
//   } else {
//     echo "Estado de la compra no encontrado.";
//   }
// } else {
//   echo "Datos inválidos.";
// }

//funcion par amndar le correo
// function enviarCorreo($correo, $nombre, $estado) {
//     $mail = new PHPMailer(true);

//     try {
//         //config sv
//         $mail->isSMTP();
//         $mail->Host = 'smtp.gmail.com';
//         $mail->SMTPAuth = true;
//         $mail->Username = 'gruposi797@gmail.com';
//         $mail->Password = 'xtfb fvdw zwic sttw';
//         $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
//         $mail->Port = 587;

//         //quien manda, a quien le manda
//         $mail->setFrom('gruposi797@gmail.com', 'Notificacion de Compra');
//         $mail->addAddress($correo, $nombre);

//         //msj segun el boton
//         switch ($estado) {
//             case 2:
//                 $subject = 'Compra Aceptada';
//                 $body = 'Tu compra ha sido aceptada. Pronto recibirás más detalles.';
//                 break;
//             case 3:
//                 $subject = 'Compra Enviada';
//                 $body = 'Tu compra ha sido enviada. Estará llegando pronto.';
//                 break;
//             case 4:
//                 $subject = 'Compra Cancelada';
//                 $body = 'Lamentamos informarte que tu compra ha sido cancelada.';
//                 break;
//         }

//         //config contenido
//         $mail->isHTML(true);
//         $mail->Subject = $subject;
//         $mail->Body = "<p>Hola $nombre,</p><p>$body</p><p>Saludos,<br>El equipo de soporte</p>";
//         $mail->AltBody = strip_tags($body);

//         //mandar correo
//         $mail->send();
//     } catch (Exception $e) {
//         echo "Error al enviar correo: {$mail->ErrorInfo}";
//     }
// }
// 
