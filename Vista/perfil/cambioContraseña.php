<?php

include_once "../../config.php";
include_once "../../estructura/headerSeguro.php";
$idUsuario = $session->getUsuario();
$objUsuario = new ABMUsuario();
$usuario = $objUsuario->buscar(['idusuario' => $idUsuario]);



$usuario = $usuario[0];
?>


<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perfil de Usuario</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
</head>

<body>
  <div class="container mt-5">
    <h1 class="text-center">Modificar Contraseña</h1>

    <!-- Mostrar mensaje de éxito o error si existe -->
    <?php if (isset($_GET['mensaje'])): ?>
      <div class="alert alert-success">
        <?= htmlspecialchars($_GET['mensaje']); ?>
      </div>
    <?php endif; ?>

    <!-- Formulario para editar perfil -->
    <form action="cambiar_contrasena_action.php" method="post">
  <div class="mb-3">
    <label for="uspass_actual" class="form-label">Contraseña Actual</label>
    <input type="password" class="form-control" id="uspass_actual" name="uspass_actual" required>
  </div>
  <div class="mb-3">
    <label for="uspass_nueva" class="form-label">Nueva Contraseña</label>
    <input type="password" class="form-control" id="uspass_nueva" name="uspass_nueva" required>
  </div>
  <div class="mb-3">
    <label for="uspass_confirmar" class="form-label">Confirmar Nueva Contraseña</label>
    <input type="password" class="form-control" id="uspass_confirmar" name="uspass_confirmar" required>
  </div>
  <button type="submit" class="btn btn-primary">Cambiar Contraseña</button>
</form>

<hr class="mt-4">
<a href="index.php" class="btn btn-danger">Volver al perfil</a>
  </div>
</body>

</html>