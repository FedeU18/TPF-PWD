<?php
include_once "../../config.php";
$titulo = "Crear Menú";
include_once "../../estructura/headerSeguro.php";
?>

<div class="container mt-4">
  <h1>Crear Nuevo Menú</h1>
  <form action="accionCrearMenu.php" method="post">
    <div class="mb-3">
      <label for="menombre" class="form-label">Nombre del Menú</label>
      <input type="text" class="form-control" id="menombre" name="menombre" required>
    </div>
    <div class="mb-3">
      <label for="medescripcion" class="form-label">Descripción</label>
      <input type="text" class="form-control" id="medescripcion" name="medescripcion">
    </div>
    <div class="mb-3">
      <label for="idpadre" class="form-label">Menú Padre (opcional)</label>
      <select class="form-select" id="idpadre" name="idpadre">
        <option value="">Ninguno</option>
        <?php
        $abmMenu = new ABMMenu();
        // Buscar únicamente los menús cuyo idpadre sea null
        $paramPadres = ['idpadre' => null];
        $menusPadres = $abmMenu->buscar($paramPadres);

        foreach ($menusPadres as $menu) {
          echo "<option value='" . $menu->getIdMenu() . "'>" . htmlspecialchars($menu->getMenombre()) . "</option>";
        }
        ?>
      </select>
    </div>
    <div class="mb-3">
      <label for="estado" class="form-label">Estado</label>
      <select class="form-select" id="estado" name="estado" required>
        <option value="habilitado">Habilitado</option>
        <option value="deshabilitado">Deshabilitado</option>
      </select>
    </div>
    <button type="submit" class="btn btn-success">Crear Menú</button>
    <a href="menu.php" class="btn btn-secondary">Volver</a>
  </form>
</div>

<?php include_once "../../estructura/footer.php"; ?>