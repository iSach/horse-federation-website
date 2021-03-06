<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
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
    <title>Affichage des tuples</title>
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

if (!isset($_SESSION['nomTable'])) {
    header("Location: ../index.php");
}

switch ($_SESSION['nomTable']) {
case 'Club':
    if (!isset($_POST['numero']) or !isset($_POST['nom']) or !isset($_POST['code_postal']) or !isset($_POST['localite']) or !isset($_POST['rue']) or !isset($_POST['num']) or !isset($_POST['id_president'])) {
        header("Location: ../index.php");
    }

    $_POST['numero'] = str_replace("'", "\'", $_POST['numero']);
    $_POST['nom'] = htmlspecialchars(trim(str_replace("'", "\'", $_POST['nom'])));
    $_POST['code_postal'] = str_replace("'", "\'", $_POST['code_postal']);
    $_POST['localite'] = htmlspecialchars(trim(str_replace("'", "\'", $_POST['localite'])));
    $_POST['rue'] = htmlspecialchars(trim(str_replace("'", "\'", $_POST['rue'])));
    $_POST['num'] = str_replace("'", "\'", $_POST['num']);
    $_POST['id_president'] = str_replace("'", "\'", $_POST['id_president']);

    $query = 'SELECT * FROM Club WHERE LOWER(nom) LIKE LOWER(:nom) AND LOWER(rue) LIKE LOWER(:rue) AND LOWER(localite) LIKE LOWER(:localite)';
    $variable = array(':nom' => '%' . $_POST['nom'] . '%', ':rue' => '%' . $_POST['rue'] . '%', ':localite' => '%' . $_POST['localite'] . '%');

    if ($_POST['numero'] != '') {
        $query .= "AND numero = :numero ";
        $variable[':numero'] = $_POST['numero'];
    }
    if ($_POST['code_postal'] != '') {
        $query .= "AND code_postal = :code_postal ";
        $variable[':code_postal'] = $_POST['code_postal'];
    }
    if ($_POST['num'] != '') {
        $query .= "AND num = :num";
        $variable[':num'] = $_POST['num'];
    }
    if ($_POST['id_president'] != '') {
        $query .= "AND id_president = :id_president";
        $variable[':id_president'] = $_POST['id_president'];
    }

    $req = $bdd->prepare($query);
    $req->execute($variable);
    if ($req->rowCount() == 0) {
        echo '<div class="centered-box"><p style=\'color:red\'>D??sol??, aucun tuple ne correspond ?? vos contraintes. <br/> Veuillez r??essayer</p></div>';
        break;
    }

    ?>
    <h2 style="text-align: center; color: white; margin-top: 10px;">Tuples des clubs : </h2>
    <table>
        <thead>
        <tr>
            <th width=15%>Num??ro du club</th>
            <th>Nom</th>
            <th>Code postal</th>
            <th>Localit??</th>
            <th>Rue</th>
            <th>Num??ro de rue</th>
            <th>ID du pr??sident</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($data = $req->fetch()) {
            echo '<tr> <td> ' . $data['numero'] . '</td><td>' . $data['nom'] . '</td><td>' . $data['code_postal'] . '</td><td>' . $data['localite'] . '</td><td>' . $data['rue'] . '</td><td>' . $data['num'] . '</td><td>' . $data['id_president'] . '</td> </tr> ';
        }
        ?>
        </tbody>
    </table>
    <?php
    break;
case 'Membre':
    if (!isset($_POST['id']) or !isset($_POST['nom']) or !isset($_POST['prenom']) or !isset($_POST['email']) or !isset($_POST['id_club'])) {
        header("Location: ../index.php");
    }

    $_POST['id'] = str_replace("'", "\'", $_POST['id']);
    $_POST['nom'] = htmlspecialchars(trim(str_replace("'", "\'", $_POST['nom'])));
    $_POST['prenom'] = htmlspecialchars(trim(str_replace("'", "\'", $_POST['prenom'])));
    $_POST['email'] = str_replace("'", "\'", $_POST['email']);
    $_POST['id_club'] = str_replace("'", "\'", $_POST['id_club']);

    $query = 'SELECT * FROM Membre WHERE LOWER(nom) LIKE LOWER(:nom) AND LOWER(prenom) LIKE LOWER(:prenom) AND LOWER(email) LIKE LOWER(:email) ';
    $variable = array(':nom' => '%' . $_POST['nom'] . '%', ':prenom' => '%' . $_POST['prenom'] . '%', ':email' => '%' . $_POST['email'] . '%');

    if ($_POST['id'] != '') {
        $query .= "AND id = :id ";
        $variable[':id'] = $_POST['id'];
    }
    if ($_POST['id_club'] != '') {
        $query .= "AND id_club = :id_club ";
        $variable[':id_club'] = $_POST['id_club'];
    }

    $req = $bdd->prepare($query);
    $req->execute($variable);
    if ($req->rowCount() == 0) {
        echo '<div class="centered-box"><p style=\'color:red\'>D??sol??, aucun tuple ne correspond ?? vos contraintes. <br/> Veuillez r??essayer</p></div>';
        break;
    }

    ?>
    <h2 style="text-align: center; color: white; margin-top: 10px;">Tuples des membres : </h2>
    <table>
        <thead>
        <tr>
            <th width=15%>ID du membre</th>
            <th>Nom du membre</th>
            <th>Pr??nom du membre</th>
            <th>Email du membre</th>
            <th>ID du club</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($data = $req->fetch()) {
            echo '<tr> <td> ' . $data['id'] . '</td><td>' . $data['nom'] . '</td><td>' . $data['prenom'] . '</td><td>' . $data['email'] . '</td><td>' . $data['id_club'] . '</td> </tr> ';
        }
        ?>
        </tbody>
    </table>
    <?php
    break;
case 'Cheval':
    if (!isset($_POST['numero']) or !isset($_POST['nom']) or !isset($_POST['sexe']) or !isset($_POST['taille']) or !isset($_POST['date_naissance'])) {
        header("Location: ../index.php");
    }

    $_POST['numero'] = str_replace("'", "\'", $_POST['numero']);
    $_POST['nom'] = htmlspecialchars(trim(str_replace("'", "\'", $_POST['nom'])));
    $_POST['sexe'] = htmlspecialchars(trim(str_replace("'", "\'", $_POST['sexe'])));
    $_POST['taille'] = str_replace("'", "\'", $_POST['taille']);
    $_POST['date_naissance'] = htmlspecialchars(trim(str_replace("'", "\'", $_POST['date_naissance'])));

    $query = 'SELECT * FROM Cheval WHERE LOWER(nom) LIKE LOWER(:nom) ';
    $variable = array(':nom' => '%' . $_POST['nom'] . '%');

    if ($_POST['numero'] != '') {
        $query .= "AND numero = :numero ";
        $variable[':numero'] = $_POST['numero'];
    }
    if ($_POST['sexe'] != '') {
        $query .= "AND sexe = :sexe ";
        $variable[':sexe'] = $_POST['sexe'];
    }
    if ($_POST['taille'] != '') {
        $query .= "AND taille = :taille ";
        $variable[':taille'] = $_POST['taille'];
    }
    if ($_POST['date_naissance'] != '') {
        $query .= "AND date_naissance = :date_naissance";
        $variable[':date_naissance'] = $_POST['date_naissance'];
    }

    $req = $bdd->prepare($query);
    $req->execute($variable);
    if ($req->rowCount() == 0) {
        echo '<div class="centered-box"><p style=\'color:red\'>D??sol??, aucun tuple ne correspond ?? vos contraintes. <br/> Veuillez r??essayer</p></div>';
        break;
    }

    ?>
    <h2 style="text-align: center; color: white; margin-top: 10px;">Tuples des chevaux : </h2>
    <table>
        <thead>
        <tr>
            <th width=15%>Num??ro du cheval</th>
            <th>Nom du cheval</th>
            <th>Sexe du cheval</th>
            <th>Taille du cheval</th>
            <th>Date de naissance du cheval</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($data = $req->fetch()) {
            echo '<tr> <td> ' . $data['numero'] . '</td><td>' . $data['nom'] . '</td><td>' . $data['sexe'] . '</td><td>' . $data['taille'] . '</td><td>' . $data['date_naissance'] . '</td> </tr> ';
        }
        ?>
        </tbody>
    </table>
    <?php
    break;
case 'ProprieteDe':
    if (!isset($_POST['id_membre']) or !isset($_POST['id_cheval'])) {
        header("Location: ../index.php");
    }

    $_POST['id_membre'] = str_replace("'", "\'", $_POST['id_membre']);
    $_POST['id_cheval'] = str_replace("'", "\'", $_POST['id_cheval']);

    $query = 'SELECT * FROM ProprieteDe ';
    $variable = array();

    if ($_POST['id_membre'] != '') {
        $query .= "WHERE numero_membre = :numero_membre ";
        $variable[':numero_membre'] = $_POST['id_membre'];
    }
    if ($_POST['id_cheval'] != '') {
        if ($_POST['id_membre'] != '') {
            $query .= "AND numero_cheval = :numero_cheval ";
            $variable[':numero_cheval'] = $_POST['id_cheval'];
        } else {
            $query .= "WHERE numero_cheval = :numero_cheval ";
            $variable[':numero_cheval'] = $_POST['id_cheval'];
        }
    }

    $req = $bdd->prepare($query);
    $req->execute($variable);
    if ($req->rowCount() == 0) {
        echo '<div class="centered-box"><p style=\'color:red\'>D??sol??, aucun tuple ne correspond ?? vos contraintes. <br/> Veuillez r??essayer</p></div>';
        break;
    }

    ?>

    <h2 style="text-align: center; color: white; margin-top: 10px;">Tuples des propri??taires de chevaux : </h2>
    <table>
        <thead>
        <tr>
            <th>ID du membre</th>
            <th>ID du cheval</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($data = $req->fetch()) {
            echo '<tr> <td> ' . $data['numero_membre'] . '</td><td>' . $data['numero_cheval'] . '</td> </tr> ';
        }
        ?>
        </tbody>
    </table>
    <?php
    break;
case 'Competition':
    if (!isset($_POST['nom']) or !isset($_POST['libelle'])) {
        header("Location: ../index.php");
    }

    $_POST['nom'] = htmlspecialchars(trim(str_replace("'", "\'", $_POST['nom'])));
    $_POST['libelle'] = htmlspecialchars(trim(str_replace("'", "\'", $_POST['libelle'])));

    $query = 'SELECT * FROM Competition WHERE LOWER(nom) LIKE LOWER(:nom) AND LOWER(libelle) LIKE LOWER(:libelle) ';
    $variable = array(':nom' => '%' . $_POST['nom'] . '%', ':libelle' => '%' . $_POST['libelle'] . '%');

    $req = $bdd->prepare($query);
    $req->execute($variable);
    if ($req->rowCount() == 0) {
        echo '<div class="centered-box"><p style=\'color:red\'>D??sol??, aucun tuple ne correspond ?? vos contraintes. <br/> Veuillez r??essayer</p></div>';
        break;
    }

    ?>


    <h2 style="text-align: center; color: white; margin-top: 10px;">Tuples des comp??titions : </h2>
    <table>
        <thead>
        <tr>
            <th width=25%>Nom de la comp??tition</th>
            <th>Libell?? de la comp??tition</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($data = $req->fetch()) {
            echo '<tr> <td> ' . $data['nom'] . '</td><td>' . $data['libelle'] . '</td> </tr> ';
        }
        ?>
        </tbody>
    </table>
    <?php
    break;
case 'Obstacle':
    if (!isset($_POST['nom']) or !isset($_POST['nb_haies'])) {
        header("Location: ../index.php");
    }

    $_POST['nom'] = htmlspecialchars(trim(str_replace("'", "\'", $_POST['nom'])));
    $_POST['nb_haies'] = str_replace("'", "\'", $_POST['nb_haies']);

    $query = 'SELECT * FROM Obstacles WHERE LOWER(nom) LIKE LOWER(:nom) ';
    $variable = array(':nom' => '%' . $_POST['nom'] . '%');

    if ($_POST['nb_haies'] != '') {
        $query .= "AND nb_haies = :nb_haies";
        $variable[':nb_haies'] = $_POST['nb_haies'];
    }

    $req = $bdd->prepare($query);
    $req->execute($variable);
    if ($req->rowCount() == 0) {
        echo '<div class="centered-box"><p style=\'color:red\'>D??sol??, aucun tuple ne correspond ?? vos contraintes. <br/> Veuillez r??essayer</p></div>';
        break;
    }

    ?>

    <h2 style="text-align: center; color: white; margin-top: 10px;">Tuples des courses d'obstacles</h2>
    <table>
        <thead>
        <tr>
            <th width=25%>Nom de la course d'obstacles</th>
            <th>Nombre de haies de la course</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($data = $req->fetch()) {
            echo '<tr> <td> ' . $data['nom'] . '</td><td>' . $data['nb_haies'] . '</td> </tr> ';
        }
        ?>
        </tbody>
    </table>
    <?php
    break;
case 'Dressage':
    if (!isset($_POST['nom'])) {
        header("Location: ../index.php");
    }

    $_POST['nom'] = htmlspecialchars(trim(str_replace("'", "\'", $_POST['nom'])));

    $query = 'SELECT * FROM Dressage WHERE LOWER(nom) LIKE LOWER(:nom) ';
    $variable = array(':nom' => '%' . $_POST['nom'] . '%');

    $req = $bdd->prepare($query);
    $req->execute($variable);
    if ($req->rowCount() == 0) {
        echo '<div class="centered-box"><p style=\'color:red\'>D??sol??, aucun tuple ne correspond ?? vos contraintes. <br/> Veuillez r??essayer</p></div>';
        break;
    }

    ?>

    <h2 style="text-align: center; color: white; margin-top: 10px;">Tuples des comp??titions de dressage</h2>
    <table>
        <thead>
        <tr>
            <th width=25%>Nom de la comp??tition de dressage</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($data = $req->fetch()) {
            echo '<tr> <td> ' . $data['nom'] . '</td> </tr> ';
        }
        ?>
        </tbody>
    </table>
    <?php
    break;
case 'Ordres':
    if (!isset($_POST['nom_comp']) or !isset($_POST['numero']) or !isset($_POST['ordre'])) {
        header("Location: ../index.php");
    }

    $_POST['nom_comp'] = htmlspecialchars(trim(str_replace("'", "\'", $_POST['nom_comp'])));
    $_POST['numero'] = str_replace("'", "\'", $_POST['numero']);
    $_POST['ordre'] = htmlspecialchars(trim(str_replace("'", "\'", $_POST['ordre'])));

    $query = 'SELECT * FROM Ordres WHERE LOWER(nom) LIKE LOWER(:nom) AND LOWER(ordre) LIKE LOWER(:ordre)';
    $variable = array(':nom' => '%' . $_POST['nom_comp'] . '%', ':ordre' => '%' . $_POST['ordre'] . '%');

    if ($_POST['numero'] != '') {
        $query .= "AND numero = :numero";
        $variable[':numero'] = $_POST['numero'];
    }

    $req = $bdd->prepare($query);
    $req->execute($variable);

    if ($req->rowCount() == 0) {
        echo '<div class="centered-box"><p style=\'color:red\'>D??sol??, aucun tuple ne correspond ?? vos contraintes. <br/> Veuillez r??essayer</p></div>';
        break;
    }

    ?>

    <h2 style="text-align: center; color: white; margin-top: 10px;">Tuples des ordres : </h2>
    <table>
        <thead>
        <tr>
            <th width=50%>Nom de la comp??tition de dressage</th>
            <th>Num??ro de l'ordre dans la liste</th>
            <th>Nom de l'ordre</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($data = $req->fetch()) {
            echo '<tr> <td> ' . $data['nom'] . '</td><td>' . $data['numero'] . '</td><td>' . $data['ordre'] . '</td> </tr> ';
        }
        ?>
        </tbody>
    </table>
    <?php
    break;
