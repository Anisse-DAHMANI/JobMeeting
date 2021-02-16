<?php
require_once __DIR__."/../vue/vueAfficherCsv.php";
require_once __DIR__."/../vue/vueMonCompte.php";
require_once __DIR__."/../modele/dao/dao.php";
require_once __DIR__."/../controleur/controleurMail.php";



/**
* Contrôleur de la majorité des pages affichées lors de la connexion d'un utilisateur.
*/
class ControleurAfficherCsvResponsable{

  private $vue;
  private $vueCompte;
  private $dao;

  public function __construct(){
    $this->vue=new VueAfficherCsv();
    $this->vueCompte = new vueMonCompte();
    $this->dao = new Dao();
  }





  public function afficherCsv($export){
    
  	switch ($export) {
        /*case $export=='#isemty':
            $requete = "select * from planning where nometu not like '---' order by 2,1,5;";

            $result = $this->dao->requete($requete);

            $tabFinal=array();
            $tabFinalLigne=array();
            $titre="Planning des entreprises";
            array_push($tabFinalLigne,'Entreprise');
            array_push($tabFinalLigne,'Formation');
            array_push($tabFinalLigne,'Nom étu');
            array_push($tabFinalLigne,'Prénom étu');
            array_push($tabFinalLigne,'Heure');
            array_push($tabFinal, $tabFinalLigne);

            foreach ($result as $value){
                $tabFinalLigne=array();
                array_push($tabFinalLigne,$value["nomEnt"]);
                array_push($tabFinalLigne,$value["typeFormation"]);
                array_push($tabFinalLigne,$value["nomEtu"]);
                array_push($tabFinalLigne,$value["prenomEtu"]);
                array_push($tabFinalLigne,$value["heure"]);
                array_push($tabFinal, $tabFinalLigne);
            }



            if (isset($_GET["telecharger"])){
                header('Content-Type: text/cs');
                header('Content-Disposition: attachment; filename="Export Planning.csv"');

                foreach ($tabFinal as $ligne){
                    foreach ($ligne as $value){
                        echo '"'.$value.'";';
                    }
                    echo "\n";
                }
            } else {
                $this->vue->afficherPlanning($tabFinal,$export,$titre);
            }

            break;*/
      case $export=='AffectationsEtudiantsResponsable':
        if (isset($_GET["telecharger"])){
          header('Location: vue/ExportAffectationsEtudiantsResponsable.php');
        } else {
        $tabFinal=array();
        $tabFinalLigne=array();
          $titre="Affectations des Etudiants";
          array_push($tabFinalLigne,'Entreprise');
          array_push($tabFinalLigne,'Jury');
          array_push($tabFinalLigne,'Formation');
          array_push($tabFinalLigne,'Nom Etudiant');
          array_push($tabFinalLigne,'Heure');
          array_push($tabFinal, $tabFinalLigne);

          $planning=array();
          $planning=$this->dao->getPlanningResp($_SESSION['idUser']);
          foreach ($planning as $value) {
              if($value["nomEtu"]!='---'){    
            $tabFinalLigne=array();
                array_push($tabFinalLigne,$value["nomEnt"]);
                array_push($tabFinalLigne,$value["jurie"]);
                array_push($tabFinalLigne,$value["typeFormation"]);
                array_push($tabFinalLigne,strtoupper($value["nomEtu"]));
                array_push($tabFinalLigne,$value["heure"]);
                array_push($tabFinal, $tabFinalLigne);
          }
          }
          $this->vue->afficherPlanning($tabFinal,$export,$titre);
        }

        break;
    
      case $export=='CreneauxEntrepriseResponsable':
        if (isset($_GET["telecharger"])){
            header('Location: vue/ExportCreneauxEntrepriseResponsable.php');
          } else {
              $formation = $this->dao->getFormationsResponsableBis($_SESSION['idUser']);
              $tabFinal=array();
              
              $nb = count($formation);
              $cpt =0;
              $titre="Nombres de créneaux par entreprises";
              $tabFinalLigne=array();   
              array_push($tabFinalLigne,'Entreprise');
              array_push($tabFinalLigne,'Nb Total Creneaux');              
              array_push($tabFinal, $tabFinalLigne);
              if($nb == 1){
                $listes=$this->dao->getEntreprisesTotalCreneauxResponsable($formation[$cpt]['typeFormation']);
                foreach ($listes as $value) {
                $tabFinalLigne=array();
                  array_push($tabFinalLigne,$value["nomEnt"]);
                  array_push($tabFinalLigne,$value["nbCreneauxTotal"]);
                  if(!in_array($tabFinalLigne,$tabFinal)){
                    array_push($tabFinal, $tabFinalLigne);
                  }
                }
              }
              else{
              while($cpt<$nb){
                $listes=$this->dao->getEntreprisesTotalCreneauxResponsable($formation[$cpt]['typeFormation']);
                foreach ($listes as $value) {
                $tabFinalLigne=array();
                  array_push($tabFinalLigne,$value["nomEnt"]);
                  array_push($tabFinalLigne,$value["nbCreneauxTotal"]);
                  if(!in_array($tabFinalLigne,$tabFinal)){
                    array_push($tabFinal, $tabFinalLigne);
                  }
                }
              
                $cpt++;
              }
            }
            $this->vue->afficherPlanning($tabFinal,$export,$titre);
            }
            break;

  		case $export=='EtudiantChoixNonSatisfaitResp':
  			if (isset($_GET["telecharger"])){
            header('Location: vue/ExportEtudiantChoixNonSatisfaitResp.php');
          } else {
            $listes=$this->dao->getEntreprisesParResp($_SESSION['idUser']);
            $tabFinal=array();
            $tabFinalLigne=array();
            $titre="Etudiants non satisfaits";
            array_push($tabFinalLigne,'Formation');
            array_push($tabFinalLigne,'Numero Etu');
            array_push($tabFinalLigne,'Nom Etudiant');
            array_push($tabFinalLigne,'Entreprise');
            array_push($tabFinal, $tabFinalLigne);
            $formResp = $this->dao->getFormationsResponsable($_SESSION['idUser']);
            foreach ($listes as $value) {
            $temp=$this->dao->getEtudiantshorsPlan($value->getId());
            foreach($temp as $etuHP){
              $res = false;
              foreach($formResp as $tmpform){
                if($etuHP["formationEtu"] == $tmpform['typeFormation']){
                  $res = true;
                }
              }
              if($res){
                $tabFinalLigne=array();
                array_push($tabFinalLigne,$etuHP["formationEtu"]);
                array_push($tabFinalLigne,$etuHP["IDEtu"]);
                array_push($tabFinalLigne,strtoupper($etuHP["nomEtu"]));
                array_push($tabFinalLigne,$etuHP["nomEnt"]);
                array_push($tabFinal, $tabFinalLigne);
              }  
            } 
          }
            $this->vue->afficherPlanning($tabFinal,$export,$titre);
        }     
        break;

  		case $export=='EntResAffIns':
        if (isset($_GET["telecharger"])){
          header('Location: vue/ExportEntResAffInsResp.php');
            } else {
                $listes=$this->dao->getEntResAffInsResp($_SESSION["idUser"]);
                $tabFinal=array();
                $tabFinalLigne=array();
                $titre="Affectations, réservations et différences des rdv par entreprises";
                array_push($tabFinalLigne,'Entreprise');
                array_push($tabFinalLigne,'Type Formation');
                array_push($tabFinalLigne,'Creneaux Disponibles');
                array_push($tabFinalLigne,'Creneaux Reserves');
                array_push($tabFinalLigne,'Creneaux Affectes');
                array_push($tabFinalLigne,'Etudiants Inscrits');
                array_push($tabFinalLigne,'Difference inscrits & attendus');
                array_push($tabFinal, $tabFinalLigne);

                foreach ($listes as $value) {
                  $tabFinalLigne=array();
                  array_push($tabFinalLigne,$value["nomEnt"]);
                  array_push($tabFinalLigne,str_replace("_", " ", $value["typeFormation"]));
                  array_push($tabFinalLigne,$value["nbcreneauxReserves"]-$value["NBCreneauxAffectes"]);
                  array_push($tabFinalLigne,$value["nbcreneauxReserves"]);
                  array_push($tabFinalLigne,$value["NBCreneauxAffectes"]);
                  array_push($tabFinalLigne,$value["nbEtudinantsInscrits"]);
                  array_push($tabFinalLigne,($value["nbEtudinantsInscrits"]-$value["NBCreneauxAffectes"]));
                  array_push($tabFinal, $tabFinalLigne);
                }
              $this->vue->afficherPlanning($tabFinal,$export,$titre);
              }
              break;

  		case $export=='EtudiantChoixAffResp':
      if (isset($_GET["telecharger"])){
        header('Location: vue/ExportEtudiantChoixAffResp.php');
          } else {
              $listes=$this->dao->getEtudiantChoixAffResp($_SESSION['idUser']);
              $tabFinal=array();
              $tabFinalLigne=array();
              $titre="Choix et rdv des étudiants";
              array_push($tabFinalLigne,'Type Formation');
              array_push($tabFinalLigne,'NomEtu');
              array_push($tabFinalLigne,'Nb Choix');
              array_push($tabFinalLigne,'Nb rdv');
              array_push($tabFinalLigne,'Ecart');
              array_push($tabFinalLigne,'Téléphone');
              array_push($tabFinalLigne,'Mail');
              array_push($tabFinal, $tabFinalLigne);

              foreach ($listes as $value) {
                $tabFinalLigne=array();
                array_push($tabFinalLigne,$value["formationEtu"]);
                array_push($tabFinalLigne,strtoupper($value["nomEtu"]));
                array_push($tabFinalLigne,$value["NbChoix"]);
                array_push($tabFinalLigne,$value["Nbaffecte"]);
                array_push($tabFinalLigne,$value["NbChoix"]-$value["Nbaffecte"]);
                array_push($tabFinalLigne,$value["numtelEtu"]);
                array_push($tabFinalLigne,$value["mailEtu"]);
                array_push($tabFinal, $tabFinalLigne);
              }
            
            $this->vue->afficherPlanning($tabFinal,$export,$titre);
            }
        break;

      

  case $export=='DistCrFormEntr.php':
	    if (isset($_GET["telecharger"])){
	        header('Location: vue/ExportDistCrFormEntrResp.php');
	          } else {
	                $listes=$this->dao->getExportDistCrFormEntrResp($_SESSION["idUser"]);
                  $tabFinal=array();
	                $tabFinalLigne=array();
                  $titre="Créneaux des entreprises";
                  array_push($tabFinalLigne,'Entreprise');
                  array_push($tabFinalLigne,'Type Formation');
	                array_push($tabFinalLigne,'Début Creneaux');
	                array_push($tabFinalLigne,'Fin Creneaux');
	                array_push($tabFinal, $tabFinalLigne);

	                foreach ($listes as $value) {
                    $tabFinalLigne=array();
                    array_push($tabFinalLigne,$value["nomEnt"]);
	                  array_push($tabFinalLigne,$value["typeFormation"]);
	                  array_push($tabFinalLigne,$value["creneauDebut"]);
	                  array_push($tabFinalLigne,$value["creneauFin"]);
	                  array_push($tabFinal, $tabFinalLigne);
	                }
	              $this->vue->afficherPlanning($tabFinal,$export,$titre);
	              }
	        break;


    case $export == 'vueMonCompte.php':
      $resp = $this->dao->getResp($_SESSION['idUser']);
      $this->vueCompte->afficherMonCompte($resp);
          

          
          break;

  		case $export=='Planning':
      if (isset($_GET["telecharger"])){
                header('Location: vue/ExportPlanning.php');
                  } else {
                    $alljury= $this->dao->getjurie();
                    $Allformation = $this->dao->getFormationsResponsableBis($_SESSION['idUser']);
                    $listes = $this->dao->getListeCreneaux();
                    $i = 0;
                    foreach($Allformation as $form){
                      
                      $titre= $form [0];
                      $tabFinal=array();
                      $tabFinalLigne=array();
                      array_push($tabFinalLigne,"Entreprises");
                      array_push($tabFinalLigne,"Jury");
                      foreach ($listes as $heure){
                        array_push($tabFinalLigne, $heure);
                      }
                      array_push($tabFinal, $tabFinalLigne);

                      $tabFinalLigne=array();

                      $entreprises = $this->dao->getEntreprisesParFormation($form[0]);
                      foreach($entreprises as $ent)
                      {
                        $tabFinalLigne=array();
                        array_push($tabFinalLigne, $ent["nomEnt"]);
                        $idEnt = $ent['IDEnt'];
                        $idForm = $this->dao->getIDFormation($form['typeFormation'],$idEnt);
                        array_push($tabFinalLigne,$form['typeFormation']."- Jury : ".$alljury[$idForm]);


                        for($cpt = 0; $cpt < count($listes); $cpt++) {
                          $idEtu=$this->dao->getCreneau($cpt+1, $idForm);
                          if ($idEtu!=null) array_push($tabFinalLigne,strtoupper($this->dao -> getNomEtudiant($idEtu)));
                          else array_push($tabFinalLigne,"--------");
                        }


                        array_push($tabFinal, $tabFinalLigne);
                      }

                      if($i == 0)
                      {
                        $this->vue->afficherPlanning($tabFinal,$export,$titre);
                      }
                      else{
                        $this->vue->afficherTableau($tabFinal,$export,$titre);
                      }
                      $i++;
                    }
                      
                   
                    
                      /*$listes=$this->dao->getListeCreneaux();
                        $tabFinal=array();
                        $tabFinalLigne=array();
                        //laisser 2 colonnes avant les heures
                         array_push($tabFinalLigne, " ");
                         array_push($tabFinalLigne, " ");
                      foreach ($listes as $heure){
                        array_push($tabFinalLigne, $heure);
                      }
                        array_push($tabFinal, $tabFinalLigne);

                    $tabEnt = $this->dao->getAllEntreprises();
                      

                    
                    foreach ($tabEnt as $ent) {
                      $tabForm = $this->dao->getFormationsEntreprise($ent->getID());
                      foreach ($tabForm as $form) {
                        $tabFinalLigne=array();
                        //on note le nom de lent et la formation concernée
                        array_push($tabFinalLigne, $ent->getNomEnt());
                        array_push($tabFinalLigne,$form['typeFormation']."- Jury : ".$alljury[$form['IDformation']]);
                        //on recup le nb de creneaux en
                        //erreur 'info2-2015-jobda'@'%' does not exist --> 
                        //if ($form['typeFormation']!="info2-2015-jobda'@'%")$nbCreneaux=$this->dao->getNbCreneauxFormation($form['typeFormation']);
                        $idForm=$form['IDformation'];
                        //pour chaque formation recup num de case et id etu 
                        for($i = 0; $i < count($listes); $i++) {
                            $idEtu=$this->dao->getCreneau($i+1, $idForm);
                            if ($idEtu!=null) array_push($tabFinalLigne,utf8_decode($this->dao -> getNomEtudiant($idEtu)));
                            else array_push($tabFinalLigne,"--------"); 
                          }
                          
                          array_push($tabFinal, $tabFinalLigne);
                        }
                    }*/
                      
                      }
                break;


            default:
            echo $export;
            /*$allent = $this->dao->getEntreprisesParRespBis($_SESSION["idUser"]);
            $allforma = $this->dao->getListeFormations();
            $alletu = $this->dao->getAllEtudiants();*/
            $titre="Planning des entreprises";

            /*
            foreach ($allent as $value){

                if (is_int(strpos(strtoupper($value->getNomEnt()),strtoupper($_GET["export"])))){
                    //$tabrecherche[$value->getNomEnt()] = "ent";
                }
            }
            foreach ($allforma as $value){

                if (is_int(strpos(strtoupper($value->getInitiales()),strtoupper($_GET["export"])))){
                    //$tabrecherche[$value->getInitiales()] = "for";

                }
            }
            foreach ($alletu as $value){

                if (is_int(strpos(strtoupper($value->getNomEtu()),strtoupper($_GET["export"])))){
                    //$tabrecherche[$value->getNomEtu()] = "etu";

                }

            }*/

            $requete = "select * from planning where";

            if (!empty($tabrecherche)){
                $firsttime = true;
                $requete = $requete." (";



                foreach ($tabrecherche as $key => $value){


                    if ($firsttime == false){
                        $requete = $requete." or ";
                    }

                    if($value == "ent"){
                        $requete = $requete." (nomEnt='".$key."') ";
                    } else if ($value == "for"){
                        $requete = $requete." (typeFormation='".$key."') ";
                    } else if ($value == "etu"){
                        $requete = $requete." (nomEtu='".$key."') ";
                    }
                    $firsttime = false;
                }
                $requete = $requete.")  and";
            }

            $requete = $requete." nometu not like '---' and typeFormation IN (SELECT typeformation from formation where typeformation IN (Select typeformation from lienformationresp where IDresp = '".$_SESSION["idUser"]."')) order by 2,1,5;";

            $result = $this->dao->requete($requete);



            $tabFinal=array();
            $tabFinalLigne=array();
            array_push($tabFinalLigne,'Entreprise');
            array_push($tabFinalLigne,'Formation');
            array_push($tabFinalLigne,'Nom étudiant');
            array_push($tabFinalLigne,'Prénom étudiant');
            array_push($tabFinalLigne,'Heure');
            array_push($tabFinal, $tabFinalLigne);

            foreach ($result as $value){
                $tabFinalLigne=array();
                array_push($tabFinalLigne,$value["nomEnt"]);
                array_push($tabFinalLigne,$value["typeFormation"]);
                array_push($tabFinalLigne,$value["nomEtu"]);
                array_push($tabFinalLigne,$value["prenomEtu"]);
                array_push($tabFinalLigne,$value["heure"]);
                array_push($tabFinal, $tabFinalLigne);
            }



            if (isset($_GET["telecharger"])){
                header('Content-Type: text/cs');
                header('Content-Disposition: attachment; filename="Export Planning.csv"');

                foreach ($tabFinal as $ligne){
                    foreach ($ligne as $value){
                        echo '"'.$value.'";';
                    }
                    echo "\n";
                }
            } else {
                $this->vue->afficherPlanning($tabFinal,$export,$titre);
            }
        break;

  	}
  }
}
 ?>