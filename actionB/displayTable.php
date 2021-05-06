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
            <li> <a href="displayTable.php"> Liste ordres </a></li>
            <li> <a href="../actionC/displayTable.php"> Afficher </a></li>
        </ul>
    </nav>

    <form action="tableDressage.php" method="post">

        <h3> Que souhaitez vous consulter ? </h3>
        <select name="choixDressage">
            <option value="cointe">CHI de Cointe</option>
            <option value="vise">CHI de Visé</option>
            <option value="waremme">CHI de Waremme</option>
            <option value="herve">Grande course de Herve</option>
        </select>
        <input type="submit" id='submit' value='Soumettre' >
    </form>

    </body>
</html>
