<?php
// Gestion equipe pedagogique
if (isset($_GET["page"]) && $_GET["page"] == "equipe-pedagogique") {
?>
    <main>
        <h1>Gestion de l'équipe pédagogique</h1>
        <form method="POST">
            <fieldset>
                <legend>Ajouter des membres</legend>

                <label for="nomPedago">Nom :</label>
                <input type="text" name="nomPedago" id="nomPedago">

                <label for="prenomPedago">Prénom :</label>
                <input type="text" name="prenomPedago" id="prenomPedago">

                <label for="mailPedago">Mail :</label>
                <input type="email" name="mailPedago" id="mailPedago">

                <label for="telPedago">Numéro téléphone :</label>
                <input type="tel" name="telPedago" id="telPedago">

                <label for="idRole">Sélectionnez un rôle</label>
                <select name="role" id="idRole">
                    <option value="" hidden>Rôle</option>
                    <?php
                    $results = read("role");

                    foreach ($results as $value) {
                        echo '<option value="' . htmlspecialchars($value['id_role'], ENT_QUOTES) . '">' . htmlspecialchars($value['nom_role'], ENT_QUOTES) . '</option>';
                    }
                    ?>
                </select>

                <input type="submit" name="submitPedago" value="Ajouter">

            </fieldset>
        </form>

        <article>
            <h2>Equipe pédagogique</h2>

            <form method="POST">
                <fieldset>
                    <legend>Notre équipe pédagogique</legend>
                    <table>
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Mail</th>
                                <th>Telephone</th>
                                <th>Rôle</th>
                                <th>Modification</th>
                                <th>Suppression</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            // Récupérer les données depuis la base de données
                            $sql = "SELECT `id_pedagogie`, `nom_pedagogie`, `prenom_pedagogie`, `mail_pedagogie`, `num_pedagogie`,`nom_role` 
                                                        FROM `pedagogie`
                                                        INNER JOIN `role` 
                                                        ON pedagogie.id_role = role.id_role";
                            $requete = $bdd->prepare($sql);
                            $requete->execute();
                            $results = $requete->fetchAll(PDO::FETCH_ASSOC);

                            // Afficher chaque ligne de la table
                            foreach ($results as $value) {
                                // Créer la ligne du tableau pour chaque entrée
                                echo '<tr>';

                                // Input hidden pour stocker l'ID du centre
                                echo '<input type="hidden" name="hiddenPedago" value="' . htmlspecialchars($value['id_pedagogie'], ENT_QUOTES) . '">';

                                // Affichage du nom
                                echo '<td>' . htmlspecialchars($value['nom_pedagogie'], ENT_QUOTES) . '</td>';

                                // Affichage du prénom
                                echo '<td>' . htmlspecialchars($value['prenom_pedagogie'], ENT_QUOTES) . '</td>';

                                // Affichage du mail
                                echo '<td>' . htmlspecialchars($value['mail_pedagogie'], ENT_QUOTES) . '</td>';

                                // Affichage du téléphone
                                echo '<td>' . htmlspecialchars($value['num_pedagogie'], ENT_QUOTES) . '</td>';

                                // Affichage du rôle
                                echo '<td>' . htmlspecialchars($value['nom_role'], ENT_QUOTES) . '</td>';

                                // Bouton Modifier
                                echo '<td><a href="?page=equipe-pedagogique&type=modifier&id=' . htmlspecialchars($value['id_pedagogie'], ENT_QUOTES) . '" class="modifier">Modifier</a></td>';

                                // Bouton Supprimer
                                echo '<td><button type="submit" name="deletePedago" value="' . htmlspecialchars($value['id_pedagogie'], ENT_QUOTES) . '" class="supprimer">Supprimer</button></td>';

                                // Fermeture de la ligne du tableau
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </fieldset>
            </form>

            <?php
            if (isset($_POST['submitPedago'])) {
                $nomPedago = $_POST['nomPedago'];
                $prenomPedago = $_POST['prenomPedago'];
                $mailPedago = $_POST['mailPedago'];
                $telPedago = $_POST['telPedago'];
                $role = $_POST['role'];

                // Requête préparée pour l'insertion des données
                $sql = "INSERT INTO `pedagogie`(`nom_pedagogie`, `prenom_pedagogie`, `mail_pedagogie`, `num_pedagogie`, `id_role`) 
                                        VALUES (?, ?, ?, ?, ?)";
                $requete = $bdd->prepare($sql);
                $requete->execute([$nomPedago, $prenomPedago, $mailPedago, $telPedago, $role]);

                echo "Données ajoutées dans la base de données.";
            }

            if (isset($_POST['deletePedago'])) {
                $idPedagoDelete = $_POST['deletePedago'];

                // Requête préparée pour la suppression
                $sql = "DELETE FROM `pedagogie` WHERE `id_pedagogie` = ?";
                $requete = $bdd->prepare($sql);
                if ($requete->execute([$idPedagoDelete])) {
                    echo "Le membre a été supprimé de la base de données.";
                } else {
                    echo "Erreur lors de la suppression du membre.";
                }
            }

            if (isset($_GET['type']) && $_GET['type'] == "modifier") {
                $id = $_GET['id'];
                // Requête préparée pour récupérer les données du membre à modifier
                $sqlId = "SELECT * FROM `pedagogie` WHERE `id_pedagogie` = ?";
                $requeteId = $bdd->prepare($sqlId);
                $requeteId->execute([$id]);
                $resultsId = $requeteId->fetch(PDO::FETCH_ASSOC);

            ?>

                <form method="POST">
                    <input type="hidden" name="updateIdPedago" value="<?php echo htmlspecialchars($resultsId['id_pedagogie'], ENT_QUOTES); ?>">
                    <input type="text" name="updateNomPedago" value="<?php echo htmlspecialchars($resultsId['nom_pedagogie'], ENT_QUOTES); ?>">
                    <input type="text" name="updatePrenomPedago" value="<?php echo htmlspecialchars($resultsId['prenom_pedagogie'], ENT_QUOTES); ?>">
                    <input type="text" name="updateMailPedago" value="<?php echo htmlspecialchars($resultsId['mail_pedagogie'], ENT_QUOTES); ?>">
                    <input type="text" name="updateNumPedago" value="<?php echo htmlspecialchars($resultsId['num_pedagogie'], ENT_QUOTES); ?>">
                    <select name="updateRolePedago" id="idRole">
                        <?php
                        $sql = "SELECT `id_role`, `nom_role` FROM role";
                        $requete = $bdd->prepare($sql);
                        $requete->execute();
                        $results = $requete->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($results as $value) {
                            $selected = ($value['id_role'] == $resultsId['id_role']) ? 'selected' : '';
                            echo '<option value="' . htmlspecialchars($value['id_role'], ENT_QUOTES) . '" ' . $selected . '>' . htmlspecialchars($value['nom_role'], ENT_QUOTES) . '</option>';
                        }
                        ?>
                    </select>

                    <input type="submit" name="updatePedago" value="Modifier">
                </form>

        <?php

                if (isset($_POST['updatePedago'])) {
                    $idPedagoUpdate = $_POST['updateIdPedago'];
                    $nomPedagoUpdate = $_POST['updateNomPedago'];
                    $prenomPedagoUpdate = $_POST['updatePrenomPedago'];
                    $mailPedagoUpdate = $_POST['updateMailPedago'];
                    $numPedagoUpdate = $_POST['updateNumPedago'];
                    $updateRolePedago = $_POST['updateRolePedago'];

                    // Requête préparée pour la mise à jour des données
                    $sqlUpdate = "UPDATE pedagogie SET 
                                                `nom_pedagogie` = ?,
                                                `prenom_pedagogie` = ?,
                                                `mail_pedagogie` = ?,
                                                `num_pedagogie` = ?,
                                                `id_role` = ?
                                                WHERE `id_pedagogie` = ?";
                    $requeteUpdate = $bdd->prepare($sqlUpdate);
                    if ($requeteUpdate->execute([$nomPedagoUpdate, $prenomPedagoUpdate, $mailPedagoUpdate, $numPedagoUpdate, $updateRolePedago, $idPedagoUpdate])) {
                        echo "La formation a été mise à jour dans la base de données.";
                    } else {
                        echo "Erreur lors de la mise à jour de la formation.";
                    }
                }
            }
        }
        ?>
        </article>
    </main>