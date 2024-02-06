<?php
// Gestion Rôles
if (isset($_GET["page"]) && $_GET["page"] == "roles") {
?>
    <main>
        <h1>Gestion des rôles</h1>
        <form method="POST">
            <fieldset>
                <legend>Ajouter des rôles</legend>

                <label for="nomRole">Nom du rôle : </label>
                <input type="text" name="nomRole" id="nomRole">

                <input type="submit" name="submitRole" value="Ajouter">
            </fieldset>
        </form>

        <article>
            <h2>Rôles</h2>

            <form method="POST">
                <fieldset>
                    <legend>Les rôles</legend>
                    <table>
                        <thead>
                            <tr>
                                <th>Nom rôle</th>
                                <th>Modification</th>
                                <th>Suppression</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Récupérer les données depuis la base de données
                            $sql = "SELECT * FROM `role`";
                            $requete = $bdd->query($sql);
                            $results = $requete->fetchAll(PDO::FETCH_ASSOC);

                            // Afficher chaque ligne de la table
                            foreach ($results as $value) {
                                // Créer la ligne du tableau pour chaque entrée
                                echo '<tr>';

                                // Input hidden pour stocker l'ID du rôle
                                echo '<input type="hidden" name="hiddenRole" value="' . $value['id_role'] . '">';

                                // Affichage du rôle
                                echo '<td>' . $value['nom_role'] . '</td>';

                                // Bouton Modifier
                                echo '<td><a href="?page=roles&type=modifier&id=' . $value['id_role'] . '" class="modifier">Modifier</a></td>';

                                // Bouton Supprimer
                                echo '<td><button type="submit" name="deleteRole" value="' . $value['id_role'] . '" class="supprimer">Supprimer</button></td>';

                                // Fermeture de la ligne du tableau
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </fieldset>
            </form>

            <?php
            if (isset($_POST['submitRole'])) {
                $nomRole = $_POST['nomRole'];

                $sql = "INSERT INTO `role`(`nom_role`) VALUES ('$nomRole')";
                $bdd->query($sql);

                echo "data ajoutée dans la bdd";
            }

            if (isset($_POST['deleteRole'])) {
                $idRoleDelete = $_POST['deleteRole'];

                $sql = "DELETE FROM `role` WHERE `id_role` = $idRoleDelete";
                if ($bdd->query($sql)) {
                    echo "Le rôle a été supprimé dans la BDD.";
                } else {
                    echo "Erreur lors de la suppression du rôle.";
                }
            }

            if (isset($_GET['type']) && $_GET['type'] == "modifier") {
                $id = $_GET['id'];
                $sqlId = "SELECT * FROM `role` WHERE `id_role` = $id";
                $requeteId = $bdd->query($sqlId);
                $resultsId = $requeteId->fetch(PDO::FETCH_ASSOC);

            ?>

                <form method="POST">
                    <input type="hidden" name="updateIdRole" value="<?php echo $resultsId['id_role']; ?>">
                    <input type="text" name="updateNomRole" value="<?php echo $resultsId['nom_role']; ?>">
                    <input type="submit" name="updateRole" value="Modifier">
                </form>

        <?php

                if (isset($_POST["updateRole"])) {
                    $idRoleUpdate = $_POST['updateIdRole'];
                    $nomRoleUpdate = $_POST['updateNomRole'];

                    $sqlUpdate = "UPDATE `role` 
                        SET `nom_role` = '$nomRoleUpdate' 
                        WHERE `id_role` = $idRoleUpdate";

                    if ($bdd->query($sqlUpdate)) {
                        echo "Le rôle a été mis à jour dans la BDD.";
                    } else {
                        echo "Erreur lors de la mise à jour du rôle.";
                    }
                }
            }
        }
        ?>
        </article>
    </main>