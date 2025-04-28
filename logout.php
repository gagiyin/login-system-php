<?php
unset($_SESSION['logged-in']);
unset($_SESSION['user']);

redirect("index.php");

session_destroy();
?>
