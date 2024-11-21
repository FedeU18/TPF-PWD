<?php

include_once "../../config.php";
include_once "../../estructura/headerSeguro.php";

// Obtener el ID del usuario desde la sesión
$idUsuario = $session->getUsuario();

// Instanciar los objetos necesarios
$objUsuario = new ABMUsuario();
$objCompras = new ABMCompra();
$objEstadoCompras = new ABMCompraEstado();

// Buscar información del usuario
$usuario = $objUsuario->buscar(['idusuario' => $idUsuario]);
$usuario = $usuario[0]; // Suponemos un único resultado

// Buscar las compras realizadas por el usuario
$compras = $objCompras->buscar(['idusuario' => $idUsuario]);

// Crear listas para almacenar las compras y sus estados
$listaCompras = [];
$listaEstados = [];

// Procesar compras y obtener estados asociados
foreach ($compras as $compra) {
    // Agregar compra a la lista
    $listaCompras[] = $compra;

    // Buscar estados de la compra actual
    $estadosCompra = $objEstadoCompras->buscar(['idcompra' => $compra->getIdCompra()]);
    foreach ($estadosCompra as $estado) {
        $listaEstados[$compra->getIdCompra()] = $estado->getIdCompraEstadoTipo();
    }
}

?>




  <div class="container mt-5">
    <h1 class="text-center">Perfil de Usuario</h1>

    <!-- Mostrar mensaje de éxito o error si existe -->
    <?php if (isset($_GET['mensaje'])): ?>
      <div class="alert alert-success">
        <?= htmlspecialchars($_GET['mensaje']); ?>
      </div>
    <?php endif; ?>

    <!-- Formulario para editar perfil -->
    <form id="form-perfil" class="mt-4">

      <input type="hidden" id="accion" name="accion" >
      <input type="hidden" id="idusuario" name="idusuario" value="<?= $usuario->getIdUsuario(); ?>">

      <div class="mb-3">
        <label for="usnombre" class="form-label">Nombre de Usuario</label>
        <input type="text" class="form-control" id="usnombre" name="usnombre" value="<?= htmlspecialchars($usuario->getUsNombre()); ?>" required>
      </div>

      <div class="mb-3">
        <label for="usmail" class="form-label">Correo Electrónico</label>
        <input type="email" class="form-control" id="usmail" name="usmail" value="<?= htmlspecialchars($usuario->getUsMail()); ?>" required>
      </div>
      <div id="mensaje" class="mb-3"></div>

      <a href="cambioContraseña.php" class="btn btn-danger">Cambiar Contraseña</a>
      <button type="submit"  id="btn-perfil" class="btn btn-primary">Guardar Cambios</button>
    </form>

    <br>
    <a href="../productos/productos.php" class="btn btn-secondary">Volver a la Página</a>
  </div>

  <!-- <div id="mensaje"></div> -->
  <div class="container mt-5">
    <hr class="mt-4">
    <h1 class="text-center">Historial de compras</h1>
    <div class="table-responsive">
      <table class="table table-striped table-bordered table-hover">
        <thead class="thead-dark">
          <tr>
            <th scope="col">Pedido #</th>
            <th scope="col">Fecha Compra</th>
            <th scope="col">Estado</th>
            <th scope="col">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($listaCompras)): ?>
            <?php foreach ($listaCompras as $compra): ?>
              <tr>
                <td><?= htmlspecialchars($compra->getIdCompra()); ?></td>
                <td><?= htmlspecialchars($compra->getCoFecha()); ?></td>
                <td>
                  <?php 
                  $estado = $listaEstados[$compra->getIdCompra()] ?? 'Desconocido';
                  switch ($estado) {
                      case 1:
                          echo 'Iniciada';
                          break;
                      case 2:
                          echo 'Aceptada';
                          break;
                      case 3:
                          echo 'Enviada';
                          break;
                      case 4:
                          echo 'Cancelada';
                          break;
                      default:
                          echo 'Desconocido';
                  }
                  ?>
                </td>
                <td>
                <form action="mostrarDetalles.php" method="post" class="mt-4">
                  <input type="hidden" name="idcompra" value="<?= $compra->getIdCompra(); ?>">
                  <button type="submit" class="btn btn-primary">Detalles</button>
                  
                </form>

                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="4" class="text-center">No se encontraron compras.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>




<script>
  $(document).ready(function() {
    $("#btn-perfil").click(function(e) {
      e.preventDefault();
      // Limpiar mensajes previos
      $("#mensaje").empty();

      let datosFormulario = {
        // accion: $("#accion").val(),
        idusuario: $("#idusuario").val(),
        usnombre: $("#usnombre").val(),
        usmail: $("#usmail").val(),
      };
      // Enviar solicitud AJAX
      $.ajax({
        type: 'POST',
        url: 'action.php',
        data: datosFormulario,
        dataType: 'json',
        success: function(respuesta) {
          console.log(respuesta);
                if (respuesta.success) {
                  // window.location.href = response.redirect;
                    $("#mensaje").html(
                        `<div class="alert alert-success">${respuesta.message}</div>`
                    );
                } else {
                    $("#mensaje").html(
                        `<div class="alert alert-danger">${respuesta.message}</div>`
                    );
                }
            },
            error: function (error) {
                $("#mensaje").html(
                    '<div class="alert alert-danger">Error en la conexión al servidor.</div>'
                );
                console.log(error);
            },
      });
    });
  });
</script>


<?php include_once "../../estructura/footer.php"; ?>
