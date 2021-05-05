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
        <title>Contenu</title>
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

        <form action="chooseField.php" method="post">

            <h3> Que souhaitez vous consulter ? </h3>
                <select name="nomTable">
                    <option value="Club">Les clubs</option>
                    <option value="Membre">Les membres</option>
                    <option value="Cheval">Les chevaux</option>
                    <option value="ProprieteDe">Les propriétaires des chevaux</option>
                    <option value="Competition">Les compétitions</option>
                    <option value="Obstacle">Les courses d'obstacles</option>
                    <option value="Dressage">Les compétitions de dressage</option>
                    <option value="Ordres">La liste des ordres des compétitions de dressage</option>
                    <option value="InstanceComp">Les compétitions organisées</option>
                    <option value="Participe">Les membres, les chevaux et l'oganisateur d'une compétition</option>
                </select>
                <input type="submit" id='submit' value='Soumettre' >
        </form>

    </body>
</html>
