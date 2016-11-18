<?php
require_once "bd.php";
require_once "joueur.php";
require_once "phaseDeJeu.php";
class ExceptionPseudo extends Exception{
  private $chaine;
  public function __construct($chaine){
    $this->chaine=$chaine;
  }

  public function afficher(){
    return $this->chaine;
  }

}
class Jeu{
  private $j1; // Joueur qui choisit la combinaison : IntelligenceArtificielle
  private $j2; // Joueur qui doit trouver la combinaison : Utlisateur
  private $phasesDeJeu; // Tableau qui stocke chacune des phases de jeu : PhaseDeJeu[]
  private $gagne; // Booléen qui passe à vrai si la partie est gagnée

  public function __construct($pseudo){
    //On initialise le nombre de coups à 0
    $this->nbCoups = 0;
    //On initialise le tableau contenant les phases de jeu
    $this->phasesDeJeu = array();
    //On initialise la variable booleenne indiquant si la partie est gagnée;
    $this->phasesDeJeu = array();
    //Génération de la combinaison
    $this->combinaison = array();
    for ($i=0; $i < 4; $i++) {
      //Génération d'une pastille de couleur pour chacune des quatres colonnes
      $this->combinaison[$i]=rand(1,8);
      /*
      Association de nombres à des couleurs :
      1 -> Violet
      2 -> Fuschia
      3 -> Bleu
      4 -> Vert
      5 -> Jaune
      6 -> Orange
      7 -> Rouge
      8 -> Blanc
      */
    }
    //On vérifie si le pseudo correspond à un joueur existant, sinon, on lève une exception
    if(this->bd->exists($pseudo)){
      //Le pseudo correspond à un joueur existant, on peut le créer
      $this->joueur->new Joueur($pseudo);
    }else{
      //Le pseudo correspond à un joueur inexistant, on lève une exception
      throw new ExceptionPseudo("Joueur inexistant dans la base de données.");
    }
  }

  //Récupérer le nombre de coups restants
  //Post condition : retourne un entier
  public function getNbCoupsRestants(){
    return 10-$this->nbCoups;
  }

  //Precondition : la partie n'est pas gagnée et le nombre de coups joués <10
  //Fonction qui correspond au jeu d'un joueur qui retourne le nombre de pion noirs (pions bien placés) et le nombre de pions blancs (pions de bonne couleurs mais mal placés)
  //post-condition : retourne un tableau à deux entrées (la première entrée correspond au nombre de pions noirs et la deuxième au nombre de pions blancs)
  public function jouer($comb){
    //On ajoute 1 coup au nombre de coups
    $this->nbCoups++;
    //On calcule le nombre de pions blancs et de pions noirs;
    $pionsNoirBlanc = array(0,0);
    for ($i=0; $i < 4 ; $i++) {
      if($combinaison[$i] == $comb[$i]){
          // On ajoute un pion noir
        $pionsNoirBlanc[0]++;
      }else{
        for($j=0; $j < 4 ; $j++){
          if($combinaison[$j] == $comb[$i]){
              // On ajoute un pion blanc
              $pionsNoirBlanc[1]++;
          }
        }
      }
    }
    //On créer une nouvelle phase de jeu
    $this->phasesDeJeu[count($this->phasesDeJeu)] = new phasesDeJeu($comb, $pionsNoirBlanc);
    //On vérifie si la partie est gagnée
    if($pionsNoirBlanc[0] == 4){
      $this->gagne = true;
    }
  }
  public function estPerdue(){
    return ($this->gagne != true && $this->nbCoups == 10);
  }
  public function estGagnee(){
    return ($this->gagne == true && $this->nbCoups <= 10);
  }
  public function getNbCoups() {
  	return $this->nbCoups;
  }

}
