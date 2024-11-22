<?php
include_once "../../config.php";
$titulo = "Compras";
include_once "../../estructura/headerSeguro.php";

if ($rol != 3) {
  $mensaje = "Acceso denegado. Solo los Depositores pueden acceder.";
  echo "<script>location.href = '../perfil/index.php?msg=" . urlencode($mensaje) . "';</script>";
  exit; // detener ejecución
}

// Crear instancias de ABMCompra y ABMUsuario
$objAbmCompra = new ABMCompra();
$objAbmUsuario = new ABMUsuario();

// Obtener todas las compras
$listadoCompras = $objAbmCompra->buscar(null);

?>

<div class="container mt-4">
  <h2>Listado de Compras</h2>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>ID de la Compra</th>
        <th>Fecha de la Compra</th>
        <th>Email del Usuario</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if (!empty($listadoCompras)) {
        foreach ($listadoCompras as $compra) {
          // Obtener el email del usuario relacionado con esta compra
          $paramUsuario = ['idusuario' => $compra->getIdusuario()];
          $usuario = $objAbmUsuario->buscar($paramUsuario);
          $emailUsuario = !empty($usuario) ? $usuario[0]->getusmail() : 'Usuario no encontrado';

          echo "<tr>";
          echo "<td>" . $compra->getIdcompra() . "</td>";
          echo "<td>" . $compra->getCofecha() . "</td>";
          echo "<td>" . $emailUsuario . "</td>";
          echo "<td>";
          echo "<a href='detalleCompra.php?idcompra=" . $compra->getIdcompra() . "' class='btn btn-primary btn-sm'>Ver Detalles</a> ";
          echo "<a href='estadoCompra.php?idcompra=" . $compra->getIdcompra() . "' class='btn btn-info btn-sm'>Ver Estado</a>";
          echo "</td>";
          echo "</tr>";
        }
      } else {
        echo "<tr><td colspan='4'>No se encontraron compras.</td></tr>";
      }
      ?>
    </tbody>
  </table>
</div>

<?php
include_once "../../estructura/footer.php";
?>