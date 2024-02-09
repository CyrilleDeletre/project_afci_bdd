<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion AFCI</title>
    <link rel="stylesheet" href="/css/style.css?v=<?php echo time(); ?>">
</head>

<body>

    <?php
    
    include 'header.php';
    include 'pdo.php';
    include 'roles.php';
    include 'centres.php';
    include 'affectations.php';
    include 'formations.php';
    include 'equipe_pedagogique.php';
    include 'sessions.php';
    include 'apprenants.php';
    
    if (isset($_GET["page"]) && $_GET["page"] == "home") {
    ?>
    <form method="POST">
        <legend>Inscription</legend>
        <fieldset>
            <label for="identifiantSignIN">Pseudo</label>
            <input type="text" name="identifiantSignIN" id="identifiantSignIN" placeholder="JohnDoe">

            <label for="passwordSignIN">Password</label>
            <input type="password" name="passwordSignIN" id="passwordSignIN" placeholder="******">

            <button type="submit" name="signInSubmit" class="user">Inscription</button>
        </fieldset>
    </form>

    <form method="POST">
        <legend>Connexion</legend>
        <fieldset>
            <label for="identifiantLogIN">Pseudo</label>
            <input type="text" name="identifiantLogIN" id="identifiantLogIN" placeholder="JohnDoe">

            <label for="passwordLogIN">Password</label>
            <input type="password" name="passwordLogIN" id="passwordLogIN" placeholder="******">

            <button type="submit" name="submitLogIN" class="user">Connexion</button>
    </form>
    </fieldset>
    <?php

if (isset($_POST['signInSubmit'])) {
    $identifiantSignIN = $_POST['identifiantSignIN'];
    $passwordSignIN = $_POST['passwordSignIN'];

    $sqlCreateUser = "INSERT INTO `users`(`identifiant`, `password`) VALUES (?, ?)";
    $stmt = $bdd->prepare($sqlCreateUser);
    $hashedPassword = password_hash($passwordSignIN, PASSWORD_DEFAULT);
    $stmt->execute([$identifiantSignIN, $hashedPassword]);
    echo "Votre compte a bien été créé.";
}

if (isset($_POST['submitLogIN'])) {
    $identifiantLogIN = $_POST['identifiantLogIN'];
    $passwordLogIN = $_POST['passwordLogIN'];

    $sqlLogUser = "SELECT * FROM `users` WHERE `identifiant` = ?";
    $stmt = $bdd->prepare($sqlLogUser);
    $stmt->execute([$identifiantLogIN]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if (password_verify($passwordLogIN, $user['password'])) {
            echo "Vous êtes connecté.";
        } else {
            echo "Identifiants invalides.";
        }
    } else {
        echo "Identifiants invalides.";
    }
}
}
?>

    


</body>

</html>