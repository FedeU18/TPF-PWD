<?php

include_once "../../config.php";
include_once "../../estructura/headerSeguro.php";
$idUsuario = $session->getUsuario();
$objUsuario = new ABMUsuario();
$objCompras = new ABMCompra();
$objEstadoCompras = new ABMCompraEstado();
$usuario = $objUsuario->buscar(['idusuario' => $idUsuario]);

$compras = $objEstadoCompras->buscar(['idusuario' => $idUsuario]);



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



  <a href="cambioContraseña.php" class="btn btn-danger">Cambiar Contraseña</a>
  
  <button type="submit" class="btn btn-primary">Guardar Cambios</button>

</form>


      <!-- <hr class="mt-4"> -->
       <br>
      <a href="../productos/productos.php" class="btn btn-secondary">Volver a la Página</a>
  </div>

<div class="container mt-5">
<hr class="mt-4">
  <h1 class="text-center">Historial de compras</h1>
  <div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
      <thead class="thead-dark">
        <tr>
          <th scope="col">Pedido #</th>
          <th scope="col">Fecha</th>
          <th scope="col">Estado</th>
          <!-- <th scope="col">Total</th> -->
          <th scope="col">Acciones</th>
        </tr>
      </thead>
      <tbody>
    <?php

      

    if(count($compras) > 0){
        foreach($compras as $compra) {

            echo '<tr>';
            echo '<td>' . $compra->getidcompra() . '</td>';
            echo '<td>' . $compra->getcefechaini() . '</td>';
            if($compra->getidcompraestadotipo() == 1){
              
              echo '<td>' . "Iniciada". '</td>';
            }else if($compra->getidcompraestadotipo() == 2){
              
              echo '<td>' . "Aceptada". '</td>';
            }else if($compra->getidcompraestadotipo() == 3){
              echo '<td>' . "Enviada". '</td>';
              
            }else if($compra->getidcompraestadotipo() == 4){
              echo '<td>' . "Cancelada". '</td>';

            }
            // echo '<td>' . $compra->getTotal() . '</td>';
            echo '<td>';
            // echo '<a class="btn btn-primary btn-sm" role="button" href="./editar.php?editar=editar&idusuario=' . $compra->getidusuario() . '">Roles</a>';
            //boton deshab solo si el user esta habilitado
            
            echo '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="5" class="text-center text-muted">No se encontraron usuarios.</td></tr>';
    }
    ?>
</tbody>
    </table>
  </div>

</div>
</body>

</html>