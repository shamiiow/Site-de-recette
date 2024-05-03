<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Liste des recettes</title>
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

<?php
session_start();
require_once 'config.php';

$chemin_fichier = "config.txt";
$lignes = file($chemin_fichier, FILE_IGNORE_NEW_LINES);

$server_name = "";
$login = "";
$password = "";
$nom_db = "";

foreach ($lignes as $ligne) {
    list($cle, $valeur) = explode(" : ", $ligne);
    switch ($cle) {
        case 'server_name':
            $server_name = trim($valeur);
            break;
        case 'login':
            $login = trim($valeur);
            break;
        case 'password':
            $password = trim($valeur);
            break;
        case 'nom_db':
            $nom_db = trim($valeur);
            break;
        default:
            break;
    }
}

$conn = new mysqli($server_name, $login, $password, $nom_db);
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

// Nombre de recettes par page
$recettesParPage = 10;

// Récupérer le numéro de la page à afficher
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $pageCourante = $_GET['page'];
} else {
    $pageCourante = 1;
}

// Calculer l'indice de départ
$indiceDepart = ($pageCourante - 1) * $recettesParPage;

echo '<div class="main">';

// Requête SQL pour récupérer les recettes avec pagination
$sql = "SELECT idRecette, nbpersonne FROM Recette LIMIT $indiceDepart, $recettesParPage";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>Liste des recettes :</h2>";
    echo "<div class = 'liste_recette'>";
    while ($row = $result->fetch_assoc()) {
        echo "<a href='recette.php?id=" . $row["idRecette"] . "'>Recette " . $row["idRecette"] . "</a><br>";
    }


    // Afficher les liens de pagination
    $sqlTotalRecettes = "SELECT COUNT(*) AS totalRecettes FROM Recette";
    $resultTotalRecettes = $conn->query($sqlTotalRecettes);
    $rowTotalRecettes = $resultTotalRecettes->fetch_assoc();
    $totalRecettes = $rowTotalRecettes['totalRecettes'];
    $totalPages = ceil($totalRecettes / $recettesParPage);

    
    for ($i = 1; $i <= $totalPages; $i++) {
        echo "<a href='index.php?page=$i'>$i</a> ";
    }
    
} else {
    echo "<h2>Aucune recette trouvée.</h2>";
}
echo "</div>";

echo '</div>';



$conn->close();
?>
<div class="bgwrap">
        <img src="registerBG.avif" alt="pizza">
    </div>

</body>
</html>
