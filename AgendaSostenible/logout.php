<?php
session_start();
session_unset();
session_destroy();
header("Location: agendasostenible.php");
exit();
?>
