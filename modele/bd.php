<?php
require_once "joueur.php";
class BD{
  private $connexion;

// Constructeur de la classe
//Initialise la connexion et renvoie une ConnexionException en cas d'echec de la connexion à la base de donnée

  public function __construct(){
   try{
      $chaine="mysql:host=localhost;dbname=E155890W";
      $this->connexion = new PDO($chaine,"E155890W","E155890W");
      $this->connexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
     }
    catch(PDOException $e){
      $exception=new ConnexionException("Problème de connection à la base de donnée");
      throw $exception;
    }
  }


  // méthode qui permet de fermer la connexion
  public function deconnexion(){
     $this->connexion=null;
  }


  //A développer
  // utiliser une requête préparée
  //vérifie qu'un pseudo existe dans la table joueurs
  // post-condition retourne vrai si le pseudo existe sinon faux
  // si un problème est rencontré, une exception de type TableAccesException est levée
  public function estValide($pseudo, $motDePasse){
    try{
    	$statement = $this->connexion->prepare("select id from joueurs where pseudo=?;");
    	$statement->bindParam(1, $pseudoParam);
    	$pseudoParam=$pseudo;
    	$statement->execute();
    	$result=$statement->fetch(PDO::FETCH_ASSOC);

    	if ($result["id"]!=NUll){
    	   if($result["motDePasse"] = crypt($motDePasse)){
           return true;
         }else{
           throw new MotDePasseException("Mot de passe invalide")
         }
    	}
    	else{
    	  throw new PseudonymeException("Pseudo inexistant dans la base");
    	}
    }catch(PDOException $e){
      $this->deconnexion();
      throw new TableAccesException("problème avec la table pseudonyme");
    }
  }
	//Foncion qui enregistre une partie dans la base de données
	public function enregistrerJeu($jeu, $pseudo) {
		$gagnee = 0
		if ($jeu->estGagnee()) {
			$gagnee = 1;
		}
		$statement = $this->connexion->prepare("INSERT INTO parties(pseudo, partieGagnee, nbCoups) VALUES(:pseudo, :gagnee, :nbCoups)");
		$statement->execute(array("pseudo"=>$pseudo,
		"gagnee" => $gagnee,
		"nbCoups" => $jeu->getNbCoups()));

	}



}

?>
