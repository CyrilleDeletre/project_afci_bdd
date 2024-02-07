<?php
// Gestion affectation
if (isset($_GET["page"]) && $_GET["page"] == "affectations") {
?>
    <main>
        <h1>Gestion des affectations</h1>
        <form method="POST">
            <fieldset>
                <legend>Affectez des membres de l'équipe pédagogique à des centres</legend>

                <label for="idPedago">Séléctionnez un membre de l'équipe pédagogique</label>
                <select name="idAssociationPedago" id="idPedago">
                    <option value="" hidden>Membre</option>
                    <?php

                    $sql = "SELECT `id_pedagogie`, pedagogie.id_role, CONCAT(`nom_role`, ' - ', `nom_pedagogie`, ' ', `prenom_pedagogie`) AS `pedago`
                                        FROM `pedagogie`
                                        INNER JOIN `role`
                                        ON pedagogie.id_role = role.id_role";
                    $requete = $bdd->query($sql);
                    $results = $requete->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($results as $value) {
                        echo '<option value="' . $value['id_pedagogie'] . '">' . $value['pedago'] . '</option>';
                    }
                    ?>
                </select>

                <label for="idCentre">Séléctionnez un centre</label>
                <select name="idAssociationCentre" id="idCentre">
                    <option value="" hidden>Nom du centre</option>
                    <?php

                    $sql = "SELECT `id_centre`, `ville_centre` FROM centres";
                    $requete = $bdd->query($sql);
                    $results = $requete->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($results as $value) {
                        echo '<option value="' . $value['id_centre'] . '">' . 'AFCI' . ' - ' . $value['ville_centre'] . '</option>';
                    }
                    ?>
                </select>

                <input type="submit" name="submitAffectation" value="Affecter">
            </fieldset>
        </form>

        <article>
            <h2>Affectations</h2>
            <form method="POST">
                <fieldset>
                    <legend>Nos affectations</legend>
                    <table>
                        <thead>
                            <tr>
                                <th>Rôle</th>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Centres</th>
                                <th>Modification</th>
                                <th>Suppression</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Récupérer les données depuis la base de données
                            $sql = "SELECT affecter.id_pedagogie, pedagogie.nom_pedagogie, pedagogie.prenom_pedagogie, role.id_role, role.nom_role, affecter.id_centre, centres.ville_centre
                                        FROM affecter
                                        INNER JOIN pedagogie ON affecter.id_pedagogie = pedagogie.id_pedagogie
                                        INNER JOIN centres ON affecter.id_centre = centres.id_centre
                                        INNER JOIN role ON pedagogie.id_role = role.id_role
                                        ORDER BY `affecter`.`id_pedagogie` ASC";

                            $requete = $bdd->query($sql);
                            $results = $requete->fetchAll(PDO::FETCH_ASSOC);
                            // Afficher chaque ligne de la table
                            foreach ($results as $value) {
                                // Créer la ligne du tableau pour chaque entrée
                                echo '<tr>';

                                // Affichage du role
                                echo '<td>' . $value['nom_role'] . '</td>';

                                // Affichage du nom
                                echo '<td>' . $value['nom_pedagogie'] . '</td>';

                                // Affichage du prénom
                                echo '<td>' . $value['prenom_pedagogie'] . '</td>';

                                // Affichage de la ville
                                echo '<td>' . $value['ville_centre'] . '</td>';

                                // Bouton Modifier
                                echo '<td><a href="?page=affectations&type=modifier&id=' . $value['id_pedagogie'] . '&' . $value['id_centre'] . '" class="modifier">Modifier</a></td>';

                                // Bouton Supprimer
                                echo '<td><button type="submit" name="deleteAffectation" value="' . $value['id_pedagogie'] . '_' . $value['id_centre'] . '" class="supprimer">Supprimer</button></td>';

                                // Fermeture de la ligne du tableau
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </fieldset>
            </form>

            <?php
            // Création d'une affectation
            if (isset($_POST['submitAffectation']) && isset($_POST['idAssociationPedago']) && isset($_POST['idAssociationCentre'])) {
                $idPedago = $_POST['idAssociationPedago'];
                $idCentre = $_POST['idAssociationCentre'];

                // Requête préparée pour l'insertion sécurisée des données
                $sql = "INSERT INTO `affecter`(`id_pedagogie`, `id_centre`) VALUES (:idPedago, :idCentre)";
                $requete = $bdd->prepare($sql);
                $requete->bindParam(':idPedago', $idPedago, PDO::PARAM_INT);
                $requete->bindParam(':idCentre', $idCentre, PDO::PARAM_INT);

                if ($requete->execute()) {
                    echo "Affectation ajoutée dans la base de données.";
                } else {
                    echo "Erreur lors de l'ajout de l'affectation.";
                }
            }

            // Suppression d'une affectation
            if (isset($_POST['deleteAffectation']) && !empty($_POST['deleteAffectation'])) {
                $idAssociationDelete = $_POST['deleteAffectation'];

                // Requête préparée pour la suppression sécurisée des données
                $sql = "DELETE FROM `affecter` WHERE CONCAT(id_pedagogie, '_', id_centre) = :idAssociationDelete";
                $requete = $bdd->prepare($sql);
                $requete->bindParam(':idAssociationDelete', $idAssociationDelete, PDO::PARAM_STR);

                if ($requete->execute()) {
                    echo "L'affectation a été supprimée de la base de données.";
                } else {
                    echo "Erreur lors de la suppression de l'affectation.";
                }
            }
            if (isset($_GET['type']) && $_GET['type'] == "modifier") {
                if (isset($_GET['id'])) {
                    // Récupérer l'identifiant de l'affectation à modifier
                    $id = $_GET['id'];

                    // Requête préparée pour récupérer les données de l'affectation à modifier
                    $sqlId = "SELECT * FROM `affecter` WHERE CONCAT(id_pedagogie, '_', id_centre) = :id";
                    $requeteId = $bdd->prepare($sqlId);
                    $requeteId->bindParam(':id', $id, PDO::PARAM_STR);
                    $requeteId->execute();
                    $resultsId = $requeteId->fetch(PDO::FETCH_ASSOC);

            ?>

                    <form method="POST">

                        <label for="idPedago">Sélectionnez un membre de l'équipe pédagogique</label>
                        <select name="idAssociationPedago" id="idPedago">
                            <option value="" hidden>Membre</option>
                            <?php
                            // Utilisation des résultats de la requête préparée pour sélectionner l'option appropriée
                            $sql = "SELECT `id_pedagogie`, pedagogie.id_role, CONCAT(`nom_role`, ' - ', `nom_pedagogie`, ' ', `prenom_pedagogie`) AS `pedago`
                        FROM `pedagogie`
                        INNER JOIN `role`
                        ON pedagogie.id_role = role.id_role";
                            $requete = $bdd->query($sql);
                            $results = $requete->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($results as $value) {
                                $selected = ($value['id_pedagogie'] == $resultsId['id_pedagogie']) ? 'selected' : '';
                                echo '<option value="' . $value['id_pedagogie'] . '" ' . $selected . '>' . $value['pedago'] . '</option>';
                            }
                            ?>
                        </select>

                        <label for="idCentre">Sélectionnez un centre</label>
                        <select name="idAssociationCentre" id="idCentre">
                            <option value="" hidden>Nom du centre</option>
                            <?php
                            // Utilisation des résultats de la requête préparée pour sélectionner l'option appropriée
                            $sql = "SELECT `id_centre`, `ville_centre` FROM centres";
                            $requete = $bdd->query($sql);
                            $results = $requete->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($results as $value) {
                                $selected = ($value['id_centre'] == $resultsId['id_centre']) ? 'selected' : '';
                                echo '<option value="' . $value['id_centre'] . '" ' . $selected . '>' . 'AFCI' . ' - ' . $value['ville_centre'] . '</option>';
                            }
                            ?>
                        </select>

                        <input type="submit" name="updateAffectation" value="Modifier">
                    </form>
        <?php

                    // Mise à jour d'une affectation
                    if (isset($_POST['updateAffectation']) && isset($_POST['idAssociationPedago']) && isset($_POST['idAssociationCentre'])) {
                        $idPedagoUpdate = $_POST['idAssociationPedago'];
                        $idCentreUpdate = $_POST['idAssociationCentre'];

                        // Requête préparée pour la mise à jour sécurisée des données
                        $sql = "UPDATE `affecter` SET `id_pedagogie` = :idPedago, `id_centre` = :idCentre WHERE CONCAT(id_pedagogie, '_', id_centre) = :idAssociationUpdate";
                        $requete = $bdd->prepare($sql);
                        $requete->bindParam(':idPedago', $idPedagoUpdate, PDO::PARAM_INT);
                        $requete->bindParam(':idCentre', $idCentreUpdate, PDO::PARAM_INT);
                        $requete->bindParam(':idAssociationUpdate', $_POST['updateIdAssociation'], PDO::PARAM_STR);

                        if ($requete->execute()) {
                            echo "Affectation mise à jour dans la base de données.";
                        } else {
                            echo "Erreur lors de la mise à jour de l'affectation.";
                        }
                    }
                }
            }
        }
        ?>
        </article>
    </main>