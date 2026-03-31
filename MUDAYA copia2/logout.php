<?php
session_start();
session_unset();
session_destroy();

// Redirigir al login o a la página principal de MUDAYA
header("Location: index.php");
exit();
?>