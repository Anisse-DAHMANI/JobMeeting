<?php
require_once __DIR__."/../modele/dao/dao.php";
require_once __DIR__."/../modele/bean/Etudiant.php";
require_once __DIR__."/../modele/bean/Entreprise.php";
require_once __DIR__."/../modele/formationV2.php";


header('Content-Type: text/cs');
header('Content-Disposition: attachment; filename="Export EtudiantChoixNonSatisfait.csv"');
$dao = new Dao();

$listes=$dao->getAllIdEntreprises();
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
  
  
  foreach ($listes as $value) {
            $temp=$dao->getEtudiantshorsPlan($value['IDEnt']);
            foreach($temp as $etuHP){
              //$tabFinalLigne=array();
              // forme : "var";
                echo '"'.$etuHP["formationEtu"].'";';
                echo '"'.$etuHP["IDEtu"].'";';
                echo '"'.$etuHP["nomEtu"].'";';
                echo '"'.$etuHP["nomEnt"].'";';
                echo"\n";
            } 
          }
  

}







?>
