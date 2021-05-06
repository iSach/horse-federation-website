<?php
    session_start();
    include '../credentials.php';
    if (!isset($_SESSION['login']) OR $_SESSION['login'] != $login )
    {
        session_destroy();
        header("Location: ../index.php");
    }
?>

<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Tables des dressages</title>
        <link rel="stylesheet" href="../style.css" media="screen" type="text/css" />
    </head>
    <body>
    <header>
        <div id="deco">
            <a class="deco" href="../deconnexion.php"> Déconnexion </a>
        </div>
        <a href="../menu.php"> <p style="text-align: center"><img src="../Images/UliegeLogo.png" width="25%"></p> </a>

    </header>
    <nav>
        <ul>
          <li> <a href="../menu.php"> Accueil </a></li>
          <li> <a href="../actionA/chooseTable.php"> Contenu </a></li>
          <li> <a href="displayTable.php"> Liste ordres </a></li>
          <li> <a href="../actionC/addResult.php"> Ajouter un résultat </a></li>
          <li> <a href="../actionD/participation.php"> Participation </a></li>
          <li> <a href="../actionE/memberByResults.php"> Résultats </a></li>
    </nav>

    <?php
    try{
        $bdd = new PDO('mysql:host=localhost;dbname=group4;charset=utf8', $login, $pass);
        $bdd->exec('set names utf8');
    }catch (Exception $e){
        die('Erreur: '.$e->getMessage());
    }

    if (isset($_POST['choixDressage'])){
        $_SESSION['choixDressage'] = $_POST['choixDressage'];
    }
    else{
        header("Location: ../menu.php");
    }

    switch($_POST["choixDressage"]){
    case "cointe":
        $query = 'SELECT ordre FROM Ordres WHERE nom LIKE ' . "'%CHI de Cointe%'" . ' ORDER BY ordre ASC';
        $req = $bdd->query($query);
    ?>
    <h2 style="text-align: center">Liste des ordres triés alphabétiquement : </h2>
    <table>
        <thead>
        <tr>
            <th>Ordre</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while($data = $req->fetch()){
            echo '<tr> <td> '.$data['ordre'].'</td> </tr> ';
        }
        ?>
        </tbody>
    </table>
    <?php
    break;
    case "vise":
    $query = 'SELECT ordre FROM Ordres WHERE nom LIKE ' . "'%CHI de Visé%'" . ' ORDER BY ordre ASC';
    $req = $bdd->query($query);
?>
<h2 style="text-align: center">Liste des ordres triés alphabétiquement : </h2>
<table>
    <thead>
    <tr>
        <th>Ordre</th>
    </tr>
    </thead>
    <tbody>
    <?php
    while($data = $req->fetch()){
        echo '<tr> <td> '.$data['ordre'].'</td> </tr> ';
        }
        ?>
        </tbody>
    </table>
        <?php
        break;
    case "waremme":
    $query = 'SELECT ordre FROM Ordres WHERE nom LIKE ' . "'%CHI de Waremme%'" . ' ORDER BY ordre ASC';
    $req = $bdd->query($query);
?>
<h2 style="text-align: center">Liste des ordres triés alphabétiquement : </h2>
<table>
    <thead>
    <tr>
        <th>Ordre</th>
    </tr>
    </thead>
    <tbody>
    <?php
    while($data = $req->fetch()){
        echo '<tr> <td> '.$data['ordre'].'</td> </tr> ';
        }
        ?>
        </tbody>
    </table>
        <?php
        break;
    case "herve":
    $query = 'SELECT ordre FROM Ordres WHERE nom LIKE ' . "'%Grande course de Herve%'" . ' ORDER BY ordre ASC';
    $req = $bdd->query($query);
?>
<h2 style="text-align: center">Liste des ordres triés alphabétiquement : </h2>
<table>
    <thead>
    <tr>
        <th>Ordre</th>
    </tr>
    </thead>
    <tbody>
    <?php
    while($data = $req->fetch()){
        echo '<tr> <td> '.$data['ordre'].'</td> </tr> ';
        }
        ?>
        </tbody>
    </table>
    <?php
        break;
    default :
        header("Location: ../menu.php");
        break;
    }
    ?>
    </body>
</html>
