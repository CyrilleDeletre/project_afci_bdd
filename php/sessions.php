<?php

// Gestion sessions
if (isset($_GET["page"]) && $_GET["page"] == "sessions") {
?>
    <main>
        <h1>Gestion des sessions</h1>
        <form method="POST">
            <fieldset>
                <legend>Ajouter des sessions</legend>

                <label for="nomSession">Nom de la session :</label>
                <input type="text" name="nomSession" id="nomSession">

                <label for="debutSession">Date de début :</label>
                <input type="date" name="debutSession" id="debutSession">

                <label for="idCentre">Séléctionnez un centre</label>
                <select name="centre" id="idCentre">
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

                <label for="idFormation">Séléctionnez une formation</label>
                <select name="formation" id="idFormation">
                    <option value="" hidden>Nom de la formation</option>
                    <?php


                    $sql = "SELECT `id_formation`, `nom_formation` FROM formations";
                    $requete = $bdd->query($sql);
                    $results = $requete->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($results as $value) {
                        echo '<option value="' . $value['id_formation'] . '">' . $value['nom_formation'] . '</option>';
                    }
                    ?>
                </select>

                <label for="idFormateur">Séléctionner un formateur</label>
                <select name="formateur" id="idFormateur">
                    <option value="" hidden>Formateur</option>
                    <?php

                    $sql = "SELECT `id_pedagogie`, CONCAT(`nom_pedagogie`, ' ', `prenom_pedagogie`) AS `formateur`
                    FROM `pedagogie`
                    INNER JOIN `role` ON pedagogie.id_role = role.id_role
                    WHERE role.id_role = 3";
                    $requete = $bdd->query($sql);
                    $results = $requete->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($results as $value) {
                        echo '<option value="' . $value['id_pedagogie'] . '">' . $value['formateur'] . '</option>';
                    }
                    ?>
                </select>

                <input type="submit" name="submitSession" value="Ajouter">
            </fieldset>
        </form>

        <article>
            <h2>Sessions</h2>

            <form method="POST">
                <fieldset>
                    <legend>Nos sessions</legend>
                    <table>
                        <thead>
                            <tr>
                                <th>Nom de la session</th>
                                <th>Date de début</th>
                                <th>Centre</th>
                                <th>Formateur</th>
                                <th>Formation</th>
                                <th>Modification</th>
                                <th>Suppression</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Récupérer les données depuis la base de données
                            $sql = "SELECT `id_session`, `nom_session`, `date_debut`, `ville_centre`, `nom_formation`, CONCAT(`nom_pedagogie`, ' ', `prenom_pedagogie`) AS `formateur` FROM session
                            INNER JOIN centres ON session.id_centre = centres.id_centre
                            INNER JOIN formations ON session.id_formation = formations.id_formation
                            INNER JOIN pedagogie ON session.id_pedagogie = pedagogie.id_pedagogie";
                            $requete = $bdd->query($sql);
                            $results = $requete->fetchAll(PDO::FETCH_ASSOC);

                            // Afficher chaque ligne de la table
                            foreach ($results as $value) {
                                // Créer la ligne du tableau pour chaque entrée
                                echo '<tr>';

                                // Input hiddent pour stocker l'ID du centre
                                echo '<input type="hidden" name="hiddenSession" value="' . $value['id_session'] . '">';

                                // Affichage du nom de la session
                                echo '<td>' . $value['nom_session'] . '</td>';

                                // Affichage date de début de la session
                                echo '<td>' . $value['date_debut'] . '</td>';

                                // Affichage du centre de la session
                                echo '<td>' . $value['ville_centre'] . '</td>';

                                // Affichage du formateur de la session
                                echo '<td>' . $value['formateur'] . '</td>';

                                // Affichage de la formation de la session
                                echo '<td>' . $value['nom_formation'] . '</td>';

                                // Bouton Modifier
                                echo '<td><a href="?page=sessions&type=modifier&id=' . $value['id_session'] . '" class="modifier">Modifier</a></td>';

                                // Bouton Supprimer
                                echo '<td><button type="submit" name="deleteSession" value="' . $value['id_session'] . '" class="supprimer">Supprimer</button></td>';

                                // Fermeture de la ligne du tableau
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </fieldset>
            </form>
            <?php

            if (isset($_POST['submitSession'])) {
                $nomSession = $_POST['nomSession'];
                $debutSession = $_POST['debutSession'];
                $centre = $_POST['centre'];
                $formation = $_POST['formation'];
                $formateur = $_POST['formateur'];

                $sql = "INSERT INTO `session`(`nom_session`, `date_debut`, `id_centre`, `id_pedagogie`, `id_formation` )    
                VALUES ('$nomSession', '$debutSession', '$centre', '$formateur', '$formation')";
                $bdd->query($sql);

                $sqlLocalisation = "INSERT INTO `localiser`(`id_formation`,`id_centre`)    
                VALUES ('$formation', '$centre')";
                $bdd->query($sqlLocalisation);

                echo "data ajoutée dans la bdd";
            }

            if (isset($_POST['deleteSession'])) {
                $idSessionDelete = $_POST['deleteSession'];

                $sql = "DELETE FROM `session` WHERE `id_session` = $idSessionDelete";
                if ($bdd->query($sql)) {
                    echo "Le membre a été supprimé de la BDD.";
                } else {
                    echo "Erreur lors de la suppression du membre.";
                }
            }

            if (isset($_GET['type']) && $_GET['type'] == "modifier") {
                $id = $_GET['id'];
                $sqlId = "SELECT * FROM `session` WHERE id_session = $id";
                $requeteId = $bdd->query($sqlId);
                $resultsId = $requeteId->fetch(PDO::FETCH_ASSOC);

            ?>

                <form method="POST">
                    <input type="hidden" name="updateIdSession" value="<?php echo $resultsId['id_session']; ?>">
                    <input type="text" name="updateNomSession" value="<?php echo $resultsId['nom_session']; ?>">
                    <input type="text" name="updateDateDebutSession" value="<?php echo $resultsId['date_debut']; ?>">

                    <select name="centre" id="idCentre">
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

                    <select name="formation" id="idFormation">
                        <?php


                        $sql = "SELECT `id_formation`, `nom_formation` FROM formations";
                        $requete = $bdd->query($sql);
                        $results = $requete->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($results as $value) {
                            $selected = ($value['id_formation'] == $resultsId['id_formation']) ? 'selected' : '';
                            echo '<option value="' . $value['id_formation'] . '" ' . $selected . '>' . $value['nom_formation'] . '</option>';
                        }
                        ?>
                    </select>

                    <select name="formateur" id="idFormateur">
                        <?php

                        $sql = "SELECT `id_pedagogie`, CONCAT(`nom_pedagogie`, ' ', `prenom_pedagogie`) AS `formateur`
                FROM `pedagogie`
                INNER JOIN `role` ON pedagogie.id_role = role.id_role
                WHERE role.id_role = 3";
                        $requete = $bdd->query($sql);
                        $results = $requete->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($results as $value) {
                            $selected = ($value['id_pedagogie'] == $resultsId['id_pedagogie']) ? 'selected' : '';
                            echo '<option value="' . $value['id_pedagogie'] . '" ' . $selected . '>' . $value['formateur'] . '</option>';
                        }
                        ?>
                    </select>
                    <input type="submit" name="updateSession" value="Modifier">
                </form>
        <?php

                if (isset($_POST['updateSession'])) {
                    $updateIdSession = $_POST['updateIdSession'];
                    $updateNomSession = $_POST['updateNomSession'];
                    $updateDateDebutSession = $_POST['updateDateDebutSession'];
                    $updateCentreSession = $_POST['updateCentreSession'];
                    $updatePedagogieSession = $_POST['updatePedagogieSession'];
                    $updateFormationSession = $_POST['updateFormationSession'];

                    $sqlUpdate = "UPDATE `session` 
                SET 
                `nom_session` = '$updateNomSession',
                `date_debut` = '$updateDateDebutSession',
                `id_centre` = '$updateCentreSession',
                `id_pedagogie` = '$updatePedagogieSession',
                `id_formation` = '$updateFormationSession'
                WHERE `id_session` = $updateIdSession";

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