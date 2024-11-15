<?php
$Titulo = "Usuario Rol";
include_once("../../estructura/header.php");
include_once("../../config.php");

$datosIngresados = data_submitted();

$abmUsuario = new ABMUsuario();
$usuarioRoles = null;

//verifica si hay un idusuario valido para buscar los roles
if (isset($datosIngresados['idusuario']) && $datosIngresados['idusuario'] != -1) {
  $listaRolesAsignados = $abmUsuario->darRoles($datosIngresados);
  if (count($listaRolesAsignados) == 1) {
    $usuarioRoles = $listaRolesAsignados[0];
  }
}

$abmRol = new ABMRol();
$listaRolesDisponibles = $abmRol->buscar(null);
// Crear un índice de descripciones basadas en los IDs de los roles disponibles
$rolesDescripcion = [];
foreach ($listaRolesDisponibles as $rolDisponible) {
  $rolesDescripcion[$rolDisponible->getidrol()] = $rolDisponible->getrodescripcion();
}
print_r($rolesDescripcion)
?>

<div class="container my-4">
  <h3 class="text-primary">ABM - Agregar Roles</h3>

  <div class="row">
    <div class="col-md-12">
      <?php
      if (isset($datosIngresados['msg']) && $datosIngresados['msg'] != null) {
        echo '<div class="alert alert-info">' . htmlspecialchars($datosIngresados['msg']) . '</div>';
      }
      ?>
    </div>
  </div>

  <div class="row float-right mb-3">
    <div class="col-md-12">
      <?php
      if (count($listaRolesDisponibles) > 0) {
        foreach ($listaRolesDisponibles as $rolDisponible) {
          echo '<a class="btn btn-primary btn-sm m-1" role="button" href="./agregarRol.php?accion=nuevoRol&idrol=' . $rolDisponible->getidrol() . '&idusuario=' . htmlspecialchars($datosIngresados['idusuario']) . '">Agregar Rol ' . htmlspecialchars($rolDisponible->getrodescripcion()) . '</a>';
        }
      }
      ?>
    </div>
  </div>

  <div class="table-responsive">
    <table class="table table-striped table-hover">
      <thead class="thead-dark">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Rol</th>
          <th scope="col">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if (count($listaRolesAsignados) > 0) {
          foreach ($listaRolesAsignados as $rolAsignado) {

            echo '<tr>';
            echo '<td>' . htmlspecialchars($rolAsignado->getidrol()) . '</td>';
            echo '<td>' . htmlspecialchars($rolesDescripcion[$rolAsignado->getidrol()]) . '</td>'; //acá está el error
            echo '<td><a class="btn btn-primary btn-sm" role="button" href="./borrarRol.php?Action=borrarRol&idusuario=' . htmlspecialchars($rolAsignado->getidusuario()) . '&idrol=' . htmlspecialchars($rolAsignado->getidrol()) . '">Borrar</a></td>';
            echo '</tr>';
          }
        } else {
          echo '<tr><td colspan="3" class="text-center text-muted">No se encontraron roles asignados.</td></tr>';
        }
        ?>
      </tbody>
    </table>
  </div>

  <a href="../listaUsers.php" class="btn btn-secondary mt-3">Volver</a>
</div>

<?php
include_once("../../estructura/footer.php");
?>