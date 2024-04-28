<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sélectionnez des tags</title>
</head>
<body>
    <h1>Sélectionnez des tags</h1>
    <form action="recherche.php" method="get">
        <label for="tags">Sélectionnez un ou plusieurs tags :</label><br>
        <select name="tags[]" id="tags" multiple>
            <?php

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

            // Récupérer les tags depuis la base de données et afficher les options
            // Assurez-vous que votre connexion à la base de données est déjà établie ici
            $sql = "SELECT idTag, libelle FROM Tag";
            $result = $conn->query($sql);

            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['idTag'] . "'>" . $row['libelle'] . "</option>";
            }
            ?>
        </select>
        <button type="submit">Rechercher</button>
    </form>
</body>
</html>



</body>
</html>
