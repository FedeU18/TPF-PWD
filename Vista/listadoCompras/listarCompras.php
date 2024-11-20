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

    //pasar el estado numero a texto
    $estadoTexto = '';
    switch ($estadoActual) {
        case 1:
            $estadoTexto = 'Iniciada';
            break;
        case 2:
            $estadoTexto = 'Aceptada';
            break;
        case 3:
            $estadoTexto = 'Enviada';
            break;
        case 4:
            $estadoTexto = 'Cancelada';
            break;
    }

    //determinar si hay q deshabilitar los botnes
    $disabledAceptar = $estadoActual >= 2 ? 'disabled' : '';
    $disabledEnviar = $estadoActual >= 3 ? 'disabled' : '';
    $disabledCancelar = $estadoActual == 4 ? 'disabled' : '';

    echo "<tr>
            <td>{$idCompraEstado}</td>
            <td>{$estadoTexto}</td>
            <td>{$fechaInicio}</td>
            <td>
                <button class='btn btn-success btn-sm change-state' data-id='{$idCompraEstado}' data-state='2' {$disabledAceptar}>Aceptar</button>
                <button class='btn btn-warning btn-sm change-state' data-id='{$idCompraEstado}' data-state='3' {$disabledEnviar}>Enviar</button>
                <button class='btn btn-danger btn-sm change-state' data-id='{$idCompraEstado}' data-state='4' {$disabledCancelar}>Cancelar</button>
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
$(document).ready(function () {
    $(".change-state").click(function (e) {
        e.preventDefault();

        //no hacer la accion si el boton esta deshab
        if ($(this).prop('disabled')) {
            return;
        }

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
            success: function (response) {
                mostrarMsj(response, 'success');

                //cambiar estado de la tabla
                var estadoText = '';
                switch (nuevoEstado) {
                    case 2:
                        estadoText = 'Aceptada';
                        break;
                    case 3:
                        estadoText = 'Enviada';
                        break;
                    case 4:
                        estadoText = 'Cancelada';
                        break;
                }

                //actualizar estado tabla
                $button.closest('tr').find('td').eq(1).text(estadoText);

                //deshab botones segun estado
                var $row = $button.closest('tr');
                if (nuevoEstado == 2) {
                    $row.find('button[data-state="2"]').prop('disabled', true).addClass('btn-secondary');
                } else if (nuevoEstado == 3) {
                    $row.find('button[data-state="2"], button[data-state="3"]').prop('disabled', true).addClass('btn-secondary');
                } else if (nuevoEstado == 4) {
                    $row.find('button').prop('disabled', true).addClass('btn-secondary');
                }
            },
            error: function () {
                mostrarMsj("Ocurrió un error al cambiar el estado.", 'danger');
            }
        });
    });
});

//funcion para mostrar msj dinamic
function mostrarMsj(msj, type) {
    var msjDiv = $('<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert"></div>');
    msjDiv.text(msj);
    msjDiv.append('<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>');

    //msj al contenedor
    $("#mensaje").html(msjDiv);
}
</script>

<?php
include_once('../../estructura/footer.php');
?>