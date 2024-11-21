<?php


include_once '../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function data_submitted()
{
  $_AAux = array();
  if (!empty($_POST))
    $_AAux = $_POST;
  else
            if (!empty($_GET)) {
    $_AAux = $_GET;
  }
  if (count($_AAux)) {
    foreach ($_AAux as $indice => $valor) {
      if ($valor == "")
        $_AAux[$indice] = 'null';
    }
  }
  return $_AAux;
}

function verEstructura($e)
{
  echo "<pre>";
  print_r($e);
  echo "</pre>";
}

spl_autoload_register(function ($class_name) {
  $directorys = array(
    $GLOBALS['ROOT'] . 'Modelo/',
    $GLOBALS['ROOT'] . 'Modelo/conector/',
    $GLOBALS['ROOT'] . 'Control/'
  );

  foreach ($directorys as $directory) {
    if (file_exists($directory . $class_name . '.php')) {
      require_once($directory . $class_name . '.php');
      return;
    }
  }
});

function enviarCorreo($correo, $nombre, $subject, $body)
{
  $mail = new PHPMailer(true);

  try {
    //config sv
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'gruposi797@gmail.com';
    $mail->Password = 'xtfb fvdw zwic sttw';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    //quien manda, a quien le manda
    $mail->setFrom('gruposi797@gmail.com', 'Notificacion de Compra');
    $mail->addAddress($correo, $nombre);

    //config contenido
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = "<p>Hola $nombre,</p><p>$body</p><p>Saludos,<br>El equipo de soporte</p>";
    $mail->AltBody = strip_tags($body);

    //mandar correo
    $mail->send();
  } catch (Exception $e) {
    echo "Error al enviar correo: {$mail->ErrorInfo}";
  }
}
