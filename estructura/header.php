<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo isset($titulo) ? $titulo : "TPF"; ?></title>
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <link rel="stylesheet" href="../../estructura/CSS/alertas.css">
</head>

<body class="d-flex flex-column min-vh-100"> <!-- Añadir min-vh-100 al body -->
  <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
    <div class="col-md-3 mb-2 mb-md-0">
      <a class="mx-3 w-25 h-25" href="../productos/productos.php"><img class="w-25 h-25" src="../../estructura/assets/pancho.jpg" alt="el perrito de Ema"></a>
    </div>
    <div class="col-md-3 text-end">
      <a href="../login/login.php" type="button" class="btn btn-outline-primary me-2">Inicar Sesión</a>
      <a href="../registro/" type="button" class="btn btn-primary">Registrar</a>
    </div>
  </header>
  <div class="container mb-5"> <!-- Contenedor para el contenido principal -->