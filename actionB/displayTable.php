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
            <li> <a href="../actionD/participation.php"> Participations </a></li>
            <li> <a href="../actionE/memberByResults.php"> Résultats </a></li>
        </ul>
    </nav>

    <form action="tableDressage.php" method="post">

        <h3> Que souhaitez vous consulter ? </h3>
        <select name="choixDressage">
            <?php
            try{
                $bdd = new PDO('mysql:host=localhost;dbname=group4;charset=utf8', $login, $pass);
                $bdd->exec('set names utf8');
            }catch (Exception $e){
                die('Erreur: '.$e->getMessage());
            }
            $req = $bdd->query('SELECT nom FROM Dressage');
            $i = 1;
            while($data = $req->fetch()){
                echo "<option value=\"".$data['nom']."\">".$data['nom'].'</option>';
                $i++;
            }
            ?>
        </select>
        <input type="submit" id='submit' value='Soumettre' >
    </form>
    </body>
</html>
