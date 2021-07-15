<?php
session_start();

if (isset($_POST['disconnect'])) {
    session_unset();
}

include 'credentials.php';

$bdd = new PDO('mysql:host=localhost;dbname=group4', $login, $pass);
if ($bdd == NULL)
    echo "Problème de connexion";

if (isset($_POST["login"])) {
    $username = $_POST["login"];
    $password = $_POST["password"];

    if ($username == $login and $password == $pass) {
        $_SESSION['login'] = $username;
        header('Location: index.php');
    } else {
        header('Location: login.php?erreur=1');
    }
} else {
    header('Location: login.php');
}
die();
?>
