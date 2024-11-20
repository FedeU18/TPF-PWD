<?php
include_once ('../../config.php');
include_once ('../../estructura/headerSeguro.php');

$abmCompraEstado = new ABMCompraEstado();

//obtengo todas las compras
$compras = $abmCompraEstado->buscar(null);

//verificar q hayan comprras
if (count($compras) > 0) {
    echo '<table border="1" cellspacing="0" cellpadding="10">
            <thead>
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
                    <form method='post' action='cambiarEstado.php'>
                        <input type='hidden' name='idCompraEstado' value='{$idCompraEstado}'>
                        <button type='submit' name='estado' value='1'>Iniciar</button>
                        <button type='submit' name='estado' value='2'>Aceptar</button>
                        <button type='submit' name='estado' value='3'>Enviar</button>
                        <button type='submit' name='estado' value='4'>Cancelar</button>
                    </form>
                </td>
            </tr>";
    }

    echo '</tbody>
        </table>';
} else {
    echo '<p>No hay compras registradas.</p>';
}

include_once('../../estructura/footer.php');
?>