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

                <label for="telPedago">Numéro teléphone :</label>
                <input type="tel" name="telPedago" id="telPedago">

                <label for="idRole">Séléctionnez un rôle</label>
                <select name="role" id="idRole">
                    <option value="" hidden>Rôle</option>


                    <?php
                    $sql = "SELECT `id_role`, `nom_role` FROM role";
                    $requete = $bdd->query($sql);
                    $results = $requete->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($results as $value) {
                        echo '<option value="' . $value['id_role'] .  '">' . $value['nom_role'] . '</option>';
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
                            $requete = $bdd->query($sql);
                            $results = $requete->fetchAll(PDO::FETCH_ASSOC);

                            // Afficher chaque ligne de la table
                            foreach ($results as $value) {
                                // Créer la ligne du tableau pour chaque entrée
                                echo '<tr>';

                                // Input hiddent pour stocker l'ID du centre
                                echo '<input type="hidden" name="hiddenPedago" value="' . $value['id_pedagogie'] . '">';

                                // Affichage du nom
                                echo '<td>' . $value['nom_pedagogie'] . '</td>';

                                // Affichage du prénom
                                echo '<td>' . $value['prenom_pedagogie'] . '</td>';

                                // Affichage du mail
                                echo '<td>' . $value['mail_pedagogie'] . '</td>';

                                // Affichage du mail
                                echo '<td>' . $value['num_pedagogie'] . '</td>';

                                // Affichage du mail
                                echo '<td>' . $value['nom_role'] . '</td>';

                                // Bouton Modifier
                                echo '<td><a href="?page=equipe-pedagogique&type=modifier&id=' . $value['id_pedagogie'] . '" class="modifier">Modifier</a></td>';

                                // Bouton Supprimer
                                echo '<td><button type="submit" name="deletePedago" value="' . $value['id_pedagogie'] . '" class="supprimer">Supprimer</button></td>';

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

                $sql = "INSERT INTO `pedagogie`(`nom_pedagogie`, `prenom_pedagogie`, `mail_pedagogie`, `num_pedagogie`, `id_role`) 
                                    VALUES ('$nomPedago','$prenomPedago','$mailPedago','$telPedago','$role')";
                $bdd->query($sql);

                echo "data ajoutée dans la bdd";
            }

            if (isset($_POST['deletePedago'])) {
                $idPedagoDelete = $_POST['deletePedago'];

                $sql = "DELETE FROM `pedagogie` WHERE `id_pedagogie` = $idPedagoDelete";
                if ($bdd->query($sql)) {
                    echo "Le membre a été supprimé de la BDD.";
                } else {
                    echo "Erreur lors de la suppression du membre.";
                }
            }

            if (isset($_GET['type']) && $_GET['type'] == "modifier") {
                $id = $_GET['id'];
                $sqlId = "SELECT * FROM `pedagogie` WHERE `id_pedagogie` = $id";
                $requeteId = $bdd->query($sqlId);
                $resultsId = $requeteId->fetch(PDO::FETCH_ASSOC);

            ?>

                <form method="POST">
                    <input type="hidden" name="updateIdPedago" value="<?php echo $resultsId['id_pedagogie']; ?>">
                    <input type="text" name="updateNomPedago" value="<?php echo $resultsId['nom_pedagogie']; ?>">
                    <input type="text" name="updatePrenomPedago" value="<?php echo $resultsId['prenom_pedagogie']; ?>">
                    <input type="text" name="updateMailPedago" value="<?php echo $resultsId['mail_pedagogie']; ?>">
                    <input type="text" name="updateNumPedago" value="<?php echo $resultsId['num_pedagogie']; ?>">
                    <select name="updateRolePedago" id="idRole">
                        <?php
                        $sql = "SELECT `id_role`, `nom_role` FROM role";
                        $requete = $bdd->query($sql);
                        $results = $requete->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($results as $value) {
                            $selected = ($value['id_role'] == $resultsId['id_role']) ? 'selected' : '';
                            echo '<option value="' . $value['id_role'] . '" ' . $selected . '>' . $value['nom_role'] . '</option>';
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

                    $sqlUpdate = "UPDATE pedagogie SET 
                                            `nom_pedagogie` = '$nomPedagoUpdate',
                                            `prenom_pedagogie` = '$prenomPedagoUpdate',
                                            `mail_pedagogie` = '$mailPedagoUpdate',
                                            `num_pedagogie` = '$numPedagoUpdate',
                                            `id_role` = '$updateRolePedago'
                                            WHERE `id_pedagogie` = $idPedagoUpdate";


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