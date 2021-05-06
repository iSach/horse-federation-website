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
            <li> <a href="../actionA/chooseTable.php"> Contenu </a></li>
            <li> <a href="../actionB/displayTable.php"> Liste ordres </a></li>
            <li> <a href="../actionC/displayTable.php"> Afficher </a></li>
            <li> <a href="participation.php"> Participation </a></li>
        </ul>
    </nav>
    <?php
    try{
        $bdd = new PDO('mysql:host=localhost;dbname=group4;charset=utf8', $login, $pass);
        $bdd->exec('set names utf8');
    }catch (Exception $e){
        die('Erreur: '.$e->getMessage());
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
    <h2 style="text-align: center">Membre ayant participé à toutes les courses d'obstacles : </h2>
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
        while($data = $req->fetch()){
            echo '<tr> <td> '.$data['id'].'</td><td>'.$data['nom'].'</td><td>'.$data['prenom'].'</td> </tr> ';
        }
        ?>
        </tbody>
    </table>
    </body>
</html>

