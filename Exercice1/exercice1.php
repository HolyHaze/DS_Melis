<?php

// Classe abstraite de base Vehicule
abstract class Vehicule 
{
    protected $demarrer = FALSE; // État du véhicule, démarré ou non
    protected $vitesse = 0;       // Vitesse actuelle du véhicule
    protected $vitesseMax;        // Vitesse maximale du véhicule

    // Méthodes abstraites que les classes filles doivent définir
    abstract function demarrer();
    abstract function eteindre();
    abstract function decelerer($vitesse);
    abstract function accelerer($vitesse);

    // Méthode magique toString pour afficher des informations de base sur le véhicule
    public function __toString()
    {
        $chaine = "Ceci est un véhicule \n"; // Message de base
        $chaine .= "---------------------- \n"; // Séparateur visuel
        return $chaine; // Retourne le message
    }
}

// Classe Voiture qui hérite de Vehicule
class Voiture extends Vehicule 
{
    const VITESSE_MAX = 360; // Vitesse maximale constante pour toutes les voitures
    private static $_compteur = 0; // Compteur pour le nombre de voitures instanciées
    private $freinParking = FALSE; // État du frein de parking (activé ou désactivé)

    // Méthode statique pour obtenir le nombre de voitures créées
    public static function getNombreVoiture()
    {
        return self::$_compteur; // Retourne le compteur de voitures
    }

    // Constructeur de la classe Voiture
    public function __construct($vMax) 
    {
        $this->setVitesseMax($vMax); // Définit la vitesse maximale de la voiture
        self::$_compteur++; // Incrémente le compteur à chaque nouvelle instance
    }

    // Méthode pour démarrer la voiture
    public function demarrer() 
    {
        if ($this->freinParking) {
            // Avertit si le frein de parking est activé et empêche le démarrage
            trigger_error("Impossible de démarrer avec le frein de parking activé.", E_USER_WARNING);
        } else {
            $this->demarrer = TRUE; // Change l'état à démarré
        }
    }

    // Méthode pour éteindre la voiture
    public function eteindre() 
    {
        $this->demarrer = FALSE; // Change l'état à éteint
    }

    // Vérifie si la voiture est démarrée
    public function estDemarre() 
    {
        return $this->demarrer; // Retourne l'état du véhicule (vrai ou faux)
    }

    // Méthode pour accélérer la voiture
    public function accelerer($vitesse) 
    {
        if ($this->freinParking) {
            // Avertit si le frein de parking est activé et empêche l'accélération
            trigger_error("Impossible d'accélérer avec le frein de parking activé.", E_USER_WARNING);
        } elseif ($this->estDemarre()) {
            // Limite à 10 km/h pour le démarrage
            if ($this->getVitesse() == 0) {
                $accelerationPermise = min($vitesse, 10);
            } else {
                // Limite d'accélération à 30% de la vitesse actuelle
                $limiteAcceleration = floor($this->getVitesse() * 0.3); // Arrondi à l'entier inférieur
                $accelerationPermise = min($vitesse, $limiteAcceleration);
            }

            // Met à jour la vitesse actuelle
            $this->setVitesse($this->getVitesse() + $accelerationPermise);

            // Avertit si l'accélération a été limitée
            if ($vitesse > $accelerationPermise) {
                echo "L'accélération a été limitée à " . $accelerationPermise . " km/h.\n";
            }
        } else {
            // Avertit si le moteur est à l'arrêt
            trigger_error("On ne peut pas accélérer ! Le moteur est à l'arrêt !", E_USER_WARNING);
        }
    }

    // Méthode pour décélérer la voiture
    public function decelerer($vitesse) 
    {
        if ($this->estDemarre() && $vitesse <= 20) {
            $this->setVitesse($this->getVitesse() - $vitesse); // Met à jour la vitesse
        } else {
            // Avertit si la décélération est trop rapide
            trigger_error("Vous ralentissez trop vite !", E_USER_WARNING);
        }
    }

