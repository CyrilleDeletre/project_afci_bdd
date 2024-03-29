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

function read($table)
{
    $sql = "SELECT * FROM $table";

    global $bdd;
    $requete = $bdd->prepare($sql);
    $requete->execute();
    return $requete->fetchAll(PDO::FETCH_ASSOC);
}
