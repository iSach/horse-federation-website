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

<form class="centered-box" action="tableDressage.php" method="post">
    <h3> Que souhaitez vous consulter ? </h3>

    <select name="choixDressage">
        <?php
        try {
            $bdd = new PDO('mysql:host=localhost;dbname=group4;charset=utf8', $login, $pass);
            $bdd->exec('set names utf8');
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
        $req = $bdd->query('SELECT nom FROM Dressage');
        $i = 1;
        while ($data = $req->fetch()) {
            echo "<option value=\"" . $data['nom'] . "\">" . $data['nom'] . '</option>';
            $i++;
        }
        ?>
    </select>

    <input type="submit" id='submit' value='Soumettre'>
</form>

</body>
</html>
