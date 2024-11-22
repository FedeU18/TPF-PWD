<?php

include_once "../../config.php";
$titulo = "Menú";
include_once "../../estructura/headerSeguro.php";

$abmMenu = new ABMMenu();
$abmMenuRol = new ABMMenuRol();

// Obtener todos los menús padres (idpadre es null)
$paramPadres = ['idpadre' => null];
$menusPadres = $abmMenu->buscar($paramPadres);

// Array para almacenar los menús con sus submenús
$estructuraMenus = [];

// Obtener los submenús de cada menú padre
foreach ($menusPadres as $menuPadre) {
  $paramSubmenus = ['idpadre' => $menuPadre->getIdMenu()];
  $submenus = $abmMenu->buscar($paramSubmenus);
  $estructuraMenus[] = [
    'padre' => $menuPadre,
    'submenus' => $submenus,
  ];
}

?>

<div class="container mt-4">
  <h1 class="d-flex justify-content-between align-items-center">
    Menús
    <a href="crearMenu.php" class="btn btn-primary">Crear Nuevo Menú</a>
  </h1>

  <div class="accordion" id="menuAccordion">
    <?php foreach ($estructuraMenus as $index => $menu): ?>
      <div class="accordion-item">
        <h2 class="accordion-header" id="heading<?= $index ?>">
          <button class="accordion-button <?= $index !== 0 ? 'collapsed' : '' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $index ?>" aria-expanded="<?= $index === 0 ? 'true' : 'false' ?>" aria-controls="collapse<?= $index ?>">
            <?= htmlspecialchars($menu['padre']->getMenombre()) ?>
          </button>
        </h2>
        <div id="collapse<?= $index ?>" class="accordion-collapse collapse <?= $index === 0 ? 'show' : '' ?>" aria-labelledby="heading<?= $index ?>" data-bs-parent="#menuAccordion">
          <div class="accordion-body">
            <?php if (!empty($menu['submenus'])): ?>
              <table class="table table-striped table-bordered">
                <thead class="table-dark">
                  <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Estado</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($menu['submenus'] as $submenu): ?>
                    <tr>
                      <td><?= htmlspecialchars($submenu->getIdMenu()) ?></td>
                      <td><?= htmlspecialchars($submenu->getMenombre()) ?></td>
                      <td><?= htmlspecialchars($submenu->getMedescripcion()) ?></td>
                      <td><?= htmlspecialchars($submenu->getMedeshabilitado() ? 'Deshabilitado' : 'Habilitado') ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            <?php else: ?>
              <p class="text-muted">Sin submenús</p>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>


<?php include_once "../../estructura/footer.php"; ?>