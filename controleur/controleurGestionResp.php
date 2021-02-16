<?php
require_once __DIR__."/../vue/vueGestionResp.php";

/**
* Contrôleur de l'affichage de la vue générée en cas de page non trouvée.
*/
class controleurGestionResp{

  private $vue;
  /**
  * Constructeur de la classe initialisant la vue de page non trouvée.
  */
  public function __construct(){
    $this->vue=new vueGestionResp();
  }

  /**
   * Fonction permettant d'afficher la vue de page non trouvée.
   */
  public function genererVueAjoutResp_ctrl(){
    $this->vue->genererVueAjoutResp();
  }

  public function ajouterResp(){
    $this->vue->genererVueAjoutResp_valider();
  }
  public function genererVueAjoutEtu_ctrl(){
    $this->vue->genererVueAjoutEtu();
  }

  public function ajouterEtu(){
    $this->vue->genererVueAjoutEtu_valider();
  }

  public function genererVueAjoutEnt_ctrl(){
    $this->vue->genererVueAjoutEnt();
  }

  public function ajouterEnt(){
    $this->vue->genererVueAjoutEnt_valider();
  }
}
