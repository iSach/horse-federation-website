<?php
session_start();
include 'credentials.php';
if (!isset($_SESSION['login']) or $_SESSION['login'] != $login) {
    session_destroy();
    header("Location: ./login.php");
}
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Menu</title>
    <link rel="stylesheet" href="css/style.css" media="screen" type="text/css"/>
</head>
<body>

<?php
$home_path = "";
include 'header.php';
?>

<div class="centered-box">
    <p>
        Bienvenue dans la base de donnée de Fédération équestre !
    </p>
</div>
</body>
</html>
