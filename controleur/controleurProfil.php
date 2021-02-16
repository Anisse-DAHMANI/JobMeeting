<?php
require_once __DIR__."/../vue/vueProfil.php";

/**
* Contrôleur de la vue relative à l'affichage du profil d'un compte.
*/
class ControleurProfil{

  private $vue;

  /**
  * Constructeur de la classe permettant d'initialiser la vue du profil.
  */
  public function __construct(){
    $this->vue=new VueProfil();
	$this->dao = new Dao();
    $this->ctrlMenu = new ControleurMenu();
  }

  /**
  * Fonction qui demandera à VueMenu de générer une vue correspondant au choix du menu selon le type de connexion.
  * @param  String      $type   le type de connexion.
  * @param  Utilisateur $profil le profil à afficher.
  */
  public function afficherProfil($type,$profil) {
    if (isset($profil[0]))
    $this->vue->afficherProfil($type,$profil[0]);
    else
    header('Location:index.php');
  }

    public function ajoutcreneauxFormationEntrepise($idEntre, $formation, $numDebut, $numFin, $numjurie)
    {

        $this->dao->ajoutFormation($formation, $idEntre, $numDebut, $numFin);
        $this->dao->updatejurie2($formation, $idEntre, $numjurie);


        if (isset($_SESSION['testProfil']) && isset($_SESSION['testType']))
        {
            $_SESSION['testProfil'] = $this->dao->getEnt($_SESSION['idUser']);
            $this->afficherProfil($_SESSION['testType'], $_SESSION['testProfil']);
        }

        else{
            $this->ctrlMenu->afficherMenu(2);
        }
    }
}
