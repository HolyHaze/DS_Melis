<?php

class ManagerAvion {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Méthode pour ajouter un avion
    public function addAvion(Avion $avion) {
        $stmt = $this->pdo->prepare("INSERT INTO avions (nom, paysOrigine, anneeMiseEnService, constructeur) VALUES (:nom, :paysOrigine, :anneeMiseEnService, :constructeur)");
        $stmt->bindValue(':nom', $avion->getNom());
        $stmt->bindValue(':paysOrigine', $avion->getPaysOrigine());
        $stmt->bindValue(':anneeMiseEnService', $avion->getAnneeMiseEnService());
        $stmt->bindValue(':constructeur', $avion->getConstructeur());
        $stmt->execute();
    }

    // Méthode pour récupérer tous les avions
    public function getAvions() {
        $avions = [];
        $stmt = $this->pdo->query("SELECT * FROM avions");
        
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $avion = new Avion($data['nom'], $data['paysOrigine'], $data['anneeMiseEnService'], $data['constructeur']);
            $avions[] = $avion;
        }
        
        return $avions;
    }
}
?>
