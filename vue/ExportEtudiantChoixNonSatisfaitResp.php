<?php
require_once __DIR__."/../modele/dao/dao.php";
require_once __DIR__."/../modele/bean/Etudiant.php";
require_once __DIR__."/../modele/bean/Entreprise.php";
require_once __DIR__."/../modele/formationV2.php";

session_cache_limiter('none');
session_start();

header('Content-Type: text/cs');
header('Content-Disposition: attachment; filename="Export EtudiantChoixNonSatisfait.csv"');
$dao = new Dao();

$listes=$dao->getEntreprisesParResp($_SESSION['idUser']);
$att1="Formation";
$att2="IDEtu";
$att3="NomEtu";
$att4="Entreprise";

echo '"'.$att1.'"';
echo ';"'.$att2.'"';
echo ';"'.$att3.'"';
echo ';"'.$att4.'"';

echo "\n";

if (!empty($listes))  {
  
  $formResp = $dao->getFormationsResponsable($_SESSION['idUser']);
  foreach ($listes as $value) {
    $temp=$dao->getEtudiantshorsPlan($value->getId());
    foreach($temp as $etuHP){
      $res = false;
      foreach($formResp as $tmpform){
        if($etuHP["formationEtu"] == $tmpform['typeFormation']){
          $res = true;
        }
      }
      if($res){
        echo '"'.$etuHP["formationEtu"].'";';
        echo '"'.$etuHP["IDEtu"].'";';
        echo '"'.strtoupper($etuHP["nomEtu"]).'";';
        echo '"'.$etuHP["nomEnt"].'";';
        echo"\n";
      } 
    }
  }
}








?>
