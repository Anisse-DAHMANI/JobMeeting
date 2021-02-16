<?php
require_once __DIR__."/../modele/dao/dao.php";


session_cache_limiter('none');
session_start();

header('Content-Type: text/cs');
header('Content-Disposition: attachment; filename="Export_CreneauxEntrepriseResponsable.csv"');
$dao = new Dao();
$listes=$dao->getEntreprisesTotalCreneaux();
  $tabfor = $dao -> getFormationsResponsableBis($_SESSION['idUser']);
  
  $att1="Entreprise";
  $att2="NbTotalCreneaux";
  echo '"'.$att1.'"';
  echo ';"'.$att2.'"';

  echo "\n";
  for($i=0;$i<count($tabfor);$i++) {
  $tabEnt = $dao -> getEntreprisesParFormation($tabfor[$i][0]);
  if (!empty($listes))  {
  foreach($listes as $ent){
    foreach($tabEnt as $tabent){
       if($ent["nomEnt"]==$tabent['nomEnt']){
        $nomEnt=$ent["nomEnt"];
        $NbCreneaux=$ent["nbCreneauxTotal"];
    
    
        echo '"'.$nomEnt.'"';
        echo ';"'.$NbCreneaux.'"';
    
        echo "\n";
       } 
    }
    
  }
}
  }
  ?>