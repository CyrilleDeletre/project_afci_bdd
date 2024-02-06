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
            if (isset($_POST['submitAffectation'])) {
                $idAssociationPedago = $_POST['idAssociationPedago'];
                $idAssociationCentre = $_POST['idAssociationCentre'];

                $sql = "INSERT INTO `affecter`(`id_pedagogie`, `id_centre`) 
                                    VALUES ('$idAssociationPedago', '$idAssociationCentre')";
                $bdd->query($sql);

                echo "data ajoutée dans la bdd";
            }

            if (isset($_POST['deleteAffectation'])) {
                $idAssociationDelete = $_POST['deleteAffectation'];
                $sql = "DELETE FROM `affecter` WHERE CONCAT(id_pedagogie, '_', id_centre) = '" . $idAssociationDelete . "'";
                // $sql = "DELETE FROM `affecter` WHERE CONCAT(id_pedagogie, '_', id_centre) = $idAssociationDelete";
                if ($bdd->query($sql)) {
                    echo "La formation a été supprimée de la BDD.";
                } else {
                    echo "Erreur lors de la suppression de la formation.";
                }
            }

            if (isset($_GET['type']) && $_GET['type'] == "modifier") {
                $id = $_GET['id'];
                $sqlId = "SELECT * FROM `affecter` WHERE CONCAT(id_pedagogie, '&', id_centre) = $id";
                $requeteId = $bdd->query($sqlId);
                $resultsId = $requeteId->fetch(PDO::FETCH_ASSOC);

            ?>

                <form method="POST">

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
                            $selected = ($value['id_pedagogie'] == $resultsId['id_pedagogie']) ? 'selected' : '';
                            echo '<option value="' . $value['id_pedagogie'] . '" ' . $selected . '>' . $value['pedago'] . '</option>';
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
                            $selected = ($value['id_centre'] == $resultsId['id_centre']) ? 'selected' : '';
                            echo '<option value="' . $value['id_centre'] . '" ' . $selected . '>' . 'AFCI' . ' - ' . $value['ville_centre'] . '</option>';
                        }
                        ?>
                    </select>

                    <input type="submit" name="updateAffectation" value="Modifier">
                </form>

        <?php

                if (isset($_POST['updateCentre'])) {
                    $idCentreUpdate = $_POST['updateIdCentre'];
                    $idCentreUpdate = $_POST['updateIdCentre'];

                    $sqlUpdate = "UPDATE `centres` 
                                    SET 
                                        `ville_centre` = '$villeCentreUpdate',
                                        `adresse_centre` = '$adresseCentreUpdate',
                                        `code_postal_centre` = '$codePostalCentreUpdate'
                                    WHERE `id_centre` = $idCentreUpdate";

                    if ($bdd->query($sqlUpdate)) {
                        echo "Le centre a été mis à jour dans la BDD.";
                    } else {
                        echo "Erreur lors de la mise à jour du centre.";
                    }
                }
            }
        }
        ?>
        </article>
    </main>