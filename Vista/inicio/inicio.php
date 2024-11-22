<?php
include_once "../../config.php";
$titulo = "Inicio";
include_once "../../estructura/header.php";
?>
<?php if (isset($_GET['msg'])): ?>
  <div class="alert alert-info w-25"><?php echo htmlspecialchars($_GET['msg']); ?></div>
<?php endif; ?>
<div class="container mt-4">
  <h1>Grupo 11</h1>
  <table class="table table-striped table-hover table-bordered">
    <thead class="table-dark">
      <tr>
        <th>Nombre</th>
        <th>Legajo</th>
        <th>Repositorios</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Federico Uñates</td>
        <td>FAI - 4988</td>
        <td><a href="https://github.com/FedeU18" target="_blank" class="text-decoration-none">Github</a></td>
      </tr>
      <tr>
        <td>Emanuel Pinedo</td>
        <td>FAI - 4871</td>
        <td><a href="https://github.com/emanuelPinedo" target="_blank" class="text-decoration-none">Github</a></td>
      </tr>
      <tr>
        <td>Joaquín Vargas</td>
        <td>FAI - 4873</td>
        <td><a href="https://github.com/JoaquinIVL95" target="_blank" class="text-decoration-none">Github</a></td>
      </tr>
    </tbody>
  </table>
</div>
<?php
include_once "../../estructura/footer.php"
?>