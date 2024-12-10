<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: paginaLoginAdm.php"); // Redireciona para login
    exit();
}
?>