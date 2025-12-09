<?php
// db.php – connexion à la base pour login / register / historique / etc.

$host = "localhost";
$dbname = "charityconnect_db"; // <-- c'est le nom que tu vois dans phpMyAdmin
$user = "root";
$pass = "";

// création de l'objet PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
