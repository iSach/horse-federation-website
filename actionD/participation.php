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

try {
    $bdd = new PDO('mysql:host=localhost;dbname=group4;charset=utf8', $login, $pass);
    $bdd->exec('set names utf8');
} catch (Exception $e) {
    die('Erreur: ' . $e->getMessage());
}

$query = 'SELECT id,nom,prenom 
              FROM Membre 
              WHERE id IN 
                    (SELECT numero_membre
                    FROM
                        (SELECT nom FROM Obstacles) AS t1
                        NATURAL JOIN
                        (SELECT DISTINCT numero_membre,nom FROM Participe) AS t2
                    GROUP BY numero_membre
                    HAVING COUNT(nom) = (SELECT COUNT(*) FROM Obstacles)
                    )';
$req = $bdd->query($query);
?>

<h2 style="text-align: center; color: white; margin-top: 10px;">Membre ayant participé à toutes les courses d'obstacles : </h2>
<table>
    <thead>
    <tr>
        <th width=15%>ID</th>
        <th>Nom</th>
        <th>Prénom</th>
    </tr>
    </thead>
    <tbody>
    <?php
    while ($data = $req->fetch()) {
        echo '<tr> <td> ' . $data['id'] . '</td><td>' . $data['nom'] . '</td><td>' . $data['prenom'] . '</td> </tr> ';
    }
    ?>
    </tbody>
</table>
</body>
</html>

