<?php
// Gestion formation
if (isset($_GET["page"]) && $_GET["page"] == "formations") {

?>
    <main>
        <h1>Gestion des formations</h1>
        <form method="POST">
            <fieldset>
                <legend>Ajouter des formations</legend>

                <label for="nomFormation">Nom de la formation : </label>
                <input type="text" name="nomFormation" id="nomFormation">

                <label for="dureeFormation">Durée : </label>
                <input type="text" name="dureeFormation" id="dureeFormation">

                <label for="niveauSortieFormation">Niveau de sortie : </label>
                <input type="text" name="niveauSortieFormation" id="niveauSortieFormation">

                <label for="descriptionFormation">Description :</label>
                <input type="text" name="descriptionFormation" id="descriptionFormation">

                <input type="submit" name="submitFormation" value="Ajouter">
            </fieldset>
        </form>

        <article>
            <h2>Formations</h2>

            <form method="POST">
                <fieldset>
                    <legend>Nos formations</legend>
                    <table>
                        <thead>
                            <tr>
                                <th>Nom Formation</th>
                                <th>Durée</th>
                                <th>Diplôme</th>
                                <th>Description</th>
                                <th>Modification</th>
                                <th>Suppression</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Récupérer les données depuis la base de données
                            $sql = "SELECT * FROM `formations`";
                            $requete = $bdd->query($sql);
                            $results = $requete->fetchAll(PDO::FETCH_ASSOC);

                            // Afficher chaque ligne de la table
                            foreach ($results as $value) {
                                // Créer la ligne du tableau pour chaque entrée
                                echo '<tr>';

                                // Input hidden pour stocker l'ID de la formation
                                echo '<input type="hidden" name="hiddenFormation" value="' . $value['id_formation'] . '">';

                                // Affichage du nom de la formation
                                echo '<td>' . $value['nom_formation'] . '</td>';

                                // Affichage diplôme de la formation
                                echo '<td>' . $value['duree_formation'] . '</td>';

                                // Affichage du nom de la formation
                                echo '<td>' . $value['niveau_sortie_formation'] . '</td>';

                                // Affichage description de la formation
                                echo '<td>' . $value['description'] . '</td>';

                                // Bouton Modifier
                                echo '<td><a href="?page=formations&type=modifier&id=' . $value['id_formation'] . '" class="modifier">Modifier</a></td>';

                                // Bouton Supprimer
                                echo '<td><button type="submit" name="deleteFormation" value="' . $value['id_formation'] . '" class="supprimer">Supprimer</button></td>';

                                // Fermeture de la ligne du tableau
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </fieldset>
            </form>

            <?php
            if (isset($_POST['submitFormation'])) {
                $nomFormation = $_POST['nomFormation'];
                $dureeFormation = $_POST['dureeFormation'];
                $niveauSortieFormation = $_POST['niveauSortieFormation'];
                $descriptionFormation = $_POST['descriptionFormation'];

                $sql = "INSERT INTO `formations`(`nom_formation`, `duree_formation`, `niveau_sortie_formation`, `description`) VALUES ('$nomFormation','$dureeFormation',' $niveauSortieFormation','$descriptionFormation')";
                $bdd->query($sql);
                echo "data ajoutée dans la bdd";
            }


            if (isset($_POST['deleteFormation'])) {
                $idFormationDelete = $_POST['deleteFormation'];

                $sql = "DELETE FROM `formations` WHERE `id_formation` = $idFormationDelete";
                if ($bdd->query($sql)) {
                    echo "La formation a été supprimée de la BDD.";
                } else {
                    echo "Erreur lors de la suppression de la formation.";
                }
            }

            if (isset($_GET['type']) && $_GET['type'] == "modifier") {
                $id = $_GET['id'];
                $sqlId = "SELECT * FROM `formations` WHERE `id_formation` = $id";
                $requeteId = $bdd->query($sqlId);
                $resultsId = $requeteId->fetch(PDO::FETCH_ASSOC);

            ?>

                <form method="POST">
                    <input type="hidden" name="updateIdFormation" value="<?php echo $resultsId['id_formation']; ?>">
                    <input type="text" name="updateNomFormation" value="<?php echo $resultsId['nom_formation']; ?>">
                    <input type="text" name="updateDureeFormation" value="<?php echo $resultsId['duree_formation']; ?>">
                    <input type="text" name="updateNiveauSortieFormation" value="<?php echo $resultsId['niveau_sortie_formation']; ?>">
                    <input type="text" name="updateDescriptionFormation" value="<?php echo $resultsId['description']; ?>">
                    <input type="submit" name="updateFormation" value="Modifier">
                </form>

        <?php

                if (isset($_POST['updateFormation'])) {
                    $idFormationUpdate = $_POST['updateIdFormation'];
                    $nomFormationUpdate = $_POST['updateNomFormation'];
                    $dureeFormationUpdate = $_POST['updateDureeFormation'];
                    $niveauSortieFormationUpdate = $_POST['updateNiveauSortieFormation'];
                    $descriptionFormationUpdate = $_POST['updateDescriptionFormation'];

                    $sqlUpdate = "UPDATE `formations` 
                                        SET 
                                            `nom_formation` = '$nomFormationUpdate',
                                            `duree_formation` = '$dureeFormationUpdate',
                                            `niveau_sortie_formation` = '$niveauSortieFormationUpdate',
                                            `description` = '$descriptionFormationUpdate'
                                        WHERE `id_formation` = $idFormationUpdate";

                    if ($bdd->query($sqlUpdate)) {
                        echo "La formation a été mise à jour dans la BDD.";
                    } else {
                        echo "Erreur lors de la mise à jour de la formation.";
                    }
                }
            }
        }
        ?>
        </article>
    </main>