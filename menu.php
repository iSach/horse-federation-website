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
        			<a href="deconnexion.php"> Déconnexion </a>
        		</div>
        		<a href="menu.php"> <p style="text-align: center"><img src="Images/UliegeLogo.png" width="25%"></p> </a>

       	 	</header>
        	<nav>
           	 	<ul>
                	<li> <a href="chooseTable.php"> Contenu </a></li>
                	<li> <a href="addTable.php"> Ajouter </a></li>
                	<li> <a href="displayTable.php"> Afficher </a></li>
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
