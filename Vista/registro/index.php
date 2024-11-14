<?php
$titulo = "Registro";
include_once "../../estructura/header.php"
?>
<h1>Registro nuevo usuario</h1>

<form action="action.php" method="post">
    <label for="usnombre">Nombre de usuario:</label><br>
    <input type="text" id="usnombre" name="usnombre" required><br><br>
    <label for="pass">Contraseña:</label><br>
    <input type="password" id="pass" name="pass" required><br><br>
    <label for="email">E-mail:</label><br>
    <input type="text" id="email" name="email" required><br><br>

    <input type="submit"  value="Enviar">

    


<?php
include_once "../../estructura/footer.php"
?>