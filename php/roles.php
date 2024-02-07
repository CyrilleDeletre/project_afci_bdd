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

                    // Affichage du rôle en utilisant htmlspecialchars()
                    echo '<td>' . htmlspecialchars($value['nom_role']) . '</td>';

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
            if (isset($_POST['submitRole']) && isset($_POST['nomRole'])) {
                $sql = "INSERT INTO `role`(`nom_role`) VALUES (:nom)";
                $requete = $bdd->prepare($sql);

                $nomRole = $_POST['nomRole'];
                $requete->bindParam(':nom', $nomRole);

                $requete->execute();

                echo "Données ajoutées dans la base de données.";
            }


            if (isset($_POST['deleteRole'])) {
                // Assurez-vous que $idRoleDelete est un entier
                $idRoleDelete = intval($_POST['deleteRole']);

                // Préparez la requête SQL
                $sql = "DELETE FROM `role` WHERE `id_role` = :idRole";

                // Préparez la requête SQL
                $stmt = $bdd->prepare($sql);

                // Liez le paramètre :idRole à la valeur $idRoleDelete
                $stmt->bindParam(':idRole', $idRoleDelete, PDO::PARAM_INT);

                // Exécutez la requête préparée
                if ($stmt->execute()) {
                    echo "Le rôle a été supprimé dans la BDD.";
                } else {
                    echo "Erreur lors de la suppression du rôle.";
                }
            }

            if (isset($_GET['type']) && $_GET['type'] == "modifier") {
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
            
                    // Sélection des données à mettre à jour
                    $sqlId = "SELECT * FROM `role` WHERE `id_role` = :id";
                    $requeteId = $bdd->prepare($sqlId);
                    $requeteId->bindParam(':id', $id, PDO::PARAM_INT);
                    $requeteId->execute();
                    $resultsId = $requeteId->fetch(PDO::FETCH_ASSOC);
            
                    // Affichage du formulaire de mise à jour
            ?>
                    <form method="POST">
                        <input type="hidden" name="updateIdRole" value="<?php echo htmlspecialchars($resultsId['id_role']); ?>">
                        <input type="text" name="updateNomRole" value="<?php echo htmlspecialchars($resultsId['nom_role']); ?>">
                        <input type="submit" name="updateRole" value="Modifier">
                    </form>
            <?php
                    // Traitement de la soumission du formulaire de mise à jour
                    if (isset($_POST["updateRole"])) {
                        $idRoleUpdate = $_POST['updateIdRole'];
                        $nomRoleUpdate = $_POST['updateNomRole'];
            
                        // Requête de mise à jour sécurisée
                        $sqlUpdate = "UPDATE `role` SET `nom_role` = :nomRoleUpdate WHERE `id_role` = :idRoleUpdate";
                        $stmt = $bdd->prepare($sqlUpdate);
                        $stmt->bindParam(':idRoleUpdate', $idRoleUpdate, PDO::PARAM_INT);
                        $stmt->bindParam(':nomRoleUpdate', $nomRoleUpdate, PDO::PARAM_STR);
                        
                        if ($stmt->execute()) {
                            echo "Le rôle a été mis à jour dans la BDD.";
                        } else {
                            echo "Erreur lors de la mise à jour du rôle.";
                        }
                    }
                }
            }
        }            
        ?>
        </article>
    </main>