<?php
session_start();
require_once 'config.php'; // Inclure le fichier de configuration de la base de données

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si le formulaire d'inscription a été soumis

    if(isset($_POST['pseudo']) && isset($_POST['mdp'])) {
        // Récupérer les données du formulaire
        $pseudo = $_POST['pseudo'];
        $mdp = $_POST['mdp'];

        // Vérifier si l'utilisateur existe déjà dans la base de données
        $query = "SELECT * FROM Utilisateur WHERE pseudo = :pseudo";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':pseudo', $pseudo);
        $stmt->execute();
        $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$existingUser) {
            // Ajouter l'utilisateur à la base de données
            $query = "INSERT INTO Utilisateur (pseudo, mdp) VALUES (:pseudo, :mdp)";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':pseudo', $pseudo);
            $stmt->bindParam(':mdp', $mdp);
            $stmt->execute();

            echo "<div class='main'>Inscription réussie. Vous pouvez maintenant vous connecter.</div>";
        } else {
            echo "Ce nom d'utilisateur est déjà pris. Veuillez en choisir un autre.";
        }
    } else {
        // Rediriger l'utilisateur si les données du formulaire ne sont pas définies
        header('Location: login.php'); // Remplacez 'formulaire_inscription.php' par le chemin de votre formulaire d'inscription
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inscription</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <?php if(isset($error)) { ?>
        <p><?php echo $error; ?></p>
    <?php } ?>

    <div class="topbar">
            <a href='index.php'><p>INDEX</p></a>
            <a href='register.php'><p>REGISTER</p></a>
            <a href='login.php'><p>LOGIN</p></a>
            <a href='ajoutDB.html'><p>RECETTES</p></a>
            <a href='recherches.php'><p>POSTER</p></a>
        </div>

    <div class="main">
    <h2>Inscription</h2><br>
    <form method="post" action="register.php">
        <label>Nom d'utilisateur:</label>
        <input type="text" name="pseudo"><br><br>
        <label>Mot de passe:</label>
        <input type="password" name="mdp"><br><br>
        <input type="submit" value="S'inscrire" id="end">

    </form>
    </div>

    <div class="bgwrap">
        <img src="registerBG.avif" alt="pizza">
    </div>
</body>
</html>
