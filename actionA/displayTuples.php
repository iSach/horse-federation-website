<?php
    session_start();
    header('Content-Type: text/html; charset=utf-8');

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
        <title>Affichage des tuples</title>
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
                <li> <a href="chooseTable.php"> Contenu </a></li>
                <li> <a href="../actionB/displayTable.php"> Liste ordres </a></li>
                <li> <a href="../actionC/displayTable.php"> Afficher </a></li>
                <li> <a href="../actionD/participation.php"> Participations </a></li>
                <li> <a href="../actionE/memberByResults.php"> Résultats </a></li>
            </ul>
    	</nav>

        <?php
        try{
            $bdd = new PDO('mysql:host=localhost;dbname=group4;charset=utf8', $login, $pass);
            $bdd->exec('set names utf8');
        }catch (Exception $e){
            die('Erreur: '.$e->getMessage());
        }

        if(!isset($_SESSION['nomTable'])){
        	header("Location: ../menu.php");
        }

        switch ($_SESSION['nomTable']) {
        	case 'Club':
        		if(!isset($_POST['numero']) OR !isset($_POST['nom']) OR !isset($_POST['code_postal']) OR !isset($_POST['localite']) OR !isset($_POST['rue']) OR !isset($_POST['num']) OR !isset($_POST['id_president'])){
        			header("Location: ../menu.php");
        		}

        		 $_POST['numero'] = str_replace("'" , "\'" ,  $_POST['numero']);
        		 $_POST['nom'] = str_replace("'" , "\'" ,  $_POST['nom']);
             $_POST['code_postal'] = str_replace("'" , "\'" ,  $_POST['code_postal']);
             $_POST['localite'] = str_replace("'" , "\'" ,  $_POST['localite']);
             $_POST['rue'] = str_replace("'" , "\'" ,  $_POST['rue']);
             $_POST['num'] = str_replace("'" , "\'" ,  $_POST['num']);
             $_POST['id_president'] = str_replace("'" , "\'" ,  $_POST['id_president']);

             $query = 'SELECT * FROM Club WHERE LOWER(nom) LIKE LOWER(:nom) AND LOWER(rue) LIKE LOWER(:rue) AND LOWER(localite) LIKE LOWER(:localite)' ;
         		 $variable = array(':nom' => '%' . $_POST['nom'] .'%', ':rue' => '%' . $_POST['rue'] . '%', ':localite' => '%' . $_POST['localite'] . '%');

         	   if($_POST['numero'] != ''){
         		   $query .= "AND numero = :numero ";
         		   $variable[':numero'] = $_POST['numero'];
         		 }
         		 if($_POST['code_postal'] != ''){
         			 $query .= "AND code_postal = :code_postal ";
         			 $variable[':code_postal'] = $_POST['code_postal'];
         		 }
         		 if($_POST['num'] != ''){
         			 $query .= "AND num = :num";
         			 $variable[':num'] = $_POST['num'];
         		 }
             if($_POST['id_president'] != ''){
         			 $query .= "AND id_president = :id_president";
         			 $variable[':id_president'] = $_POST['id_president'];
         		 }

         		 $req = $bdd ->prepare($query);
 				$req->execute($variable);
 				if($req->rowCount() == 0){
      				echo '<div id="ajout"><p style=\'color:red\'>Désolé, aucun tuple ne correspond à vos contraintes. <br/> Veuillez réessayer</p></div>';
      				break;
      			}

        ?>
      			<h2 style="text-align: center">Tuples des clubs : </h2>
             	<table>
             		<thead>
             			<tr>
             				<th width=15%>Numéro du club</th>
             				<th>Nom</th>
             				<th>Code postal</th>
             				<th>Localité</th>
                    <th>Rue</th>
                    <th>Numéro de rue</th>
             				<th>ID du président</th>
             			</tr>
             		</thead>
             		<tbody>
             			<?php
             				while($data = $req->fetch()){
                 				echo '<tr> <td> '.$data['numero'].'</td><td>'.$data['nom'].'</td><td>'.$data['code_postal'].'</td><td>'.$data['localite'].'</td><td>'.$data['rue'].'</td><td>'.$data['num'].'</td><td>'.$data['id_president'].'</td> </tr> ';
             				}
             			?>
             		</tbody>
             	</table>
        <?php
        		break;
        	case 'Membre':
        		if(!isset($_POST['id']) OR !isset($_POST['nom']) OR !isset($_POST['prenom']) OR !isset($_POST['email']) OR !isset($_POST['id_club'])){
        			header("Location: ../menu.php");
        		}

        		$_POST['id'] = str_replace("'" , "\'" ,  $_POST['id']);
        		$_POST['nom'] = str_replace("'" , "\'" ,  $_POST['nom']);
        		$_POST['prenom'] = str_replace("'" , "\'" ,  $_POST['prenom']);
        		$_POST['email'] = str_replace("'" , "\'" ,  $_POST['email']);
        		$_POST['id_club'] = str_replace("'" , "\'" ,  $_POST['id_club']);

        		$query = 'SELECT * FROM Membre WHERE LOWER(nom) LIKE LOWER(:nom) AND LOWER(prenom) LIKE LOWER(:prenom) AND LOWER(email) LIKE LOWER(:email) ' ;
        		$variable = array(':nom' => '%' . $_POST['nom'] .'%', ':prenom' => '%' . $_POST['prenom'] . '%', ':email' => '%' . $_POST['email'] . '%');

        		if($_POST['id'] != ''){
        			$query .= "AND id = :id ";
        			$variable[':id'] = $_POST['id'];
        		}
        		if($_POST['id_club'] != ''){
        			$query .= "AND id_club = :id_club ";
        			$variable[':id_club'] = $_POST['id_club'];
        		}

        		$req = $bdd ->prepare($query);
				$req->execute($variable);
				if($req->rowCount() == 0){
     				echo '<div id="ajout"><p style=\'color:red\'>Désolé, aucun tuple ne correspond à vos contraintes. <br/> Veuillez réessayer</p></div>';
     				break;
     			}

       ?>
     			<h2 style="text-align: center">Tuples des membres : </h2>
            	<table>
            		<thead>
            			<tr>
            				<th width=15%>ID du membre</th>
            				<th>Nom du membre</th>
            				<th>Prénom du membre</th>
            				<th>Email du membre</th>
            				<th>ID du club</th>
            			</tr>
            		</thead>
            		<tbody>
            			<?php
            				while($data = $req->fetch()){
                				echo '<tr> <td> '.$data['id'].'</td><td>'.$data['nom'].'</td><td>'.$data['prenom'].'</td><td>'.$data['email'].'</td><td>'.$data['id_club'].'</td> </tr> ';
            				}
            			?>
            		</tbody>
            	</table>
        <?php
        		break;
        	case 'Cheval':
        		if(!isset($_POST['numero']) OR !isset($_POST['nom']) OR !isset($_POST['sexe']) OR !isset($_POST['taille']) OR !isset($_POST['date_naissance'])){
        		    header("Location: ../menu.php");
        		}

        		$_POST['numero'] = str_replace("'" , "\'" ,  $_POST['numero']);
                $_POST['nom'] = str_replace("'" , "\'" ,  $_POST['nom']);
                $_POST['sexe'] = str_replace("'" , "\'" ,  $_POST['sexe']);
        		$_POST['taille'] = str_replace("'" , "\'" ,  $_POST['taille']);
                $_POST['date_naissance'] = str_replace("'" , "\'" ,  $_POST['date_naissance']);

                $query = 'SELECT * FROM Cheval WHERE LOWER(nom) LIKE LOWER(:nom) ' ;
        		$variable = array(':nom' => '%' . $_POST['nom'] .'%');

        		if($_POST['numero'] != ''){
        			$query .= "AND numero = :numero ";
        			$variable[':numero'] = $_POST['numero'];
        		}
        		if($_POST['taille'] != ''){
        			$query .= "AND taille = :taille ";
        			$variable[':taille'] = $_POST['taille'];
        		}
        		if($_POST['date_naissance'] != ''){
        			$query .= "AND date_naissance = :date_naissance";
        			$variable[':date_naissance'] = $_POST['date_naissance'];
        		}

        		$req = $bdd ->prepare($query);
				$req->execute($variable);
				if($req->rowCount() == 0){
     				echo '<div id="ajout"><p style=\'color:red\'>Désolé, aucun tuple ne correspond à vos contraintes. <br/> Veuillez réessayer</p></div>';
     				break;
     			}

       ?>
     			<h2 style="text-align: center">Tuples des chevaux : </h2>
            	<table>
            		<thead>
            			<tr>
            				<th width=15%>Numéro du cheval</th>
            				<th>Nom du cheval</th>
            				<th>Sexe du cheval</th>
            				<th>Taille du cheval</th>
            				<th>Date de naissance du cheval</th>
            			</tr>
            		</thead>
            		<tbody>
            			<?php
            				while($data = $req->fetch()){
                				echo '<tr> <td> '.$data['numero'].'</td><td>'.$data['nom'].'</td><td>'.$data['sexe'].'</td><td>'.$data['taille'].'</td><td>'.$data['date_naissance'].'</td> </tr> ';
            				}
            			?>
            		</tbody>
            	</table>
        <?php
        		break;
          case 'ProprieteDe':
            if(!isset($_POST['id_membre']) OR !isset($_POST['id_cheval'])){
              header("Location: ../menu.php");
            }

            $_POST['id_membre'] = str_replace("'" , "\'" ,  $_POST['id_membre']);
            $_POST['id_cheval'] = str_replace("'" , "\'" ,  $_POST['id_cheval']);

            $query = 'SELECT * FROM ProprieteDe ' ;
            $variable = array();

            if($_POST['id_membre'] != ''){
        			$query .= "WHERE numero_membre = :numero_membre ";
        			$variable[':numero_membre'] = $_POST['id_membre'];
        		}
        		if($_POST['id_cheval'] != ''){
        			if($_POST['id_membre'] != ''){
        				$query .= "AND numero_cheval = :numero_cheval ";
                $variable[':numero_cheval'] = $_POST['id_cheval'];
              }
        			else{
        				$query .= "WHERE numero_cheval = :numero_cheval ";
        			  $variable[':numero_cheval'] = $_POST['id_cheval'];
              }
        		}

            $req = $bdd ->prepare($query);
          $req->execute($variable);
          if($req->rowCount() == 0){
            echo '<div id="ajout"><p style=\'color:red\'>Désolé, aucun tuple ne correspond à vos contraintes. <br/> Veuillez réessayer</p></div>';
            break;
          }

          ?>

          <h2 style="text-align: center">Tuples des propriétaires de chevaux : </h2>
              <table>
                <thead>
                  <tr>
                    <th>ID du membre</th>
                    <th>ID du cheval </th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    while($data = $req->fetch()){
                        echo '<tr> <td> '.$data['numero_membre'].'</td><td>'.$data['numero_cheval'].'</td> </tr> ';
                    }
                  ?>
                </tbody>
              </table>
        <?php
        		break;
        	case 'Competition':
        		if(!isset($_POST['nom']) OR !isset($_POST['libelle'])){
        			header("Location: ../menu.php");
        		}

        		$_POST['nom'] = str_replace("'" , "\'" ,  $_POST['nom']);
        		$_POST['libelle'] = str_replace("'" , "\'" ,  $_POST['libelle']);

        	    $query = 'SELECT * FROM Competition WHERE LOWER(nom) LIKE LOWER(:nom) AND LOWER(libelle) LIKE LOWER(:libelle) ' ;
        		$variable = array(':nom' => '%' . $_POST['nom'] . '%', ':libelle' => '%' . $_POST['libelle'] .'%');

        		$req = $bdd ->prepare($query);
				$req->execute($variable);
				if($req->rowCount() == 0){
     				echo '<div id="ajout"><p style=\'color:red\'>Désolé, aucun tuple ne correspond à vos contraintes. <br/> Veuillez réessayer</p></div>';
     				break;
     			}

       ?>


     			<h2 style="text-align: center">Tuples des compétitions : </h2>
            	<table>
            		<thead>
            			<tr>
            				<th width=25%>Nom de la compétition</th>
            				<th>Libellé de la compétition</th>
            			</tr>
            		</thead>
            		<tbody>
            			<?php
            				while($data = $req->fetch()){
                				echo '<tr> <td> '.$data['nom'].'</td><td>'.$data['libelle'].'</td> </tr> ';
            				}
            			?>
            		</tbody>
            	</table>
        <?php
        		break;
        	case 'Obstacle':
        		if(!isset($_POST['nom']) OR !isset($_POST['nb_haies'])){
        			header("Location: ../menu.php");
        		}

        		$_POST['nom'] = str_replace("'" , "\'" ,  $_POST['nom']);
        		$_POST['nb_haies'] = str_replace("'" , "\'" ,  $_POST['nb_haies']);

        		$query = 'SELECT * FROM Obstacles WHERE LOWER(nom) LIKE LOWER(:nom) ' ;
        		$variable = array(':nom' => '%' . $_POST['nom'] . '%');

        		if($_POST['nb_haies'] != ''){
        			$query .= "AND nb_haies = :nb_haies";
        			$variable[':nb_haies'] = $_POST['nb_haies'];
        		}

        		$req = $bdd ->prepare($query);
				$req->execute($variable);
				if($req->rowCount() == 0){
     				echo '<div id="ajout"><p style=\'color:red\'>Désolé, aucun tuple ne correspond à vos contraintes. <br/> Veuillez réessayer</p></div>';
     				break;
     			}

       ?>

     			<h2 style="text-align: center">Tuples des utilisateurs demandés </h2>
            	<table>
            		<thead>
            			<tr>
            				<th width=25%>Nom de la course d'obstacles</th>
            				<th>Nombre de haies de la course</th>
            			</tr>
            		</thead>
            		<tbody>
            			<?php
            				while($data = $req->fetch()){
                				echo '<tr> <td> '.$data['nom'].'</td><td>'.$data['nb_haies'].'</td> </tr> ';
            				}
            			?>
            		</tbody>
            	</table>
        <?php
        		break;
          case 'Dressage':
        		if(!isset($_POST['nom'])){
        			header("Location: ../menu.php");
        		}

        		$_POST['nom'] = str_replace("'" , "\'" ,  $_POST['nom']);

        		$query = 'SELECT * FROM Dressage WHERE LOWER(nom) LIKE LOWER(:nom) ' ;
        		$variable = array(':nom' => '%' . $_POST['nom'] . '%');

        		$req = $bdd ->prepare($query);
				$req->execute($variable);
				if($req->rowCount() == 0){
     				echo '<div id="ajout"><p style=\'color:red\'>Désolé, aucun tuple ne correspond à vos contraintes. <br/> Veuillez réessayer</p></div>';
     				break;
     			}

       ?>

     			<h2 style="text-align: center">Tuples des utilisateurs demandés </h2>
            	<table>
            		<thead>
            			<tr>
            				<th width=25%>Nom de la compétition de dressage</th>
            			</tr>
            		</thead>
            		<tbody>
            			<?php
            				while($data = $req->fetch()){
                				echo '<tr> <td> '.$data['nom'].'</td> </tr> ';
            				}
            			?>
            		</tbody>
            	</table>
        <?php
        		break;
        	case 'Ordres':
        		if(!isset($_POST['nom_comp']) OR !isset($_POST['numero']) OR !isset($_POST['ordre'])){
        			header("Location: ../menu.php");
        		}

        		$_POST['nom_comp'] = str_replace("'" , "\'" ,  $_POST['nom_comp']);
        		$_POST['numero'] = str_replace("'" , "\'" ,  $_POST['numero']);
            $_POST['ordre'] = str_replace("'" , "\'" ,  $_POST['ordre']);

            $query = 'SELECT * FROM Ordres WHERE LOWER(nom) LIKE LOWER(:nom) AND LOWER(ordre) LIKE LOWER(:ordre)';
				    $variable = array(':nom' => '%' . $_POST['nom_comp'] .'%', ':ordre' => '%' . $_POST['ordre'] . '%');

            if($_POST['numero'] != ''){
              $query .= "AND numero = :numero";
              $variable[':numero'] = $_POST['numero'];
            }

            $req = $bdd ->prepare($query);
				$req->execute($variable);

				if($req->rowCount() == 0){
     				echo '<div id="ajout"><p style=\'color:red\'>Désolé, aucun tuple ne correspond à vos contraintes. <br/> Veuillez réessayer</p></div>';
     				break;
     			}

        ?>

     			<h2 style="text-align: center">Tuples des ordres : </h2>
            	<table>
            		<thead>
            			<tr>
            				<th width=50%>Nom de la compétition de dressage</th>
            				<th>Numéro de l'ordre dans la liste</th>
                    <th>Nom de l'ordre</th>
            			</tr>
            		</thead>
            		<tbody>
            			<?php
            				while($data = $req->fetch()){
                				echo '<tr> <td> '.$data['nom'].'</td><td>'.$data['numero'].'</td><td>'.$data['ordre'].'</td> </tr> ';
            				}
            			?>
            		</tbody>
            	</table>
        <?php
        		break;
        	case 'InstanceComp':
        		if(!isset($_POST['nom']) OR !isset($_POST['annee']) OR !isset($_POST['id_organisateur'])){
        			header("Location: ../menu.php");
        		}

        		$_POST['nom'] = str_replace("'" , "\'" ,  $_POST['nom']);
        		$_POST['annee'] = str_replace("'" , "\'" ,  $_POST['annee']);
        		$_POST['id_organisateur'] = str_replace("'" , "\'" ,  $_POST['id_organisateur']);

        		$query = 'SELECT * FROM InstanceComp WHERE LOWER(nom) LIKE LOWER(:nom) ' ;
        		$variable = array(':nom' => '%' . $_POST['nom'] . '%');

        		if($_POST['annee'] != ''){
        			$query .= "AND annee = :annee ";
        			$variable[':annee'] = $_POST['annee'];
        		}
        		if($_POST['id_organisateur'] != ''){
        			$query .= "AND id_organisateur = :id_organisateur ";
        			$variable[':id_organisateur'] = $_POST['id_organisateur'];
        		}

        		$req = $bdd ->prepare($query);
				$req->execute($variable);
				if($req->rowCount() == 0){
     				echo '<div id="ajout"><p style=\'color:red\'>Désolé, aucun tuple ne correspond à vos contraintes. <br/> Veuillez réessayer</p></div>';
     				break;
     			}

       ?>

     			<h2 style="text-align: center">Tuples des instances de compétition </h2>
            	<table>
            		<thead>
            			<tr>
            				<th width=33%>Nom de la compétition organisée</th>
            				<th>Année de la compétition organisée</th>
            				<th>ID du membre organisateur</th>
            			</tr>
            		</thead>
            		<tbody>
            			<?php
            				while($data = $req->fetch()){
                				echo '<tr> <td> '.$data['nom'].'</td><td>'.$data['annee'].'</td><td>'.$data['id_organisateur'].'</td> </tr> ';
            				}
            			?>
            		</tbody>
            	</table>
        <?php
        		break;
        	case 'Participe':
        		if(!isset($_POST['id_membre']) OR !isset($_POST['nom']) OR !isset($_POST['annee'])  OR !isset($_POST['id_cheval']) OR !isset($_POST['resultat'])){
        			header("Location: ../menu.php");
        		}

            $_POST['id_membre'] = str_replace("'" , "\'" ,  $_POST['id_membre']);
        		$_POST['nom'] = str_replace("'" , "\'" ,  $_POST['nom']);
        		$_POST['annee'] = str_replace("'" , "\'" ,  $_POST['annee']);
        		$_POST['id_cheval'] = str_replace("'" , "\'" ,  $_POST['id_cheval']);
            $_POST['resultat'] = str_replace("'" , "\'" ,  $_POST['resultat']);

        		$query = 'SELECT * FROM Participe WHERE LOWER(nom) LIKE LOWER(:nom) ' ;
        		$variable = array(':nom' => '%' . $_POST['nom'] . '%');

        		if($_POST['id_membre'] != ''){
        			$query .= "AND numero_membre = :numero_membre ";
        			$variable[':numero_membre'] = $_POST['id_membre'];
        		}
        		if($_POST['annee'] != ''){
        			$query .= "AND annee = :annee ";
        			$variable[':annee'] = $_POST['annee'];
        		}
        		if($_POST['id_cheval'] != ''){
        			$query .= "AND numero_cheval = :numero_cheval";
        			$variable[':numero_cheval'] = $_POST['id_cheval'];
        		}
            if($_POST['resultat'] != ''){
        			$query .= "AND resultat = :resultat";
        			$variable[':resultat'] = $_POST['resultat'];
        		}

        		$req = $bdd ->prepare($query);
				$req->execute($variable);
				if($req->rowCount() == 0){
     				echo '<div id="ajout"><p style=\'color:red\'>Désolé, aucun tuple ne correspond à vos contraintes. <br/> Veuillez réessayer</p></div>';
     				break;
     			}

       ?>

     			<h2 style="text-align: center">Tuples des participants à une compétition <h2>
            	<table>
            		<thead>
            			<tr>
            				<th width=25%>Numéro du membre participant à la compétition</th>
            				<th>Nom de la compétition</th>
            				<th>Année de la compétition réalisée</th>
            				<th>ID du cheval utilisé</th>
                    <th>Résultat du duo cheval-membre à la compétition</th>
            			</tr>
            		</thead>
            		<tbody>
            			<?php
            				while($data = $req->fetch()){
                				echo '<tr> <td> '.$data['numero_membre'].'</td><td>'.$data['nom'].'</td><td>'.$data['annee'].'</td><td>'.$data['numero_cheval'].'</td><td>'.$data['resultat'].'</td> </tr> ';
            				}
            			?>
            		</tbody>
            	</table>

        <?php
        		break;
        	default:
            	header("Location: ../menu.php");
                break;
        }
        ?>
    </body>
</html>
