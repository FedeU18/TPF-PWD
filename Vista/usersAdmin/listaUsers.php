<?php
$Titulo = " Gestion de Usuarios";
include_once("../../estructura/header.php");
include_once "../../config.php";
$datos = data_submitted();

$obj= new ABMUsuario();
$lista = $obj->buscar(null);

?>
<div class="container mt-5">
    <h3 class="text-primary text-center">ABM - Roles de Usuarios</h3>

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
                if(count($lista) > 0){
                    foreach($lista as $objTabla) {
                        echo '<tr>';
                        echo '<td>' . $objTabla->getidusuario() . '</td>';
                        echo '<td>' . $objTabla->getusnombre() . '</td>';
                        echo '<td>' . $objTabla->getusmail() . '</td>';
                        echo '<td>' . $objTabla->getusdeshabilitado() . '</td>';
                        echo '<td><a class="btn btn-primary btn-sm" role="button" href="./editar.php?editar=editar&idusuario=' . $objTabla->getidusuario() . '">Roles</a></td>';
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

<?php

include_once("../../estructura/footer.php");
?>