<?php
session_start();

// Simula que el usuario con ID 1 está logueado
$_SESSION['idusuario'] = 5; // Cambia 1 por un ID de usuario válido en tu base de datos

echo "Usuario simulado con ID: " . $_SESSION['idusuario'];
