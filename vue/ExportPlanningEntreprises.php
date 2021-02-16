<?php 
require_once __DIR__."/../modele/dao/dao.php";
require_once __DIR__."/../modele/bean/Etudiant.php";
require_once __DIR__."/../modele/bean/Entreprise.php";
require_once __DIR__."/../modele/formationV2.php";


session_cache_limiter('none');
session_start();

header('Content-Type: text/cs');
          
if(isset($_SESSION["idEnt"]))
{
header('Content-Disposition: attachment; filename="Export_planning_'.$_SESSION["nomEnt"].'.csv"');
$dao = new Dao();
ECHO iconv('UTF-8', 'ISO-8859-1//TRANSLIT//IGNORE', $_SESSION["nomEnt"])."\n";
$HeureAprem=array("Jury","Formation","13:40", "14:00", "14:20", "14:40","15:00", "15:20","16:00","16:20","16:40","17:00", "17:20","17:40");
           echo '"'.$HeureAprem[0].'"';
           for($i = 1; $i <= 13; $i++) 
           {
           echo ';"'.$HeureAprem[$i].'"';

           } 
           echo "\n";

           $alljury= $dao->getjurie();
$listes = $dao->getListeCreneaux();
 
  $ent = $_SESSION["idEnt"];
  $Allformation = $dao->getFormationsEntreprise($ent);
  foreach($Allformation as $form){
      echo $alljury[$form[0]].";";
      echo $form[1].";";
      for($cpt = 0; $cpt < count($listes); $cpt++) {
          $idEtu=$dao->getCreneau($cpt, $form[0]);
      if (($idEtu)){
          echo strtoupper($dao->getNomEtudiant($idEtu)).";";
      }
      else{
          echo "---;";
      }
      }
  
      echo "\n";
  }
}
else{
  header('Content-Disposition: attachment; filename="Export_planning_entreprises.csv');
$dao = new Dao();

$AllEntreprises = $dao->getAllEntreprises();

      foreach($AllEntreprises as $entreprise)
      {
        $_SESSION["nomEnt"] = $entreprise->getNomEnt();
        $dao = new Dao();
        $nomEnt = iconv('UTF-8', 'ISO-8859-1//TRANSLIT//IGNORE', $_SESSION["nomEnt"]."\n");
ECHO $nomEnt;
$HeureAprem=array("Jury","Formation","13:40", "14:00", "14:20", "14:40","15:00", "15:20","16:00","16:20","16:40","17:00", "17:20","17:40");
           echo '"'.$HeureAprem[0].'"';
           for($i = 1; $i <= 13; $i++) 
           {
           echo ';"'.$HeureAprem[$i].'"';

           } 
           echo "\n";

           $alljury= $dao->getjurie();
$listes = $dao->getListeCreneaux();
 
  $ent = $entreprise->getId();
  $Allformation = $dao->getFormationsEntreprise($ent);
  foreach($Allformation as $form){
      echo $alljury[$form[0]].";";
      echo $form[1].";";
      for($cpt = 0; $cpt < count($listes); $cpt++) {
          $idEtu=$dao->getCreneau($cpt, $form[0]);
      if ($idEtu!=null){
          echo strtoupper($dao->getNomEtudiant($idEtu)).";";
      }
      else{
          echo "--------;";
      }
      }
  
      echo "\n";

  }
      }
}


/*
$alljury= $dao->getjurie();
$listes = $dao->getListeCreneaux();
      $i = 0;
      foreach($allent as $ent){
        $titre= $ent->getNomEnt();
        $tabFinal=array();
        $tabFinalLigne=array();
        array_push($tabFinalLigne,"Jury");
        array_push($tabFinalLigne,"Formation");
        foreach ($listes as $heure){
          array_push($tabFinalLigne, $heure);
        }

        array_push($tabFinal, $tabFinalLigne);
        $tabFinalLigne=array();
        
        $Allformation = $dao->getFormationsEntreprise($ent->getId());
        foreach($Allformation as $form){
          $tabFinalLigne = array();
          array_push($tabFinalLigne,$alljury[$form[0]]);
          array_push($tabFinalLigne,$form[1]);

          for($cpt = 0; $cpt < count($listes); $cpt++) {
            $idEtu=$dao->getCreneau($cpt, $form[0]);
            if ($idEtu!=null) array_push($tabFinalLigne,strtoupper($dao->getNomEtudiant($idEtu)));
            else array_push($tabFinalLigne,,"--------"););
          }
          
          array_push($tabFinal, $tabFinalLigne);

          
        }
    }*/
      