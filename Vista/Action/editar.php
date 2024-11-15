<?php
$Titulo = "Usuario Rol";
include_once("../../estructura/header.php");
include_once("../../config.php");

$datos = data_submitted();

$objC = new ABMUsuario();
$obj = null;
if (isset($datos['idusuario']) && $datos['idusuario'] != -1) {
    $listaTabla = $objC->darRoles($datos);
    if (count($listaTabla) == 1) {
        $obj = $listaTabla[0];
    }
}

$objr = new ABMRol();
$listaRol = $objr->buscar(null);
?>

<div class="container my-4">
    <h3 class="text-primary">ABM - Agregar Roles</h3>
    
    <div class="row">
        <div class="col-md-12">
            <?php 
            if (isset($datos['msg']) && $datos['msg'] != null) {
                echo '<div class="alert alert-info">' . htmlspecialchars($datos['msg']) . '</div>';
            }
            ?>
        </div>
    </div>

    <div class="row float-right mb-3">
        <div class="col-md-12">
            <?php 
            if (count($listaRol) > 0) {
                foreach ($listaRol as $obj) {
                    echo '<a class="btn btn-success btn-sm m-1" role="button" href="accion.php?accion=nuevo_rol&idrol=' . $obj->getidrol() . '&idusuario=' . htmlspecialchars($datos['idusuario']) . '">Agregar Rol ' . htmlspecialchars($obj->getrodescripcion()) . '</a>';
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
                    <th scope="col">Nombre</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (count($listaTabla) > 0) {
                    foreach ($listaTabla as $objTabla) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($objTabla->getidrol()->getidrol()) . '</td>';
                        echo '<td>' . htmlspecialchars($objTabla->getidrol()->getrodescripcion()) . '</td>';
                        echo '<td><a class="btn btn-info btn-sm" role="button" href="accion.php?accion=borrar_rol&idusuario=' . htmlspecialchars($objTabla->getidusuario()->getidusuario()) . '&idrol=' . htmlspecialchars($objTabla->getidrol()->getidrol()) . '">Borrar</a></td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="3" class="text-center text-muted">No se encontraron roles asignados.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <a href="../listaUsers.php" class="btn btn-secondary mt-3">Volver</a>
</div>

<?php
include_once("../../estructura/footer.php");
?>