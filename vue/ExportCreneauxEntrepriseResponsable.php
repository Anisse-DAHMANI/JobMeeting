<?php
require_once __DIR__."/../modele/dao/dao.php";


session_cache_limiter('none');
session_start();

header('Content-Type: text/cs');
header('Content-Disposition: attachment; filename="Export_CreneauxEntrepriseResponsable.csv"');
$dao = new Dao();
//$listes=$dao->getEntreprisesTotalCreneaux();
$listes=$dao->getExportDistCrTotalFormEntrResp($_SESSION['idUser']);
  
   $att1="Formationn";
  $att2="Entreprise";
  $att3="NbTotalCreneaux";
 
  echo '"'.$att1.'"';
  echo ';"'.$att2.'"';
  echo ';"'.$att3.'"';

  echo "\n";
 
  if (!empty($listes))  {
  foreach($listes as $ent){
   
       if($ent["nomEnt"]==$tabent['nomEnt']){
		$nomFormation=$ent["typeFormation"];
        $nomEnt=$ent["nomEnt"];
        $NbCreneaux=$ent["nb total de creneaux"];
    
        echo '"'.$nomFormation.'"';
        echo '"'.$nomEnt.'"';
        echo ';"'.$NbCreneaux.'"';
    
        echo "\n";
       } 
    
    
  }
}
  
  ?>