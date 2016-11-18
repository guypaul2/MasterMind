<?php
class PhaseDeJeu{
  private $noirBlanc;
  private $combinaison;

  public function __construct($comb, $pionsV){
    $this->combinaison = $comb;
    $this->noirBlanc = $pionsV;
  }

  //Méthode qui retourne la combinaison entrée par le joueur lors de la phase de jeu
  public function getCombinaison()
  {
    return $this->combinaison;
  }

}
 ?>
