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

<?php
try {
    $bdd = new PDO('mysql:host=localhost;dbname=group4;charset=utf8', $login, $pass);
    $bdd->exec('set names utf8');
} catch (Exception $e) {
    die('Erreur: ' . $e->getMessage());
}

if (!isset($_POST['member']) and !isset($_POST['comp']) and !isset($_POST['horse']) and !isset($_POST['score'])) {
    ?>

    <form class="centered-box" action="addResult.php" method="post">

        <h3>Veuillez entrer le résultat à ajouter</h3>

        <label><b>Membre : </b></label>
        <select name="member">
            <?php
            $query = 'SELECT nom, prenom, id FROM Membre ORDER BY nom ASC';
            $req = $bdd->query($query);
            while ($row = $req->fetch()) {
                echo "<option value=\"" . $row['id'] . "\">" . $row['nom'] . ' ' . $row['prenom'] . "</option>";
            }
            ?>
        </select>

        <br>

        <label><b>Compétition : </b></label>
        <select name="comp">
            <?php
            $query = 'SELECT nom, annee FROM InstanceComp ORDER BY annee ASC';
            $req = $bdd->query($query);
            while ($row = $req->fetch()) {
                echo "<option value=\"" . $row['nom'] . "_" . $row['annee'] . "\">" . $row['nom'] .
                    " (" . $row['annee'] . ")</option>";
            }
            ?>
        </select>

        <input type="submit" id='submit' value='Suivant'>
    </form>

    <?php
} else {

    if (isset($_POST['score']) && isset($_POST['horse'])) {
        $member_id = $_SESSION['member'];
        $comp_data = explode("_", $_SESSION['comp']);
        $comp_name = $comp_data[0];
        $comp_year = $comp_data[1];
        $horse_id = $_POST['horse'];
        $score = $_POST['score'];

        $query = "INSERT INTO Participe (numero_membre, nom, annee, numero_cheval, resultat)
                     VALUES ('" . $member_id . "', '" . $comp_name . "', '" . $comp_year . "', '" . $horse_id . "', '" . $score
            . "')";
        $bdd->query($query);
        ?>

        <div class="centered-box">
            <p style="text-align: center;">Résultat ajouté avec succès !</p>

            <a href="addResult.php"><button class="blue-button">Ajouter un autre résultat</button></a>
        </div>

    <?php

    } else if (isset($_POST['comp']) && isset($_POST['member'])) {
        $member_id = $_POST['member'];
        $comp_data = explode("_", $_POST['comp']);
        $comp_name = $comp_data[0];
        $comp_year = $comp_data[1];

        $_SESSION['member'] = $_POST['member'];
        $_SESSION['comp'] = $_POST['comp'];

        // Check if the member has already participated in that competition.
        $query = "SELECT resultat FROM Participe WHERE numero_membre = '" . $member_id . "' AND
                      nom = '" . $comp_name . "' AND annee = '" . $comp_year . "'";
        $req = $bdd->query($query);
        $participates = $req->rowCount();

        if ($participates > 0) {
            ?>
            <div class="centered-box">
                <p style="text-align: center; color: red;">Ce membre a déjà participé à cette compétition (et a obtenu
                    un score de
                    <?php
                    $row = $req->fetch();
                    echo $row['resultat'];
                    ?> points).</p>

                <a href="addResult.php"><button class="blue-button">Ajouter un autre résultat</button></a>
            </div>

            <?php
        } else {
            ?>

            <h3>Veuillez choisir un cheval et entrer le score obtenu</h3>

            <form class="centered-box" action="addResult.php" method="post">
                <label><b>Cheval : </b></label>
                <select name="horse">
                    <?php
                    $query = 'SELECT numero_cheval, nom 
                          FROM ProprieteDe 
                          INNER JOIN Cheval 
                          ON ProprieteDe.numero_cheval = Cheval.numero 
                          WHERE numero_membre = ' . $member_id;
                    $req = $bdd->query($query);
                    while ($row = $req->fetch()) {
                        echo "<option value=\"" . $row['numero_cheval'] . "\">" . $row['nom'] . "</option>";
                    }
                    ?>
                </select>

                <br>

                <label><b>Score : </b></label>
                <input type="number" required min="0" placeholder="Entrez le score obtenu" name="score">

                <input type="submit" id='submit' value='Ajouter'>

            </form>

            <?php
        }
    }
}
?>

</body>
</html>
