<?php
require_once 'Avion.class.php';
require_once 'ManagerAvion.class.php';

try {
    // Connexion à la base de données
    $pdo = new PDO('mysql:host=localhost;dbname=avion', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $manager = new ManagerAvion($pdo);

    // Création de quelques avions
    $avion1 = new Avion('F4U Corsair', 'États-Unis', 1943, 'Chance Vought Aircraft Division');
    $avion2 = new Avion('Spitfire', 'Royaume-Uni', 1936, 'Supermarine');
    $avion3 = new Avion('MIG-15', 'URSS', 1947, 'Mikoyan-Gurevich');

    // Ajout des avions à la base de données
    $manager->addAvion($avion1);
    $manager->addAvion($avion2);
    $manager->addAvion($avion3);

    // Récupération et affichage des avions
    $avions = $manager->getAvions();
    foreach ($avions as $avion) {
        echo $avion->getNom() . " - " . $avion->getPaysOrigine() . " - " . $avion->getAnneeMiseEnService() . " - " . $avion->getConstructeur() . "<br>";
    }
} catch (PDOException $e) {
    echo 'Erreur : ' . $e->getMessage();
}

// Pour que tout fonction bien 
// Crée une base de donnée avion sur XAMPP
// Puis éxécuter ce petit code SQL

// CREATE TABLE avions (
//     id INT AUTO_INCREMENT PRIMARY KEY,
//     nom VARCHAR(255) NOT NULL,
//     paysOrigine VARCHAR(100) NOT NULL,
//     anneeMiseEnService INT NOT NULL,
//     constructeur VARCHAR(255) NOT NULL
// );

// Ensuite éxecute le fichier test.php
// Bravo ! Nos 3 avions sont maintenant dans la base de donnée

?>
