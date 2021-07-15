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
    <title>Tables des dressages</title>
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

if (isset($_POST['choixDressage'])) {
    $name = $_POST['choixDressage'];
    $_SESSION['choixDressage'] = $_POST['choixDressage'];
} else {
    header("Location: ../index.php");
}

$name = trim($name);
$query = 'SELECT ordre FROM Ordres WHERE nom LIKE ' . "'%" . $name . "%'" . ' ORDER BY ordre ASC';
$req = $bdd->query($query);
?>

<h2 style="text-align: center; color: white; margin-top: 10px">Liste des ordres triés alphabétiquement : </h2>

<table>
    <thead>
    <tr>
        <th>Ordre</th>
    </tr>
    </thead>
    <tbody>
    <?php
    while ($data = $req->fetch()) {
        echo '<tr> <td> ' . $data['ordre'] . '</td> </tr> ';
    }
    ?>
    </tbody>
</table>

</body>
</html>