case 'InstanceComp':
    if (!isset($_POST['nom']) or !isset($_POST['annee']) or !isset($_POST['id_organisateur'])) {
        header("Location: ../index.php");
    }

    $_POST['nom'] = htmlspecialchars(trim(str_replace("'", "\'", $_POST['nom'])));
    $_POST['annee'] = str_replace("'", "\'", $_POST['annee']);
    $_POST['id_organisateur'] = str_replace("'", "\'", $_POST['id_organisateur']);

    $query = 'SELECT * FROM InstanceComp WHERE LOWER(nom) LIKE LOWER(:nom) ';
    $variable = array(':nom' => '%' . $_POST['nom'] . '%');

    if ($_POST['annee'] != '') {
        $query .= "AND annee = :annee ";
        $variable[':annee'] = $_POST['annee'];
    }
    if ($_POST['id_organisateur'] != '') {
        $query .= "AND id_organisateur = :id_organisateur ";
        $variable[':id_organisateur'] = $_POST['id_organisateur'];
    }

    $req = $bdd->prepare($query);
    $req->execute($variable);
    if ($req->rowCount() == 0) {
        echo '<div class="centered-box"><p style=\'color:red\'>D??sol??, aucun tuple ne correspond ?? vos contraintes. <br/> Veuillez r??essayer</p></div>';
        break;
    }

    ?>

    <h2 style="text-align: center; color: white; margin-top: 10px;">Tuples des instances de comp??tition </h2>
    <table>
        <thead>
        <tr>
            <th width=33%>Nom de la comp??tition organis??e</th>
            <th>Ann??e de la comp??tition organis??e</th>
            <th>ID du membre organisateur</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($data = $req->fetch()) {
            echo '<tr> <td> ' . $data['nom'] . '</td><td>' . $data['annee'] . '</td><td>' . $data['id_organisateur'] . '</td> </tr> ';
        }
        ?>
        </tbody>
    </table>
    <?php
    break;
