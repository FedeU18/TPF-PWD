<?php
include_once('../../config.php');
require '../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$datos = data_submitted();

//crear una instancia de PHPMailer; pasando `true` habilita excepciones
$mail = new PHPMailer(true);

try {
    //config sv
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                //salida depuracion
    $mail->isSMTP();                                      //usar smtp
    $mail->Host       = 'smtp.gmail.com';                 //sv smtp
    $mail->SMTPAuth   = true;                             //autenticacion smtp
    $mail->Username   = 'gruposi797@gmail.com';           
    $mail->Password   = 'xtfb fvdw zwic sttw';                       
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;   //cifrado tls
    $mail->Port       = 587;                              //puerto tcp

    // Destinatarios
    $mail->setFrom('gruposi797@gmail.com', 'Notificacion de Compra');
    //$mail->addAddress('emanuelpinedo7@gmail.com');//comprobar q funciona con mi mail
    if (isset($datos['usmail']) && isset($datos['usnombre'])) {
        $mail->addAddress($datos['usmail'], $datos['usnombre']); //añadir destinatario
    } else {
        echo 'Datos de destinatario no válidos.';
        exit();
    }

    //contenido
    $mail->isHTML(true);                                  
    $mail->Subject = 'Gracias por tu compra!!!';
    $mail->Body    = "
    <h1>Gracias por tu compra!!!</h1>
    <p>Te agradecemos por elegirnos. Tu pedido ha sido recibido correctamente.</p>
    <p>Recibirás un correo con los detalles de tu envío una vez que tu pedido haya sido procesado.</p>
    <p>Si tienes alguna pregunta, no dudes en contactarnos.</p>
    <p>¡Gracias por comprar con nosotros!</p>
    <p>Saludos,<br>El equipo de Soporte</p>
    ";
    $mail->AltBody = 'Gracias por tu compra. Te agradecemos por elegirnos. Tu pedido ha sido recibido correctamente. 
    Recibirás un correo con los detalles de tu envío una vez que tu pedido haya sido procesado. 
    Si tienes alguna pregunta, no dudes en contactarnos.';

    //mandar correo
    $mail->send();
    echo 'Correo enviado exitosamente.';
} catch (Exception $e) {
    echo "Error al enviar el correo: {$mail->ErrorInfo}";
}