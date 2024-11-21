<?php
include_once "../../config.php";
$titulo = "Estados de Compra";
include_once "../../estructura/headerSeguro.php";

if (!in_array(3, $rol)) {
  $mensaje = "Acceso denegado. Solo los Depositores pueden acceder.";
  echo "<script>location.href = '../perfil/index.php?msg=" . urlencode($mensaje) . "';</script>";
  exit; // detener ejecución
}
$datos = data_submitted();
// Verificar que se haya proporcionado el ID de la compra
$idCompra = isset($datos['idcompra']) ? intval($datos['idcompra']) : 0;

if ($idCompra <= 0) {
  echo "<div class='alert alert-danger'>ID de compra no válido.</div>";
  include_once "../../estructura/footer.php";
  exit;
}

// Crear instancias de ABMCompraEstado y ABMCompraEstadoTipo
$objAbmCompraEstado = new ABMCompraEstado();
$objAbmCompraEstadoTipo = new ABMCompraEstadoTipo();

// Buscar estados relacionados con la compra
$param = ['idcompra' => $idCompra];
$listadoEstados = $objAbmCompraEstado->buscar($param);
?>
<div class="container mt-4">
  <h2>Estados de la Compra #<?php echo $idCompra; ?></h2>
  <div id="mensaje" class="mb-3"></div>

  <?php if (!empty($listadoEstados)): ?>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Estado</th>
          <th>Fecha Inicio</th>
          <th>Fecha Fin</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $estadoActual = null;

        foreach ($listadoEstados as $estado):
          $estadoTipo = $objAbmCompraEstadoTipo->buscar(['idcompraestadotipo' => $estado->getIdcompraestadotipo()]);
          $descripcionEstado = !empty($estadoTipo) ? $estadoTipo[0]->getCetdescripcion() : 'Desconocido';

          $fechaInicio = $estado->getCefechaini();
          $fechaFin = $estado->getCefechafin();

          // Determinar si es el estado actual
          if (!empty($fechaInicio) && ($fechaFin == '0000-00-00 00:00:00' || $fechaFin == null)) {
            $estadoActual = $descripcionEstado;
          }
        ?>
          <tr>
            <td><?php echo $descripcionEstado; ?></td>
            <td><?php echo $fechaInicio; ?></td>
            <td><?php echo $fechaFin == '0000-00-00 00:00:00' ? 'En curso' : $fechaFin; ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <div class="alert alert-warning">No hay estados registrados para esta compra.</div>
  <?php endif; ?>

  <!-- Mostrar botones según el estado actual -->

  <div class="mt-4">
    <?php if ($estadoActual == 'iniciada'): ?>
      <button class="btn btn-success me-2" id="aceptarCompra" data-compra="<?php echo $idCompra; ?>">Aceptar Compra</button>
      <button class="btn btn-danger" id="cancelarCompra" data-compra="<?php echo $idCompra; ?>">Cancelar Compra</button>
    <?php elseif ($estadoActual == 'aceptada'): ?>
      <button class="btn btn-primary me-2" id="enviarCompra" data-compra="<?php echo $idCompra; ?>">Enviar Compra</button>
      <button class="btn btn-danger" id="cancelarCompra" data-compra="<?php echo $idCompra; ?>">Cancelar Compra</button>
    <?php elseif ($estadoActual == 'enviada'): ?>
      <button class="btn btn-danger" id="cancelarCompra" data-compra="<?php echo $idCompra; ?>">Cancelar Compra</button>
    <?php else: ?>
      <div class="alert alert-info">No hay acciones disponibles para el estado actual.</div>
    <?php endif; ?>
  </div>
  <a href="compras.php" class="btn btn-secondary mt-3">Volver al Listado de Compras</a>
</div>
<script>
  $(document).ready(function() {

    // Aceptar compra
    $('#aceptarCompra').click(function() {
      var idCompra = $(this).data('compra');
      cambiarEstadoCompra(idCompra, 'aceptar');
    });

    // Enviar compra
    $('#enviarCompra').click(function() {
      var idCompra = $(this).data('compra');
      cambiarEstadoCompra(idCompra, 'enviar');
    });

    // Cancelar compra
    $('#cancelarCompra').click(function() {
      var idCompra = $(this).data('compra');
      cambiarEstadoCompra(idCompra, 'cancelar');
    });

    function cambiarEstadoCompra(idCompra, accion) {
      $.ajax({
        url: 'cambiarEstadoCompra.php',
        type: 'POST',
        data: {
          idcompra: idCompra,
          accion: accion
        },
        dataType: 'json', // Asegúrate de que el servidor responda JSON puro
        success: function(response) {
          if (response.success) {
            $("#mensaje").html(
              `<div class="alert alert-info">${response.msg}</div>`
            );
            location.reload(); // Recargar la página para ver el cambio
          } else {
            $("#mensaje").html(
              `<div class="alert alert-danger">Error: ${response.msg}</div>`
            );
          }
        },
        error: function(xhr, status, error) {
          alert('Error en la comunicación con el servidor: ' + error);
          console.log(xhr.responseText); // Para depuración
        }
      });
    }


  });
</script>

<?php
include_once "../../estructura/footer.php";
?>