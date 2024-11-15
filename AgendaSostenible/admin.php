<?php
session_start();

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: agendasostenible.php"); // Redirige a la página principal si no es admin
    exit();
}
?>
