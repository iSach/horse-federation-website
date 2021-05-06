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
        <title>Contraintes</title>
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
                <li> <a href="chooseTable.php"> Contenu </a></li>
                <li> <a href="../actionB/displayTable.php"> Liste ordres </a></li>
                <li> <a href="../actionC/displayTable.php"> Afficher </a></li>
            	</ul>
    	</nav>

        <?php
        if (isset($_POST['nomTable'])){
            $_SESSION['nomTable'] = $_POST['nomTable'];
        }
        else{
        	header("Location: ../menu.php");
        }

        switch($_POST["nomTable"]){
            case "Club":
        ?>
            	<form action="displayTuples.php" method="post">
                	<p><strong>Choisissez les contraintes dans les champs suivants :</strong></p>
                    <label><b>Numéro identifiant</b></label>
                    <input type="number" placeholder="Entrer le numéro identifiant du club (falcutatif)" name="numero">

                    <label><b>Nom</b></label>
                		<input type="text" placeholder="Entrer le nom du club (falcutatif)" name="nom">

                    <label><b>Code Postal</b></label>
                    <input type="number" placeholder="Entrer le code postal du club (falcutatif)" name="code_postal">

                    <label><b>Localité</b></label>
                    <input type="text" placeholder="Entrer la localité du club (falcutatif)" name="localite">

                    <label><b>Rue</b></label>
                    <input type="text" placeholder="Entrer la rue du club (falcutatif)" name="rue">

                    <label><b>Numéro de rue</b></label>
                    <input type="number" placeholder="Entrer le numéro de rue du club (falcutatif)" name="num">

                    <label><b>ID Président</b></label>
                    <input type="number" placeholder="Entrer l'ID du président du club (falcutatif)" name="id_president">
                        <input type="submit" value="Soumettre">
                </form>
		<?php
				break;
            case "Membre":
        ?>
            	<form action="displayTuples.php" method="post">
                	<p><strong>Choisissez les contraintes dans les champs suivants :</strong></p>
                    <label><b>ID</b></label>
                		<input type="number" placeholder="Entrer l'identifiant du membre (falcutatif)" name="id">

                    <label><b>Nom</b></label>
                        <input type="text" placeholder="Entrer le nom du membre (facultatif)" name="nom">

                    <label><b>Prénom</b></label>
                		<input type="text" placeholder="Entrer le prénom du membre (falcutatif)" name="prenom">

                    <label><b>email</b></label>
                        <input type="email" placeholder="Entrer l'email du membre (facultatif)" name="email">

                    <label><b>ID Club</b></label>
                        <input type="number" placeholder="Entrer le numéro identifiant du club associé au membre (falcutatif)" name="id_club">
                        <input type="submit" value="Soumettre">
                </form>
		<?php
				break;
            case "Cheval":
        ?>
            	<form action="displayTuples.php" method="post">
                	<p><strong>Choisissez les contraintes dans les champs suivants :</strong></p>
                    <label><b>Numéro</b></label>
                		<input type="number" placeholder="Entrer le numéro du cheval (falcutatif)" name="numero">

                    <label><b>Nom</b></label>
                        <input type="text" placeholder="Entrer le nom du cheval (facultatif)" name="nom">

                    <label><b>Sexe</b></label>
                    <input type="text" placeholder="Entrer le sexe du cheval (falcutatif)" name="sexe">

                    <label><b>Taille</b></label>
                    <input type="number" placeholder="Entrer la taille du cheval (falcutatif)" name="taille">

                    <label><b>Date de naissance</b></label>
                    <input type="text" placeholder="Entrer la date de naissance du cheval YYYY-MM-JJ (falcutatif)" name="date_naissance">
                        <input type="submit" value="Soumettre">
                </form>
		<?php
				break;
            case "ProprieteDe":
        ?>
            	<form action="displayTuples.php" method="post">
                	<p><strong>Choisissez les contraintes dans les champs suivants :</strong></p>
                    <label><b>ID du membre</b></label>
                		<input type="number" placeholder="Entrer l'ID du membre (falcutatif)" name="id_membre">

                    <label><b>ID du cheval</b></label>
                    <input type="number" placeholder="Entrer l'ID du cheval (facultatif)" name="id_cheval" >
                        <input type="submit" value="Soumettre">
                </form>
		<?php
				break;
            case "Competition":
        ?>
            	<form action="displayTuples.php" method="post">
                	<p><strong>Choisissez les contraintes dans les champs suivants :</strong></p>
                    <label><b>Nom</b></label>
                		<input type="text" placeholder="Entrer le nom de la compétition (falcutatif)" name="nom">

                    <label><b>Libellé</b></label>
                        <input type="text" placeholder="Entrer le libellé de la compétition (facultatif)" name="libelle">
                        <input type="submit" value="Soumettre">
                </form>
		<?php
				break;
            case "Obstacle":
        ?>
            	<form action="displayTuples.php" method="post">
                	<p><strong>Choisissez les contraintes dans les champs suivants :</strong></p>
                    <label><b>Nom</b></label>
                		<input type="text" placeholder="Entrer le nom de la course d'obstacles (falcutatif)" name="nom">

                    <label><b>Nombre de haies</b></label>
                        <input type="number" placeholder="Entrer le nombre de haies de la course d'obstacles (facultatif)" name="nb_haies">
                        <input type="submit" value="Soumettre">
                </form>
		<?php
				break;
            case "Dressage":
        ?>
            	<form action="displayTuples.php" method="post">
                	<p><strong>Choisissez les contraintes dans les champs suivants :</strong></p>
                	<label><b>Nom</b></label>
                		<input type="text" placeholder="Entrer le nom de la compétition de dressage (falcutatif)" name="nom">
                        <input type="submit" value="Soumettre">
                </form>
		<?php
				break;
            case "Ordres":
        ?>
            	<form action="displayTuples.php" method="post">
                	<p><strong>Choisissez les contraintes dans les champs suivants :</strong></p>
                    <label><b>Nom Compétition</b></label>
                		<input type="text" placeholder="Entrer de la compétition de la compétition de dressage (falcutatif)" name="nom_comp">

                    <label><b>Numéro</b></label>
                		<input type="number" placeholder="Entrer le numéro de l'ordre dans la liste d'ordres (falcutatif)" name="numero">

                    <label><b>Ordre</b></label>
                    <input type="text" placeholder="Entrer le nom de l'ordre (falcutatif)" name="ordre">
                        <input type="submit" value="Soumettre">
                </form>
		<?php
				break;
            case "InstanceComp":
        ?>
            	<form action="displayTuples.php" method="post">
                	<p><strong>Choisissez les contraintes dans les champs suivants :</strong></p>
                	<label><b>Nom</b></label>
                		<input type="text" placeholder="Entrer le nom de la compétition réalisée (falcutatif)" name="nom">

                    <label><b>Année</b></label>
                		<input type="number" placeholder="Entrer l'année de la compétition réalisée (falcutatif)" name="annee">

                    <label><b>ID Organisateur</b></label>
                        <input type="number" placeholder="Entrer l'ID du membre organisateur (facultatif)" name="id_organisateur">
                        <input type="submit" value="Soumettre">
                </form>
		<?php
				break;
            case "Participe":
        ?>
            	<form action="displayTuples.php" method="post">
                	<p><strong>Choisissez les contraintes dans les champs suivants :</strong></p>
                    <label><b>ID Membre</b></label>
                		<input type="number" placeholder="Entrer l'ID du membre (falcutatif)" name="id_membre">

					          <label><b>Nom de Compétition</b></label>
                		<input type="text" placeholder="Entrer le nom de la compétition réalisée (falcutatif)" name="nom">

                    <label><b>Année</b></label>
                		<input type="number" placeholder="Entrer l'année de la compétition réalisée (falcutatif)" name="annee">

                    <label><b>ID Cheval</b></label>
                    <input type="number" placeholder="Entrer l'ID du cheval (falcutatif)" name="id_cheval">

                    <label><b>Résultat</b></label>
                		<input type="number" placeholder="Entrer le résultat obtenu (falcutatif)" name="resultat">
                        <input type="submit" value="Soumettre">
                </form>

		<?php
				break;
			default:
				header("Location: ../menu.php");
                break;
        }
        ?>
    </body>
</html>
