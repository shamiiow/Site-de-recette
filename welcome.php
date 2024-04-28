<?php
echo "<a href='index.php'><h1>INDEX</h1></a><br>";
session_start();
require_once 'config.php';

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header('Location: login.php');
    exit;
}

$idUtilisateur = $_SESSION['idUtilisateur'];
$pseudo = $_SESSION['pseudo'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Bienvenue</title>
</head>
<body>
    <h2>Bienvenue, <?php echo $pseudo; ?>!</h2>
    <p>C'est une page protégée. Seulement accessible aux utilisateurs connectés.</p>
    <p><a href="logout.php">Déconnexion</a></p>
</body>
</html>
