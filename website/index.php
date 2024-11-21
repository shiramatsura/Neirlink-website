<?php
session_start();
require_once(__DIR__ . '/config/mysql.php');
require_once(__DIR__ . '/back/db_connect.php');
require_once(__DIR__ . '/back/functions.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>You are at INDEX</title>
    <link rel="stylesheet" href="styles.css">

    <script src="script.js" defer></script> 
</head>
<body>
    <header>
        <?php require_once(__DIR__ . '/back/header.php'); ?>
    </header>
    <main>
        <h1>Welcome on Neirlink</h1>
        <a class="nav-link" href="user_sign_out">Déconnexion</a>
    </main>
    <footer>
        <?php require_once(__DIR__ . '/back/footer.php'); ?>
    </footer>

</body>
</html>