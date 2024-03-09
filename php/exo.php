<!-- <?php
class Véhicule {
    // Attributs
    public $nombreDeRoues;
    public $couleur;
    public $annéeDeConstruction;
    public $marque;

    // Construct
    public function __construct($nombreDeRoues, $couleur, $annéeDeConstruction, $marque) {
        $this->nombreDeRoues = $nombreDeRoues;
        $this->couleur = $couleur;
        $this->annéeDeConstruction = $annéeDeConstruction;
        $this->marque = $marque;
    }

    // Getters

    public function getNombreDeRoues () {
        return $this->nombreDeRoues;
    }
    public function getCouleur () {
        return $this->couleur;
    }
    public function getAnnéeDeConstruction () {
        return $this->annéeDeConstruction;
    }
    public function getMarque () {
        return $this->marque;
    }

    // Setters
    public function setNombreDeRoues($nombreDeRoues) {
        $this->nombreDeRoues = $nombreDeRoues;
    }
    public function setCouleur($couleur) {
        $this->couleur = $couleur;
    }
    public function setAnnéeDeConstruction($annéeDeConstruction) {
        $this->annéeDeConstruction = $annéeDeConstruction;
    }
    public function setMarque($marque) {
        $this->marque = $marque;
    }

    // Methods
    public function concat() {
        return "Nombre de roues : " 
        . $this->getNombreDeRoues() 
        . ", Couleur : " 
        . $this->getCouleur() 
        . ", Année : " 
        . $this->getAnnéeDeConstruction() 
        . ", Marque : " 
        . $this->getMarque();
}
}

$voiture = new Véhicule(4, "violet", 2009, "Renault");
$moto = new Véhicule(2, "jaune", 2023, "Yamaha");

echo 'exo';
echo '<br>';
$voiture->setAnnéeDeConstruction($voiture->getAnnéeDeConstruction() + 22);
echo $voiture->getAnnéeDeConstruction();
echo '<br>';
$moto->setMarque($moto->getMarque()." / Honda");
echo $moto->getMarque();
echo '<br>';
echo $moto->concat();

///


class Personnage
{
    // Attributs
    public $taille;
    public $sexe;
    public $couleurDeCheveux;

    // Constructor
    public function __construct($taille, $sexe, $couleurDeCheveux) {
        $this->taille = $taille;
        $this->sexe = $sexe;
        $this->couleurDeCheveux = $couleurDeCheveux;
    }

    // Getters
    public function getTaille(){
        return $this->taille;
    }

    public function getSexe(){
        return $this->sexe;
    }

    public function getCouleurDeCheveux(){
        return $this->couleurDeCheveux;
    }

    // Setters
    public function setTaille($taille){
        $this->taille = $taille;
    }

    public function setSexe($sexe){
        $this->sexe = $sexe;
    }

    public function setCouleurDeCheveux($couleurDeCheveux){
        $this->couleurDeCheveux = $couleurDeCheveux;
    }

    // Methode 

    public function conc(){
        return "Taille : " . $this->taille . ". Sexe : " . $this->getSexe() . ". Couleur de cheveux : " . $this->getCouleurDeCheveux();
    }
}

class Mécanicien extends Personnage{
    public function role(){
        return "Mon rôle est de réparer des voitures";
    }
}
class Développeur extends Personnage{
    public function role(){
        return "Je suis développeur full stack";
    }
}
class Pilote extends Personnage{
    public function role(){
        return "Je suis Pilote !";
    }

    public function getCouleurDeCheveux(){
        return "chauve";
    }
}

class FrontEnd extends Développeur{
    public function role(){
        echo "je suis développeur front end";
    }
}

class BackEnd extends Développeur{
    public function role(){
        echo "j'aime les bases de données";
    }
}

$mecanicien = new Mécanicien(185, "homme", "brun");
echo "Je suis mécanicien. ";
echo "<br>";
echo $mecanicien->conc();
echo "<br>";
echo $mecanicien->role();
echo "<br>";
echo "<br>";

$developpeuse = new Développeur(175, "femme", "blonde");
echo $developpeuse->role();
echo "<br>";
echo $developpeuse->conc();
echo "<br>";
echo "<br>";

$pilote = new Pilote(180, "homme", "roux");
echo $pilote->role();
echo "<br>";
echo $pilote->conc();
echo "<br>";
echo "<br>";


$frontEndDev = new FrontEnd(170, "homme", "châtain");
echo $frontEndDev->role();
echo "<br>";
echo $frontEndDev->conc();
echo "<br>";
echo "<br>";

$backEndDev = new BackEnd(175, "femme", "brune");
echo $backEndDev->role();
echo "<br>";
echo $backEndDev->conc();
echo "<br>";

?>
////

