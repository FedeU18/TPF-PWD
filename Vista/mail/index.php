<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    // Configuración del servidor SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.example.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'tu_usuario@example.com';
    $mail->Password = 'tu_contraseña';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;//puerto moderno y recomendado para enviar correos desde un cliente a un servidor SMTP.

    // Configuración del correo
    $mail->setFrom('remitente@example.com', 'Remitente');
    $mail->addAddress('destinatario@example.com', 'Destinatario');
    $mail->Subject = 'Asunto del correo';
    $mail->Body = 'Este es el cuerpo del correo.';
    $mail->AltBody = 'Texto alternativo para clientes sin soporte HTML.';

    // Enviar correo
    $mail->send();
    echo 'Correo enviado exitosamente.';
} catch (Exception $e) {
    echo "Error al enviar el correo: {$mail->ErrorInfo}";
}
?>