    // Méthode pour activer le frein de parking
    public function activerFreinParking() 
    {
        if ($this->getVitesse() == 0) {
            $this->freinParking = TRUE; // Active le frein si la voiture est arrêtée
        } else {
            // Avertit si la voiture n'est pas arrêtée
            trigger_error("Impossible d'activer le frein de parking si la voiture n'est pas arrêtée.", E_USER_WARNING);
        }
    }

    // Méthode pour désactiver le frein de parking
    public function desactiverFreinParking() 
    {
        $this->freinParking = FALSE; // Désactive le frein
    }

    // Méthode pour définir la vitesse maximale
    public function setVitesseMax($vMax) 
    {
        if ($vMax > self::VITESSE_MAX) {
            $this->vitesseMax = self::VITESSE_MAX; // Limite à la vitesse maximale constante
        } elseif ($vMax > 0) {
            $this->vitesseMax = $vMax; // Définit la vitesse maximale si elle est positive
        } else {
            $this->vitesseMax = 0; // Définit à 0 si la valeur est négative
        }
    }

    // Méthode pour définir la vitesse actuelle
    public function setVitesse($vitesse) 
    {
        if ($vitesse > $this->getVitesseMax()) {
            $this->vitesse = $this->getVitesseMax(); // Limite la vitesse à la vitesse maximale
        } elseif ($vitesse > 0) {
            $this->vitesse = $vitesse; // Définit la vitesse si elle est positive
        } else {
            $this->vitesse = 0; // Définit à 0 si la valeur est négative
        }
    }

    // Méthode pour obtenir la vitesse actuelle
    public function getVitesse() 
    {
        return $this->vitesse; // Retourne la vitesse actuelle
    }

    // Méthode pour obtenir la vitesse maximale
    public function getVitesseMax() 
    {
        return $this->vitesseMax; // Retourne la vitesse maximale
    }

    // Méthode magique toString pour afficher des informations sur la voiture
    public function __toString() 
    {
        $chaine = parent::__toString(); // Appelle la méthode toString de la classe parent
        $chaine .= "La voiture a une vitesse maximale de " . $this->vitesseMax . " km/h \n"; // Affiche la vitesse maximale
        if ($this->demarrer) {
            $chaine .= "Elle est démarrée \n"; // Indique que la voiture est démarrée
            $chaine .= "Sa vitesse est actuellement de " . $this->getVitesse() . " km/h \n"; // Affiche la vitesse actuelle
        } else {
            $chaine .= "Elle est arrêtée \n"; // Indique que la voiture est arrêtée
        }

        if ($this->freinParking) {
            $chaine .= "Le frein de parking est activé \n"; // Indique que le frein de parking est activé
        } else {
            $chaine .= "Le frein de parking est désactivé \n"; // Indique que le frein de parking est désactivé
        }

        return $chaine; // Retourne la chaîne de caractères
    }
}

// Test du code modifié
$veh1 = new Voiture(110); // Crée une nouvelle voiture avec une vitesse maximale de 110 km/h
$veh1->demarrer(); // Démarre la voiture
$veh1->accelerer(40); // Première accélération limitée à 10 km/h car la voiture est à l'arrêt
echo $veh1; // Affiche l'état de la voiture
$veh1->accelerer(40); // Deuxième accélération avec limitation de 30% de la vitesse actuelle
echo $veh1; // Affiche l'état de la voiture
$veh1->accelerer(12); // Accélération en dessous de la limite
$veh1->accelerer(40); // Nouvelle accélération avec limitation
echo $veh1; // Affiche l'état de la voiture
$veh1->accelerer(40); // Nouvelle accélération avec limitation
$veh1->decelerer(20); // Décélération de 20 km/h
$veh1->decelerer(20); // Décélération de 20 km/h
echo $veh1; // Affiche l'état de la voiture
$veh1->activerFreinParking(); // Active le frein de parking
echo $veh1; // Affiche l'état de la voiture

$veh2 = new Voiture(180); // Crée une autre voiture avec une vitesse maximale de 180 km/h
echo $veh2; // Affiche l'état de la deuxième voiture

// Affiche le nombre total de voitures instanciées
echo "############################ \n";
echo "Nombre de voiture instanciée : " . Voiture::getNombreVoiture() . "\n"; // Affiche le compteur de voitures
?>