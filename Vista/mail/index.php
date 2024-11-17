<?php
include_once('../../config.php');
require_once '../../vendor/autoload.php';

$datos = data_submitted();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true); //crear nueva instancia de PHPMailer

try {
    //config sv smtp
    $mail->isSMTP();//usar smtp
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;//autenticacion
    $mail->Username = 'gruposi797@gmail.com';
    $mail->Password = 'disenio7';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;//usar TLS
    $mail->Port = 587;//puerto moderno usado para mandar mail x smtp

    //config correo
    $mail->setFrom('gruposi797@gmail.com', 'Notificación de Compra');

    //verificar datos presentes
    if (isset($datos['usmail']) && isset($datos['usnombre'])) {
        $mail->addAddress($datos['usmail'], $datos['usnombre']);
    } else {
        echo 'Datos de destinatario no válidos.';
        exit();
    }

    $mail->Subject = '¡Gracias por tu compra!';

    //cuerpo del correo
    $mail->isHTML(true);//cuerpo html
    $mail->Body = "
    <h1>¡Gracias por tu compra!</h1>
    <p>Te agradecemos por elegirnos. Tu pedido ha sido recibido correctamente.</p>
    <p>Recibirás un correo con los detalles de tu envío una vez que tu pedido haya sido procesado.</p>
    <p>Si tienes alguna pregunta, no dudes en contactarnos.</p>
    <p>¡Gracias por comprar con nosotros!</p>
    <p>Saludos,<br>El equipo de Soporte</p>
    ";

    //cuerpo alternativo para clientes sin soporte html
    $mail->AltBody = 'Gracias por tu compra. Te agradecemos por elegirnos. Tu pedido ha sido recibido correctamente. 
    Recibirás un correo con los detalles de tu envío una vez que tu pedido haya sido procesado. 
    Si tienes alguna pregunta, no dudes en contactarnos.';

    //mandar correo
    if ($mail->send()) {
        echo 'Correo enviado exitosamente.';
    } else {
        echo 'Hubo un problema al enviar el correo.';
    }
} catch (Exception $e) {
    echo "Error al enviar el correo: {$mail->ErrorInfo}";
}
?>