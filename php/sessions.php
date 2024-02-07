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

                <label for="idCentre">Sélectionnez un centre</label>
                <select name="centre" id="idCentre">
                    <option value="" hidden>Nom du centre</option>
                    <?php
                    $sql = "SELECT `id_centre`, `ville_centre` FROM centres";
                    $requete = $bdd->prepare($sql);
                    $requete->execute();
                    $results = $requete->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($results as $value) {
                        echo '<option value="' . htmlspecialchars($value['id_centre'], ENT_QUOTES) . '">' . 'AFCI' . ' - ' . htmlspecialchars($value['ville_centre'], ENT_QUOTES) . '</option>';
                    }
                    ?>
                </select>

                <label for="idFormation">Sélectionnez une formation</label>
                <select name="formation" id="idFormation">
                    <option value="" hidden>Nom de la formation</option>
                    <?php
                    $sql = "SELECT `id_formation`, `nom_formation` FROM formations";
                    $requete = $bdd->prepare($sql);
                    $requete->execute();
                    $results = $requete->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($results as $value) {
                        echo '<option value="' . htmlspecialchars($value['id_formation'], ENT_QUOTES) . '">' . htmlspecialchars($value['nom_formation'], ENT_QUOTES) . '</option>';
                    }
                    ?>
                </select>

                <label for="idFormateur">Sélectionner un formateur</label>
                <select name="formateur" id="idFormateur">
                    <option value="" hidden>Formateur</option>
                    <?php
                    $sql = "SELECT `id_pedagogie`, CONCAT(`nom_pedagogie`, ' ', `prenom_pedagogie`) AS `formateur`
                    FROM `pedagogie`
                    INNER JOIN `role` ON pedagogie.id_role = role.id_role
                    WHERE role.id_role = 3";
                    $requete = $bdd->prepare($sql);
                    $requete->execute();
                    $results = $requete->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($results as $value) {
                        echo '<option value="' . htmlspecialchars($value['id_pedagogie'], ENT_QUOTES) . '">' . htmlspecialchars($value['formateur'], ENT_QUOTES) . '</option>';
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
                            $requete = $bdd->prepare($sql);
                            $requete->execute();
                            $results = $requete->fetchAll(PDO::FETCH_ASSOC);

                            // Afficher chaque ligne de la table
                            foreach ($results as $value) {
                                // Créer la ligne du tableau pour chaque entrée
                                echo '<tr>';

                                // Input hidden pour stocker l'ID du centre
                                echo '<input type="hidden" name="hiddenSession" value="' . htmlspecialchars($value['id_session'], ENT_QUOTES) . '">';

                                // Affichage du nom de la session
                                echo '<td>' . htmlspecialchars($value['nom_session'], ENT_QUOTES) . '</td>';

                                // Affichage date de début de la session
                                echo '<td>' . htmlspecialchars($value['date_debut'], ENT_QUOTES) . '</td>';

                                // Affichage du centre de la session
                                echo '<td>' . htmlspecialchars($value['ville_centre'], ENT_QUOTES) . '</td>';

                                // Affichage du formateur de la session
                                echo '<td>' . htmlspecialchars($value['formateur'], ENT_QUOTES) . '</td>';

                                // Affichage de la formation de la session
                                echo '<td>' . htmlspecialchars($value['nom_formation'], ENT_QUOTES) . '</td>';

                                // Bouton Modifier
                                echo '<td><a href="?page=sessions&type=modifier&id=' . htmlspecialchars($value['id_session'], ENT_QUOTES) . '" class="modifier">Modifier</a></td>';

                                // Bouton Supprimer
                                echo '<td><button type="submit" name="deleteSession" value="' . htmlspecialchars($value['id_session'], ENT_QUOTES) . '" class="supprimer">Supprimer</button></td>';

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
                // Utilisation de requête préparée pour l'insertion
                $nomSession = $_POST['nomSession'];
                $debutSession = $_POST['debutSession'];
                $centre = $_POST['centre'];
                $formation = $_POST['formation'];
                $formateur = $_POST['formateur'];

                $sql = "INSERT INTO `session`(`nom_session`, `date_debut`, `id_centre`, `id_pedagogie`, `id_formation` )    
                VALUES (?, ?, ?, ?, ?)";
                $requete = $bdd->prepare($sql);
                $requete->execute([$nomSession, $debutSession, $centre, $formateur, $formation]);

                $sqlLocalisation = "INSERT INTO `localiser`(`id_formation`,`id_centre`)    
                VALUES (?, ?)";
                $requeteLocalisation = $bdd->prepare($sqlLocalisation);
                $requeteLocalisation->execute([$formation, $centre]);

                echo "Données ajoutées dans la base de données.";
            }

            if (isset($_POST['deleteSession'])) {
                // Utilisation de requête préparée pour la suppression
                $idSessionDelete = $_POST['deleteSession'];

                $sql = "DELETE FROM `session` WHERE `id_session` = ?";
                $requete = $bdd->prepare($sql);
                if ($requete->execute([$idSessionDelete])) {
                    echo "La session a été supprimée de la base de données.";
                } else {
                    echo "Erreur lors de la suppression de la session.";
                }
            }

            if (isset($_GET['type']) && $_GET['type'] == "modifier") {
                $id = $_GET['id'];
                $sqlId = "SELECT * FROM `session` WHERE id_session = ?";
                $requeteId = $bdd->prepare($sqlId);
                $requeteId->execute([$id]);
                $resultsId = $requeteId->fetch(PDO::FETCH_ASSOC);
            ?>

                <form method="POST">
                    <input type="hidden" name="updateIdSession" value="<?php echo htmlspecialchars($resultsId['id_session'], ENT_QUOTES); ?>">
                    <input type="text" name="updateNomSession" value="<?php echo htmlspecialchars($resultsId['nom_session'], ENT_QUOTES); ?>">
                    <input type="text" name="updateDateDebutSession" value="<?php echo htmlspecialchars($resultsId['date_debut'], ENT_QUOTES); ?>">

                    <select name="centre" id="idCentre">
                        <?php
                        $sql = "SELECT `id_centre`, `ville_centre` FROM centres";
                        $requete = $bdd->prepare($sql);
                        $requete->execute();
                        $results = $requete->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($results as $value) {
                            $selected = ($value['id_centre'] == $resultsId['id_centre']) ? 'selected' : '';
                            echo '<option value="' . htmlspecialchars($value['id_centre'], ENT_QUOTES) . '" ' . $selected . '>' . 'AFCI' . ' - ' . htmlspecialchars($value['ville_centre'], ENT_QUOTES) . '</option>';
                        }
                        ?>
                    </select>

                    <select name="formation" id="idFormation">
                        <?php
                        $sql = "SELECT `id_formation`, `nom_formation` FROM formations";
                        $requete = $bdd->prepare($sql);
                        $requete->execute();
                        $results = $requete->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($results as $value) {
                            $selected = ($value['id_formation'] == $resultsId['id_formation']) ? 'selected' : '';
                            echo '<option value="' . htmlspecialchars($value['id_formation'], ENT_QUOTES) . '" ' . $selected . '>' . htmlspecialchars($value['nom_formation'], ENT_QUOTES) . '</option>';
                        }
                        ?>
                    </select>

                    <select name="formateur" id="idFormateur">
                        <?php
                        $sql = "SELECT `id_pedagogie`, CONCAT(`nom_pedagogie`, ' ', `prenom_pedagogie`) AS `formateur`
                FROM `pedagogie`
                INNER JOIN `role` ON pedagogie.id_role = role.id_role
                WHERE role.id_role = 3";
                        $requete = $bdd->prepare($sql);
                        $requete->execute();
                        $results = $requete->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($results as $value) {
                            $selected = ($value['id_pedagogie'] == $resultsId['id_pedagogie']) ? 'selected' : '';
                            echo '<option value="' . htmlspecialchars($value['id_pedagogie'], ENT_QUOTES) . '" ' . $selected . '>' . htmlspecialchars($value['formateur'], ENT_QUOTES) . '</option>';
                        }
                        ?>
                    </select>
                    <input type="submit" name="updateSession" value="Modifier">
                </form>
        <?php
                if (isset($_POST['updateSession'])) {
                    // Utilisation de requête préparée pour la mise à jour
                    $updateIdSession = $_POST['updateIdSession'];
                    $updateNomSession = $_POST['updateNomSession'];
                    $updateDateDebutSession = $_POST['updateDateDebutSession'];
                    $updateCentreSession = $_POST['centre'];
                    $updatePedagogieSession = $_POST['formateur'];
                    $updateFormationSession = $_POST['formation'];

                    $sqlUpdate = "UPDATE `session` 
                SET 
                `nom_session` = ?,
                `date_debut` = ?,
                `id_centre` = ?,
                `id_pedagogie` = ?,
                `id_formation` = ?
                WHERE `id_session` = ?";

                    $requeteUpdate = $bdd->prepare($sqlUpdate);
                    if ($requeteUpdate->execute([$updateNomSession, $updateDateDebutSession, $updateCentreSession, $updatePedagogieSession, $updateFormationSession, $updateIdSession])) {
                        echo "La session a été mise à jour dans la base de données.";
                    } else {
                        echo "Erreur lors de la mise à jour de la session.";
                    }
                }
            }
        }
        ?>
        </article>
    </main>
