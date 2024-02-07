<?php
// Gestion centres
if (isset($_GET["page"]) && $_GET["page"] == "centres") {
    ?>
    <main>
        <h1>Gestion des centres</h1>
        <form method="POST">
            <fieldset>
                <legend>Ajouter des centres</legend>

                <label for="villeCentre">Nom de la ville : </label>
                <input type="text" name="villeCentre" id="villeCentre">

                <label for="adresseCentre">Adresse : </label>
                <input type="text" name="adresseCentre" id="adresseCentre">

                <label for="cpCentre">Code postal : </label>
                <input type="number" name="cpCentre" id="cpCentre">

                <input type="submit" name="submitCentre" value="Ajouter">
            </fieldset>
        </form>

        <article>
            <h2>Centres</h2>

            <form method="POST">
                <fieldset>
                    <legend>Nos centres</legend>
                    <table>
                        <thead>
                        <tr>
                            <th>Ville</th>
                            <th>Adresse</th>
                            <th>Code Postal</th>
                            <th>Modification</th>
                            <th>Suppression</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        // Récupérer les données depuis la base de données
                        $sql = "SELECT * FROM `centres`";
                        $requete = $bdd->prepare($sql);
                        $requete->execute();
                        $results = $requete->fetchAll(PDO::FETCH_ASSOC);

                        // Afficher chaque ligne de la table
                        foreach ($results as $value) {
                            // Créer la ligne du tableau pour chaque entrée
                            echo '<tr>';

                            // Affichage de la ville (échappement des données)
                            echo '<td>' . htmlspecialchars($value['ville_centre']) . '</td>';

                            // Affichage de l'adresse (échappement des données)
                            echo '<td>' . htmlspecialchars($value['adresse_centre']) . '</td>';

                            // Affichage du code postal
                            echo '<td>' . htmlspecialchars($value['code_postal_centre']) . '</td>';

                            // Bouton Modifier
                            echo '<td><a href="?page=centres&type=modifier&id=' . $value['id_centre'] . '" class="modifier">Modifier</a></td>';

                            // Bouton Supprimer
                            echo '<td><button type="submit" name="deleteCentre" value="' . $value['id_centre'] . '" class="supprimer">Supprimer</button></td>';

                            // Fermeture de la ligne du tableau
                            echo '</tr>';
                        }
                        ?>
                        </tbody>
                    </table>
                </fieldset>
            </form>

            <?php
            if (isset($_POST['submitCentre'])) {
                // Utilisation de la requête préparée pour l'insertion
                $villeCentre = $_POST['villeCentre'];
                $adresseCentre = $_POST['adresseCentre'];
                $cpCentre = $_POST['cpCentre'];

                $sql = "INSERT INTO `centres`(`ville_centre`, `adresse_centre`, `code_postal_centre`) 
                            VALUES (?, ?, ?)";
                $requete = $bdd->prepare($sql);
                $requete->execute([$villeCentre, $adresseCentre, $cpCentre]);

                echo "data ajoutée dans la bdd";
            }

            if (isset($_POST['deleteCentre'])) {
                // Utilisation de la requête préparée pour la suppression
                $idCentreDelete = $_POST['deleteCentre'];

                $sql = "DELETE FROM `centres` WHERE `id_centre` = ?";
                $requete = $bdd->prepare($sql);
                if ($requete->execute([$idCentreDelete])) {
                    echo "Le centre a été supprimé dans la BDD.";
                } else {
                    echo "Erreur lors de la suppression du centre.";
                }
            }

            if (isset($_GET['type']) && $_GET['type'] == "modifier") {
                $id = $_GET['id'];
                $sqlId = "SELECT * FROM `centres` WHERE id_centre = ?";
                $requeteId = $bdd->prepare($sqlId);
                $requeteId->execute([$id]);
                $resultsId = $requeteId->fetch(PDO::FETCH_ASSOC);

                ?>
                <form method="POST">
                    <input type="hidden" name="updateIdCentre" value="<?php echo $resultsId['id_centre']; ?>">
                    <input type="text" name="updateVilleCentre" value="<?php echo htmlspecialchars($resultsId['ville_centre']); ?>">
                    <input type="text" name="updateAdresseCentre" value="<?php echo htmlspecialchars($resultsId['adresse_centre']); ?>">
                    <input type="text" name="updateCodePostalCentre" value="<?php echo htmlspecialchars($resultsId['code_postal_centre']); ?>">
                    <input type="submit" name="updateCentre" value="Modifier">
                </form>

                <?php

                if (isset($_POST['updateCentre'])) {
                    // Utilisation de la requête préparée pour la mise à jour
                    $idCentreUpdate = $_POST['updateIdCentre'];
                    $villeCentreUpdate = $_POST['updateVilleCentre'];
                    $adresseCentreUpdate = $_POST['updateAdresseCentre'];
                    $codePostalCentreUpdate = $_POST['updateCodePostalCentre'];

                    $sqlUpdate = "UPDATE `centres` 
                                SET 
                                    `ville_centre` = ?,
                                    `adresse_centre` = ?,
                                    `code_postal_centre` = ?
                                WHERE `id_centre` = ?";
                    $requeteUpdate = $bdd->prepare($sqlUpdate);
                    if ($requeteUpdate->execute([$villeCentreUpdate, $adresseCentreUpdate, $codePostalCentreUpdate, $idCentreUpdate])) {
                        echo "Le centre a été mis à jour dans la BDD.";
                    } else {
                        echo "Erreur lors de la mise à jour du centre.";
                    }
                }
            }
            ?>
        </article>
    </main>
<?php
}
?>
