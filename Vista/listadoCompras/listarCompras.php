<?php
include_once ('../../config.php');
include_once ('../../estructura/headerSeguro.php');

$abmCompraEstado = new ABMCompraEstado();

//obtener todas las comrpas
$compras = $abmCompraEstado->buscar(null);

//verificar q haya compras
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
                mostrarMsj(response, 'success');

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
                $button.closest('tr').find('td').eq(1).text(estadoText);//actualizar estado en la tabla

                $button.addClass('btn-secondary').prop('disabled', true);
            },
            error: function(){
                mostrarMsj("Ocurrió un error al cambiar el estado.", 'danger');
            }
        });
    });
});

//mostrar mensajes en el div
function mostrarMsj(msj, type) {
    var msjDiv = $('<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert"></div>');
    msjDiv.text(msj);
    msjDiv.append('<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>');

    //agregar msj al contenedor de msj
    $("#mensaje").html(msjDiv);
}
</script>

<?php
include_once('../../estructura/footer.php');
?>