<?php
//PROJET
require_once __DIR__."/../modele/dao/dao.php";


session_cache_limiter('none');
session_start();

header('Content-Type: text/cs');
header('Content-Disposition: attachment; filename="Export AffectationsEtudiants.csv"');
$dao = new Dao();

$listes=$dao->getPlanningResp($_SESSION['idUser']);
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
/*
if (!empty($listes))  {
  
  
  foreach ($listes as $value) {
            $temp=$dao->getEtuIns($value['IDEnt']);
            foreach($temp as $etuInscr){
              //$tabFinalLigne=array();
              // forme : "var";
                echo '"'.$etuInscr["formationEtu"].'";';
                echo '"'.$etuInscr["IDEtu"].'";';
                echo '"'.$etuInscr["nomEtu"].'";';
                echo '"'.$etuInscr["nomEnt"].'";';
                echo"\n";
            } 
          }
  */

/*
array_push($tabFinalLigne,$temp[$i]["formationEtu"]);
      array_push($tabFinalLigne,$temp[$i]["IDEtu"]);
      array_push($tabFinalLigne,$temp[$i]["nomEtu"]);
      array_push($tabFinalLigne,$temp[$i]["nomEnt"]);
      array_push($tabFinal, $tabFinalLigne);
      */    

////
?>

          
          
       