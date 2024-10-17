<?php

class Avion {
    private $nom;
    private $paysOrigine;
    private $anneeMiseEnService;
    private $constructeur;

    // Constructeur
    public function __construct($nom, $paysOrigine, $anneeMiseEnService, $constructeur) {
        $this->nom = $nom;
        $this->paysOrigine = $paysOrigine;
        $this->anneeMiseEnService = $anneeMiseEnService;
        $this->constructeur = $constructeur;
    }

    // Getters
    public function getNom() {
        return $this->nom;
    }

    public function getPaysOrigine() {
        return $this->paysOrigine;
    }

    public function getAnneeMiseEnService() {
        return $this->anneeMiseEnService;
    }

    public function getConstructeur() {
        return $this->constructeur;
    }

    // Setters
    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function setPaysOrigine($paysOrigine) {
        $this->paysOrigine = $paysOrigine;
    }

    public function setAnneeMiseEnService($anneeMiseEnService) {
        $this->anneeMiseEnService = $anneeMiseEnService;
    }

    public function setConstructeur($constructeur) {
        $this->constructeur = $constructeur;
    }

    // Méthode d'hydratation
    public function hydrate(array $data) {
        if (isset($data['nom'])) {
            $this->setNom($data['nom']);
        }
        if (isset($data['paysOrigine'])) {
            $this->setPaysOrigine($data['paysOrigine']);
        }
        if (isset($data['anneeMiseEnService'])) {
            $this->setAnneeMiseEnService($data['anneeMiseEnService']);
        }
        if (isset($data['constructeur'])) {
            $this->setConstructeur($data['constructeur']);
        }
    }
}
?>
