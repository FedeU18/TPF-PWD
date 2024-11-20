<?php
include_once ('../../config.php');
include_once ('../../estructura/headerSeguro.php');

$abmCompraEstado = new ABMCompraEstado();

// Obtengo todas las compras
$compras = $abmCompraEstado->buscar(null);

// Verificar que haya compras
if (count($compras) > 0) {
    echo '<div class="container mt-5">
            <h3 class="text-primary text-center">Gestión de Compras</h3>

            <!-- Contenedor para mensajes dinámicos -->
            <div id="mensaje" class="my-3"></div>

            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID Compra</th>
                            <th>Estado Actual</th>
                            <th>Fecha Inicio</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>';

    foreach ($compras as $compra) {
        $idCompraEstado = $compra->getidcompraestado();
        $estadoActual = $compra->getidcompraestadotipo();
        $fechaInicio = $compra->getcefechaini();

        echo "<tr>
                <td>{$idCompraEstado}</td>
                <td>{$estadoActual}</td>
                <td>{$fechaInicio}</td>
                <td>
                    <button class='btn btn-success btn-sm change-state' data-id='{$idCompraEstado}' data-state='2'>Aceptar</button>
                    <button class='btn btn-warning btn-sm change-state' data-id='{$idCompraEstado}' data-state='3'>Enviar</button>
                    <button class='btn btn-danger btn-sm change-state' data-id='{$idCompraEstado}' data-state='4'>Cancelar</button>
                </td>
            </tr>";
    }

    echo '</tbody>
        </table>
    </div>
</div>';
} else {
    echo '<div class="container"><p>No hay compras registradas.</p></div>';
}
?>
<script>
$(document).ready(function(){
    $(".change-state").click(function(e){
        e.preventDefault();

        var idCompraEstado = $(this).data('id');
        var nuevoEstado = $(this).data('state');
        var $button = $(this);

        $.ajax({
            url: './cambiarEstadoAction.php',
            type: 'POST',
            data: { 
                idCompraEstado: idCompraEstado,
                estado: nuevoEstado 
            },
            success: function(response){
                showMessage(response, 'success');

                var estadoText = '';
                switch(nuevoEstado) {
                    case '2':
                        estadoText = 'Aceptada';
                        break;
                    case '3':
                        estadoText = 'Enviada';
                        break;
                    case '4':
                        estadoText = 'Cancelada';
                        break;
                }
                $button.closest('tr').find('td').eq(1).text(estadoText);//actualiza estado en la tabla

                $button.addClass('btn-secondary').prop('disabled', true);
            },
            error: function(){
                showMessage("Ocurrió un error al cambiar el estado.", 'danger');
            }
        });
    });
});

// Función para mostrar mensajes dentro de un div
function showMessage(message, type) {
    var messageDiv = $('<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert"></div>');
    messageDiv.text(message);
    messageDiv.append('<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>');

    // Agrega el mensaje al contenedor de mensajes
    $("#mensaje").html(messageDiv);
}
</script>

<?php
include_once('../../estructura/footer.php');
?>