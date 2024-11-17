<?php
$para = "destinatario@example.com";
$asunto = "Asunto del correo";
$mensaje = "Este es el cuerpo del correo.\nPuedes usar múltiples líneas.";
$cabeceras = "From: remitente@example.com\r\n";
$cabeceras .= "Reply-To: respuesta@example.com\r\n";
$cabeceras .= "Content-Type: text/plain; charset=UTF-8\r\n";

// Enviar el correo
if (mail($para, $asunto, $mensaje, $cabeceras)) {
    echo "Correo enviado exitosamente.";
} else {
    echo "Hubo un problema al enviar el correo.";
}
?>