case 'Participe':
if (!isset($_POST['id_membre']) or !isset($_POST['nom']) or !isset($_POST['annee']) or !isset($_POST['id_cheval']) or !isset($_POST['resultat'])) {
    header("Location: ../index.php");
}

$_POST['id_membre'] = str_replace("'", "\'", $_POST['id_membre']);
$_POST['nom'] = htmlspecialchars(trim(str_replace("'", "\'", $_POST['nom'])));
$_POST['annee'] = str_replace("'", "\'", $_POST['annee']);
$_POST['id_cheval'] = str_replace("'", "\'", $_POST['id_cheval']);
$_POST['resultat'] = str_replace("'", "\'", $_POST['resultat']);

$query = 'SELECT * FROM Participe WHERE LOWER(nom) LIKE LOWER(:nom) ';
$variable = array(':nom' => '%' . $_POST['nom'] . '%');

if ($_POST['id_membre'] != '') {
    $query .= "AND numero_membre = :numero_membre ";
    $variable[':numero_membre'] = $_POST['id_membre'];
}
if ($_POST['annee'] != '') {
    $query .= "AND annee = :annee ";
    $variable[':annee'] = $_POST['annee'];
}
if ($_POST['id_cheval'] != '') {
    $query .= "AND numero_cheval = :numero_cheval";
    $variable[':numero_cheval'] = $_POST['id_cheval'];
}
if ($_POST['resultat'] != '') {
    $query .= "AND resultat = :resultat";
    $variable[':resultat'] = $_POST['resultat'];
}

