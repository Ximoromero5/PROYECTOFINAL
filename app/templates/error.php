<?php ob_start() ?>
<h1>An error has ocurred, please go <a href="index.php?action=login">to the login page</a></h1>
<?php $contenido = ob_get_clean() ?>
<?php include 'header.php' ?>