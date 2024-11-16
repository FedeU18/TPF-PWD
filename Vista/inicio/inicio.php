<?php
include_once "../../config.php";
$titulo = "Inicio";
include_once "../../estructura/header.php";
?>
<?php if (isset($_GET['msg'])): ?>
  <div class="alert alert-info w-25"><?php echo htmlspecialchars($_GET['msg']); ?></div>
<?php endif; ?>
<h1>Inicio</h1>
<?php
include_once "../../estructura/footer.php"
?>