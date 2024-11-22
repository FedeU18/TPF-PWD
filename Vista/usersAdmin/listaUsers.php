<?php
$Titulo = " Gestion de Usuarios";
include_once "../../config.php";
include_once("../../estructura/headerSeguro.php");

//verifico q entre un user con el rol de admin a la pagina
if ($rol != 2) {
  $mensaje = "Acceso denegado. Solo los administradores pueden acceder.";
  echo "<script>location.href = '../perfil/index.php?msg=" . urlencode($mensaje) . "';</script>";
  exit; //detener ejec
}

$datos = data_submitted();

$obj = new ABMUsuario();
$lista = $obj->buscar(null);
?>

<div class="container mt-5">
  <h3 class="text-primary text-center">ABM - Roles de Usuarios</h3>

  <!-- Contenedor para mensajes dinámicos -->
  <div id="mensaje" class="my-3"></div>

  <div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
      <thead class="thead-dark">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Nombre</th>
          <th scope="col">Correo</th>
          <th scope="col">Deshabilitado</th>
          <th scope="col">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if (count($lista) > 0) {
          foreach ($lista as $objTabla) {
            echo '<tr>';
            echo '<td>' . $objTabla->getidusuario() . '</td>';
            echo '<td>' . $objTabla->getusnombre() . '</td>';
            echo '<td>' . $objTabla->getusmail() . '</td>';
            echo '<td>' . ($objTabla->getusdeshabilitado() == '0000-00-00' || is_null($objTabla->getusdeshabilitado()) ? 'Activo' : 'Deshabilitado') . '</td>';
            echo '<td>';
            echo '<a class="btn btn-primary btn-sm" role="button" href="./editar.php?editar=editar&idusuario=' . $objTabla->getidusuario() . '">Roles</a>';
            if ($objTabla->getusdeshabilitado() == '0000-00-00' || is_null($objTabla->getusdeshabilitado())) {
              echo ' <button class="btn btn-danger btn-sm btn-accion" data-accion="deshabilitar" data-id="' . $objTabla->getidusuario() . '">Deshabilitar</button>';
            } else {
              echo ' <button class="btn btn-success btn-sm btn-accion" data-accion="habilitar" data-id="' . $objTabla->getidusuario() . '">Habilitar</button>';
            }
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

<script>
  $(document).on('click', '.btn-accion', function(e) {
    e.preventDefault(); //prevenir q recargue la pagina

    const accion = $(this).data('accion'); //accion habilitar/deshabilitar
    const idUsuario = $(this).data('id');
    const button = $(this);

    if (accion === 'habilitar' || accion === 'deshabilitar') {
      $.ajax({
        url: './ajaxUsuarioAction.php',
        type: 'POST',
        data: {
          accion: accion,
          idusuario: idUsuario
        },
        dataType: 'json',
        success: function(response) {
          if (response.success) {
            //msj d q funca (d exito)
            mostrarMsj(response.message, 'success');

            //actualizar fila dinamic
            if (accion === 'habilitar') {
              button
                .removeClass('btn-success')
                .addClass('btn-danger')
                .data('accion', 'deshabilitar')
                .text('Deshabilitar');
              button.closest('tr').find('td:nth-child(4)').text('Activo');
            } else if (accion === 'deshabilitar') {
              button
                .removeClass('btn-danger')
                .addClass('btn-success')
                .data('accion', 'habilitar')
                .text('Habilitar');
              button.closest('tr').find('td:nth-child(4)').text('Deshabilitado');
            }
          } else {
            //msj error
            mostrarMsj(response.message, 'danger');
          }
        },
        error: function() {
          //msj error x si falla la soli
          mostrarMsj('Error en la conexión al servidor.', 'danger');
        }
      });
    }
  });

  function mostrarMsj(msj, type) {
    var msjDiv = $('<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert"></div>');
    msjDiv.text(msj);
    msjDiv.append('<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>');

    //msj contenedor
    $("#mensaje").html(msjDiv);
  }
</script>

<?php
include_once("../../estructura/footer.php");
?>