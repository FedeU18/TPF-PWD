<?php
$Titulo = "Usuario Rol";
include_once("../../config.php");
include_once("../../estructura/headerSeguro.php");

//verifico q entre un user con el rol de admin a la pagina
if ($rol != 2) {
  $mensaje = "Acceso denegado. Solo los administradores pueden acceder.";
  echo "<script>location.href = '../perfil/index.php?msg=" . urlencode($mensaje) . "';</script>";
  exit; //detener ejec
}

$datosIngresados = data_submitted();

$abmUsuario = new ABMUsuario();
$usuarioRoles = null;

//verificar si hay un idusuario valido para buscar los roles
$listaRolesAsignados = [];
if (!empty($datosIngresados['idusuario']) && $datosIngresados['idusuario'] != -1) {
  $listaRolesAsignados = $abmUsuario->darRoles($datosIngresados);
  if (count($listaRolesAsignados) == 1) {
    $usuarioRoles = $listaRolesAsignados[0];
  }
} else {
  echo '<div class="alert alert-danger">Error: No se recibió un ID de usuario válido.</div>';
  exit; //detener ejec para evitar errores posteriores
}

$abmRol = new ABMRol();
$listaRolesDisponibles = $abmRol->buscar(null);

//indice de descripciones basadas en los ids de los roles disponibles
$rolesDescripcion = [];
foreach ($listaRolesDisponibles as $rolDisponible) {
  $rolesDescripcion[$rolDisponible->getidrol()] = $rolDisponible->getrodescripcion();
}
?>

<div class="container my-4">
  <h3 class="text-primary">ABM - Agregar Roles</h3>

  <div id="mensaje" class="alert" style="display:none;"></div>

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
          echo '<button class="btn btn-primary btn-sm m-1 btn-accion" data-accion="nuevoRol" data-idrol="' . $rolDisponible->getidrol() . '" data-idusuario="' . htmlspecialchars($datosIngresados['idusuario']) . '">Agregar Rol ' . htmlspecialchars($rolDisponible->getrodescripcion()) . '</button>';
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
            echo '<td>' . htmlspecialchars($rolesDescripcion[$rolAsignado->getidrol()]) . '</td>';
            echo '<td><button class="btn btn-danger btn-sm btn-accion" data-accion="borrarRol" data-idrol="' . htmlspecialchars($rolAsignado->getidrol()) . '" data-idusuario="' . htmlspecialchars($rolAsignado->getidusuario()) . '">Borrar</button></td>';
            echo '</tr>';
          }
        } else {
          echo '<tr><td colspan="3" class="text-center text-muted">No se encontraron roles asignados.</td></tr>';
        }
        ?>
      </tbody>
    </table>
  </div>

  <a href="./listaUsers.php" class="btn btn-secondary mt-3">Volver</a>
</div>

<script>
  $(document).on('click', '.btn-accion', function(e) {
    e.preventDefault();//prevenir q recargue la pagina

    const accion = $(this).data('accion'); //accion nuevo o borrar rol
    const idUsuario = $(this).data('idusuario');
    const idRol = $(this).data('idrol');
    const button = $(this);

    $.ajax({
      url: './ajaxRolesAction.php',
      type: 'POST',
      data: {
        accion: accion,
        idusuario: idUsuario,
        idrol: idRol
      },
      dataType: 'json',
      success: function(response) {
        if (response.success) {
          //msj extio
          mostrarMsj(response.message, 'success');

          //actualizar tabla dinamic sin recargar la pag
          if (accion === 'nuevoRol') {
            //accion agregar, nueva fila
            const newRow = `
                        <tr>
                            <td>${idRol}</td>
                            <td>${button.text().replace('Agregar Rol', '').trim()}</td>
                            <td>
                                <button class="btn btn-danger btn-sm btn-accion" data-accion="borrarRol" data-idrol="${idRol}" data-idusuario="${idUsuario}">Borrar</button>
                            </td>
                        </tr>
                    `;
            $('table tbody').append(newRow);
          } else if (accion === 'borrarRol') {
            //accion borrar, sacar fila
            button.closest('tr').remove();
          }
        } else {
          //msj error
          mostrarMsj(response.message, 'danger');
        }
      },
      error: function() {
        //msj error si falla la soli
        mostrarMsj('Ocurrió un error al procesar la solicitud.', 'danger');
      }
    });
  });
  //mostrar msj dinamic en div
  function mostrarMsj(msj, type) {
    var msjDiv = $('<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert"></div>');
    msjDiv.text(msj);
    msjDiv.append('<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>');

    //msj en el contenedor
    $("#mensaje").html(msjDiv).show();
  }
</script>

<?php
include_once("../../estructura/footer.php");
?>