<?php

class JobMeeting {
  var $CASE_VIDE = 0; //constante qui represente une case vide pour l'echiquiers
  var $Gauss = '0';
  var $nbChoixASatisfaire = 5;// au max est egal a la moitie des creneauxs
  var $Echiquier = array();
  var $Formations = array();

  var $Etudiants = array('Bourreau  ',	'Cadeau     ',	'Nussbaum   ', 'STEPHAN    ', 'Didier     ','Ganivet    ',  'Chcouropat ','Blin       ', 'Gautier    ',
    'Gonnord    ',	'Dubois     ',	'Grailard   ',	'Chappron   ',	'Cadorel    ',	'Creach     ');
  var $Choix = array(array(1,5,2,7,3,4), array(6,5,7,3,4,1), array(6,3,5,1,4,7), array(6,1,5,3,4,7),
array(1,5,6,3,4,7), array(1,4,7,3,6),  array(1,6,5,7,3,4), array(6,3,5,1,7,4), array(1,6,3,7,4,5),
array(6,7,1,5,3,4), array(3,6,5,1,4,7), array(1,7,3,6,5,4),array(7,6,5,1,3,4),
array(1,5,7,3,6,4), array(6,1,7,5,4,3));


  var $Entreprises = array('Capgemini', 'Test', 'Immostore', 'Agena3000', 'Speachme', 'Moovtime', 'PanierLoc');
  var $LiensEntrCren; /*= array(array(2,0,1), array(0), array(1,2), array(1,3), array(1,4), array(1,5), array(1,6));*/
  var $Creneaux; /*= array(array(2,2,2,2,2,2,2,2,2,2), array(1,1,1,1,1,1,1,1,1,1),
array(1,1,1,1,1,1,1,1,1,1), array(1,1,1,1,1,1,1,1,1,1), array(1,1,1,1,1,1,1,1,1,1), array(1,1,1,1,1,1,1,1,1,1));*/
  var $nbCreneaux = 10;
  var $nbStands = 0;

  var $satisfait = array();
  var $Max = 0;// un choix pour chaque ETUDIANT

  //Va peremttre de mémoriser si l'étudiant à déjà un entretient vace l'entreprise
  var $EntretiensEntrepriseEtudiant = array();

  function __construct($c_Etudiants, $c_Choix, $c_Entreprises, $c_Creneaux, $c_LiensEntrCren , $c_Formations, $c_nbCreneaux) {
    $this -> Etudiants = $c_Etudiants;
    $this -> Choix = $c_Choix;
    $this -> Entreprises = $c_Entreprises;
    $this -> Creneaux = $c_Creneaux;
    $this -> LiensEntrCren = $c_LiensEntrCren;
    $this -> Formations = $c_Formations;
    $this -> nbCreneaux = $c_nbCreneaux;
  }

  function appli() {
    
  }

  //Fonction qui va diviser les entreprises avec plusieurs créneaux simultané

  //Fonction qui va initialiser les tableaux Echiquier et Satisfait
  function initEchiquier(){
    
  }

  /* Place la ETUDIANT sur la ligne l et les suivantes recursivement
  /Place un etudiant
  /
  */
  function placeEtudiant($etu, $l) {
    
  }

  // Verifie qu'une ETUDIANT placee en (l,c) n'est pas en prise avec un des
  // ETUDIANTs deja placees.
  function bienPlace($etu, $l, $c, $entreprise) {
    //On vérifie que l'étudiant et libre, et qu'il a une pause avant ou après
   
  }

  

  function afficheEchiquier() { //Affichage en html, tableau
   
}
}

?>
