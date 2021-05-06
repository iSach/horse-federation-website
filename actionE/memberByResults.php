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
        <title>Contenu</title>
        <link rel="stylesheet" href="../style.css" media="screen" type="text/css" />
    </head>
    <body>
    <header>
        <div id="deco">
            <a href="../deconnexion.php"> Déconnexion </a>
        </div>
        <a href="../menu.php"> <p style="text-align: center"><img src="../Images/UliegeLogo.png" width="25%"></p> </a>

    </header>
    <nav>
        <ul>
            <li> <a href="../menu.php"> Accueil </a></li>
            <li> <a href="../actionA/chooseTable.php"> Contenu </a></li>
            <li> <a href="../actionB/displayTable.php"> Liste ordres </a></li>
            <li> <a href="../actionC/displayTable.php"> Afficher </a></li>
            <li> <a href="../actionD/participation.php"> Participation </a></li>
            <li> <a href="memberByResults.php"> Résultats </a></li>
        </ul>
    </nav>
    <?php
    try{
        $bdd = new PDO('mysql:host=localhost;dbname=group4;charset=utf8', $login, $pass);
        $bdd->exec('set names utf8');
    }catch (Exception $e){
        die('Erreur: '.$e->getMessage());
    }
    $query = 'SELECT id, nom, prenom, score, nb_inst
              FROM Membre NATURAL JOIN
                  (SELECT numero_membre AS id, COUNT(nom) AS nb_inst, SUM(resultat) AS score
                  FROM Participe 
                  GROUP BY id) AS t1
              UNION	
              SELECT id, nom, prenom, 0 AS score, 0 AS nb_inst 
              FROM Membre 
              WHERE id NOT IN 
                  (SELECT DISTINCT numero_membre
                  FROM Participe)	
              ORDER BY score DESC, nb_inst DESC, id ASC';
    $req = $bdd->query($query);
    ?>
    <h2 style="text-align: center">Somme des points pour chaque membre par ordre décroissant : </h2>
    <table>
        <thead>
        <tr>
            <th width=15%>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Score total</th>
            <th>Nombre d'instances</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while($data = $req->fetch()){
            echo '<tr> <td> '.$data['id'].'</td><td>'.$data['nom'].'</td><td>'.$data['prenom'].'</td><td>'.$data['score'].'</td><td>'.$data['nb_inst'].'</td></tr> ';
        }
        ?>
        </tbody>
    </table>
    </body>
</html>
