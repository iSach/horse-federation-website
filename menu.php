<?php
    session_start();
    include 'credentials.php';
    if (!isset($_SESSION['login']) OR $_SESSION['login'] != $login )
    {
        session_destroy();
        header("Location: ./index.php");
    }
?>

<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Menu</title>
        <link rel="stylesheet" href="style.css" media="screen" type="text/css" />
    </head>
    <body>
        	<header>
        		<div id="deco">
                    <a class="deco" href="deconnexion.php"> Déconnexion </a>
        		</div>
        		<a href="menu.php"> <p style="text-align: center"><img src="Images/UliegeLogo.png" width="25%"></p> </a>

       	 	</header>
        	<nav>
           	 	<ul>
                    <li> <a href="menu.php"> Accueil </a></li>
                	<li> <a href="actionA/chooseTable.php"> Contenu </a></li>
                	<li> <a href="actionB/displayTable.php"> Liste ordres </a></li>
                	<li> <a href="actionC/addResult.php"> Ajouter un résultat </a></li>
                    <li> <a href="actionD/participation.php"> Participation </a></li>
                    <li> <a href="actionE/memberByResults.php"> Résultats </a></li>
            	</ul>
    		</nav>


            <div id="bienvenue">
                <p>
                Bienvenue dans la base de donnée de Fédération équestre !
                </p>
            </div>


        </main>
    </body>
</html>
