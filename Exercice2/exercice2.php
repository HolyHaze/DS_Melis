<?php

// Classe abstraite de base Vehicule
abstract class Vehicule
{
    protected $demarrer = FALSE; // Indicateur pour savoir si le véhicule est démarré
    protected $vitesse = 0;      // Vitesse actuelle du véhicule
    protected $vitesseMax;       // Vitesse maximale autorisée pour le véhicule

    // Méthodes abstraites que les classes filles doivent implémenter
    abstract function decelerer($vitesse);
    abstract function accelerer($vitesse);

    // Fonction pour démarrer le véhicule
    public function demarrer() 
    {
        $this->demarrer = TRUE; // Change l'état à démarré
    }

    // Fonction pour éteindre le véhicule
    public function eteindre() 
    {
        $this->demarrer = FALSE; // Change l'état à éteint
    }

    // Vérifier si le véhicule est démarré
    public function estDemarre() 
    {
        return $this->demarrer; // Retourne l'état du véhicule (vrai ou faux)
    }

    // Vérifier si le véhicule est éteint
    public function estEteint() 
    {
        return !$this->demarrer; // Retourne si le véhicule est éteint (inverse de estDemarre)
    }

    // Obtenir la vitesse actuelle du véhicule
    public function getVitesse() 
    {
        return $this->vitesse; // Retourne la vitesse actuelle
    }

    // Obtenir la vitesse maximale du véhicule
    public function getVitesseMax() 
    {
        return $this->vitesseMax; // Retourne la vitesse maximale
    }

    // Méthode magique toString pour afficher des informations sur le véhicule
    public function __toString() 
    {
        $chaine = "Ceci est un véhicule \n"; // Message générique
        $chaine .= "---------------------- \n"; // Séparateur visuel
        return $chaine; // Retourne la chaîne de caractères
    }
}

// Classe Avion qui hérite de Vehicule
class Avion extends Vehicule 
{
    private $altitude = 0; // Altitude actuelle de l'avion
    private $altitudeMax;  // Altitude maximale que l'avion peut atteindre
    private $trainAtterrissageSorti = true; // Indicateur pour savoir si le train d'atterrissage est sorti

    // Constructeur de la classe Avion
    public function __construct($vitesseMax, $altitudeMax)
    {
        // On limite la vitesse maximale à 2000 km/h si elle dépasse
        $this->vitesseMax = min($vitesseMax, 2000);

        // On limite l'altitude maximale à 40 000 m si elle dépasse
        $this->altitudeMax = min($altitudeMax, 40000);
    }

    // Fonction pour décoller
    public function decoller()
    {
        // On ne peut décoller que si la vitesse est supérieure ou égale à 120 km/h
        if ($this->vitesse >= 120) {
            $this->altitude = 100; // L'avion prend immédiatement 100 m d'altitude
            $this->trainAtterrissageSorti = false; // Le train d'atterrissage est rentré automatiquement
            echo "L'avion a décollé.\n"; // Message indiquant que l'avion a décollé
        } else {
            echo "Vitesse insuffisante pour décoller.\n"; // Message d'erreur si la vitesse est insuffisante
        }
    }

    // Fonction pour atterrir
    public function atterrir()
    {
        // Conditions nécessaires pour que l'avion puisse atterrir
        if ($this->trainAtterrissageSorti && 
            $this->vitesse >= 80 && $this->vitesse <= 110 && 
            $this->altitude >= 50 && $this->altitude <= 150) {
            
            // Si les conditions sont réunies, l'altitude et la vitesse deviennent 0 (atterrissage complet)
            $this->altitude = 0;
            $this->vitesse = 0;
            echo "L'avion a atterri.\n"; // Message indiquant que l'avion a atterri
        } else {
            echo "Conditions non réunies pour atterrir.\n"; // Message d'erreur si les conditions ne sont pas réunies
        }
    }

    // Fonction pour augmenter l'altitude
    public function prendreAltitude($altitude)
    {
        // On ne peut prendre de l'altitude que si l'avion est déjà en vol (altitude > 0)
        if ($this->altitude > 0 && $this->altitude + $altitude <= $this->altitudeMax) {
            
            // Si l'altitude est supérieure à 300 m, on vérifie que le train est rentré
            if ($this->altitude > 300 && !$this->trainAtterrissageSorti) {
                $this->altitude += $altitude; // On augmente l'altitude
                echo "L'avion prend de l'altitude. Altitude actuelle : $this->altitude m.\n";
            } elseif ($this->altitude <= 300) {
                $this->altitude += $altitude; // On augmente l'altitude si elle est inférieure à 300 m
                echo "L'avion prend de l'altitude. Altitude actuelle : $this->altitude m.\n";
            } else {
                echo "Le train d'atterrissage est sorti, l'avion ne peut plus monter.\n"; // Message d'erreur si le train est sorti au-dessus de 300 m
            }
        } else {
            echo "Impossible de prendre de l'altitude.\n"; // Message d'erreur si on ne peut pas augmenter l'altitude
        }
    }

