<?php
require_once __DIR__."/../modele/dao/dao.php";




header('Content-Type: text/cs');
header('Content-Disposition: attachment; filename="Export AffectationsEtudiants.csv"');
$dao = new Dao();

$listes=$dao->getPlanning();
$att1="Formation";
$att2="Nom Etudiant";
$att3="Prenom Etudiant";
$att4="Heure";
$att5="Entreprise";

echo '"'.$att1.'"';
echo ';"'.$att2.'"';
echo ';"'.$att3.'"';
echo ';"'.$att4.'"';
echo ';"'.$att5.'"';


echo "\n";

if (!empty($listes))  {
  
  
  foreach ($listes as $value) {
    if($value['nomEtu']!='---'){
      echo '"'.$value["typeFormation"].'";';
        echo '"'.strtoupper($value["nomEtu"]).'";';
        echo '"'.$value["prenomEtu"].'";';
        echo '"'.$value["heure"].'";';
        echo '"'.$value["nomEnt"].'";';
        echo"\n";
    }  
          }
  

}
?>

          
          
       