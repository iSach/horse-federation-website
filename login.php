<html lang="">
    <head>
        <title>Page de connection</title>
    </head>
    <body>
        <?php
        session_start();
        if(isset($_POST['disconnect'])) {
            session_unset();
        }
        /*$bdd = new PDO('mysql:host=localhost;dbname=group4','group4','BN1qyU7Tv/');
        if($bdd == NULL)
            echo "Problème de connection";*/

        if(isset($_POST["login"]) and isset($_POST["pass"])) {
            if ($_POST["login"] == 'group4' and $_POST["pass"] == 'BN1qyU7Tv/') {
                $_SESSION['login'] = $_POST["login"];
                $_SESSION['pass'] = $_POST["pass"];
            } else
                echo "Votre login ou mot de passe est incorrect <BR><BR>";
        }
            if(isset($_SESSION['login'])) {
                echo "<h1>Bienvenue ".$_SESSION['login']."</h1><BR>";
            ?>
            <h3> Quelle action souhaitez vous effectuer ?</h3>
                <!-- Liste des actions possibles -->
                <form method="post" action="">
                <label>
                    <select name="choose_value">
                    <option disabled selected>Veuillez sélectionner une action ...</option>
                    <option value="actionA.php">Sélection et affichage de tuples</option>
                    <option value="actionB.php">Liste des ordres</option>
                    <option value="actionC.php">Ajouter un nouveau résultat</option>
                    <option value="actionD.php">Rechercher un membre</option>
                    <option value="actionE.php">Liste des membres par points</option>
                    </select>
                    <input type="submit" value="Choisir">
                </label>
                </form>
                <?php
                if(isset($_POST["choose_value"])){
                    header("Location: ".$_POST["choose_value"]);
                }
                ?>
            <!--Formulaire pour se deconnecter-->
            <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
            <p>
                <input type="hidden" name="disconnect" value="yes">
                <input type="submit" value="Deconnection"/>
            </p>
            </form>
            <?php } else {?>
                <h1> Veuillez entrer vos identifiants </h1>

                <form method="post" action="login.php">
                    <p>
                        <label>
                            <input type="text" name="login" placeholder="Nom d'utilisateur" required>
                        </label>
                        <label>
                            <input type="password" name="pass" placeholder="Mot de passe" required><br><br>
                        </label>
                        <input type="submit" value="Se connecter"/>
                    </p>
                </form>
            <?php } ?>
    </body>
</html>
