<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion AFCI</title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="?page=roles">Rôles</a></li>
                <li><a href="?page=centres">Centres</a></li>
                <li><a href="?page=formations">Formations</a></li>
                <li><a href="?page=equipe-pedagogique">Equipe Pedagogique</a></li>
                <li><a href="?page=sessions">Sessions</a></li>
                <li><a href="?page=apprenants">Apprenants</a></li>
            </ul>
        </nav>
    </header>

    <?php
    $host = "mysql"; // Remplacez par l'hôte de votre base de données
    $port = "3306"; // Remplacez par l'hôte de votre base de données
    $dbname = "afci"; // Remplacez par le nom de votre base de données
    $user = "admin"; // Remplacez par votre nom d'utilisateur
    $pass = "admin"; // Remplacez par votre mot de passe

    // Création d'une nouvelle instance de la classe PDO
    $bdd = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $user, $pass);

    // Configuration des options PDO
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $bdd->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    // Gestion Rôles
    if (isset($_GET["page"]) && $_GET["page"] == "roles") {
    ?>

        <main>
            <h1>Gestion des rôles</h1>
            <form method="POST">
                <fieldset>
                    <legend>Ajouter des rôles</legend>

                    <label for="nomRole">Nom du rôle</label>
                    <input type="text" name="nomRole" id="nomRole">

                    <input type="submit" name="submitRole" value="Ajouter">
                </fieldset>
            </form>

            <?php
            if (isset($_POST['submitRole'])) {
                $nomRole = $_POST['nomRole'];

                $sql = "INSERT INTO `role`(`nom_role`) VALUES ('$nomRole')";
                $bdd->query($sql);

                echo "data ajoutée dans la bdd";
            }
            ?>

            <article>
                <h2>Rôles</h2>

            <?php

            // Lire des données dans la BDD
            $sql = "SELECT * FROM role";
            $requete = $bdd->query($sql);
            $results = $requete->fetchAll(PDO::FETCH_ASSOC);

            foreach ($results as $value) {
                foreach ($value as $key => $data) {
                    if ($key !== 'id_role') {
                        echo $data;
                        echo "<br>";
                    }
                }
                echo "<br>";
            }
        }
            ?>

            </article>
        </main>

        <?php
        // Gestion centres
        if (isset($_GET["page"]) && $_GET["page"] == "centres") {
        ?>

            <main>
                <h1>Gestion des centres</h1>
                <form method="POST">
                    <fieldset>
                        <legend>Ajouter des centres</legend>

                        <label for="villeCentre">Nom de la ville :</label>
                        <input type="text" name="villeCentre" id="villeCentre">

                        <label for="adresseCentre">Adresse :</label>
                        <input type="text" name="adresseCentre" id="adresseCentre">

                        <label for="cpCentre">Code postal :</label>
                        <input type="number" name="cpCentre" id="cpCentre">

                        <input type="submit" name="submitCentre" value="Ajouter">
                    </fieldset>
                </form>

                <?php
                if (isset($_POST['submitCentre'])) {
                    $villeCentre = $_POST['villeCentre'];
                    $adresseCentre = $_POST['adresseCentre'];
                    $cpCentre = $_POST['cpCentre'];

                    $sql = "INSERT INTO `centres`(`ville_centre`, `adresse_centre`, `code_postal_centre`) VALUES ('$villeCentre','$adresseCentre','$cpCentre')";
                    $bdd->query($sql);
                    echo "data ajoutée dans la bdd";
                }
                ?>
                <article>
                    <h2>Centres</h2>

                <?php

                // Lire des données dans la BDD centre
                $sql = "SELECT * FROM centres";
                $requete = $bdd->query($sql);
                $results = $requete->fetchAll(PDO::FETCH_ASSOC);


                foreach ($results as $value) {
                    foreach ($value as $key => $data) {
                        if ($key !== 'id_centre') {
                            echo $data;
                            echo "<br>";
                        }
                    }
                    echo "<br>";
                }
            }
                ?>
                </article>
            </main>
            <?php
            // Gestion formation
            if (isset($_GET["page"]) && $_GET["page"] == "formations") {

            ?>
                <main>
                    <h1>Gestion des formations</h1>
                    <form method="POST">
                        <fieldset>
                            <legend>Ajouter des formations</legend>

                            <label for="nomFormation">Nom :</label>
                            <input type="text" name="nomFormation" id="nomFormation">

                            <label for="dureeFormation">Durée :</label>
                            <input type="text" name="dureeFormation" id="dureeFormation">

                            <label for="niveauSortieFormation">Niveau de sortie :</label>
                            <input type="text" name="niveauSortieFormation" id="niveauSortieFormation">

                            <label for="descriptionFormation">Description :</label>
                            <input type="text" name="descriptionFormation" id="descriptionFormation">

                            <input type="submit" name="submitFormation" value="Ajouter">
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
                    ?>
                    <article>
                        <h2>Formations</h2>

                    <?php

                    // Lire des données dans la BDD formations
                    $sql = "SELECT * FROM formations";
                    $requete = $bdd->query($sql);
                    $results = $requete->fetchAll(PDO::FETCH_ASSOC);


                    foreach ($results as $value) {
                        foreach ($value as $key => $data) {
                            if ($key !== 'id_formation') {
                                echo $data;
                                echo "<br>";
                            }
                        }
                        echo "<br>";
                    }
                }
                    ?>
                    </article>
                </main>

                <?php
                // Gestion equipe pedago
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

                                <input type="submit" name="submitPedago" value="Ajouter">
                            </fieldset>
                        </form>

                        <?php
                        if (isset($_POST['submitPedago'])) {
                            $nomPedago = $_POST['nomPedago'];
                            $prenomPedago = $_POST['prenomPedago'];
                            $mailPedago = $_POST['mailPedago'];
                            $telPedago = $_POST['telPedago'];

                            $sql = "INSERT INTO `pedagogie`(`nom_pedagogie`, `prenom_pedagogie`, `mail_pedagogie`, `num_pedagogie`) VALUES ('$nomPedago','$prenomPedago','$mailPedago','$telPedago')";
                            $bdd->query($sql);
                            echo "data ajoutée dans la bdd";
                        }
                        ?>
                        <article>
                            <h2>Équipe pédagogique</h2>

                        <?php
                        // Lire des données dans la BDD formations
                        $sql = "SELECT * FROM pedagogie";
                        $requete = $bdd->query($sql);
                        $results = $requete->fetchAll(PDO::FETCH_ASSOC);


                        foreach ($results as $value) {
                            foreach ($value as $key => $data) {
                                if ($key !== 'id_pedagogie') {
                                    echo $data;
                                    echo "<br>";
                                }
                            }
                            echo "<br>";
                        }
                    }
                        ?>
                        </article>
                    </main>

                    <?php
                    // Gestion sessions
                    if (isset($_GET["page"]) && $_GET["page"] == "sessions") {
                    ?>
                        <main>
                            <h1>Gestion des sessions</h1>
                            <form method="POST">
                                <fieldset>
                                    <legend>Ajouter des sessions</legend>

                                    <label for="debutSession">Date de début :</label>
                                    <input type="date" name="debutSession" id="debutSession">

                                    <input type="submit" name="submitSession" value="Ajouter">
                                </fieldset>
                            </form>

                            <?php
                            if (isset($_POST['submitSession'])) {
                                $debutSession = $_POST['debutSession'];

                                $sql = "INSERT INTO `session`(`date_debut`) VALUES ('$debutSession')";
                                $bdd->query($sql);

                                echo "data ajoutée dans la bdd";
                            }
                            ?>
                            <article>
                                <h2>Sessions</h2>

                            <?php
                            // Lire des données dans la BDD formations
                            $sql = "SELECT * FROM session";
                            $requete = $bdd->query($sql);
                            $results = $requete->fetchAll(PDO::FETCH_ASSOC);


                            foreach ($results as $value) {
                                foreach ($value as $key => $data) {
                                    if ($key !== 'id_session') {
                                        echo $data;
                                        echo "<br>";
                                    }
                                }
                                echo "<br>";
                            }
                        }
                            ?>
                            </article>
                        </main>
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

                                        <label for="telephoneApprenant">Télephone</label>
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

                                        <input type="submit" name="submitApprenant" value="Ajouter">
                                    </fieldset>
                                </form>

                                <?php
                                if (isset($_POST['submitApprenant'])) {
                                    $nomApprenant = $_POST['nomApprenant'];
                                    $prenomApprenant = $_POST['prenomApprenant'];
                                    $emailApprenant = $_POST['emailApprenant'];
                                    $adresseApprenant = $_POST['adresseApprenant'];
                                    $villeApprenant = $_POST['villeApprenant'];
                                    $codePostalApprenant = $_POST['codePostalApprenant'];
                                    $telephoneApprenant = $_POST['telephoneApprenant'];
                                    $dateDeNaissanceApprenant = $_POST['dateDeNaissanceApprenant'];
                                    $niveauApprenant = $_POST['niveauApprenant'];
                                    $numeroPoleEmploiApprenant = $_POST['numeroPoleEmploiApprenant'];
                                    $numeroSecuriteSocialeApprenant = $_POST['numeroSecuriteSocialeApprenant'];
                                    $ribApprenant = $_POST['ribApprenant'];

                                    $sql =
                                        "INSERT INTO `apprenants`(
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
                    `rib_apprenant`
                ) 
                VALUES (
                    '$nomApprenant',
                    '$prenomApprenant',
                    '$emailApprenant',
                    '$adresseApprenant',
                    '$villeApprenant',
                    '$codePostalApprenant',
                    '$telephoneApprenant',
                    '$dateDeNaissanceApprenant',
                    '$niveauApprenant',
                    '$numeroPoleEmploiApprenant',
                    '$numeroSecuriteSocialeApprenant',
                    '$ribApprenant'
                )";

                                    $bdd->query($sql);

                                    echo "data ajoutée dans la bdd";
                                }
                                ?>

                                <article>
                                    <h2>Apprenants</h2>
                                <?php
                                // Lire des données dans la BDD
                                $sql = "SELECT * FROM apprenants";
                                $requete = $bdd->query($sql);
                                $results = $requete->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($results as $value) {
                                    foreach ($value as $key => $data) {
                                        if ($key !== 'id_apprenant') {
                                            echo $data;
                                            echo "<br>";
                                        }
                                    }
                                    echo "<br>";
                                }
                            }
                                ?>

                                </article>
                            </main>

</body>

</html>