$req = $bdd->prepare($query);
$req->execute($variable);
if ($req->rowCount() == 0) {
    echo '<div class="centered-box"><p style=\'color:red\'>D??sol??, aucun tuple ne correspond ?? vos contraintes. <br/> Veuillez r??essayer</p></div>';
    break;
}

?>

<h2 style="text-align: center; color: white; margin-top: 10px;">Tuples des participants ?? une comp??tition </h2>
        <table>
            <thead>
            <tr>
                <th width=25%>Num??ro du membre participant ?? la comp??tition</th>
                <th>Nom de la comp??tition</th>
                <th>Ann??e de la comp??tition r??alis??e</th>
                <th>ID du cheval utilis??</th>
                <th>R??sultat du duo cheval-membre ?? la comp??tition</th>
            </tr>
            </thead>
            <tbody>
            <?php
            while ($data = $req->fetch()) {
                echo '<tr> <td> ' . $data['numero_membre'] . '</td><td>' . $data['nom'] . '</td><td>' . $data['annee'] . '</td><td>' . $data['numero_cheval'] . '</td><td>' . $data['resultat'] . '</td> </tr> ';
            }
            ?>
            </tbody>
        </table>

        <?php
        break;
        default:
            header("Location: ../index.php");
            break;
        }
        ?>
</body>
</html>
