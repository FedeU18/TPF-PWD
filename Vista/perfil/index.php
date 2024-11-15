<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['idusuario'])) {
    header("Location: ../login/login.php");
    exit;
}

// Obtener el ID del usuario desde la sesión
$idUsuario = $_SESSION['idusuario'];

include_once "../../config.php";

$objUsuario = new ABMUsuario();
$usuario = $objUsuario->buscar(['idusuario' => $idUsuario]);

if (!$usuario) {
    die("Usuario no encontrado.");
}

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
        <h1 class="text-center">Perfil de Usuario</h1>

        <!-- Mostrar mensaje de éxito o error si existe -->
        <?php if (isset($_GET['mensaje'])): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($_GET['mensaje']); ?>
            </div>
        <?php endif; ?>

        <!-- Formulario para editar perfil -->
        <form action="action.php" method="post" class="mt-4">
            <input type="hidden" name="idusuario" value="<?= $usuario->getIdUsuario(); ?>">

            <div class="mb-3">
                <label for="usnombre" class="form-label">Nombre de Usuario</label>
                <input type="text" class="form-control" id="usnombre" name="usnombre" value="<?= htmlspecialchars($usuario->getusnombre()); ?>" required>
            </div>

            <div class="mb-3">
                <label for="usmail" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" id="usmail" name="usmail" value="<?= htmlspecialchars($usuario->getusmail()); ?>" required>
            </div>

            <div class="mb-3">
                <label for="uspass" class="form-label">Nueva Contraseña</label>
                <input type="password" class="form-control" id="uspass" name="uspass" placeholder="Dejar en blanco para no cambiar">
            </div>

            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </form>

        <hr class="mt-4">
        <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
    </div>
</body>
</html>
