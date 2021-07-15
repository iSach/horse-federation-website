<?php
session_start();
include '../credentials.php';
if (!isset($_SESSION['login']) or $_SESSION['login'] != $login) {
    session_destroy();
    header("Location: ../login.php");
}
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Contenu</title>
    <link rel="stylesheet" href="../css/style.css" media="screen" type="text/css"/>
</head>
<body>

<?php
$home_path = "../";
include '../header.php';
?>

<form class="centered-box" action="chooseField.php" method="post">
    <h3> Que souhaitez-vous consulter ? </h3>

    <select name="nomTable">
        <option value="Club">Les clubs</option>
        <option value="Membre">Les membres</option>
        <option value="Cheval">Les chevaux</option>
        <option value="ProprieteDe">Les propriétaires des chevaux</option>
        <option value="Competition">Les compétitions hippiques</option>
        <option value="Obstacle">Les courses d'obstacles</option>
        <option value="Dressage">Les compétitions de dressage</option>
        <option value="Ordres">La liste des ordres des compétitions de dressage</option>
        <option value="InstanceComp">Les instances de compétition</option>
        <option value="Participe">Les participants d'une instance de compétition et leur résultat</option>
    </select>

    <input type="submit" id='submit' value='Soumettre'>
</form>

</body>
</html>
