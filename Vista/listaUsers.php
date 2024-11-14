<?php
$datos = data_submitted();

$obj = new ABMUsuario();
$listar = $obj->buscar(null);

?>
<h2>Roles de Usuarios</h2>

<div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Deshabilitado</th>
                <th>Acciones</th>
            </tr>
        </thead>
    </table>
    <tbody>
        <?php
        if(count($listar)>0){
            foreach($listar as $obj){
                echo '<tr>';
                    echo '<td>' . htmlspecialchars($obj->getidusuario()) . '</td>';
                    echo '<td>' . htmlspecialchars($obj->getusnombre()) . '</td>';
                    echo '<td>' . htmlspecialchars($obj->getusmail()) . '</td>';
                    echo '<td>'. htmlspecialchars($obj->getusdeshabilitado()) .'</td>';
                    echo '<td><a role="button" href="Action/editar.php?Action=editar&idusuario=' . htmlspecialchars($obj->getidusuario()) . '">Roles</a></td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="5">No se encontraron usuarios.</td></tr>';
            }
        ?>
    </tbody>
</div>