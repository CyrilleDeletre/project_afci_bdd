<?php
// Gestion Apprenants
if (isset($_GET["page"]) && $_GET["page"] == "apprenants") {
?>
    <main>
        <h1>Gestion des Apprenants</h1>
        <form method="POST">
            <fieldset>
                <legend>Ajouter des Apprenants</legend>

                <label for="nomApprenant">Nom</label>
                <input type="text" name="nomApprenant" id="nomApprenant">

                <label for="prenomApprenant">Prénom</label>
                <input type="text" name="prenomApprenant" id="prenomApprenant">

                <label for="emailApprenant">Email</label>
                <input type="email" name="emailApprenant" id="emailApprenant">

                <label for="adresseApprenant">Adresse</label>
                <input type="text" name="adresseApprenant" id="adresseApprenant">

                <label for="villeApprenant">Ville</label>
                <input type="text" name="villeApprenant" id="villeApprenant">

                <label for="codePostalApprenant">Code Postal</label>
                <input type="number" name="codePostalApprenant" id="codePostalApprenant">

                <label for="telephoneApprenant">Téléphone</label>
                <input type="tel" name="telephoneApprenant" id="telephoneApprenant">

                <label for="dateDeNaissanceApprenant">Date de naissance</label>
                <input type="date" name="dateDeNaissanceApprenant" id="dateDeNaissanceApprenant">

                <label for="niveauApprenant">Niveau</label>
                <input type="text" name="niveauApprenant" id="niveauApprenant">

                <label for="numeroPoleEmploiApprenant">N° Pôle Emploi</label>
                <input type="text" name="numeroPoleEmploiApprenant" id="numeroPoleEmploiApprenant">

                <label for="numeroSecuriteSocialeApprenant">N° Sécurité sociale</label>
                <input type="number" name="numeroSecuriteSocialeApprenant" id="numeroSecuriteSocialeApprenant">

                <label for="ribApprenant">RIB</label>
                <input type="text" name="ribApprenant" id="ribApprenant">

                <label for="idSessionApprenant">Session</label>
                <select name="sessionApprenant" id="idSessionApprenant">
                    <option value="" hidden>Choisissez une session</option>

                    <?php
                    $results = read("session");

                    foreach ($results as $value) {
                        echo '<option value="' . htmlspecialchars($value['id_session']) . '">' . htmlspecialchars($value['nom_session']) . '</option>';
                    }
                    ?>
                </select>

                <input type="submit" name="submitApprenant" value="Ajouter">
            </fieldset>
        </form>

        <article>
            <h2>Apprenants</h2>

            <form method="POST">
                <fieldset>
                    <legend>Nos centres</legend>
                    <table>
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Email</th>
                                <th>Adresse</th>
                                <th>Ville</th>
                                <th>Code Postal</th>
                                <th>Téléphone</th>
                                <th>Date de naissance</th>
                                <th>Niveau</th>
                                <th>N° Pôle Emploi</th>
                                <th>N° Sécurité Sociale</th>
                                <th>RIB</th>
                                <th>Rôle</th>
                                <th>Session</th>
                                <th>Modification</th>
                                <th>Suppression</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Récupérer les données depuis la base de données
                            $sql = "SELECT apprenants.*, role.nom_role, session.nom_session
                                FROM apprenants
                                INNER JOIN role ON apprenants.id_role = role.id_role
                                INNER JOIN session ON apprenants.id_session = session.id_session;";
                            $requete = $bdd->prepare($sql);
                            $requete->execute();
                            $results = $requete->fetchAll(PDO::FETCH_ASSOC);

                            // Afficher chaque ligne de la table
                            foreach ($results as $value) {
                                // Créer la ligne du tableau pour chaque entrée
                                echo '<tr>';

                                // Input hidden pour stocker l'ID de l'apprenant
                                echo '<input type="hidden" name="hiddenApprenant" value="' . htmlspecialchars($value['id_apprenant']) . '">';

                                // Affichage du nom
                                echo '<td>' . htmlspecialchars($value['nom_apprenant']) . '</td>';

                                // Affichage du prénom
                                echo '<td>' . htmlspecialchars($value['prenom_apprenant']) . '</td>';

                                // Affichage du mail
                                echo '<td>' . htmlspecialchars($value['mail_apprenant']) . '</td>';

                                // Affichage de l'adresse
                                echo '<td>' . htmlspecialchars($value['adresse_apprenant']) . '</td>';

                                // Affichage de la ville
                                echo '<td>' . htmlspecialchars($value['ville_apprenant']) . '</td>';

                                // Affichage du code postal
                                echo '<td>' . htmlspecialchars($value['code_postal_apprenant']) . '</td>';

                                // Affichage du téléphone
                                echo '<td>' . htmlspecialchars($value['tel_apprenant']) . '</td>';

                                // Affichage de la date de naissance
                                echo '<td>' . htmlspecialchars($value['date_naissance_apprenant']) . '</td>';

                                // Affichage du niveau
                                echo '<td>' . htmlspecialchars($value['niveau_apprenant']) . '</td>';

                                // Affichage du n° Pole Emploi
                                echo '<td>' . htmlspecialchars($value['num_PE_apprenant']) . '</td>';

                                // Affichage du n° Sécurité sociale
                                echo '<td>' . htmlspecialchars($value['num_secu_apprenant']) . '</td>';

                                // Affichage du RIB
                                echo '<td>' . htmlspecialchars($value['rib_apprenant']) . '</td>';

                                // Affichage du rôle
                                echo '<td>' . htmlspecialchars($value['nom_role']) . '</td>';

                                // Affichage de la session
                                echo '<td>' . htmlspecialchars($value['nom_session']) . '</td>';

                                // Bouton Modifier
                                echo '<td><a href="?page=apprenants&type=modifier&id=' . htmlspecialchars($value['id_apprenant']) . '" class="modifier">Modifier</a></td>';

                                // Bouton Supprimer
                                echo '<td><button type="submit" name="deleteApprenant" value="' . htmlspecialchars($value['id_apprenant']) . '" class="supprimer">Supprimer</button></td>';

                                // Fermeture de la ligne du tableau
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </fieldset>
            </form>

            <?php
            if (isset($_POST['submitApprenant'])) {
                $nomApprenant = htmlspecialchars($_POST['nomApprenant']);
                $prenomApprenant = htmlspecialchars($_POST['prenomApprenant']);
                $emailApprenant = htmlspecialchars($_POST['emailApprenant']);
                $adresseApprenant = htmlspecialchars($_POST['adresseApprenant']);
                $villeApprenant = htmlspecialchars($_POST['villeApprenant']);
                $codePostalApprenant = htmlspecialchars($_POST['codePostalApprenant']);
                $telephoneApprenant = htmlspecialchars($_POST['telephoneApprenant']);
                $dateDeNaissanceApprenant = htmlspecialchars($_POST['dateDeNaissanceApprenant']);
                $niveauApprenant = htmlspecialchars($_POST['niveauApprenant']);
                $numeroPoleEmploiApprenant = htmlspecialchars($_POST['numeroPoleEmploiApprenant']);
                $numeroSecuriteSocialeApprenant = htmlspecialchars($_POST['numeroSecuriteSocialeApprenant']);
                $sessionApprenant = htmlspecialchars($_POST['sessionApprenant']);
                $ribApprenant = htmlspecialchars($_POST['ribApprenant']);

                $sql = "INSERT INTO `apprenants`(
                                        `nom_apprenant`, 
                                        `prenom_apprenant`, 
                                        `mail_apprenant`, 
                                        `adresse_apprenant`, 
                                        `ville_apprenant`, 
                                        `code_postal_apprenant`, 
                                        `tel_apprenant`, 
                                        `date_naissance_apprenant`, 
                                        `niveau_apprenant`, 
                                        `num_PE_apprenant`, 
                                        `num_secu_apprenant`,
                                        `id_role`,
                                        `id_session`,
                                        `rib_apprenant`
                                    ) 
                                    VALUES (
                                        :nomApprenant,
                                        :prenomApprenant,
                                        :emailApprenant,
                                        :adresseApprenant,
                                        :villeApprenant,
                                        :codePostalApprenant,
                                        :telephoneApprenant,
                                        :dateDeNaissanceApprenant,
                                        :niveauApprenant,
                                        :numeroPoleEmploiApprenant,
                                        :numeroSecuriteSocialeApprenant,
                                        4,
                                        :sessionApprenant,
                                        :ribApprenant
                                    )";

                $requete = $bdd->prepare($sql);
                $requete->bindParam(':nomApprenant', $nomApprenant);
                $requete->bindParam(':prenomApprenant', $prenomApprenant);
                $requete->bindParam(':emailApprenant', $emailApprenant);
                $requete->bindParam(':adresseApprenant', $adresseApprenant);
                $requete->bindParam(':villeApprenant', $villeApprenant);
                $requete->bindParam(':codePostalApprenant', $codePostalApprenant);
                $requete->bindParam(':telephoneApprenant', $telephoneApprenant);
                $requete->bindParam(':dateDeNaissanceApprenant', $dateDeNaissanceApprenant);
                $requete->bindParam(':niveauApprenant', $niveauApprenant);
                $requete->bindParam(':numeroPoleEmploiApprenant', $numeroPoleEmploiApprenant);
                $requete->bindParam(':numeroSecuriteSocialeApprenant', $numeroSecuriteSocialeApprenant);
                $requete->bindParam(':sessionApprenant', $sessionApprenant);
                $requete->bindParam(':ribApprenant', $ribApprenant);
                $requete->execute();

                echo "Données ajoutées dans la base de données";
            }

            if (isset($_POST['deleteApprenant'])) {
                $idApprenantDelete = htmlspecialchars($_POST['deleteApprenant']);

                $sql = "DELETE FROM `apprenants` WHERE `id_apprenant` = :idApprenantDelete";
                $requete = $bdd->prepare($sql);
                $requete->bindParam(':idApprenantDelete', $idApprenantDelete);
                if ($requete->execute()) {
                    echo "Le centre a été supprimé dans la BDD.";
                } else {
                    echo "Erreur lors de la suppression du centre.";
                }
            }

            if (isset($_GET['type']) && $_GET['type'] == "modifier") {
                $id = htmlspecialchars($_GET['id']);
                $sqlId = "SELECT * FROM `apprenants` WHERE id_apprenant = :id";
                $requeteId = $bdd->prepare($sqlId);
                $requeteId->bindParam(':id', $id);
                $requeteId->execute();
                $resultsId = $requeteId->fetch(PDO::FETCH_ASSOC);
            ?>

                <form method="POST">
                    <input type="hidden" name="updateIdApprenant" value="<?php echo htmlspecialchars($resultsId['id_apprenant']); ?>">
                    <input type="text" name="updateNomApprenant" value="<?php echo htmlspecialchars($resultsId['nom_apprenant']); ?>">
                    <input type="text" name="updatePrenomApprenant" value="<?php echo htmlspecialchars($resultsId['prenom_apprenant']); ?>">
                    <input type="email" name="updateMailApprenant" value="<?php echo htmlspecialchars($resultsId['mail_apprenant']); ?>">
                    <input type="text" name="updateAdresseApprenant" value="<?php echo htmlspecialchars($resultsId['adresse_apprenant']); ?>">
                    <input type="text" name="updateVilleApprenant" value="<?php echo htmlspecialchars($resultsId['ville_apprenant']); ?>">
                    <input type="number" name="updateCodePostalApprenant" value="<?php echo htmlspecialchars($resultsId['code_postal_apprenant']); ?>">
                    <input type="tel" name="updateTelApprenant" value="<?php echo htmlspecialchars($resultsId['tel_apprenant']); ?>">
                    <input type="date" name="updateDateNaissanceApprenant" value="<?php echo htmlspecialchars($resultsId['date_naissance_apprenant']); ?>">
                    <input type="text" name="updateNiveauApprenant" value="<?php echo htmlspecialchars($resultsId['niveau_apprenant']); ?>">
                    <input type="text" name="updateNumPEApprenant" value="<?php echo htmlspecialchars($resultsId['num_PE_apprenant']); ?>">
                    <input type="text" name="updateNumSecuApprenant" value="<?php echo htmlspecialchars($resultsId['num_secu_apprenant']); ?>">
                    <input type="text" name="updateRibApprenant" value="<?php echo htmlspecialchars($resultsId['rib_apprenant']); ?>">

                    <select name="roleApprenant" id="idroleApprenant">
                        <?php
                        $sql = "SELECT `id_role`, `nom_role` FROM `role`";
                        $requete = $bdd->prepare($sql);
                        $requete->execute();
                        $results = $requete->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($results as $value) {
                            $selected = ($value['id_role'] == $resultsId['id_role']) ? 'selected' : '';
                            echo '<option value="' . htmlspecialchars($value['id_role']) . '" ' . $selected . '>' . htmlspecialchars($value['nom_role']) . '</option>';
                        }
                        ?>
                    </select>

                    <select name="sessionApprenant" id="idSessionApprenant">
                        <?php
                        $sql = "SELECT `id_session`, `nom_session` FROM `session`";
                        $requete = $bdd->prepare($sql);
                        $requete->execute();
                        $results = $requete->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($results as $value) {
                            $selected = ($value['id_session'] == $resultsId['id_session']) ? 'selected' : '';
                            echo '<option value="' . htmlspecialchars($value['id_session']) . '" ' . $selected . '>' . htmlspecialchars($value['nom_session']) . '</option>';
                        }
                        ?>
                    </select>
                    <input type="submit" name="updateApprenant" value="Modifier">
                </form>

        <?php

                if (isset($_POST['updateApprenant'])) {
                    $updateIdApprenant = htmlspecialchars($_POST['updateIdApprenant']);
                    $updateNomApprenant = htmlspecialchars($_POST['updateNomApprenant']);
                    $updatePrenomApprenant = htmlspecialchars($_POST['updatePrenomApprenant']);
                    $updateMailApprenant = htmlspecialchars($_POST['updateMailApprenant']);
                    $updateAdresseApprenant = htmlspecialchars($_POST['updateAdresseApprenant']);
                    $updateVilleApprenant = htmlspecialchars($_POST['updateVilleApprenant']);
                    $updateCodePostalApprenant = htmlspecialchars($_POST['updateCodePostalApprenant']);
                    $updateTelApprenant = htmlspecialchars($_POST['updateTelApprenant']);
                    $updateDateNaissanceApprenant = htmlspecialchars($_POST['updateDateNaissanceApprenant']);
                    $updateNiveauApprenant = htmlspecialchars($_POST['updateNiveauApprenant']);
                    $updateNumPEApprenant = htmlspecialchars($_POST['updateNumPEApprenant']);
                    $updateNumSecuApprenant = htmlspecialchars($_POST['updateNumSecuApprenant']);
                    $updateRibApprenant = htmlspecialchars($_POST['updateRibApprenant']);

                    $sqlUpdate = "UPDATE `apprenants` 
                                SET 
                                `nom_apprenant` = :updateNomApprenant,
                                `prenom_apprenant` = :updatePrenomApprenant,
                                `mail_apprenant` = :updateMailApprenant,
                                `adresse_apprenant` = :updateAdresseApprenant,
                                `ville_apprenant` = :updateVilleApprenant,
                                `code_postal_apprenant` = :updateCodePostalApprenant,
                                `tel_apprenant` = :updateTelApprenant,
                                `date_naissance_apprenant` = :updateDateNaissanceApprenant,
                                `niveau_apprenant` = :updateNiveauApprenant,
                                `num_PE_apprenant` = :updateNumPEApprenant,
                                `num_secu_apprenant` = :updateNumSecuApprenant,
                                `rib_apprenant` = :updateRibApprenant
                                WHERE  `id_apprenant` = :updateIdApprenant";

                    $requeteUpdate = $bdd->prepare($sqlUpdate);
                    $requeteUpdate->bindParam(':updateNomApprenant', $updateNomApprenant);
                    $requeteUpdate->bindParam(':updatePrenomApprenant', $updatePrenomApprenant);
                    $requeteUpdate->bindParam(':updateMailApprenant', $updateMailApprenant);
                    $requeteUpdate->bindParam(':updateAdresseApprenant', $updateAdresseApprenant);
                    $requeteUpdate->bindParam(':updateVilleApprenant', $updateVilleApprenant);
                    $requeteUpdate->bindParam(':updateCodePostalApprenant', $updateCodePostalApprenant);
                    $requeteUpdate->bindParam(':updateTelApprenant', $updateTelApprenant);
                    $requeteUpdate->bindParam(':updateDateNaissanceApprenant', $updateDateNaissanceApprenant);
                    $requeteUpdate->bindParam(':updateNiveauApprenant', $updateNiveauApprenant);
                    $requeteUpdate->bindParam(':updateNumPEApprenant', $updateNumPEApprenant);
                    $requeteUpdate->bindParam(':updateNumSecuApprenant', $updateNumSecuApprenant);
                    $requeteUpdate->bindParam(':updateRibApprenant', $updateRibApprenant);
                    $requeteUpdate->bindParam(':updateIdApprenant', $updateIdApprenant);
                    if ($requeteUpdate->execute()) {
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
    <?php
