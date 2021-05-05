<?php
//on démarre la connexion
session_start();

// Retirer les variables de session si on s'est déconnecté
if(isset($_POST['disconnect']))
{
  session_unset();
}

include 'credentials.php';

$bdd = new PDO('mysql:host=localhost;dbname=group4', $login, $pass);
if($bdd == NULL)
  echo "Problème de connexion";

if(isset($_POST["login"]))
{
      $query = "SELECT * FROM users WHERE Login = '" . str_replace("'", "\'", $_POST["login"]) . "' AND Pass = '" . str_replace("'", "\'", $_POST["password"]) . "' ";
      $req = $bdd->query($query);
      $tuple      = $req->fetch();
      /*si $tuple n'est pas vide c'est qu'on a trouvé un tuple avec le nom d'Utilisateur
          et le mot de passe donc ce que l'utilisateur a rentré est correct*/
      if($tuple)
      {
         $_SESSION['login'] = $tuple["Login"];
         header('Location: menu.php');
      }
      /*si $tuple est null c'est qu'on a pas trouvé de tuple contenant le nom d'Utilisateur
          et le mot de passe que l'utilisateur a entré donc il y a une faute*/
      else
      {
         header('Location: index.php?erreur=1');
      }
}
/* Ici l'utilisateur n'a pas renseigné un des champs nom d'utilisateur ou mot de passe*/
else
{
   header('Location: index.php');
}
//on arrête la connexion
die();
?>
