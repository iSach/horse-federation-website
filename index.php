<html>
    <head>
       <meta charset="utf-8">
        <!-- Importer le fichier de style -->
        <link rel="stylesheet" href="style.css" media="screen" type="text/css" />
        <title> Connexion </title>
    </head>

    <body>
            <!-- Logo ULièege centré -->
            <div style="text-align: center"><img src="Images/UliegeLogo.png" alt="Logo de UlLiege" id="Logo" width="45%"></div>
            <!-- Structure du formulaire -->
            <form action="verification.php" method="POST">
                <h1>Connexion</h1>

                <label><b>Nom d'utilisateur</b></label>
                <input type="text" placeholder="Entrer le nom d'utilisateur" name="login" required>

                <label><b>Mot de passe</b></label>
                <input type="password" placeholder="Entrer le mot de passe" name="password" required>

                <input type="submit" id='submit' value='LOGIN' >
                <?php
                if(isset($_GET['erreur'])){
                    $err = $_GET['erreur'];
                    if($err==1)
                        echo "<p style='color:red'>Utilisateur ou mot de passe incorrect</p>";
                }
                ?>
            </form>
    </body>
</html>
