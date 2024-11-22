<?php
include_once "../../config.php";
$titulo = "Crear Menú";
include_once "../../estructura/headerSeguro.php";
?>

<div class="container mt-4">
  <h2>Crear Nuevo Menú</h2>
  <form id="formCrearMenu">
    <div class="mb-3">
      <label for="nombreMenu" class="form-label">Nombre del Menú</label>
      <input type="text" class="form-control" id="nombreMenu" name="nombreMenu" required>
    </div>
    <div class="mb-3">
      <label for="descripcionMenu" class="form-label">Descripción</label>
      <input type="text" class="form-control" id="descripcionMenu" name="descripcionMenu" required>
    </div>
    <div class="mb-3">
      <label for="estadoMenu" class="form-label">Estado</label>
      <select class="form-select" id="estadoMenu" name="estadoMenu" required>
        <option value="habilitado">Habilitado</option>
        <option value="deshabilitado">Deshabilitado</option>
      </select>
    </div>
    <div class="mb-3">
      <label for="menuPadre" class="form-label">Menú Padre</label>
      <select class="form-select" id="menuPadre" name="menuPadre">
        <option value="">Ninguno</option>
        <?php
        // Listar solo menús padre (idpadre es null)
        $abmMenu = new ABMMenu();
        $menusPadre = $abmMenu->buscar(['idpadre' => null]);
        foreach ($menusPadre as $menuPadre) {
          echo "<option value=\"{$menuPadre->getIdMenu()}\">{$menuPadre->getMenombre()}</option>";
        }
        ?>
      </select>
    </div>
    <button type="submit" class="btn btn-primary">Crear Menú</button>
  </form>
  <div id="respuesta" class="mt-3"></div>
</div>
<script>
  $(document).ready(function() {
    $('#formCrearMenu').on('submit', function(e) {
      e.preventDefault(); // Evita el envío normal del formulario

      $.ajax({
        url: 'accionCrearMenu.php', // Archivo que procesará la solicitud
        type: 'POST',
        data: $(this).serialize(), // Serializa todos los campos del formulario
        dataType: 'json', // Especifica el formato esperado de la respuesta
        success: function(response) {
          if (response.exito) {
            $('#respuesta').html('<div class="alert alert-success">' + response.mensaje + '</div>');
            $('#formCrearMenu')[0].reset(); // Limpia el formulario tras el éxito
          } else {
            $('#respuesta').html('<div class="alert alert-danger">' + response.mensaje + '</div>');
          }
        },
        error: function() {
          $('#respuesta').html('<div class="alert alert-danger">Ocurrió un error inesperado. Inténtalo de nuevo.</div>');
        }
      });
    });
  });
</script>

<?php include_once "../../estructura/footer.php"; ?>