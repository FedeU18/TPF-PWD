<?php
include_once "../../vendor/autoload.php";
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 2));

$dotenv->load();

echo getenv('stripe_secret_key'); // Debería mostrar la clave correcta
echo getenv('pass'); // Debería mostrar "disenio7"
