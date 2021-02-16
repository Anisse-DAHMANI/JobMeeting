<?php 
require_once __DIR__."/../modele/dao/dao.php";
require_once __DIR__."/../modele/bean/Etudiant.php";
require_once __DIR__."/../modele/bean/Entreprise.php";
require_once __DIR__."/../modele/formationV2.php";

header('Content-Type: text/cs');
 header('Content-Disposition: attachment; filename="Export planning.csv"');
 $listeDepartement = array("LP IDEB", "LP SEICOM", "DUT GEII", "LP I2P", "DUT GMP", "LP IMOCP",
"LP D2M", "DUT SGM", "LP SIL", "DUT INFO", "LP MIAR", "LP LOGIQUAL", "DUT QLIO-2ans", "DUT QLIO-1an", "GRH");
  $dao = new Dao();
$HeureAprem=array(" "," ", " ", "13:40", "14:00", "14:20", "14:40","15:00", "15:20","16:00","16:20","16:40","17:00", "17:20","17:40");
           echo '"'.$HeureAprem[0].'"'.$HeureAprem[1];
           for($i = 2; $i <= 14; $i++) 
           {
           echo ';"'.$HeureAprem[$i].'"';

           } 
           echo "\n";
  



            $dao = new Dao();
	    $tabConfig = $dao->getConfiguration();
	    $tabEnt = $dao->getAllEntreprises();
            $nbCreneaux = $tabConfig["nbCreneauxAprem"] + $tabConfig["nbCreneauxMatin"];
	    $pauseMidi = $tabConfig["nbCreneauxMatin"];
             foreach ($tabEnt as $ent) {
		$tabForm = $dao -> getFormationsEntreprise($ent -> getID());
			foreach ($tabForm as $form) {
				echo '"'.$ent->getNomEnt().'"'.';"'.$form['typeFormation'].'"';
				
				for($i = 0; $i < $nbCreneaux; $i++) {
					if ($i == $pauseMidi) {
						echo ';';
					}
                                         
					echo ';"'.utf8_decode($dao -> getNomEtudiant($dao->getCreneau($i, $form['IDformation']))).'"';
					
				}
                              echo "\n";
			}
				
		}		
				
		         



?>