    // Fonction pour diminuer l'altitude
    public function perdreAltitude($altitude)
    {
        // On ne peut diminuer l'altitude que si l'avion est déjà en vol et l'altitude ne devient pas négative
        if ($this->altitude > 0 && $this->altitude - $altitude >= 0) {
            $this->altitude -= $altitude; // On diminue l'altitude
            echo "L'avion perd de l'altitude. Altitude actuelle : $this->altitude m.\n";
        } else {
            echo "Impossible de perdre de l'altitude.\n"; // Message d'erreur si on ne peut pas diminuer l'altitude
        }
    }

    // Fonction pour sortir le train d'atterrissage
    public function sortirTrainAtterrissage()
    {
        if (!$this->trainAtterrissageSorti) {
            $this->trainAtterrissageSorti = true; // On sort le train d'atterrissage
            echo "Le train d'atterrissage est sorti.\n"; // Message indiquant que le train est sorti
        } else {
            echo "Le train d'atterrissage est déjà sorti.\n"; // Message si le train est déjà sorti
        }
    }

    // Fonction pour rentrer le train d'atterrissage
    public function rentrerTrainAtterrissage()
    {
        if ($this->trainAtterrissageSorti) {
            $this->trainAtterrissageSorti = false; // On rentre le train d'atterrissage
            echo "Le train d'atterrissage est rentré.\n"; // Message indiquant que le train est rentré
        } else {
            echo "Le train d'atterrissage est déjà rentré.\n"; // Message si le train est déjà rentré
        }
    }

    // Implémentation de la méthode abstraite pour accélérer
    public function accelerer($vitesse)
    {
        // L'avion peut accélérer seulement s'il est démarré et si la nouvelle vitesse ne dépasse pas la vitesse max
        if ($this->demarrer && $this->vitesse + $vitesse <= $this->vitesseMax) {
            $this->vitesse += $vitesse; // On augmente la vitesse
            echo "L'avion accélère. Vitesse actuelle : $this->vitesse km/h.\n";
        } else {
            echo "Impossible d'accélérer. Vitesse maximale atteinte ou avion non démarré.\n"; // Message d'erreur si on ne peut pas accélérer
        }
    }

    // Implémentation de la méthode abstraite pour décélérer
    public function decelerer($vitesse)
    {
        // L'avion peut décélérer seulement s'il est démarré et si la vitesse ne devient pas négative
        if ($this->demarrer && $this->vitesse - $vitesse >= 0) {
            $this->vitesse -= $vitesse; // On diminue la vitesse
            echo "L'avion décélère. Vitesse actuelle : $this->vitesse km/h.\n";
        } else {
            echo "Impossible de décélérer. L'avion est déjà à l'arrêt ou non démarré.\n"; // Message d'erreur si on ne peut pas décélérer
        }
    }

    // Méthode magique toString pour afficher des informations sur l'avion
    public function __toString()
    {
        $chaine = parent::__toString(); // On appelle la méthode parent pour obtenir des informations génériques
        $chaine .= "Altitude actuelle : $this->altitude m\n"; // Affiche l'altitude actuelle
        $chaine .= "Train d'atterrissage : " . ($this->trainAtterrissageSorti ? "sorti" : "rentré") . "\n"; // Affiche l'état du train d'atterrissage
        return $chaine; // Retourne la chaîne de caractères
    }
}

// Exemple d'utilisation de la classe Avion
$avion = new Avion(1500, 35000); // On crée un avion avec une vitesse max de 1500 km/h et une altitude max de 35 000 m
$avion->demarrer(); // Démarre l'avion
$avion->accelerer(150); // L'avion accélère à 150 km/h
$avion->decoller(); // L'avion décolle
$avion->prendreAltitude(200); // L'avion prend 200 m d'altitude
$avion->sortirTrainAtterrissage(); // Le train d'atterrissage est sorti
$avion->atterrir(); // L'avion atterrit
$avion->perdreAltitude(200); // L'avion perd 200 m d'altitude
$avion->decelerer(50); // L'avion décélère de 50 km/h
$avion->atterrir(); // L'avion tente d'atterrir encore une fois
?>