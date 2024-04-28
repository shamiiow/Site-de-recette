<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Récupération des éléments d'une table</title>
    </head>
    <body>
        <a href='index.php'><h1>INDEX</h1></a><br>
        <a href='ajoutDB.html'>ajoutDB</a><br>
        <a href='login.php'>login</a><br>
        <a href='register.html'>register</a><br>
        <a href='recherches.php'>recherche</a><br>


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

            $sql = "SELECT idRecette, nbpersonne FROM Recette";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<h1>Liste des recettes :</h1>";
                echo "<ul>";
                while ($row = $result->fetch_assoc()) {
                    echo "<li><a href='recette.php?id=" . $row["idRecette"] . "'>Recette " . $row["idRecette"] . "</a></li>";
                }
                echo "</ul>";
            } else {
                echo "Aucune recette trouvée.";
            }
            $conn->close();
        ?>
    </body>
</html>