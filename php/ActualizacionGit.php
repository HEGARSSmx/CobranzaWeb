<?php
include './Header.php';
echo "<h1>Gestor de Actualizaciones</h1>";
echo shell_exec('git pull origin master');
 ?>
