<?php

require_once("ConnexionException.php");
require_once("AccesTableException.php");
//require_once(__DIR__."/../algo.php");
require_once(__DIR__."/../formationV2.php");

/* Dans un path, utiliser '\..'' remonte d'un dossier. Sous windows
*/
class Dao
{
	protected $connexion;

	# # # # # # # # # # # # # #
	# SOMMAIRE  DES FONCTIONS #
	# # # # # # # # # # # # # #

	# connexion()
	# deconnexion()
	# getMotDePasse($login)
	# verifieMotDePasse($login, $password)
	# getTypeUtilisateur($login)
	# estInscrit($login)
	# ajoutEtudiant()
	# ajoutEntreprise()
	# getAllEtudiantsTemp()
	# getAllEtudiants()
	# getAllEntreprisesTemp()
	# getAllEntreprises()
	# validerEtudiant($id)
	# validerEntreprise($id)
	# gelerEtudiant($id)
	# gelerEntreprise($id)
	# supprimerEtu($id)
	# supprimerEtuTemp($id)
	# supprimerEnt($id)
	# supprimerEntTemp($id)
	# getEtu($id)
	# getTempEtu($id)
	# getEnt($id)
	# getTempEnt($id)
	# getConfiguration()
	# getNbCreneaux()
	# getNomEtudiant($IDEtu)
	# editHeureDebutMatin($new)
	# editHeureDebutAprem($new)
	# editNbCreneauxMatin($new)
	# editNbCreneauxAprem($new)
	# editDureeCreneau($new)
	# getEtudiants($formation)
	# getEntreprises()
	# getEntreprisesParFormation($formation)
	# getFormationEtudiant($id)
	# getEntreprisesEntreprise($formation) // depuis la table entreprise
	# getFormations($formation) // pour la table formation
	# getFormationsAffichage($entreprise)
	# getFormationsEntreprise($entreprise)
	# getIdEntreprise($entreprise)
	# getIDFormation($formation, $entreprise)
	# supprimerCreneau()
	# ajoutCreneau($numCreneau, $IDformation, $etudiant)
	# getCreneau($numeroCreneau, $idFormation)
	# ajoutFormation($typeFormation, $entPropose, $creneauDebut, $creneauFin)
	# getDetails()
	# getId($identifiant,$type)
	# generatePlanning()
	# editNomEntreprise($id,$new)
	# editVilleEntreprise($id,$new)
	# editCPEntreprise($id,$new)
	# editAdresseEntreprise($id,$new)
	# editNomContactEntreprise($id,$new)
	# editPrenomContactEntreprise($id,$new)
	# editMailEntreprise($id,$new)
	# editTelephoneEntreprise($id,$new)
	# editFormationsRechercheesEntreprise($id,$new)
	# editTypeCreneauEntreprise($id,$new)
	# editNbStandsEntreprise($id,$new)
	# editNbRepasEntreprise($id,$new)
	# editNbRecruteursEntreprise($id, $new)
	# editMdpEntreprise($id,$new,$old)
	# editNomEtudiant($id,$new)
	# editPrenomEtudiant($id,$new)
	# editMailEtudiant($id,$new)
	# editTelephoneEtudiant($id,$new)
	# editFormationEtudiant($id,$new)
	# editChoixEtudiant($id,$new)
	# editMdpEtudiant($id,$new,$old)
	# editDateDebutInscriptionEnt($new)
	# editDateDebutInscriptionEtu($new)
	# editDateFinInscription($new)
	# editDateFinInscriptionEnt($new)
	# editDateDebutVuePlanning($new)
	# supprimerFormation($idEntreprise)

	/**
	* Fonction qui permet d'ouvrir une connexion avec la base de données.
	*/
	public function connexion()
	{
		try
		{

$this->connexion = new PDO      ('mysql:host=localhost;charset=UTF8;dbname=jobmeeting',"root","");
			//new PDO      ('mysql:host=localhost;charset=UTF8;dbname=jobdating-2017',"admin-jm","adm@j0b");dasn le .fr de jobmeeting
			//$this->connexion = new PDO('mysql:host=localhost;charset=UTF8;dbname=info2-2015-jobdating',"info2-2015-jobda","jobdating");
			// $this->connexion = new PDO('mysql:host=localhost;charset=UTF8;dbname=info2-2015-jobdating',"root","root");
			// $this->connexion = new PDO('mysql:host=localhost;charset=UTF8;dbname=E164651T',"E164651T","E164651T");


			//on se connecte au sgbd
			$this->connexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);	//on active la gestion des erreurs et d'exceptions
		}
		catch(PDOException $e)
		{
			throw new PDOException("Erreur de connexion");
		}
		//connexion reussie
	}

	/**
	* Fonction qui permet la déconnexion à la base de données.
	*/
	public function deconnexion()
	{
		$this->connexion = null;
	}



	//PROJET
	public function getNbJury($nom){
		$this->connexion();
		$statement = $this->connexion->prepare('SELECT nbStands from entreprise WHERE IDEnt = (SELECT entPropose from formation where IDformation = ?);');
		$statement->bindParam(1,$nom);
		$statement->execute();
		return $statement->fetch();
		$this->deconnexion();
	}
	//


	/**
	*  Fonction qui permet d'obtenir un mot de passe dans la base associé à un certain login.
	* @param  String  $login le l'adresse mail de l'utilisateur.
	* @return String  le mot de passe de l'utilisateur.
	*/
	public function getMotDePasse($login)
	{
		$this->connexion();
		$statement = $this->connexion->prepare('SELECT mdpEtu FROM etudiant WHERE mailEtu = ?;');
		$statement->bindParam(1, $login);
		$statement->execute();
		$statementBis = $this->connexion->prepare('SELECT mdpEnt FROM entreprise WHERE mailEnt = ?;');
		$statementBis->bindParam(1, $login);
		$statementBis->execute();
		//PROJET
		$statementQuad = $this->connexion->prepare('SELECT mdpResp FROM responsable WHERE IDresp = ?;');
		$statementQuad->bindParam(1, $login);
		$statementQuad->execute();
		//
		$statementTer = $this->connexion->prepare('SELECT * FROM identificationadmin WHERE emailadmin = ?;');
		$statementTer->bindParam(1, $login);
		$statementTer->execute();
		$this->deconnexion();
		$tabResult = $statement->fetch();
		$tabResultBis = $statementBis->fetch();
		$tabResultTer = $statementTer->fetch();
		//PROJET
		$tabResultQuad = $statementQuad->fetch();
		//
		if (!is_null($tabResult['mdpEtu']))
		{
			return $tabResult['mdpEtu'];
		}
		elseif (!is_null($tabResultBis['mdpEnt']))
		{
			return $tabResultBis['mdpEnt'];
		}
		elseif (!is_null($tabResultTer['mdpadmin']))
		{
			return $tabResultTer['mdpadmin'];
		}
		//PROJET
		elseif (!is_null($tabResultQuad['mdpResp']))
		{
			return $tabResultQuad['mdpResp'];
		}
		//
		return NULL;
	}




	/**
	* méthode qui permet de vérifier si un login donné correspond bien au mot de passe passé en paramètre
	* (les mots de passe ont été cryptés dans la base avec crypt() en php)
	* @param  [type]  $login    [description]
	* @param  [type]  $password [description]
	* @return {[type]           [description]
	*/
	public function verifieMotDePasse($login, $password)
	{
		$mdp_get = $this->getMotDePasse($login);
		$mdp_test = crypt($password,$mdp_get);
		if ($mdp_test == $mdp_get && strpos($login, '"') == FALSE)
		{
			return TRUE;
		}
		return FALSE;
	}

	/**
	* Fonction qui permet d'obtenir le type de l'utilisateur en fonction du login.
	* @param  String  $login l'adresse mail de l'utilisateur.
	* @return String  le type de l'utilisateur (etudiant / entreprise / admin)
	*/
	public function getTypeUtilisateur($login)
	{
		$this->connexion();
		$statement = $this->connexion->prepare('SELECT * FROM etudiant WHERE mailEtu = ?;');
		$statement->bindParam(1, $login);
		$statement->execute();
		$statementBis = $this->connexion->prepare('SELECT * FROM entreprise WHERE mailEnt = ?;');
		$statementBis->bindParam(1, $login);
		$statementBis->execute();
		//PROJET
		$statementQuad = $this->connexion->prepare('SELECT * FROM responsable WHERE IDresp = ?;');
		$statementQuad->bindParam(1, $login);
		$statementQuad->execute();
		//
		$statementTer = $this->connexion->prepare('SELECT * FROM identificationadmin WHERE emailadmin = ?;');
		$statementTer->bindParam(1, $login);
		$statementTer->execute();
		$this->deconnexion();
		$tabResult = $statement->fetch();
		$tabResultBis = $statementBis->fetch();
		$tabResultTer = $statementTer->fetch();
		//PROJET
		$tabResultQuad = $statementQuad->fetch();
		//
		if (!is_null($tabResult['mdpEtu']))
		{
			return "etudiant";
		}
		elseif (!is_null($tabResultBis['mdpEnt']))
		{
			return "entreprise";
		}
		elseif (!is_null($tabResultTer['mdpadmin']))
		{
			return "admin";
		}
		//PROJET
		elseif (!is_null($tabResultQuad['mdpResp']))
		{
			//$cookie_name = "ID";
			//$cookie_value = $login;
			//setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
			//session_start();
			//$_SESSION['login'] = $login;
			//echo $_SESSION['login'];
			return "responsable";
		}
		//
	}

	/**
	* Fonction qui permet de savoir si le login correspond à un compte ou non.
	* @param  String  $login l'adresse mail de l'utilisateur.
	* @return boolean true si l'adresse mail est valide, false sinon.
	*/
	public function estValide($login)
	{

		$typeUser = $this->getTypeUtilisateur($login);
		if ($typeUser == "etudiant") {
			$typeMail = "mailEtu";
		}
		elseif ($typeUser == "entreprise") {
			$typeMail = "mailEnt";
		}
		elseif ($typeUser == "admin") {
			return true;
		}
		//PROJET
		elseif ($typeUser == "responsable") {
			$typeMail = "mailResp";
		}
		//
		else {
			return false;
		}
		$this->connexion();
		$statement = $this->connexion->prepare('SELECT * FROM '.$typeUser.' WHERE '.$typeMail.'="'.$login.'";');
		$statement->bindParam(1, $typeUser);
		$statement->bindParam(1, $typeMail);
		$statement->bindParam(1, $login);
		$statement->execute();
		$tabResult = $statement->fetch();
		if (isset($tabResult['IDEnt']) || isset($tabResult['IDEtu']) || isset($tabResult['IDresp']))
		{
			return true;
		}
		return false;
	}

	/**
	* Fonction qui permet de savoir si le login correspond à un utilisateur inscrit.
	* @param  String  $login l'adresse mail de l'utilisateur.
	* @return boolean true si l'adresse mail est valide, false sinon.
	*/
	public function estInscrit($login)
	{
		$this->connexion();
		$statement = $this->connexion->prepare('SELECT * FROM etudiant WHERE mailEtu="'.$login.'";');
		$statement->execute();
		$statementBis = $this->connexion->prepare('SELECT * FROM entreprise WHERE mailEnt="'.$login.'";');
		$statementBis->execute();
		//PROJET
		$statementQuad = $this->connexion->prepare('SELECT * FROM responsable WHERE IDresp="'.$login.'";');
		$statementQuad->execute();
		//
		$statementTer = $this->connexion->prepare('SELECT * FROM identificationadmin WHERE emailadmin="'.$login.'";');
		$statementTer->execute();
		$this->deconnexion();
		$tabResult = $statement->fetch();
		$tabResultBis = $statementBis->fetch();
		$tabResultTer = $statementTer->fetch();
		//PROJET
		$tabResultQuad = $statementQuad->fetch();
		//
		if (!is_null($tabResult['mdpEtu']))
		{
			return TRUE;
		}
		elseif (!is_null($tabResultBis['mdpEnt']))
		{
			return TRUE;
		}
		elseif (!is_null($tabResultTer['mdpadmin']))
		{
			return TRUE;
		}
		//PROJET
		elseif (!is_null($tabResultQuad['mdpResp']))
		{
			return TRUE;
		}
		//
		return FALSE;
	}


	/**
	* Fonction qui permet d'ajouter un étudiant dans la table temporaire tmpEtu.
	* @return boolean true si l'ajout a bien été effectué, false sinon.
	*/
	public function ajoutEtudiant()
	{
		try
		{
			$this->connexion();
			$statement = $this->connexion->prepare('SELECT mailEtu from temp_etudiant WHERE mailEtu="'.$_POST['email'].'";');
			$statement->execute();
			$this->deconnexion();
			$taille = $statement->rowCount();
			if ($taille!=0)
			{
				return false;
			}
			$this->connexion();
			$statement = $this->connexion->prepare('SELECT mailEtu from etudiant WHERE mailEtu="'.$_POST['email'].'";');
			$statement->execute();
			$this->deconnexion();
			$taille = $statement->rowCount();
			if ($taille!=0)
			{
				return false;
			}
			$this->connexion();
			$statement = $this->connexion->prepare('SELECT mailEnt from temp_entreprise WHERE mailEnt="'.$_POST['email'].'";');
			$statement->execute();
			$this->deconnexion();
			$taille = $statement->rowCount();
			if ($taille!=0)
			{
				return false;
			}
			$this->connexion();
			$statement = $this->connexion->prepare('SELECT mailEnt from entreprise WHERE mailEnt="'.$_POST['email'].'";');
			$statement->execute();
			$this->deconnexion();
			$taille = $statement->rowCount();
			if ($taille!=0)
			{
				return false;
			}
			$this->connexion();
			$statement = $this->connexion->prepare('SELECT emailadmin from identificationadmin WHERE emailadmin="'.$_POST['email'].'";');
			$statement->execute();
			$this->deconnexion();
			$taille = $statement->rowCount();
			if ($taille!=0)
			{
				return false;
			}
			$prenomEtu = $_POST['prenom'];
			$nomEtu = $_POST['nom'];
			$numtelEtu = $_POST['tel'];
			$formationEtu = $_POST['formation'];
			$mailEtu = $_POST['email'];
			$salt = chr(rand(48, 122)) ;
			for ($i = 0 ; $i < 11 ; $i++)  //le "salt" sert à chiffrer le mot de passe, ici on va lui passer une chaine de 11 caractères (+ le premier caractère d'initialisation, ligne précédente)
			{
				$salt .= chr(rand(48, 122)) ; //les caractères en question sont les codes ascii de chiffres et de lettres générés aléatoirement
			}
			$mdpEtu = crypt($_POST['password'], "$6$".$salt) ; //On chiffre le mot de passe à l'aide du sel ("$salt") créé ci-dessus
			//$mdpEtu = crypt($_POST['password']);
			$this->connexion();
			$statement = $this->connexion->prepare('INSERT INTO temp_etudiant (nomEtu,prenomEtu,mailEtu,mdpEtu,numtelEtu,formationEtu) VALUES (?, ?, ?, ?, ?, ?);');
			$statement->bindParam(1, $nomEtu);
			$statement->bindParam(2, $prenomEtu);
			$statement->bindParam(3, $mailEtu);
			$statement->bindParam(4, $mdpEtu);
			$statement->bindParam(5, $numtelEtu);
			$statement->bindParam(6, $formationEtu);
			$statement->execute();
			$this->deconnexion();
			return TRUE;
		}
		catch(PDOException $e)
		{
			print($e->getMessage());
		}
	}

	/**
	* Fonction qui permet d'ajouter une entreprise dans la table temporaire tmpEnt.
	* @return boolean true si l'ajout a bien été effectué, false sinon.
	*/
	public function ajoutEntreprise()
	{
		try
		{
			$this->connexion();
			$statement = $this->connexion->prepare('SELECT mailEtu from etudiant WHERE mailEtu="'.$_POST['email'].'";');
			$statement->execute();
			$this->deconnexion();
			$taille = $statement->rowCount();
			if ($taille!=0) {
				return false;
			}
			$this->connexion();
			$statement = $this->connexion->prepare('SELECT mailEnt from temp_entreprise WHERE mailEnt="'.$_POST['email'].'";');
			$statement->execute();
			$this->deconnexion();
			$taille = $statement->rowCount();
			if ($taille!=0) {
				return false;
			}
			$this->connexion();
			$statement = $this->connexion->prepare('SELECT mailEnt from entreprise WHERE mailEnt="'.$_POST['email'].'";');
			$statement->execute();
			$this->deconnexion();
			$taille = $statement->rowCount();
			if ($taille!=0) {
				return false;
			}
			$this->connexion();
			$statement = $this->connexion->prepare('SELECT emailadmin from identificationadmin WHERE emailadmin="'.$_POST['email'].'";');
			$statement->execute();
			$this->deconnexion();
			$taille = $statement->rowCount();
			if ($taille!=0) {
				return false;
			}
			$this->connexion();
			$statement = $this->connexion->prepare('SELECT nomEnt from temp_entreprise WHERE nomEnt="'.strtoupper($_POST['nomSociete']).'";');
			$statement->execute();
			$this->deconnexion();
			$taille = $statement->rowCount();
			if ($taille!=0) {
				return false;
			}
			$nomEnt = strtoupper($_POST['nomSociete']);
			$salt = chr(rand(48, 122)) ;
			for ($i = 0 ; $i < 11 ; $i++)  //le "salt" sert à chiffrer le mot de passe, ici on va lui passer une chaine de 11 caractères (+ le premier caractère d'initialisation, ligne précédente)
			{
				$salt .= chr(rand(48, 122)) ; //les caractères en question sont les codes ascii de chiffres et de lettres générés aléatoirement
			}
			$mdpEnt = crypt($_POST['password'], "$6$".$salt) ; //On chiffre le mot de passe à l'aide du sel ("$salt") créé ci-dessus

			$typeCreneau = $_POST['disponibilite'];
			$i = 0;
			$formationsRecherchees = "";
			$listeFormations = $this->getListeFormations();
			while ($i < sizeof($listeFormations))
			{
				if (isset($_POST['formation'][$i]))
				{
					$formationsRecherchees = $formationsRecherchees.$_POST['formation'][$i];
					$i++;
					while ($i < sizeof($listeFormations))
					{
						if (isset($_POST['formation'][$i]))
						{
							$formationsRecherchees = $formationsRecherchees.",";
							$formationsRecherchees = $formationsRecherchees.$_POST['formation'][$i];
						}
						$i++;
					}
				}
				$i++;
			}
			if (substr($formationsRecherchees, -1) == ",")
			{
				$formationsRecherchees = substr($formationsRecherchees, 0, -1);
			}
			$nbPlaces = $_POST['NbAlternants'];
			if (isset($_POST['dejeuner']))
			{
				if ($_POST['dejeuner'] == "dejeuner_ok")
				{
					$nbRepas = $_POST['NbRepas'];
				}
				else
				{
					$nbRepas = 0;
				}
			}
			else
			{
				$nbRepas = 0;
			}
			if (empty($_POST['offre_txt'])) {
				$_POST['offre_txt'] = null;
			}
			$caractere_a_remplacer = array("'");
			$caractere_remplacant = array("\'");
			$_POST['offre_txt'] = str_replace($caractere_a_remplacer,$caractere_remplacant,$_POST['offre_txt']);
			$offre = $_POST['offre_txt'];
			$mailEnt = $_POST['email'];
			$nomContact = $_POST['nom'];
			$prenomContact = $_POST['prenom'];
			$numTelEnt = $_POST['tel'];
			$codePostal = $_POST['codePostal'];
			$villeEnt = $_POST['ville'];
			$adresseEnt = $_POST['adresse'];
			$nbStands = $_POST['NbStand'];
			$nbRecruteurs = $_POST['NbRecruteurs'];
			if ($nbRecruteurs < $nbStands)
			{
				$nbStands = $nbRecruteurs;
			}
			$this->connexion();
			$statement = $this->connexion->prepare('INSERT INTO temp_entreprise (nomEnt,mdpEnt,typeCreneau,formationsRecherchees,nbRecruteurs,nbPlaces,nbStands,nbRepas,
				mailEnt,nomContact,prenomContact,numTelEnt,codePostal,villeEnt,adresseEnt,offre) VALUES ("'.$nomEnt.'","'.$mdpEnt.'","'.$typeCreneau.'","'.$formationsRecherchees.'"
				,'.$nbRecruteurs.','.$nbPlaces.','.$nbStands.','.$nbRepas.',"'.$mailEnt.'","'.$nomContact.'","'.$prenomContact.'","'.$numTelEnt.'","'.$codePostal.'","'.$villeEnt.'","'.$adresseEnt.'","'.$offre.'");');
				$statement->execute();
				$this->deconnexion();
				$idEnt = $this->getIdEntreprise($nomEnt);
				$tabConfig = $this->getConfiguration();
				$this->deconnexion();
				return true;
			}
			catch(PDOException $e)
			{
				print($e->getMessage());
			}
		}

		/**
		* Fonction qui retourne l'ensemble des étudiants inscrits dans la table temporaire (inscription pas encore validée).
		* @return array(Etudiant) un tableau d'étudiants.
		*/
		public function getAllEtudiantsTemp() {
			$this->connexion();
			$statement = $this->connexion->prepare('SELECT * from temp_etudiant order by formationEtu, nomEtu;');
			$statement->execute();
			return $statement->fetchAll(PDO::FETCH_CLASS, "Etudiant");
		}

		/**
		* Fonction qui retourne l'ensemble des étudiants inscrits dans la table etudiant (inscription validée).
		* @return array(Etudiant) un tableau d'étudiants.
		*/
		public function getAllEtudiants() {
			$this->connexion();
			$statement = $this->connexion->prepare('SELECT * from etudiant order by formationEtu, nomEtu;');
			$statement->execute();
			$this->deconnexion();
			return $statement->fetchAll(PDO::FETCH_CLASS, "Etudiant");
		}
		//PROJET
		/**
		* Fonction permettant de recupérer tous les responsables de la table responsable.
		* @return array(Responsable) un tableau de responsable.
		*/
		public function getAllResp() {
			$this->connexion();
			$statement = $this->connexion->prepare('SELECT * from responsable;');
			$statement->execute();
			$this->deconnexion();
			return $statement->fetchAll(PDO::FETCH_CLASS, "Responsable");
		}

		/**
		* Fonction permettant de recupérer tous les responsables de la table temp_responsable.
		* @return array(Responsable) un tableau de responsable.
		*/
		public function getAllRespTemp() {
			$this->connexion();
			$statement = $this->connexion->prepare('SELECT * from temp_responsable;');
			$statement->execute();
			$this->deconnexion();
			return $statement->fetchAll(PDO::FETCH_CLASS, "Responsable");
		}
		//
		public function getAllEtudiantsTempFormation($formation) {
			$this->connexion();
			$statement = $this->connexion->prepare('SELECT * from temp_etudiant where formationEtu = ?;');
			$statement->bindParam(1, $formation);
			$statement ->execute();
			$this->deconnexion();
			return $statement->fetchAll(PDO::FETCH_CLASS, "Etudiant");
		}
		/**
		* Fonction permettant de recupérer tous les étudiants de la table temp_etudiant lié au responsable.
		* @param responsable : c'est l'ID du responsable
		* @return array(Etudiant) un tableau d'etudiant.
		*/
		public function getAllEtudiantsTempResponsable($responsable) {
			$this->connexion();
			$statement = $this->connexion->prepare('SELECT * from temp_etudiant where formationEtu IN (SELECT typeformation FROM lienformationresp WHERE IDresp = ?);');
			$statement->bindParam(1, $responsable);
			$statement ->execute();
			$this->deconnexion();
			return $statement->fetchAll(PDO::FETCH_CLASS, "Etudiant");
		}
		//
		/**
		* Fonction qui retourne l'ensemble des entreprises inscrites dans la table temporaire (inscription pas encore validée).
		* @return array(Entreprise) un tableau d'entreprises.
		*/
		public function getAllEntreprisesTemp() {
			$this->connexion();
			$statement = $this->connexion->prepare('SELECT * from temp_entreprise order by nomEnt;');
			$statement->execute();
			$this->deconnexion();
			return $statement->fetchAll(PDO::FETCH_CLASS, "Entreprise");
		}

		/**
		* Fonction qui retourne l'ensemble des entreprises inscrites dans la table entreprise (inscription validée).
		* @return array(Entreprise) un tableau d'entreprises.
		*/
		public function getAllEntreprises() {
			$this->connexion();
			$statement = $this->connexion->prepare('SELECT * from entreprise order by nomEnt;');
			$statement->execute();
			$this->deconnexion();
			return $statement->fetchAll(PDO::FETCH_CLASS, "Entreprise");
		}

		/**
		* Fonction qui permet de valider l'inscription d'un étudiant (transfert table temp_etudiant -> Etudiant)
		* @param  String  $id l'identifiant de l'étudiant.
		*/
		public function validerEtudiant($id) {
			$this->connexion();
			$statement = $this->connexion->prepare('INSERT INTO etudiant(nomEtu,prenomEtu,mailEtu,mdpEtu,numtelEtu,formationEtu,listechoixEtu) SELECT nomEtu,prenomEtu,mailEtu,mdpEtu,numtelEtu,formationEtu,listechoixEtu FROM temp_etudiant WHERE IDEtu = '.$id.';');
			$statement->execute();
			$this->deconnexion();


			$this->connexion();
			$statement = $this->connexion->prepare('DELETE FROM temp_etudiant WHERE IDEtu = ?;');
			$statement->bindParam(1, $id);
			$statement ->execute();
			$this->deconnexion();
			return;
		}

		/**
		* Fonction qui permet de valider l'inscription d'une entreprise (transfert table temp_entreprise -> Entreprise)
		* @param  String  $id l'identifiant de l'entreprise.
		*/
		public function validerEntreprise($id)
		{
			$this->connexion();
			$statement = $this->connexion->prepare('INSERT INTO entreprise(nomEnt,mdpEnt,typeCreneau,formationsRecherchees,nbRecruteurs,nbPlaces,nbStands,nbRepas,
				mailEnt,nomContact,prenomContact,numTelEnt,codePostal,villeEnt,adresseEnt,offre, visioEnt) SELECT nomEnt,mdpEnt,typeCreneau,formationsRecherchees,nbRecruteurs,nbPlaces,nbStands,nbRepas,
				mailEnt,nomContact,prenomContact,numTelEnt,codePostal,villeEnt,adresseEnt,offre, visioEnt FROM temp_entreprise WHERE IDEnt = ?;');
				$statement->bindParam(1, $id);
				$statement->execute();
				$statement = $this->connexion->prepare('DELETE FROM temp_entreprise WHERE IDEnt = ?;');
				$statement->bindParam(1, $id);
				$statement->execute();
				$statement = $this->connexion->prepare('SELECT * FROM entreprise ORDER BY IDEnt DESC LIMIT 1;');
				$statement->execute();
				$ent = $statement->fetch();
				$this->deconnexion();
				$tabConfig = $this->getConfiguration();
				$idEnt = $ent['IDEnt'];
				$formationsRecherchees = $ent['formationsRecherchees'];
				$nbStands = $ent['nbStands'];
				$disponibilite = $ent['typeCreneau'];
				$creationFormation = new Formation($idEnt, $formationsRecherchees, $nbStands, $disponibilite, $tabConfig['nbCreneauxMatin'], $tabConfig['nbCreneauxAprem']);
				$creationFormation->createForm();
				return;
			}

			/**
			* Fonction qui permet de geler l'inscription d'un étudiant (transfert table Etudiant -> temp_etudiant)
			* @param  int  $id l'identifiant de l'étudiant
			*/
			public function gelerEtudiant($id)
			{
				$this->connexion();
				$statement = $this->connexion->prepare('INSERT INTO temp_etudiant(nomEtu,prenomEtu,mailEtu,mdpEtu,numtelEtu,formationEtu,listechoixEtu) SELECT nomEtu,prenomEtu,mailEtu,mdpEtu,numtelEtu,formationEtu,listechoixEtu FROM etudiant WHERE IDEtu = ?;');
				$statement->bindParam(1, $id);
				$statement->execute();
				$this->deconnexion();

				$this->connexion();
				$statement = $this->connexion->prepare('DELETE FROM etudiant WHERE IDEtu = ?;');
				$statement->bindParam(1, $id);
				$statement->execute();
				$this->deconnexion();
				return;
			}

			/**
			* Fonction qui permet de geler l'inscription d'une entreprise (transfert table Entreprise -> temp_entreprise)
			* @param  String  $id l'identifiant de l'entreprise.
			*/
			public function gelerEntreprise($id)
			{
				$this->connexion();
				$statement = $this->connexion->prepare('INSERT INTO temp_entreprise(nomEnt,mdpEnt,typeCreneau,formationsRecherchees,nbRecruteurs,nbPlaces,nbStands,nbRepas,
					mailEnt,nomContact,prenomContact,numTelEnt,codePostal,villeEnt,adresseEnt) SELECT nomEnt,mdpEnt,typeCreneau,formationsRecherchees,nbRecruteurs,nbPlaces,nbStands,nbRepas,
					mailEnt,nomContact,prenomContact,numTelEnt,codePostal,villeEnt,adresseEnt FROM entreprise WHERE IDEnt = ?;');
					$statement->bindParam(1, $id);
					$statement->execute();
					$this->deconnexion();
					$this->connexion();
					$statement = $this->connexion->prepare('DELETE FROM entreprise WHERE IDEnt = ?;');
					$statement->bindParam(1, $id);
					$statement->execute();
					$statement = $this->connexion->prepare('DELETE FROM formation WHERE entPropose = ?;');
					$statement->bindParam(1, $id);
					$statement->execute();
					$this->deconnexion();
					return;
				}

				/**
				* Fonction permettant de supprimer un étudiant présent dans la table etudiant.
				* @param  String  $id l'identifiant de l'étudiant.
				*/
				public function supprimerEtu($id)
				{
					$this->connexion();
					$statement = $this->connexion->prepare('DELETE FROM etudiant WHERE IDEtu = ?;');
					$statement->bindParam(1, $id);
					$statement->execute();
					$this->deconnexion();
					return;
				}


				/**
				* Fonction permettant de supprimer un étudiant présent dans la table temp_etudiant.
				* @param  String  $id l'identifiant de l'étudiant.
				*/
				public function supprimerEtuTemp($id)
				{
					$this->connexion();
					$statement = $this->connexion->prepare('DELETE FROM temp_etudiant WHERE IDEtu = ?;');
					$statement->bindParam(1, $id);
					$statement->execute();
					$this->deconnexion();
					return;
				}


				/**
				* Fonction permettant de supprimer une entreprise présente dans la table entreprise.
				* @param  String  $id l'identifiant de l'entreprise.
				*/
				public function supprimerEnt($id) {
					$this->connexion();
					$statement = $this->connexion->prepare('DELETE FROM entreprise WHERE IDEnt = ?');
					$statement->bindParam(1, $id);
					$statement->execute();
					$statement = $this->connexion->prepare('DELETE FROM formation WHERE entPropose = ?');
					$statement->bindParam(1, $id);
					$statement->execute();
					$this->deconnexion();
					return;
				}

				/**
				* Fonction permettant de supprimer une entreprise présente dans la table temp_entreprise.
				* @param  String  $id l'identifiant de l'entreprise.
				*/
				public function supprimerEntTemp($id) {
					$this->connexion();
					$statement = $this->connexion->prepare('DELETE FROM temp_entreprise WHERE IDEnt = ?;');
					$statement->bindParam(1, $id);
					$statement->execute();
					$this->deconnexion();
					return;
				}

				/**
				* Fonction qui permet de retourner un étudiant présent dans la table etudiant.
				* @param  String $id l'identifiant de l'étudiant.
				* @return Etudiant l'étudiant concerné.
				*/
				public function getEtu($id) {
					$this->connexion();
					$statement = $this->connexion->prepare('SELECT * FROM etudiant WHERE IDEtu = ?;');
					$statement->bindParam(1, $id);
					$statement->execute();
					$this->deconnexion();
					return $statement->fetchAll(PDO::FETCH_CLASS, "Etudiant");
				}
                //PROJET
				/**
				* Fonction qui permet de retourner un responsable présent dans la table responsable.
				* @param  String $id l'identifiant du responsable.
				* @return Responsable le responsable concerné.
				*/
				public function getResp($id) {
					$this->connexion();
					$statement = $this->connexion->prepare('SELECT * FROM responsable WHERE IDresp = ?;');
					$statement->bindParam(1, $id);
					$statement->execute();
					$this->deconnexion();
					return $statement->fetchAll(PDO::FETCH_CLASS, "Responsable");
				}
				//

				/**
				* Fonction qui permet de retourner un étudiant présent dans la table etudiant.
				* @param  String $id l'identifiant de l'étudiant.
				* @return Etudiant l'étudiant concerné.
				*/
				public function getMailEtu($id) {
					$this->connexion();
					$statement = $this->connexion->prepare('SELECT mailEtu FROM etudiant WHERE IDEtu = ?;');
					$statement->bindParam(1, $id);
					$statement->execute();
					$this->deconnexion();
					$res = $statement->fetch();
					return $res['mailEtu'];
				}

				/**
				* Fonction qui permet de retourner un étudiant présent dans la table temp_etudiant.
				* @param  String $id l'identifiant de l'étudiant.
				* @return Etudiant l'étudiant concerné.
				*/
				public function getTempEtu($id) {
					$this->connexion();
					$statement = $this->connexion->prepare('SELECT * FROM temp_etudiant WHERE IDEtu = ?;');
					$statement->bindParam(1, $id);
					$statement->execute();
					$this->deconnexion();
					return $statement->fetchAll(PDO::FETCH_CLASS, "Etudiant");
				}

				/**
				* Fonction qui permet de retourner une entreprise présente dans la table entreprise.
				* @param  String $id l'identifiant de l'entreprise.
				* @return Entreprise l'entreprise concernée.
				*/
				public function getEnt($id) {
					$this->connexion();
					$statement = $this->connexion->prepare('SELECT * FROM entreprise WHERE IDEnt = ?;');
					$statement->bindParam(1, $id);
					$statement->execute();
					$this->deconnexion();
					return $statement->fetchAll(PDO::FETCH_CLASS, "Entreprise");
				}

				/**
				* Fonction qui permet de retourner un tableau des formation rechercher par une entreprise.
				* @param  String $id l'identifiant de l'entreprise.
				* @return Tableau des formations que recherche l'entreprise.
				*/
				public function getEntFormationrechercher($id) {
					$this->connexion();
					$statement = $this->connexion->prepare('SELECT formationsRecherchees FROM entreprise WHERE IDEnt = ?;');
					$statement->bindParam(1, $id);
					$statement->execute();
					$this->deconnexion();
					return explode(",",$statement->fetchColumn());
				}

				/**
				* Fonction qui permet de retourner une entreprise présente dans la table temp_entreprise.
				* @param  String $id l'identifiant de l'entreprise.
				* @return Entreprise l'entreprise concernée.
				*/
				public function getTempEnt($id) {
					$this->connexion();
					$statement = $this->connexion->prepare('SELECT * FROM temp_entreprise WHERE IDEnt = ?;');
					$statement->bindParam(1, $id);
					$statement->execute();
					$this->deconnexion();
					return $statement->fetchAll(PDO::FETCH_CLASS, "Entreprise");
				}


				/**
				* Fonction qui retourne l'ensemble des paramètres relatifs à l'évènement.
				* @return array(String) un tableau d'informations.
				*/
				public function getConfiguration()
				{
					try
					{
						$this->connexion();
						$statement = $this->connexion->prepare('SELECT * FROM scriptconfig;');
						$statement->execute();
						$this->deconnexion();
						return $statement->fetch();
					}
					catch (AccesTableException $e)
					{
						print($e -> getMessage());
					}
				}


				/**
				* Fonction qui retourne le nombre de créneaux du matin et de l'après-midi.
				* @return array(int,int) un tableau (nombreCreneauxMatin,nombreCreneauxAprèsMidi).
				*/


				public function getNbCreneaux()
				{
					try {
						$this->connexion();
						$statement = $this->connexion->prepare('SELECT nbCreneauxMatin, nbCreneauxAprem FROM scriptconfig;');
						$statement->execute();
						$tabResult = $statement->fetch();
						$ret[0] = $tabResult['nbCreneauxMatin'];
						$ret[1] = $tabResult['nbCreneauxAprem'];
						$this->deconnexion();
						return $ret;
					}
					catch (AccesTableException $e)
					{
						print($e -> getMessage());
					}
				}

				/**
				* Fonction qui permet d'accéder au nom d'un étudiant.
				* @param  String $IDEtu l'identifiant de l'étudiant.
				* @return String le nom de l'étudiant.
				*/
				public function getNomEtudiant($IDEtu)
				{
					try
					{
						$this->connexion();
						$statement = $this->connexion->prepare('SELECT nomEtu FROM etudiant WHERE IDEtu = ?;');
						$statement->bindParam(1, $IDEtu);
						$statement->execute();
						$this->deconnexion();
						if ($result = $statement->fetch())
						{
							return $result['nomEtu'];
						}
						else
						{
							return "-----------";
						}
					}
					catch (AccesTableException $e)
					{
						print($e -> getMessage());
					}
				}


				/**
				* Fonction qui permet d'éditer l'heure de début de l'évènement, le matin.
				* @param  String  $new la nouvelle heure à appliquer.
				*/
				public function editHeureDebutMatin($new) {
					$this->connexion();
					$statement = $this->connexion->prepare("UPDATE scriptconfig SET heureDebutMatin = ?;");
					$statement->bindParam(1, $new);
					$statement->execute();
					$this->deconnexion();
					$this->updateHeureCreneau();
					return;
				}


				/**
				* Fonction qui permet d'éditer l'heure de début de l'évènement, l'après-midi.
				* @param  String  $new la nouvelle heure à appliquer.
				*/
				public function editHeureDebutAprem($new) {
					$this->connexion();
					$statement = $this->connexion->prepare("UPDATE scriptconfig SET heureDebutAprem = ?;");
					$statement->bindParam(1, $new);
					$statement->execute();
					$this->deconnexion();
					$this->updateHeureCreneau();
					return;
				}

				/**
				* Fonction qui permet d'éditer le nombre de créneaux disponibles le matin.
				* @param  int  $new le nouveau nombre de créneaux le matin.
				*/
				public function editNbCreneauxMatin($new)
				{
					$this->connexion();
					$statement = $this->connexion->prepare("UPDATE scriptconfig SET nbCreneauxMatin = ?;");
					$statement->bindParam(1, $new);
					$statement->execute();
					$this->deconnexion();
					$this->updateHeureCreneau();
					if (isset($_SESSION['type_modification']))
					{
						if ($_SESSION['type_modification'] == "tmpEnt")
						{
							return;
						}
						else
						{
							$classFormation = "Formation";
							$classFormation::updateFormation($id);
							return;
						}
					}
				}

				/**
				* Fonction qui permet d'éditer le nombre de créneaux disponibles l'après midi.
				* @param  int  $new le nouveau nombre de créneaux l'après midi.
				*/
				public function editNbCreneauxAprem($new)
				{
					$this->connexion();
					$statement = $this->connexion->prepare("UPDATE scriptconfig SET nbCreneauxAprem = ?;");
					$statement->bindParam(1, $new);
					$statement->execute();
					$this->deconnexion();
					$this->updateHeureCreneau();
					if (isset($_SESSION['type_modification']))
					{
						if ($_SESSION['type_modification'] == "tmpEnt")
						{
							return;
						}
						else
						{
							$classFormation = "Formation";
							$classFormation::updateFormation($id);
							return;
						}
					}
				}

				/**
				* Fonction qui permet d'éditer la durée d'un créneau.
				* @param  int  $new la nouvelle durée du créneau.
				*/
				public function editDureeCreneau($new)
				{
					$this->connexion();
					$statement = $this->connexion->prepare("UPDATE scriptconfig SET dureeCreneau = ?;");
					$statement->bindParam(1, $new);
					$statement->execute();
					$this->deconnexion();
					$this->updateHeureCreneau();
					return;
				}

				public function editHeureCreneauPause($new)
				{
					$this->connexion();
					$statement = $this->connexion->prepare("UPDATE scriptconfig SET heureCreneauPause = ?;");
					$statement->bindParam(1, $new);
					$statement->execute();
					$this->deconnexion();
					$this->updateHeureCreneau();
					return;
				}

				public function editHeureCreneauPauseMatin($new)
				{
					$this->connexion();
					$statement = $this->connexion->prepare("UPDATE scriptconfig SET heureCreneauPauseMatin = ?;");
					$statement->bindParam(1, $new);
					$statement->execute();
					$this->deconnexion();
					$this->updateHeureCreneau();
					return;
				}

				/**
				* Fonction qui permet d'obtenir les étudiants appartenant à une formation.
				* @param  String $formation la formation à laquelle appartien l'étudiant.
				* @return array(int,String,String) un tableau (IDEtu,listechoixEtu,nomEtu);
				*/
				public function getEtudiants($formation)
				{
					try
					{
						$this->connexion();
						$statement = $this->connexion->prepare('SELECT IDEtu, listeChoixEtu, nomEtu FROM etudiant WHERE formationEtu = ?;');
						$statement->bindParam(1, $formation);
						$statement->execute();
						$tabResult = $statement->fetchAll();
						$this->deconnexion();
						return $tabResult;
					}
					catch (AccesTableException $e)
					{
						print($e -> getMessage());
					}
				}

				/**
				* Fonction qui retourne l'ensemble des formations.
				* @return array(Formation) un tableau de formations.
				*/
				public function getListeFormations()
				{
					try
					{
						$this->connexion();
						$statement = $this->connexion->prepare('SELECT * FROM listeFormations;');
						$statement->execute();
						$tabResult = $statement->fetchAll(PDO::FETCH_CLASS, "ListeFormation");
						$this->deconnexion();
						return $tabResult;
					}
					catch (AccesTableException $e)
					{
						print($e -> getMessage());
					}
				}

				/**
				* Fonction qui permet de retourner des caractéristiques de toutes les entreprises.
				* @return array(int,String,String,int) un tableau(IDEnt,typeCreneau,formationsRecherchees,nbPlaces).
				*/
				public function getEntreprises()
				{
					try
					{
						$this->connexion();
						$statement = $this->connexion->prepare('SELECT IDEnt, typeCreneau, formationsRecherchees, nbPlaces FROM entreprise;');
						$statement->execute();
						$tabResult = $statement->fetchAll();
						$this->deconnexion();
						return $tabResult;
					}
					catch (AccesTableException $e)
					{
						print($e -> getMessage());
					}
				}

				/**
				* Fonction qui permet de retourner tous les noms des entreprises.
				* @return array(String) un tableau composé des noms des entreprises.
				*/
				public function getNomEntreprises()
				{
					try
					{
						$this->connexion();
						$statement = $this->connexion->prepare('SELECT nomEnt FROM entreprise;');
						$statement->execute();
						$tabResult = $statement->fetchAll();
						$this->deconnexion();
						return $tabResult;
					}
					catch (AccesTableException $e)
					{
						print($e -> getMessage());
					}
				}

				/**
				* Fonction qui permet d'obtenir le total des créneaux pour chaque entreprise.
				* @return array(String,int) un tableau(nomEnt,nbCreneauxTotal).
				*/
				public function getEntreprisesTotalCreneaux()
				{
					try
					{
						$this->connexion();
						$statement = $this->connexion->prepare('SELECT * FROM entnbcrtotal;');
						$statement->execute();
						$tabResult = $statement->fetchAll();
						$this->deconnexion();
						return $tabResult;
					}
					catch (AccesTableException $e)
					{
						print($e -> getMessage());
					}
				}

			//PROJET
				/**
				* Fonction permettant de recupérer tous les creneaux des entreprises lié a une formation.
				* @return array(Responsable) un tableau de responsable.
				*/
				public function getEntreprisesTotalCreneauxResponsable($formation)
				{
					try
					{
						$this->connexion();
						$statement = $this->connexion->prepare('SELECT distinct * FROM entnbcrtotal where `nomEnt`IN (SELECT `nomEnt` from entreprise where IDEnt IN (SELECT entPropose FROM formation WHERE typeFormation = ? GROUP BY entPropose));');
						$statement->bindParam(1, $formation);
						$statement->execute();
						$tabResult = $statement->fetchAll();
						$this->deconnexion();
						return $tabResult;
					}
					catch (AccesTableException $e)
					{
						print($e -> getMessage());
					}
				}


				/**
				* Fonction qui permet d'accéder à la distribution des créneaux par entreprise et par formation.
				* @return array(String,String,int,int) un tableau (typeFormation,nomEnt,creneauDebut,creneauFin).
				*/
				public function getExportDistCrFormEntr()
				{
					try
					{
						$this->connexion();
						$statement = $this->connexion->prepare('SELECT * FROM distributioncreneaux;');
						$statement->execute();
						$tabResult = $statement->fetchAll();
						$this->deconnexion();
						return $tabResult;
					}
					catch (AccesTableException $e)
					{
						print($e -> getMessage());
					}
				}

								//PROJET
				/**
				* Fonction qui permet d'accéder à la distribution des créneaux par entreprise et par formation et du responsable.
				* @param responsable : c'est l'ID du responsable
				* @return array(String,String,int,int) un tableau (typeFormation,nomEnt,creneauDebut,creneauFin).
				*/
				public function getExportDistCrFormEntrResp($responsable)
				{
					try
					{
						$this->connexion();
						$statement = $this->connexion->prepare('SELECT * FROM distributioncreneaux WHERE typeFormation IN (Select typeformation from lienformationresp where IDresp = ?);');
						$statement->bindParam(1,$responsable);
						$statement->execute();
						$tabResult = $statement->fetchAll(PDO::FETCH_ASSOC);
						$this->deconnexion();
						return $tabResult;
					}
					catch (AccesTableException $e)
					{
						print($e -> getMessage());
					}
				}

                public function getExportDistCrTotalFormEntrResp($responsable)
				{
					try
					{
						$this->connexion();
						$statement = $this->connexion->prepare('SELECT * FROM distributioncreneaux WHERE typeFormation IN (Select typeformation from lienformationresp where IDresp = ?);');
						$statement->bindParam(1,$responsable);
						$statement->execute();
						$tabResult = $statement->fetchAll(PDO::FETCH_ASSOC);
						$this->deconnexion();
						return $tabResult;
					}
					catch (AccesTableException $e)
					{
						print($e -> getMessage());
					}
				}


				///



				/**
				* Fonction qui permet d'obtenir des informations sur les créneaux des entreprises en fonction de la formation.
				* @return array(int,String,String,int,int,int) un tableau composé de
				* (IDformation,typeFormation,nomEnt,nbcreneauxReserves,NBCreneauxAffectes,nbEtudinantsInscrits).
				*/
				public function getEntResAffIns()
				{
					try
					{
						$this->connexion();
						$statement = $this->connexion->prepare('SELECT * FROM entnbresaffinscrits;');
						$statement->execute();
						$tabResult = $statement->fetchAll();
						$this->deconnexion();
						return $tabResult;
					}
					catch (AccesTableException $e)
					{
						print($e -> getMessage());
					}
				}
                	public function getEntResAffInsEnt($ent)
				{
					try
					{
						$this->connexion();
						$statement = $this->connexion->prepare('SELECT nbcreneauxReserves FROM entnbresaffinscrits WHERE nomEnt = ?;');
						$statement->bindParam(1,$ent);
						$statement->execute();
						$tabResult = $statement->fetchAll();
						$this->deconnexion();
						return $tabResult;
					}
					catch (AccesTableException $e)
					{
						print($e -> getMessage());
					}
				}

				/**
				* Fonction qui permet d'obtenir des informations sur les créneaux des entreprises en fonction de la formation et du responsable.
				* @param responsable : c'est l'ID du responsable
				* @return array(String,String,int,int) un tableau (typeFormation,nomEnt,creneauDebut,creneauFin).
				*/
				//PROJET
				public function getEntResAffInsResp($responsable)
				{
					try
					{
						$this->connexion();
						$statement = $this->connexion->prepare('SELECT * FROM entnbresaffinscrits WHERE typeFormation IN (Select typeformation from lienformationresp where IDresp = ?);');
						$statement->bindParam(1,$responsable);
						$statement->execute();
						$tabResult = $statement->fetchAll();
						$this->deconnexion();
						return $tabResult;
					}
					catch (AccesTableException $e)
					{
						print($e -> getMessage());
					}
				}

				//

				/**
				* Fonction qui permet d'accéder aux choix des étudiants.
				* @return array(String,String,int,int,String,String) un tableau composé de
				* (formatinEtu,nomEtu,NbChoix,Nbaffecte,numtelEtu,mailEtu).
				*/
				public function getEtudiantChoixAff()
				{
					try
					{
						$this->connexion();
						$statement = $this->connexion->prepare('SELECT * FROM etudiantsnbchnbaff;');
						$statement->execute();
						$tabResult = $statement->fetchAll();
						$this->deconnexion();
						return $tabResult;
					}
					catch (AccesTableException $e)
					{
						print($e -> getMessage());
					}
				}

				/**
				* Fonction qui permet d'accéder aux créneaux d'une entreprise pour une formation.
				* @param  String $nomEnt    	 le nom de l'entreprise.
				* @param  String $departement le nom du département.
				* @return array(String,String,String,String,String) un tableau composé de
				* (typeFormation,nomEnt,nomEtu,prenomEtu,heure).
				*/
				public function getNomEtudiantPlanning($nomEnt,$departement)
				{
					try
					{
						$this->connexion();
						$statement = $this->connexion->prepare("SELECT * FROM planning  WHERE nomEnt = '".$nomEnt."' AND typeFormation = '".$departement."' order by 5;"); // and typeFormation= '".$departement."'

						$statement->execute();
						$tabResult = $statement->fetchAll();
						$this->deconnexion();
						$listeEtudiants=array();
						foreach ($tabResult as $Etudiant)
						{
							$listeEtudiants[]=$Etudiant["nomEtu"];
						}
						return $listeEtudiants;
					}
					catch (AccesTableException $e)
					{
						print($e -> getMessage());
					}
				}

				/**
				* Fonction qui permet d'accéder aux entreprises voulant rencontrer des étudiants d'une formation donnée.
				* @param  String $formation le nom de la formation.
				* @return array(int) un tableau des identifiants des entreprises.
				*/
				public function getEntreprisesParFormation($formation)
				{
					$this->connexion();
					$statement = $this->connexion->prepare('SELECT entPropose FROM formation WHERE typeFormation = ? GROUP BY entPropose;');
					$statement->bindParam(1, $formation);
					$statement->execute();
					$tabResult = $statement->fetchAll();
					// $sortie = array();
					// foreach ($tabResult as $id)
					// {
					// 	$statement = $this->connexion->prepare('SELECT * FROM entreprise WHERE IDEnt = '.intval($id['entPropose']).';');
					// 	$statement->execute();
					// 	array_push($sortie,$statement->fetchAll(PDO::FETCH_CLASS, "Entreprise")[0]);
					// }
					$this->deconnexion();
					return $tabResult;
					// return $sortie;
				}

       public function getEntreprisesParFormationBis($formation)
	                      {
		$this->connexion();
		$statement = $this->connexion->prepare('SELECT entPropose FROM formation WHERE typeFormation = ? GROUP BY entPropose;');
		$statement->bindParam(1, $formation);
		$statement->execute();
		$tabResult = $statement->fetchAll();
		$sortie = array();

		foreach ($tabResult as $id)
		{

			$statement = $this->connexion->prepare('SELECT * FROM entreprise WHERE IDEnt = '.$id['entPropose'].';');
			$statement->execute();
			array_push($sortie,$statement->fetchAll(PDO::FETCH_CLASS, "Entreprise")[0]);
		}
		$this->deconnexion();
           return $sortie;
	}
				/**
				* Fonction qui permet d'accéder à la formation d'un étudiant.
				* @param  int $id l'identifiant de l'étudiant.
				* @return String le nom de la formation de l'étudiant.
				*/
				public function getFormationEtudiant($id)
				{
					$this->connexion();
					$statement = $this->connexion->prepare('SELECT formationEtu FROM etudiant WHERE IDEtu = ?;');
					$statement->bindParam(1, $id);
					$statement->execute();
					$result = $statement->fetch();
					$this->deconnexion();
					return $result['formationEtu'];
				}

				/**
				* Fonction qui permet d'accéder à des caractéristiques des entreprises concernées par une formation donnée.
				* @param   $formation la formation qui concerne les entreprises recherchées.
				* @return array(int,String,String,String,int) un tableau composé de
				* (IDEnt,nomEnt,typeCreneau,formationsRecherchees,nbPlaces).
				*/

				//PROJET
		public function getEntreprisesParFormationparResp($formation){
			$this->connexion();
			$statement = $this->connexion->prepare('SELECT entPropose FROM formation WHERE typeFormation = ? GROUP BY entPropose;');
					$statement->bindParam(1, $formation);
					$statement->execute();
					$tabResult = $statement->fetchAll();
					// $sortie = array();
					// foreach ($tabResult as $id)
					// {
					// 	$statement = $this->connexion->prepare('SELECT * FROM entreprise WHERE IDEnt = '.intval($id['entPropose']).';');
					// 	$statement->execute();
					// 	array_push($sortie,$statement->fetchAll(PDO::FETCH_CLASS, "Entreprise")[0]);
					// }
					$this->deconnexion();
					return $tabResult;
					// return $sortie;
				}
		public function getEntreprisesParResp($responsable){
			$this->connexion();
			$statement = $this->connexion->prepare('SELECT * from entreprise where IDEnt IN (SELECT entPropose FROM formation WHERE typeFormation IN (SELECT typeformation from formation where typeformation IN (Select typeformation from lienformationresp where IDresp = ?)));');
			$statement->bindParam(1, $responsable);
			$statement->execute();
			$tabResult = $statement->fetchAll(PDO::FETCH_CLASS, "Entreprise");
			$this->deconnexion();
			return $tabResult;
		}

		public function getEntreprisesParRespBis($responsable)
				{
					$this->connexion();
					$statement = $this->connexion->prepare('SELECT * from entreprise where IDEnt IN (SELECT entPropose FROM formation WHERE typeFormation IN (SELECT typeformation from formation where typeformation IN (Select typeformation from lienformationresp where IDresp = ?)));');
					$statement->bindParam(1, $responsable);
					$statement->execute();
					$this->deconnexion();
					return $statement->fetchAll(PDO::FETCH_ASSOC);
				}

		public function getInscriptionfinaliseesResp($responsable){
			$this->connexion();
			$statement = $this->connexion->prepare("SELECT * FROM etudiant WHERE listechoixEtu!='' AND IDEtu IN (SELECT IDEtu from etudiant WHERE formationEtu IN (SELECT typeformation FROM lienformationresp WHERE IDresp = ?));");
			$statement->bindParam(1, $responsable);
			$statement->execute();
			$tabResult = $statement->fetchAll();
			$this->deconnexion();
			return $tabResult;
		}

		////

					//PROJET

				public function getFormationByNameAndEnt($nom, $idEnt)
				{
					$this->connexion();
					$statement = $this->connexion->prepare('SELECT idformation FROM formation WHERE typeFormation = ? AND entPropose = ?;');
					$statement->bindParam(1, $id);
					$statement->bindParam(2, $idEnt);
					$statement->execute();
					$result = $statement->fetch();
					$this->deconnexion();
					return $result['idformation'];
				}

				public function getJuryByidFormation($ifFormation)
				{
					$this->connexion();
					$statement = $this->connexion->prepare('SELECT numjurie FROM jurieformation WHERE idformation = ?;');
					$statement->bindParam(1, $ifFormation);
					$statement->execute();
					$result = $statement->fetch();
					$this->deconnexion();
					return $result['numjurie'];
				}



				////////
				public function getEntreprisesEntreprise($formation)
				{
					try
					{
						$this->connexion();
						$statement = $this->connexion->prepare('SELECT IDEnt, nomEnt, typeCreneau, formationsRecherchees, nbPlaces FROM entreprise;');
						$statement->execute();
						$tabResult = $statement->fetchAll();
						$ret = array();
						foreach ($tabResult as $entreprise)
						{
							$form = explode ( "," , $entreprise["formationsRecherchees"]);
							if(in_array('Informatique', $form))
							{
								$ret[] = $entreprise;
							}
						}
						$this->deconnexion();
						return $ret;
					}
					catch (AccesTableException $e)
					{
						print($e -> getMessage());
					}
				}

				/**
				* Fonction qui permet d'accéder aux "formations" liés à une formation donnée.
				* @param  String $formation le nom de la formation.
				* @return array(int,int,int,int) un tableau composé de
				* (IDformation,entPropose,creneauDebut,creneauFin).
				*/
				public function getFormations($formation)
				{
					try
					{
						$this->connexion();
						$statement = $this->connexion->prepare('SELECT IDformation, entPropose, creneauDebut, creneauFin FROM formation where typeFormation = ?;');
						$statement->bindParam(1, $formation);
						$statement->execute();
						$tabResult = $statement->fetchAll();
						$this->deconnexion();
						return $tabResult;
					}
					catch (AccesTableException $e)
					{
						print($e -> getMessage());
					}
				}

				/**
				* Fonction qui permet d'accéder aux "formations" liés à une entreprise donnée.
				* @param $entreprise l'identifiant de l'entreprise recherchée.
				* @return array(int,String,int,int) un tableau (IDformation,typeFormation,creneauDebut,creneauFin).
				*/
				public function getFormationsAffichage($entreprise)
				{
					try
					{
						$this->connexion();
						$statement = $this->connexion->prepare('SELECT IDformation, typeFormation, creneauDebut, creneauFin FROM formation where entPropose = ? ORDER BY typeFormation;');
						$statement->bindParam(1, $entreprise);
						$statement->execute();
						$tabResult = $statement->fetchAll();
						$this->deconnexion();
						return $tabResult;
					}
					catch (AccesTableException $e)
					{
						print($e -> getMessage());
					}
				}

				/**
				* Fonction qui permet d'accéder aux "formations" liés à une entreprise donnée.
				* @param $entreprise l'identifiant de l'entreprise recherchée.
				* @return array(int,String) un tableau (IDformation,typeFormation).
				*/
				public function getFormationsEntreprise($entreprise)
				{
					try
					{
						$this->connexion();
						$statement = $this->connexion->prepare('SELECT IDformation, typeFormation FROM formation where entPropose = ?;');
						$statement->bindParam(1, $entreprise);
						$statement->execute();
						$tabResult = $statement->fetchAll();
						$this->deconnexion();
						return $tabResult;
					}
					catch (AccesTableException $e)
					{
						print($e -> getMessage());
					}
				}


				/**
				* Fonction qui permet d'accéder à l'identifiant d'une entreprise.
				* @param  String $entreprise le nom de l'entreprise.
				* @return int l'identifiant de l'entreprise.
				*/
				public function getIdEntreprise($entreprise)
				{
					try
					{
						$this->connexion();
						$statement = $this->connexion->prepare('SELECT IDEnt FROM entreprise where nomEnt = ?;');
						$statement->bindParam(1, $entreprise);
						$statement->execute();
						$tabResult = $statement->fetch();
						$this->deconnexion();
						return $tabResult['IDEnt'];
					}
					catch (AccesTableException $e)
					{
						print($e -> getMessage());
					}
				}

				/**
				* Fonction qui permet d'accéder aux identifiants des "formations" concernant une entreprise et une formation données.
				* @param  String $formation la formation recherchée.
				* @param  int $entreprise l'idenfiant de l'entreprise concernée.
				* @return array(int) un tableau des identifiants des créneaux.
				*/
				public function getIDFormation($formation, $entreprise)
				{
					try
					{
						$this->connexion();
						$statement = $this->connexion->prepare('SELECT IDformation FROM formation WHERE typeFormation = ? AND entPropose = ?;');
						$statement->bindParam(1, $formation);
						$statement->bindParam(2, $entreprise);
						$statement->execute();
						$tabResult = $statement->fetch();

						$ret = $tabResult['IDformation'];
						$this->deconnexion();
						return $ret;
					}
					catch (AccesTableException $e)
					{
						print($e -> getMessage());
					}
				}

				/**
				* Fonction qui supprime les créneaux de la tableau créneau.
				*/
				public function supprimerCreneau() {
					try {
						$this->connexion();
						$statement = $this->connexion->prepare('DELETE FROM creneau;');
						$statement->execute();
						$this->deconnexion();

					} catch (AccesTableException $e) {
						print($e -> getMessage());
					}
				}

				/**
				* Fonction qui permet d'ajouter un créneau dans la table creneau.
				* @param  int $numCreneau  le numéro du nouveau créneau.
				* @param  int $IDformation l'identifiant de la formation concernée.
				* @param  int $etudiant    l'identifiant de l'étudiant.
				*/
				public function ajoutCreneau($numCreneau, $IDformation, $etudiant) {
					try {
						$this->connexion();
						$statement = $this->connexion->prepare('INSERT INTO creneau VALUES ("'.$numCreneau.'", "00:00:00", "00:00:00", "'.$IDformation.'",  "'.$etudiant.'");');
						$statement->execute();
						$this->deconnexion();
						return;
					} catch (AccesTableException $e) {
						print($e -> getMessage());
					}
				}

				/**
				* Fonction qui permet d'accéder à un créneau spécifié.
				* @param  int $numeroCreneau le numéro du créneau recherché.
				* @param  int $idFormation   l'identifiant de la formation.
				* @return int | boolean l'identifiant de l'étudiant ou false sinon.
				*/
				public function getCreneau($numeroCreneau, $idFormation)  {

					try {
						$this->connexion();
						$statement = $this->connexion->prepare('SELECT idEtudiant FROM creneau WHERE numeroCreneau = "'.$numeroCreneau.'" AND idFormation = "'.$idFormation.'";');
						$statement->execute();
						if ($tabResult = $statement->fetch()) {
							$ret = $tabResult['idEtudiant'];
						} else {
							$ret = False;
						}
						$this->deconnexion();
						return $ret;
					} catch (AccesTableException $e) {
						print($e -> getMessage());
					}
				}

				public function getCreneauPause(){
					$this->connexion();
					$statement = $this->connexion->prepare("SELECT heureCreneauPause FROM scriptconfig");
					$statement->execute();
					$this->deconnexion();
					return $statement->fetch();
				}

				/*Fonction qui renvoie IDFormation d'un creneau*/
				/**
				* Fonction qui permet d'accéder à la formation d'un créneau donné.
				* @param  int $numeroCreneau le numéro du créneau.
				* @param  int $idEtudiant l'identifiant de l'étudiant.
				* @return int | boolean l'identifiant de la formation ou false sinon.
				*/
				public function getFormationCreneau($numeroCreneau, $idEtudiant)  {
					try {
						$this->connexion();
						$statement = $this->connexion->prepare('SELECT idFormation FROM creneau WHERE numeroCreneau = "'.$numeroCreneau.'" AND idEtudiant = "'.$idEtudiant.'";');
						$statement->execute();

						if ($tabResult = $statement->fetch()) {
							$ret = $tabResult['idFormation'];

						} else {
							$ret = False;
						}
						$this->deconnexion();
						//var_dump($ret);
						return $ret;
					} catch (AccesTableException $e) {
						print($e -> getMessage());
					}
				}

				/**
				* Fonction qui permet de récupérer l'ID de l'entreprise à partir de l'ID de la "formation".
				* @param  int $idform l'identifiant de la "formation".
				* @return int | boolean l'identifiant de l'entreprise ou false sinon.
				*/
				public function getIDEntIDform($idform) {
					try {
						$this->connexion();
						$statement = $this->connexion->prepare('SELECT entPropose FROM formation WHERE IDformation = "'.$idform.'";');
						$statement->execute();
						if ($tabResult = $statement->fetch()) {
							$ret = $tabResult['entPropose'];
						} else {
							$ret = False;
						}
						$this->deconnexion();
						return $ret;
					} catch (AccesTableException $e) {
						print($e -> getMessage());
					}
				}

				/**
				* Fonction qui renvoie l'ID de toutes les "formations" concernant une entreprise.
				* @param  int $entreprise l'identifiant de l'entreprise.
				* @return array(int) un tableau des identifiants des formations.
				*/
				public function getIDFormationsEntreprise($entreprise)  {
					try {
						$this->connexion();
						$statement = $this->connexion->prepare('SELECT IDformation FROM formation where entPropose = "'.$entreprise.'";');
						$statement->execute();
						$tabResult = $statement->fetchAll();
						$this->deconnexion();
						return $tabResult;
					} catch (AccesTableException $e) {
						print($e -> getMessage());
					}
				}

				/**
				* Fonction qui renvoie le type de formation + l'ID formation à partir de l'ID formation.
				* @param  int $idform l'identifiant de la formation.
				* @return array(int,String) un tableau composé de (IDFormation, typeFormation).
				*/
				public function getIDTypeFormation($idform)  {
					try {
						$this->connexion();
						$statement = $this->connexion->prepare('SELECT IDformation, typeFormation FROM formation where IDformation = "'.$idform.'";');
						$statement->execute();
						$tabResult = $statement->fetchAll();
						$this->deconnexion();
						return $tabResult;
					} catch (AccesTableException $e) {
						print($e -> getMessage());
					}
				}
				public function getIDFormationresp($type_formation){
					try{
						$this->connexion();
						$statement = $this->connexion->prepare('SELECT IDformation from formation where typeFormation=? LIMIT 1;');
						$statement->bindParam(1,$type_formation);
						$statement->execute();
						$tabResult = $statement->fetchAll();
						$this->deconnexion();
						return $tabResult;
					}catch (AccesTableException $e){
						print($e -> getMessage());
					}
				}
				/**
				* Fonction qui permet de récupérer toutes les "formations".
				* @return array(int,String) un tableau composé de (IDformation,typeFormation).
				*/
				public function getAllFormations() {
					try {
						$this->connexion();
						$statement = $this->connexion->prepare('SELECT IDformation, typeFormation FROM formation;');
						$statement->execute();
						$tabResult = $statement->fetchAll();
						$this->deconnexion();
						return $tabResult;
					} catch (AccesTableException $e) {
						print($e -> getMessage());
					}
				}

								//PROJET
				/**
				* Fonction qui permet de récupérer tous les types de formations.
				* @return array(int,String) un tableau composé de (typeFormation).
				*/
				public function getAllFormationsBis() {
					try {
						$this->connexion();
						$statement = $this->connexion->prepare('SELECT DISTINCT typeFormation FROM formation;');
						$statement->execute();
						$tabResult = $statement->fetchAll();
						$this->deconnexion();
						return $tabResult;
					} catch (AccesTableException $e) {
						print($e -> getMessage());
					}
				}

				public function ajoutResponsable($nom,$prenom,$email,$tel,$mdp){
					try{
						$this->connexion();
						$statement = $this->connexion->prepare('INSERT INTO `responsable` (`IDresp`, `nomResp`, `prenomResp`, `mailResp`, `mdpResp`, `numtelResp`) VALUES (?,?,?,?,?,?);');
						$statement->bindParam(1, $email);
						$statement->bindParam(2, $nom);
						$statement->bindParam(3, $prenom);
						$statement->bindParam(4, $email);
						$statement->bindParam(5, $mdp);
						$statement->bindParam(6, $tel);
						$statement->execute();
						$this->deconnexion();

					} catch (AccesTableException $e) {
						print($e -> getMessage());
					}
				}
				//PROJET

				public function addlienentreprisesalle($entreprise, $salle, $jury){
					try{
						$this->connexion();
						$statement = $this->connexion->prepare('INSERT INTO `liensallentreprises` (`salle`, `entreprise`, `jury`) VALUES (?,?,?);');
						$statement->bindParam(1, $salle);
						$statement->bindParam(2, $entreprise);
						$statement->bindParam(3, $jury);
						$statement->execute();
						$this->deconnexion();
					}catch(AccesTableException $e){
						print($e -> getMessage());
					}
				}


				public function dellienentreprisesalle($entreprise , $salle , $jury){
					try{
						$this->connexion();
						$statement = $this->connexion->prepare('DELETE * from liensallentreprises where salle = ? AND entreprise = ? AND jury = ?;');
						$statement->bindParam(1, $salle);
						$statement->bindParam(2, $entreprise);
						$statement->bindParam(3, $jury0);
						$statement->execute();
						$this->deconnexion();
					}catch(AccesTableException $e){
						print($e -> getMessage());
					}
				}

				public function lienentreprise(){
					try{
						$this->connexion();
						$statement = $this->connexion->prepare('INSERT INTO salle_entreprise SELECT DISTINCT * FROM liensallentreprises');
						$statement->execute();
						$this->deconnexion();
					}catch(AccesTableException $e){
						print($e -> getMessage());
					}
				}

				//PROJET
				public function getliensalle($entreprise,$jury){
					try{
						$this->connexion();
						$statement = $this->connexion->prepare('SELECT salle from liensallentreprises where entreprise = ? AND jury = ?;');
						$statement->bindParam(1, $entreprise);
						$statement->bindParam(2, $jury0);
						$statement->execute();
						$this->deconnexion();
					}catch(AccesTableException $e){
						print($e -> getMessage());
					}
				}
				//PROJET
				public function getliensalleBis($salle){
					try{
						$this->connexion();
						$statement = $this->connexion->prepare('SELECT entreprise, jury from liensallentreprises where salle = ?;');
						$statement->bindParam(1, $salle);
						$statement->execute();
						$this->deconnexion();
					}catch(AccesTableException $e){
						print($e -> getMessage());
					}
				}

				//PROJET
				public function addsalles($nom, $capacity){
					try{
						$this->connexion();
						$statement = $this->connexion->prepare('INSERT INTO `salles` (`numéro`, `capacité`) VALUES (?,?);');
						$statement->bindParam(1, $nom);
						$statement->bindParam(2, $capacity);
						$statement->execute();
						$this->deconnexion();
					}catch(AccesTableException $e){
						print($e -> getMessage());
					}
				}

				//PROJET
				public function getsallelibre(){
					try{
						$this->connexion();
						$statement = $this->connexion->prepare('SELECT * from salles where capacité>0;');
						$statement->execute();
						$this->deconnexion();
						return $statement->fetchAll();
					}catch(AccesTableException $e){
						print($e -> getMessage());
					}

				}
				//PROJET

				public function delsalles($salle){
					try{
						$this->connexion();
						$statement = $this->connexion->prepare('DELETE * from salles where numéro = ?;');
						$statement->bindParam(1, $salle);
						$statement->execute();
						$this->deconnexion();
					}catch(AccesTableException $e){
						print($e -> getMessage());
					}
				}

				//PROET

				public function getNomEntrepriseFormation($id){
					try{
						$this->connexion();
						$statement = $this->connexion->prepare('SELECT nomEnt from entreprise WHERE IDEnt = (SELECT entPropose from formation where IDformation = ?);');
						$statement->bindParam(1, $id);
						$statement->execute();
						$this->deconnexion();
						return $statement->fetchAll();
					}catch(AccesTableException $e){
						print($e -> getMessage());
					}
				}


				//PROET

				public function getalljury(){
					try{
						$this->connexion();
						$statement = $this->connexion->prepare('SELECT * FROM jurieformation;');
						$statement->execute();
						$this->deconnexion();
						return $statement->fetchAll();
					}catch(AccesTableException $e){
						print($e -> getMessage());
					}
				}

				//PROJET

				public function getcapacity($salle){
					try{
						$this->connexion();
						$statement = $this->connexion->prepare('SELECT capacité from salles where numéro = ?;');
						$statement->bindParam(1,$salle);
						$statement->execute();
						$this->deconnexion();
						return $statement->fetchAll();
					}catch(AccesTableException $e){
						print($e -> getMessage());
					}
				}

				//PROJET

				public function setcapacity($salle, $capacity){
					try{
						$this->connexion();
						$statement = $this->connexion->prepare('UPDATE salles SET capacité = ? where numéro = ?;');
						$statement->bindParam(1,$capacity);
						$statement->bindParam(2,$salle);
						$statement->execute();
						$this->deconnexion();
					}catch(AccesTableException $e){
						print($e -> getMessage());
					}
				}
				//PROJET
				public function ajoutEtudiantBis($nom,$prenom,$email,$tel,$mdp,$form,$choix){
					try{
						$this->connexion();
						$statement = $this->connexion->prepare('INSERT INTO `etudiant` (`IDEtu`, `nomEtu`, `prenomEtu`, `mailEtu`, `mdpEtu`, `numtelEtu`, `formationEtu`, `listechoixEtu`) VALUES (?,?,?,?,?,?,?,?);');
						$statement->bindParam(1, $email);
						$statement->bindParam(2, $nom);
						$statement->bindParam(3, $prenom);
						$statement->bindParam(4, $email);
						$statement->bindParam(5, $mdp);
						$statement->bindParam(6, $tel);
						$statement->bindParam(7, $form);
						$statement->bindParam(8, $choix);
						$statement->execute();
						$this->deconnexion();

					} catch (AccesTableException $e) {
						print($e -> getMessage());
					}
				}

				public function ajoutEntBis($nomEnt, $nomContact, $prenomContact,$mail, $num, $adresse, $ville, $cpEnt, $nbRecru,$nbPlaces, $nbStands, $nbRepas, $mdp_crypt, $forms){
					try{
						$formations = "";
						for($i=0;$i<count($forms);$i++){
							$formations.=$forms[$i].",";
						}
						$formations.=$forms[count($forms)];
						$creneau = "apres_midi";
						$this->connexion();
						$statement = $this->connexion->prepare('INSERT INTO `entreprise` (`nomEnt`, `mdpEnt`, `typeCreneau`, `formationsRecherchees`, `nbRecruteurs`, `nbPlaces`, `nbStands`,`nbRepas`,`mailEnt`,`nomContact`,`prenomContact`,`numTelEnt`,`codePostal`,`villeEnt`,`adresseEnt`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);');
						$statement->bindParam(1, $nomEnt);
						$statement->bindParam(2, $mdp_crypt);
						$statement->bindParam(3, $creneau); // A modifier si besoin

						$statement->bindParam(4, $formations);
						$statement->bindParam(5, $nbRecru);
						$statement->bindParam(6, $nbPlaces);
						$statement->bindParam(7, $nbStands);
						$statement->bindParam(8, $nbRepas);
						$statement->bindParam(9, $mail);
						$statement->bindParam(10, $nomContact);
						$statement->bindParam(11, $prenomContact);
						$statement->bindParam(12, $num);
						$statement->bindParam(13, $cpEnt);
						$statement->bindParam(14, $ville);
						$statement->bindParam(15, $adresse);
						$statement->execute();
						$this->deconnexion();

					} catch (AccesTableException $e) {
						print($e -> getMessage());
					}
				}


				//

				public function ajoutLienFormationResp($email,$forms){
					try{
						foreach($forms as $form){
							$tmp = $this->getIDFormationresp($form);
							$this->connexion();
							$statement = $this->connexion->prepare('INSERT INTO `lienformationresp` (`IDresp`, `typeformation`,`IDformation`) VALUES (?,?,?);');
							$statement->bindParam(1, $email);
							$statement->bindParam(2, $form);
							$statement->bindParam(3, $tmp[0][0]);
							$statement->execute();
							$this->deconnexion();
						}
					}catch (AccesTableException $e) {
						print($e -> getMessage());
					}
				}

				public function supprimerResp($ID){
					try{
							$this->connexion();
							$statement = $this->connexion->prepare('DELETE FROM responsable WHERE IDresp = ?;');
							$statement->bindParam(1, $ID[0]);
							$statement->execute();
							$statement = $this->connexion->prepare('DELETE FROM lienformationresp WHERE IDresp = ?;');
							$statement->bindParam(1, $ID[0]);
							$statement->execute();
							$this->deconnexion();

						}catch (AccesTableException $e) {
						print($e -> getMessage());
					}
				}

				public function supprimerRespdeResponsable($ID){
					try{
							$this->connexion();
							$statement = $this->connexion->prepare('DELETE FROM responsable WHERE IDresp = ?;');
							$statement->bindParam(1, $ID);
							$statement->execute();
							$this->deconnexion();
						}catch (AccesTableException $e) {
						print($e -> getMessage());
					}
				}

				public function supprimerRespdeTempResponsable($ID){
					try{
							$this->connexion();
							$statement = $this->connexion->prepare('DELETE FROM temp_responsable WHERE IDresp = ?;');
							$statement->bindParam(1, $ID);
							$statement->execute();
							$this->deconnexion();
						}catch (AccesTableException $e) {
						print($e -> getMessage());
					}
				}

				///
				/**
				 * Fonction qui permet d'inserer un responsable dans la table temp_responsable
				 */
				public function ajouterTempResp($IDresp){
					try{
							$this->connexion();
							$statement = $this->connexion->prepare('INSERT INTO `temp_responsable` (`IDresp`, `nomResp`, `prenomResp`, `mailResp`, `mdpResp`, `numtelResp`) SELECT * FROM responsable WHERE IDresp = ?');
							$statement->bindParam(1, $IDresp);
							$statement->execute();
							$this->deconnexion();

						}
					catch (AccesTableException $e) {
						print($e -> getMessage());
					}
				}

				public function gelerResp($resp){
					try{
						$this->ajouterTempResp($resp);
						$this->supprimerRespdeResponsable($resp);
					}catch (AccesTableException $e) {
						print($e -> getMessage());
					}
				}

				public function ValiderResp($resp){
					try{
						$this->ajouterRespDeLienVersResp($resp);
						$this->supprimerRespdeTempResponsable($resp);
					}catch (AccesTableException $e) {
						print($e -> getMessage());
					}
				}


				public function ajouterRespDeLienVersResp($IDresp){
					try{
							$this->connexion();
							$statement = $this->connexion->prepare('INSERT INTO `responsable` (`IDresp`, `nomResp`, `prenomResp`, `mailResp`, `mdpResp`, `numtelResp`) SELECT * FROM temp_responsable WHERE IDresp = ?');
							$statement->bindParam(1, $IDresp);
							$statement->execute();
							$this->deconnexion();
						}
					catch (AccesTableException $e) {
						print($e -> getMessage());
					}
				}


				/**
				* Fonction qui retourne le nom d'une entreprise à partir de son identifiant.
				* @param  int $idEnt l'identifiant de l'entreprise recherchée.
				* @return String le nom de l'entreprise.
				*/
				public function getNomEntreprise($idEnt)  {
					try {
						$this->connexion();
						$statement = $this->connexion->prepare('SELECT nomEnt FROM entreprise WHERE IDEnt = "'.$idEnt.'";');
						$statement->execute();
						$this->deconnexion();
						if ($result = $statement->fetch()) {
							return $result['nomEnt'];
						} else {
							return "-----------";
						}
					} catch (AccesTableException $e) {
						print($e -> getMessage());
					}
				}

				public function getNomEntrepriseTmp($idEnt)  {
					try {
						$this->connexion();
						$statement = $this->connexion->prepare('SELECT nomEnt FROM temp_entreprise WHERE IDEnt = "'.$idEnt.'";');
						$statement->execute();
						$this->deconnexion();
						if ($result = $statement->fetch()) {
							return $result['nomEnt'];
						} else {
							return "-----------";
						}
					} catch (AccesTableException $e) {
						print($e -> getMessage());
					}
				}




				/**
				* Fonction qui permet d'ajouter une "formation" dans la table formation.
				* @param  String $typeFormation le nom de la formation concernée.
				* @param  int $entPropose       l'identifiant de l'entreprise.
				* @param  int $creneauDebut  	 le numéro de créneau de début.
				* @param  int $creneauFin    	 le numéro de créneau de fin.
				*/
				public function ajoutFormation($typeFormation, $entPropose, $creneauDebut, $creneauFin) {
					try {
						$this->connexion();
						$statement = $this->connexion->prepare('INSERT INTO formation(typeFormation,entPropose, creneauDebut, creneauFin) VALUES ("'.$typeFormation.'", '.$entPropose.', '.$creneauDebut.', '.$creneauFin.');');
						$statement->execute();
						$this->deconnexion();
					} catch (AccesTableException $e) {
						print($e -> getMessage());
					}
				}


				/**
				* Fonction qui permet de retourner des détails sur le nombre
				* d'étudiants, d'entreprises, de repas et d'étudiants inscrits.
				* @return array(int,int,int,int) un tableau composé de
				* (nbEtu,nbEnt,nbRepas,nbInscritsfinalisees).
				*/
				public function getDetails() {
					$sortie = array('nbEtu' => 0, 'nbEnt' => 0, 'nbRepas' => 0, 'nbInscritsfinalisees' => 0, 'nbAlternants' => 0);
					$this->connexion();
					$statement = $this->connexion->prepare("SELECT * FROM entreprise;");
					$statement->execute();
					$this->deconnexion();
					$tab_temp = $statement->fetchAll();
					$sortie['nbEnt'] = sizeof($tab_temp);
					$this->connexion();
					$statement = $this->connexion->prepare("SELECT * FROM etudiant;");
					$statement->execute();
					$this->deconnexion();
					$tab_temp = $statement->fetchAll();
					$sortie['nbEtu'] = sizeof($tab_temp);
					$this->connexion();
					$statement = $this->connexion->prepare("SELECT SUM(nbRepas) as TotalRepas FROM entreprise WHERE nbRepas > 0;");
					$statement->execute();
					$tab_temp = $statement->fetch();
					$sortie['nbRepas'] = $tab_temp['TotalRepas'];
					$this->deconnexion();
					$this->connexion();
					$statement = $this->connexion->prepare("SELECT count(*) as NbInscritsF FROM etudiant WHERE listechoixEtu!='';");
					$statement->execute();
					$tab_temp = $statement->fetch();
					$sortie['nbInscritsfinalisees']=$tab_temp['NbInscritsF'];
					$this->deconnexion();
					$this->connexion();
					$statement = $this->connexion->prepare("select count(*) as NbAlternants from (`formation` join `entreprise`) where (`formation`.`entPropose` = `entreprise`.`IDEnt`);");
					$statement->execute();
					$tab_temp = $statement->fetch();
					$sortie['nbAlternants']=$tab_temp['NbAlternants'];
					$this->deconnexion();

					return $sortie;
				}
				//PROJET
				/**
				* Fonction qui permet de retourner des détails sur le nombre
				* d'étudiants, d'entreprises, de repas et d'étudiants inscrits.
				* @return array(int,int,int) un tableau composé de
				* (nbEtu,nbEnt,nbInscritsfinalisees).
				*/
				public function getDetailsResponsable() {
					$sortie = array('nbEtu' => 0, 'nbEnt' => 0, 'nbInscritsfinalisees' => 0);
					$tab_temp = $this->getEntreprisesParResp($_SESSION['idUser']);
					$sortie['nbEnt'] = sizeof($tab_temp);
					$tab_temp = $this->getEtudiantsResponsable($_SESSION['idUser']);
					$sortie['nbEtu'] = sizeof($tab_temp);
					$tab_temp = $this->getInscriptionfinaliseesResp($_SESSION['idUser']);
					$sortie['nbInscritsfinalisees']=sizeof($tab_temp);
					return $sortie;
				}

				//
				/**
				* Fonction qui permet de retourner l'identifiant correspondant à une adresse e-mail et à un type de compte.
				* @param  String $identifiant l'adresse mail de l'utilisateur (entreprise ou étudiant).
				* @param  String $type        le type du compte.
				* @return int    l'identifiant de l'utilisateur ou 0 si c'est l'administrateur.
				*/
				public function getId($identifiant,$type) {
					if ($type=="admin") {
						return 0;
					}
					if ($type=="entreprise") {
						$select = "IDEnt";
						$mail = "mailEnt";
					}
						//PROJET
					else if ($type=="responsable"){
						$select = "IDresp";
						$mail = "mailResp";
					 }
					//
					else {
						$select = "IDEtu";
						$mail = "mailEtu";
					}
					$this->connexion();

					$statement = $this->connexion->prepare("SELECT ".$select." FROM ".$type." where ".$mail."='".$identifiant."';");
					$statement->execute();
					$this->deconnexion();
					$tab = $statement->fetch();
					if ($type=="entreprise") {
						return $tab['IDEnt'];
					}
					//PROJET
					if ($type=="responsable") {

						return $tab['IDresp'];
					}
					//
					else {
						return $tab['IDEtu'];
					}
				}

				/**
				* Fonction qui permet de générer le planning.
				*/
				public function generatePlanning(){
					$this -> supprimerCreneau();
					$this -> connexion();
					$statement = $this->connexion->prepare("DELETE FROM creneau;");
					$statement->execute();
					$arrayNbCreneaux = $this -> getNbCreneaux();
					$creneauMatin = $arrayNbCreneaux[0];
					$creneauAprem = $arrayNbCreneaux[1];
					$nbCreneaux = $creneauMatin + $creneauAprem;

					$listeDepartement = array("DUT_INFO", "DUT_GEII", "DUT_GMP", "DUT_GTE", "DUT_GEA_2ans", "DUT_SGM", "LP_MIAR", "DUT_QLIO_1an", "DUT_QLIO_2ans","LP_LOGIQUAL","LP_FICA", "LP_SEICOM","LP_IMOCP","LP_IDEB", "LP_I2P_Conception", "LP_I2P_Production", "LP_I2P_Soudage_IWS", "LP_PEGC", "MASTER_CCA", "MASTER_ITI");
					foreach ($listeDepartement as $departement) {
						$Etudiants = array();
						$Choix = array();
						$Entreprises = array();
						$Creneaux = array();
						$LiensEntrCren = array();
						$Formations = array();
						$listeEtu = $this->getEtudiants($departement);               //On s'occupe de $Etudiants
						$cmp = 0;
						foreach ($listeEtu as $etu){
							$Etudiants[$cmp+1] = $etu["IDEtu"];
							$Choix[] = explode ( "," , $etu["listeChoixEtu"]);
							//nassim
							if ($etu["listeChoixEtu"]!="") {
								$ChoixEt=explode( "," , $etu["listeChoixEtu"]);
								$id=$etu["IDEtu"];

								foreach($ChoixEt as $ch)
								{
									$this->connexion();
									$statement = $this->connexion->prepare("INSERT INTO choixetudiant values(".$id.", ".$ch.");");
									$statement->execute();
								}
							}
							//nassim
							$cmp++;
						}               //On s'occupe de $Entreprises, $Creneaux et $LiensEntrCren
						$listeEnt = $this -> getEntreprises();
						foreach ($listeEnt as $ent){
							$Entreprises[] = $ent["IDEnt"];
						}
						$listeFormation = $this -> getFormations($departement);
						foreach ($Entreprises as $IDent) {
							$LiensEntrCren[$IDent][0] = 0;
						}               $cmp = 0;
						foreach ($listeFormation as $form){
							$tmp = array();

							$Formations[$form["entPropose"]][$LiensEntrCren[$form["entPropose"]][0]] = $form["IDformation"];                 $LiensEntrCren[$form["entPropose"]][0]++;
							$LiensEntrCren[$form["entPropose"]][$LiensEntrCren[$form["entPropose"]][0]] = $cmp;

							for ($i = 0; $i < $nbCreneaux; $i++) {
								$tmp[] = 0;
							}
							for ($i = $form["creneauDebut"]-1; $i <=$form["creneauFin"]-1; $i++) {
								$tmp[$i] = 1;
							}
							$Creneaux[] = $tmp;
							$cmp++;
						}
						$jobMeeting = new jobMeeting($Etudiants, $Choix, $Entreprises, $Creneaux, $LiensEntrCren, $Formations,  $nbCreneaux);
						$jobMeeting -> appli();
					}
					$this -> deconnexion();
				}



				/**
				* Fonction qui permet de modifier le nom de l'entreprise.
				* @param  int $id  l'identifiant de l'entreprise.
				* @param  String $new le nouveau nom de l'entreprise.
				*/
				public function editNomEntreprise($id,$new) {
					$this->connexion();
					if (isset($_SESSION['type_modification'])) {
						if ($_SESSION['type_modification'] == "tmpEnt") {
							$statement = $this->connexion->prepare("UPDATE temp_entreprise SET nomEnt='".strtoupper($new)."' WHERE IDEnt = ".$id.";");
						}
						else {
							$statement = $this->connexion->prepare("UPDATE entreprise SET nomEnt='".strtoupper($new)."' WHERE IDEnt = ".$id.";");
						}
					}
					else {
						$statement = $this->connexion->prepare("UPDATE entreprise SET nomEnt='".strtoupper($new)."' WHERE IDEnt = ".$id.";");
					}
					$statement->execute();
					$this->deconnexion();
					return;
				}

				/**
				* Fonction qui permet de modifier la ville de l'entreprise.
				* @param  int $id  l'identifiant de l'entreprise.
				* @param  String $new la nouvelle ville de l'entreprise.
				*/
				public function editVilleEntreprise($id,$new) {
					$this->connexion();
					if (isset($_SESSION['type_modification'])) {
						if ($_SESSION['type_modification'] == "tmpEnt") {
							$statement = $this->connexion->prepare("UPDATE temp_entreprise SET villeEnt='".$new."' WHERE IDEnt = ".$id.";");
						}
						else {
							$statement = $this->connexion->prepare("UPDATE entreprise SET villeEnt='".$new."' WHERE IDEnt = ".$id.";");
						}
					}
					else {
						$statement = $this->connexion->prepare("UPDATE entreprise SET villeEnt='".$new."' WHERE IDEnt = ".$id.";");
					}
					$statement->execute();
					$this->deconnexion();
					return;
				}

				/**
				* Fonction qui permet de modifier le code postal de l'entreprise.
				* @param  int $id  l'identifiant de l'entreprise.
				* @param  int $new le nouveau code postal de l'entreprise.
				*/
				public function editCPEntreprise($id,$new) {
					$this->connexion();
					if (isset($_SESSION['type_modification'])) {
						if ($_SESSION['type_modification'] == "tmpEnt") {
							$statement = $this->connexion->prepare("UPDATE temp_entreprise SET codePostal=".$new." WHERE IDEnt = ".$id.";");
						}
						else {
							$statement = $this->connexion->prepare("UPDATE entreprise SET codePostal=".$new." WHERE IDEnt = ".$id.";");
						}
					}
					else {
						$statement = $this->connexion->prepare("UPDATE entreprise SET codePostal=".$new." WHERE IDEnt = ".$id.";");
					}
					$statement->execute();
					$this->deconnexion();
					return;
				}

				/**
				* Fonction qui permet de modifier l'adresse de l'entreprise.
				* @param  int $id  l'identifiant de l'entreprise.
				* @param  String $new la nouvelle adresse de l'entreprise.
				*/
				public function editAdresseEntreprise($id,$new) {
					$this->connexion();
					if (isset($_SESSION['type_modification'])) {
						if ($_SESSION['type_modification'] == "tmpEnt") {
							$statement = $this->connexion->prepare("UPDATE temp_entreprise SET adresseEnt='".$new."' WHERE IDEnt = ".$id.";");
						}
						else {
							$statement = $this->connexion->prepare("UPDATE entreprise SET adresseEnt='".$new."' WHERE IDEnt = ".$id.";");
						}
					}
					else {
						$statement = $this->connexion->prepare("UPDATE entreprise SET adresseEnt='".$new."' WHERE IDEnt = ".$id.";");
					}
					$statement->execute();
					$this->deconnexion();
					return;
				}

				/**
				* Fonction qui permet de modifier le nom du contact de l'entreprise.
				* @param  int $id  l'identifiant de l'entreprise.
				* @param  String $new le nouveau nom du contact de l'entreprise.
				*/
				public function editNomContactEntreprise($id,$new) {
					$this->connexion();
					if (isset($_SESSION['type_modification'])) {
						if ($_SESSION['type_modification'] == "tmpEnt") {
							$statement = $this->connexion->prepare("UPDATE temp_entreprise SET nomContact='".$new."' WHERE IDEnt = ".$id.";");
						}
						else {
							$statement = $this->connexion->prepare("UPDATE entreprise SET nomContact='".$new."' WHERE IDEnt = ".$id.";");
						}
					}
					else {
						$statement = $this->connexion->prepare("UPDATE entreprise SET nomContact='".$new."' WHERE IDEnt = ".$id.";");
					}
					$statement->execute();
					$this->deconnexion();
					return;
				}

				/**
				* Fonction qui permet de modifier le prénom du contact de l'entreprise.
				* @param  int $id  l'identifiant de l'entreprise.
				* @param  String $new le nouveau prénom du contact de l'entreprise.
				*/
				public function editPrenomContactEntreprise($id,$new) {
					$this->connexion();
					if (isset($_SESSION['type_modification'])) {
						if ($_SESSION['type_modification'] == "tmpEnt") {
							$statement = $this->connexion->prepare("UPDATE temp_entreprise SET prenomContact='".$new."' WHERE IDEnt = ".$id.";");
						}
						else {
							$statement = $this->connexion->prepare("UPDATE entreprise SET prenomContact='".$new."' WHERE IDEnt = ".$id.";");
						}
					}
					else {
						$statement = $this->connexion->prepare("UPDATE entreprise SET prenomContact='".$new."' WHERE IDEnt = ".$id.";");
					}
					$statement->execute();
					$this->deconnexion();
					return;
				}

				/**
				* Fonction qui permet de modifier l'adresse e-mail de l'entreprise.
				* @param  int $id  l'identifiant de l'entreprise.
				* @param  String $new la nouvelle adresse e-mail de l'entreprise.
				*/
				public function editMailEntreprise($id,$new) {
					if (!$this->estInscrit($new)) {
						$this->connexion();
						if (isset($_SESSION['type_modification'])) {
							if ($_SESSION['type_modification'] == "tmpEnt") {
								$statement = $this->connexion->prepare("UPDATE temp_entreprise SET mailEnt='".$new."' WHERE IDEnt = ".$id.";");
							}
							else {
								$statement = $this->connexion->prepare("UPDATE entreprise SET mailEnt='".$new."' WHERE IDEnt = ".$id.";");
							}
						}
						else {
							$statement = $this->connexion->prepare("UPDATE entreprise SET mailEnt='".$new."' WHERE IDEnt = ".$id.";");
						}
						$statement->execute();
						$this->deconnexion();
					}
					return;
				}

				/**
				* Fonction qui permet de modifier le numéro de téléphone de l'entreprise.
				* @param  int $id  l'identifiant de l'entreprise.
				* @param  String $new le nouveau numéro de téléphone de l'entreprise.
				*/
				public function editTelephoneEntreprise($id,$new) {
					$this->connexion();
					if (isset($_SESSION['type_modification'])) {
						if ($_SESSION['type_modification'] == "tmpEnt") {
							$statement = $this->connexion->prepare("UPDATE temp_entreprise SET numTelEnt='".$new."' WHERE IDEnt = ".$id.";");
						}
						else {
							$statement = $this->connexion->prepare("UPDATE entreprise SET numTelEnt='".$new."' WHERE IDEnt = ".$id.";");
						}
					}
					else {
						$statement = $this->connexion->prepare("UPDATE entreprise SET numTelEnt='".$new."' WHERE IDEnt = ".$id.";");
					}
					$statement->execute();
					$this->deconnexion();
					return;
				}

				/**
				* Fonction qui permet de modifier l'offre de l'entreprise.
				* @param  int $id  l'identifiant de l'entreprise.
				* @param  String $new la nouvelle offre.
				*/
				public function editOffreEntreprise($id,$new) {
					$this->connexion();
					if (isset($_SESSION['type_modification'])) {
						if ($_SESSION['type_modification'] == "tmpEnt") {
							$statement = $this->connexion->prepare("UPDATE entreprise SET offre='".$new."' WHERE IDEnt = ".$id.";");
						}
						else {
							$statement = $this->connexion->prepare("UPDATE entreprise SET offre='".$new."' WHERE IDEnt = ".$id.";");
						}
					}
					else {
						$statement = $this->connexion->prepare("UPDATE entreprise SET offre='".$new."' WHERE IDEnt = ".$id.";");
					}
					$statement->execute();
					$this->deconnexion();
					return;
				}

    /**
     * Fonction qui permet de modifier le choix des meetings en visioconférence de l'entreprise
     */
                public function editVisioEntreprise($id, $new){
					$this->connexion();
					if (isset($_SESSION['type_modification'])) {
						if ($_SESSION['type_modification'] == "tmpEnt") {
							$statement = $this->connexion->prepare("UPDATE entreprise SET offre='".$new."' WHERE IDEnt = ".$id.";");
						}
						else {
							$statement = $this->connexion->prepare("UPDATE entreprise SET offre='".$new."' WHERE IDEnt = ".$id.";");
						}
					}
					else {
						$statement = $this->connexion->prepare("UPDATE entreprise SET offre='".$new."' WHERE IDEnt = ".$id.";");
					}
					$statement->execute();
					$this->deconnexion();
					return;
                }


				/**
				* Fonction qui permet de modifier les formations recherchées par l'entreprise.
				* @param  int $id  l'identifiant de l'entreprise.
				* @param  String $new les formations recherchées par l'entreprise.
				*/
				public function editFormationsRechercheesEntreprise($id,$new) {
					$this->connexion();
					if (substr($new, -1) == ",") {
						$new = substr($new,0, -1);
					}
					if (isset($_SESSION['type_modification'])) {
						if ($_SESSION['type_modification'] == "tmpEnt") {
							$statement = $this->connexion->prepare("UPDATE temp_entreprise SET formationsRecherchees='".$new."' WHERE IDEnt = ".$id.";");
						}
						else {
							$statement = $this->connexion->prepare("UPDATE entreprise SET formationsRecherchees='".$new."' WHERE IDEnt = ".$id.";");
						}
					}
					else {
						$statement = $this->connexion->prepare("UPDATE entreprise SET formationsRecherchees='".$new."' WHERE IDEnt = ".$id.";");
					}
					$statement->execute();
					$this->deconnexion();
					if (isset($_SESSION['type_modification'])) {
						if ($_SESSION['type_modification'] == "tmpEnt") {
							return;
						}
						else {
							$classFormation = "Formation";
							$classFormation::updateFormation($id);
							return;
						}
					}
				}

				/**
				* Fonction qui permet de modifier le type de créneau de l'entreprise.
				* @param  int $id  l'identifiant de l'entreprise.
				* @param  String $new le nouveau type de créneau de l'entreprise (matin/apres_midi,journee).
				*/
				public function editTypeCreneauEntreprise($id,$new) {
					$this->connexion();
					if (isset($_SESSION['type_modification'])) {
						if ($_SESSION['type_modification'] == "tmpEnt") {
							$statement = $this->connexion->prepare("UPDATE temp_entreprise SET typeCreneau='".$new."' WHERE IDEnt = ".$id.";");
						}
						else {
							$statement = $this->connexion->prepare("UPDATE entreprise SET typeCreneau='".$new."' WHERE IDEnt = ".$id.";");
						}
					}
					else {
						$statement = $this->connexion->prepare("UPDATE entreprise SET typeCreneau='".$new."' WHERE IDEnt = ".$id.";");
					}
					$statement->execute();
					$statement = $this->connexion->prepare("SELECT * FROM entreprise WHERE IDEnt = ".$id.";");
					$statement->execute();
					$recup = $statement->fetch();
					if ($recup['nbStands'] > $recup['nbRecruteurs']) {
						if (isset($_SESSION['type_modification'])) {
							if ($_SESSION['type_modification'] == "tmpEnt") {
								$statement = $this->connexion->prepare("UPDATE temp_entreprise SET nbRecruteurs='".$new."' WHERE IDEnt = ".$id.";");
							}
						}
						else {
							$statement = $this->connexion->prepare("UPDATE entreprise SET nbRecruteurs='".$new."' WHERE IDEnt = ".$id.";");
						}
						$statement->execute();
					}
					$this->deconnexion();
					if (isset($_SESSION['type_modification'])) {
						if ($_SESSION['type_modification'] == "tmpEnt") {
							return;
						}
						else {
							$classFormation = "Formation";
							$classFormation::updateFormation($id);
							return;
						}
					}
				}

				/**
				* Fonction qui permet de modifier le nombre de stands de l'entreprise.
				* @param  int $id  l'identifiant de l'entreprise.
				* @param  int $new le nombre de stands de l'entreprise.
				*/
				public function editNbStandsEntreprise($id,$new) {
					$this->connexion();
					if (isset($_SESSION['type_modification'])) {
						if ($_SESSION['type_modification'] == "tmpEnt") {
							$statement = $this->connexion->prepare("UPDATE temp_entreprise SET nbStands=".$new." WHERE IDEnt = ".$id.";");
						}
						else {
							$statement = $this->connexion->prepare("UPDATE entreprise SET nbStands=".$new." WHERE IDEnt = ".$id.";");
						}
					}
					else {
						$statement = $this->connexion->prepare("UPDATE entreprise SET nbStands=".$new." WHERE IDEnt = ".$id.";");
					}
					$statement->execute();
					$this->deconnexion();
					if (isset($_SESSION['type_modification'])) {
						if ($_SESSION['type_modification'] == "tmpEnt") {
							return;
						}
						else {
							$classFormation = "Formation";
							$classFormation::updateFormation($id);
							return;
						}
					}
				}

				/**
				* Fonction qui permet de modifier le nombre de repas de l'entreprise.
				* @param  int $id  l'identifiant de l'entreprise.
				* @param  int $new le nombre de repas de l'entreprise.
				*/
				public function editNbRepasEntreprise($id,$new) {
					$this->connexion();
					if (isset($_SESSION['type_modification'])) {
						if ($_SESSION['type_modification'] == "tmpEnt") {
							$statement = $this->connexion->prepare("UPDATE temp_entreprise SET nbRepas=".$new." WHERE IDEnt = ".$id.";");
						}
						else {
							$statement = $this->connexion->prepare("UPDATE entreprise SET nbRepas=".$new." WHERE IDEnt = ".$id.";");
						}
					}
					else {
						$statement = $this->connexion->prepare("UPDATE entreprise SET nbRepas=".$new." WHERE IDEnt = ".$id.";");
					}
					$statement->execute();
					$this->deconnexion();
					return;
				}

				/**
				* Fonction qui permet de modifier le nombre de recruteurs de l'entreprise.
				* @param  int $id  l'identifiant de l'entreprise.
				* @param  String $new le nouveau nombre de recruteurs de l'entreprise.
				*/
				public function editNbRecruteursEntreprise($id, $new) {
					$this->connexion();
					if (isset($_SESSION['type_modification'])) {
						if ($_SESSION['type_modification'] == "tmpEnt") {
							$statement = $this->connexion->prepare("UPDATE temp_entreprise SET nbRecruteurs='".$new."' WHERE IDEnt = ".$id.";");
						}
						else {
							$statement = $this->connexion->prepare("UPDATE entreprise SET nbRecruteurs='".$new."' WHERE IDEnt = ".$id.";");
						}
					}
					else {
						$statement = $this->connexion->prepare("UPDATE entreprise SET nbRecruteurs='".$new."' WHERE IDEnt = ".$id.";");
					}
					$statement->execute();
					if (isset($_SESSION['type_modification'])) {
						if ($_SESSION['type_modification'] == "tmpEnt") {
							$statement = $this->connexion->prepare("SELECT * FROM temp_entreprise WHERE IDEnt = ".$id.";");
						}
						else {
							$statement = $this->connexion->prepare("SELECT * FROM temp_entreprise WHERE IDEnt = ".$id.";");
						}
					}
					else {
						$statement = $this->connexion->prepare("SELECT * FROM entreprise WHERE IDEnt = ".$id.";");
					}
					$statement->execute();
					$recup = $statement->fetch();
					if ($recup['nbStands'] > $recup['nbRecruteurs']) {
						if (isset($_SESSION['type_modification'])) {
							if ($_SESSION['type_modification'] == "tmpEnt") {
								$statement = $this->connexion->prepare("UPDATE temp_entreprise SET nbStands='".$new."' WHERE IDEnt = ".$id.";");
							}
							else {
								$statement = $this->connexion->prepare("UPDATE entreprise SET nbStands='".$new."' WHERE IDEnt = ".$id.";");
							}
						}
						else {
							$statement = $this->connexion->prepare("UPDATE entreprise SET nbStands='".$new."' WHERE IDEnt = ".$id.";");
						}
						$statement->execute();
					}
					$this->deconnexion();
					return;
				}

				/**
				* Fonction qui permet de modifier le mot de passe de l'étudiant.
				* @param  int $id     l'identifiant de l'étudiant.
				* @param  String $new le nouveau mot de passe de l'étudiant.
				* @param  String $old l'ancier mot de passe de l'étudiant.
				*/
				public function editMdpEtudiant($id,$new_password,$old){
					try
					{
						if ($_SESSION['type_connexion'] == "admin") {
							if ($_SESSION['type_modification'] == "tmpEtu") {
								$this->connexion();
								$salt = chr(rand(48, 122)) ;
								for ($i = 0 ; $i < 11 ; $i++) //le "salt" sert à chiffrer le mot de passe, ici on va lui passer une chaine de 11 caractères
								{
									$salt .= chr(rand(48, 122)) ; //les caractères en question sont les codes ascii de chiffres et de lettres générés aléatoirement
								}
								$new_crypted_password = crypt($new_password, "$6$".$salt) ; //On chiffre le mot de passe à l'aide du sel ("$salt") créé ci-dessus
								$statement = $this->connexion->prepare("UPDATE temp_etudiant SET mdpEtu=? WHERE IDEtu =?;");
								$statement->bindParam(1, $new_crypted_password);
								$statement->bindParam(2, $id);
								$statement->execute();
								$this->deconnexion();
								return;
							}
							else {
								$this->connexion();
								$salt = chr(rand(48, 122)) ;
								for ($i = 0 ; $i < 11 ; $i++) //le "salt" sert à chiffrer le mot de passe, ici on va lui passer une chaine de 11 caractères
								{
									$salt .= chr(rand(48, 122)) ; //les caractères en question sont les codes ascii de chiffres et de lettres générés aléatoirement
								}
								$new_crypted_password = crypt($new_password, "$6$".$salt) ; //On chiffre le mot de passe à l'aide du sel ("$salt") créé ci-dessus
								$statement = $this->connexion->prepare("UPDATE etudiant SET mdpEtu=? WHERE IDEtu =?;");
								$statement->bindParam(1, $new_crypted_password);
								$statement->bindParam(2, $id);
								$statement->execute();
								$this->deconnexion();
								return;
							}
						}
						else {
							$this->connexion();
							$statement = $this->connexion->prepare('SELECT mailEtu FROM etudiant WHERE IDEtu = ?;');
							$statement->bindParam(1, $id);
							$statement->execute();
							$result = $statement->fetch();
							$login = $result['mailEtu'];
							if ($this -> verifieMotDePasse($login, $old)) {
								$this->connexion();
								$salt = chr(rand(48, 122)) ;
								for ($i = 0 ; $i < 11 ; $i++) //le "salt" sert à chiffrer le mot de passe, ici on va lui passer une chaine de 11 caractères
								{
									$salt .= chr(rand(48, 122)) ; //les caractères en question sont les codes ascii de chiffres et de lettres générés aléatoirement
								}
								$new_crypted_password = crypt($new_password, "$6$".$salt) ; //On chiffre le mot de passe à l'aide du sel ("$salt") créé ci-dessus
								$statement = $this->connexion->prepare("UPDATE etudiant SET mdpEtu=? WHERE IDEtu =?;");
								$statement->bindParam(1, $new_crypted_password);
								$statement->bindParam(2, $id);
								$statement->execute();
								$this->deconnexion();
								return;
							}
							else {
								echo '<script>alert("Attention votre mot de passe ne correspond pas : le changement n\'est pas pris en compte.");</script>';
								return;
							}
						}
					}
					catch(AccesTableException $e)
					{
						print($e->getMessage());
					}
				}

				/**
				* Fonction qui permet de modifier le mot de passe d'une entreprise.
				* @param  int $id     l'identifiant d'une entreprise.
				* @param  String $new le nouveau mot de passe d'une entreprise.
				* @param  String $old l'ancier mot de passe d'une entreprise.
				*/
				public function editMdpEntreprise($id,$new_password,$old) {
					try
					{
						if ($_SESSION['type_connexion'] == "admin") {
							if ($_SESSION['type_modification'] == "tmpEnt") {
								$this->connexion();
								$salt = chr(rand(48, 122)) ;
								for ($i = 0 ; $i < 11 ; $i++)  //le "salt" sert à chiffrer le mot de passe, ici on va lui passer une chaine de 11 caractères
								{
									$salt .= chr(rand(48, 122)) ; //les caractères en question sont les codes ascii de chiffres et de lettres générés aléatoirement
								}
								$new_crypted_password = crypt($new_password, "$6$".$salt) ; //On chiffre le mot de passe à l'aide du sel ("$salt") créé ci-dessus
								$statement = $this->connexion->prepare("UPDATE temp_entreprise SET mdpEnt=? WHERE IDEnt =?;");
								$statement->bindParam(1, $new_crypted_password);
								$statement->bindParam(2, $id);
								$statement->execute();
								$this->deconnexion();
								return;
							}
							else {
								$this->connexion();
								$salt = chr(rand(48, 122)) ;
								for ($i = 0 ; $i < 11 ; $i++) //le "salt" sert à chiffrer le mot de passe, ici on va lui passer une chaine de 11 caractères
								{
									$salt .= chr(rand(48, 122)) ; //les caractères en question sont les codes ascii de chiffres et de lettres générés aléatoirement
								}
								$new_crypted_password = crypt($new_password, "$6$".$salt) ; //On chiffre le mot de passe à l'aide du sel ("$salt") créé ci-dessus
								$statement = $this->connexion->prepare("UPDATE entreprise SET mdpEnt=? WHERE IDEnt =?;");
								$statement->bindParam(1, $new_crypted_password);
								$statement->bindParam(2, $id);
								$statement->execute();
								$this->deconnexion();
								return;
							}
						}
						else {
							$this->connexion();
							$statement = $this->connexion->prepare('SELECT mailEnt FROM entreprise WHERE IDEnt ='.$id.';');
							$statement->execute();
							$result = $statement->fetch();
							$login = $result['mailEnt'];
							if ($this -> verifieMotDePasse($login, $old)) {
								$this->connexion();
								$salt = chr(rand(48, 122)) ;
								for ($i = 0 ; $i < 11 ; $i++)  //le "salt" sert à chiffrer le mot de passe, ici on va lui passer une chaine de 11 caractères
								{
									$salt .= chr(rand(48, 122)) ; //les caractères en question sont les codes ascii de chiffres et de lettres générés aléatoirement
								}
								$new_crypted_password = crypt($new_password, "$6$".$salt) ; //On chiffre le mot de passe à l'aide du sel ("$salt") créé ci-dessus
								$statement = $this->connexion->prepare("UPDATE entreprise SET mdpEnt=? WHERE IDEnt =?;");
								$statement->bindParam(1, $new_crypted_password);
								$statement->bindParam(2, $id);
								$statement->execute();
								$this->deconnexion();
								return;
							}
							else {
								echo '<script>alert("Attention votre mot de passe ne correspond pas : le changement n\'est pas pris en compte.");</script>';
								return;
							}
						}
					}
					catch(AccesTableException $e)
					{
						print($e->getMessage());
					}
				}

				/**
				* Fonction qui permet d'éditer le nom de l'étudiant.
				* @param  int    $id  l'identifiant de l'étudiant.
				* @param  String $new le nom de l'étudiant.
				*/
				public function editNomEtudiant($id,$new) {
					$this->connexion();
					if (isset($_SESSION['type_modification'])) {
						if ($_SESSION['type_modification'] == "tmpEtu") {
							$statement = $this->connexion->prepare("UPDATE temp_etudiant SET nomEtu='".$new."' WHERE IDEtu = ".$id.";");
						}
						else {
							$statement = $this->connexion->prepare("UPDATE etudiant SET nomEtu='".$new."' WHERE IDEtu = ".$id.";");
						}
					}
					else {
						$statement = $this->connexion->prepare("UPDATE etudiant SET nomEtu='".$new."' WHERE IDEtu = ".$id.";");
					}
					$statement->execute();
					$this->deconnexion();
					return;
				}


				/**
				* Fonction qui permet d'éditer le prénom de l'étudiant.
				* @param  int    $id  l'identifiant de l'étudiant.
				* @param  String $new le prénom de l'étudiant.
				*/
				public function editPrenomEtudiant($id,$new) {
					$this->connexion();
					if (isset($_SESSION['type_modification'])) {
						if ($_SESSION['type_modification'] == "tmpEtu") {
							$statement = $this->connexion->prepare("UPDATE temp_etudiant SET prenomEtu='".$new."' WHERE IDEtu = ".$id.";");
						}
						else {
							$statement = $this->connexion->prepare("UPDATE etudiant SET prenomEtu='".$new."' WHERE IDEtu = ".$id.";");
						}
					}
					else {
						$statement = $this->connexion->prepare("UPDATE etudiant SET prenomEtu='".$new."' WHERE IDEtu = ".$id.";");
					}
					$statement->execute();
					$this->deconnexion();
					return;
				}


				/**
				* Fonction qui permet d'éditer l'adresse e-mail de l'étudiant.
				* @param  int    $id  l'identifiant de l'étudiant.
				* @param  String $new l'adresse e-mail de l'étudiant.
				*/
				public function editMailEtudiant($id,$new) {
					if (!$this->estInscrit($new)) {
						$this->connexion();
						if (isset($_SESSION['type_modification'])) {
							if ($_SESSION['type_modification'] == "tmpEtu") {
								$statement = $this->connexion->prepare("UPDATE temp_etudiant SET mailEtu='".$new."' WHERE IDEtu = ".$id.";");
							}
							else {
								$statement = $this->connexion->prepare("UPDATE etudiant SET mailEtu='".$new."' WHERE IDEtu = ".$id.";");
							}
						}
						else {
							$statement = $this->connexion->prepare("UPDATE etudiant SET mailEtu='".$new."' WHERE IDEtu = ".$id.";");
						}
						$statement->execute();
						$this->deconnexion();
					}
					return;
				}

				/**
				* Fonction qui permet d'éditer le numéro de téléphone de l'étudiant.
				* @param  int    $id  l'identifiant de l'étudiant.
				* @param  String $new le numéro de téléphone de l'étudiant.
				*/
				public function editTelephoneEtudiant($id,$new) {
					$this->connexion();
					if (isset($_SESSION['type_modification'])) {
						if ($_SESSION['type_modification'] == "tmpEtu") {
							$statement = $this->connexion->prepare("UPDATE temp_etudiant SET numtelEtu='".$new."' WHERE IDEtu = ".$id.";");
						}
						else {
							$statement = $this->connexion->prepare("UPDATE etudiant SET numtelEtu='".$new."' WHERE IDEtu = ".$id.";");
						}
					}
					else {
						$statement = $this->connexion->prepare("UPDATE etudiant SET numtelEtu='".$new."' WHERE IDEtu = ".$id.";");
					}
					$statement->execute();
					$this->deconnexion();
					return;
				}

				/**
				* Fonction qui permet d'éditer la formation de l'étudiant.
				* @param  int    $id  l'identifiant de l'étudiant.
				* @param  String $new la formation de l'étudiant.
				*/
				public function editFormationEtudiant($id,$new) {
					$this->connexion();
					if (isset($_SESSION['type_modification'])) {
						if ($_SESSION['type_modification'] == "tmpEtu") {
							$statement = $this->connexion->prepare("UPDATE temp_etudiant SET formationEtu='".$new."' WHERE IDEtu = ".$id.";");
						}
						else {
							$statement = $this->connexion->prepare("UPDATE etudiant SET formationEtu='".$new."' WHERE IDEtu = ".$id.";");
						}
					}
					else {
						$statement = $this->connexion->prepare("UPDATE etudiant SET formationEtu='".$new."' WHERE IDEtu = ".$id.";");
					}
					$statement->execute();
					$this->deconnexion();
					return;
				}


				/**
				* Fonction qui permet d'éditer les choix de l'étudiant.
				* @param  int    $id  l'identifiant de l'étudiant.
				* @param  String $new les nouveaux choix de l'étudiant.
				*/
				public function editChoixEtudiant($id,$new) {
					$this->connexion();
					if (isset($_SESSION['type_modification'])) {
						if ($_SESSION['type_modification'] == "tmpEtu") {
							$statement = $this->connexion->prepare("UPDATE temp_etudiant SET listechoixEtu='".$new."' WHERE IDEtu = ".$id.";");
						}
						else {
							$statement = $this->connexion->prepare("UPDATE etudiant SET listechoixEtu='".$new."' WHERE IDEtu = ".$id.";");
						}
					}
					else {
						$statement = $this->connexion->prepare("UPDATE etudiant SET listechoixEtu='".$new."' WHERE IDEtu = ".$id.";");
					}
					$statement->execute();
					$this->deconnexion();
					return;
				}

				/**
				* ??
				* Fonction qui permet d'éditer le mot de passe d'un étudiant.
				* @param  int    $id  l'identifiant de l'étudiant.
				* @param  String $new le nouveau mot de passe de l'étudiant de l'étudiant.
				* @param  String $old l'ancien mot de passe de l'étudiant.
				*/
				public function Etudiant($id,$new,$old) {
					if ($_SESSION['type_connexion'] == "admin") {
						if ($_SESSION['type_modification'] == "tmpEtu") {
							$this->connexion();
							$statement = $this->connexion->prepare('SELECT mailEtu FROM temp_etudiant WHERE IDEtu ='.$id.';');
							$statement->execute();
							$result = $statement->fetch();
							$login = $result['mailEtu'];
							$statement = $this->connexion->prepare("UPDATE temp_etudiant SET mdpEtu='".crypt($new)."' WHERE IDEtu = ".$id.";");
							$this->connexion();
							$statement = $this->connexion->prepare("UPDATE temp_etudiant SET mdpEtu='".crypt($new)."' WHERE IDEtu = ".$id.";");
							$statement->execute();
							$this->deconnexion();
							return;
						}
						else {
							$this->connexion();
							$statement = $this->connexion->prepare('SELECT mailEtu FROM etudiant WHERE IDEtu ='.$id.';');
							$statement->execute();
							$result = $statement->fetch();
							$login = $result['mailEtu'];
							$statement = $this->connexion->prepare("UPDATE etudiant SET mdpEtu='".crypt($new)."' WHERE IDEtu = ".$id.";");
							if ($this -> verifieMotDePasse($login, $old)) {
								$this->connexion();
								$statement = $this->connexion->prepare("UPDATE etudiant SET mdpEtu='".crypt($new)."' WHERE IDEtu = ".$id.";");
								$statement->execute();
								$this->deconnexion();
								return;
							}
							else {
								echo '<script>alert("Attention votre mot de passe ne correspond pas : le changement n\'est pas pris en compte.");</script>';
								return;
							}
						}
					}
					else {
						$this->connexion();
						$statement = $this->connexion->prepare('SELECT mailEtu FROM etudiant WHERE IDEtu ='.$id.';');
						$statement->execute();
						$result = $statement->fetch();
						$login = $result['mailEtu'];
						$statement = $this->connexion->prepare("UPDATE etudiant SET mdpEtu='".crypt($new)."' WHERE IDEtu = ".$id.";");
						if ($this -> verifieMotDePasse($login, $old)) {
							$this->connexion();
							$statement = $this->connexion->prepare("UPDATE etudiant SET mdpEtu='".crypt($new)."' WHERE IDEtu = ".$id.";");
							$statement->execute();
							$this->deconnexion();
							return;
						}
						else {
							echo '<script>alert("Attention votre mot de passe ne correspond pas : le changement n\'est pas pris en compte.");</script>';
							return;
						}
					}
				}

				/**
				* Fonction qui permet d'éditer la date de début d'inscription des entreprises.
				* @param  String $new la date de début d'inscription.
				*/
				function editDateDebutInscriptionEnt($new) {
					try
					{
						$this->connexion();
						$statement = $this->connexion->prepare("UPDATE scriptconfig SET dateDebutInscriptionEnt = ? ;");
						$statement->bindParam(1, $new);
						$statement->execute();
					}
					catch(AccesTableException $e)
					{
						print($e->getMessage());
					}
					$this->deconnexion();
				}

				/**
				* Fonction qui permet d'éditer la date de début d'inscription des étudiants.
				* @param  String $new la date de début d'inscription.
				*/
				function editDateDebutInscriptionEtu($new) {
					try
					{
						$this->connexion();
						$statement = $this->connexion->prepare("UPDATE scriptconfig SET dateDebutInscriptionEtu = ? ;");
						$statement->bindParam(1, $new);
						$statement->execute();
					}
					catch(AccesTableException $e)
					{
						print($e->getMessage());
					}
					$this->deconnexion();
				}

				/**
				* Fonction qui permet d'éditer la date de fin d'inscription des étudiants.
				* @param  String $new la date de fin d'inscription.
				*/
				function editDateFinInscription($new) {
					try
					{
						$this->connexion();
						$statement = $this->connexion->prepare("UPDATE scriptconfig SET dateFinInscription = ? ;");
						$statement->bindParam(1, $new);
						$statement->execute();
					}
					catch(AccesTableException $e)
					{
						print($e->getMessage());
					}
					$this->deconnexion();
				}

				/**
				* Fonction qui permet d'éditer la date de fin d'inscription des entreprises.
				* @param  String $new la date de fin d'inscription.
				*/
				function editDateFinInscriptionEnt($new) {
					try
					{
						$this->connexion();
						$statement = $this->connexion->prepare("UPDATE scriptconfig SET dateFinInscriptionEnt = ? ;");
						$statement->bindParam(1, $new);
						$statement->execute();
					}
					catch(AccesTableException $e)
					{
						print($e->getMessage());
					}
					$this->deconnexion();
				}

				/**
				* Fonction qui permet d'éditer la date à partir de laquelle on peut voir le planning.
				* @param  String $new la nouvelle date.
				*/
				function editDateDebutVuePlanning($new) {
					try
					{
						$this->connexion();
						$statement = $this->connexion->prepare("UPDATE scriptconfig SET dateDebutVuePlanning = ? ;");
						$statement->bindParam(1, $new);
						$statement->execute();
					}
					catch(AccesTableException $e)
					{
						print($e->getMessage());
					}
					$this->deconnexion();
				}

				/**
				* Fonction qui permet de supprimer les 'formations' d'une entreprise.
				* @param  int $idEntreprise l'identifiant de l'entreprise concernée.
				*/
				public function supprimerFormation($idEntreprise){
					try
					{
						$this -> connexion();
						$statement = $this->connexion->prepare('DELETE FROM formation WHERE entPropose = ?;');
						$statement->bindParam(1, $idEntreprise);
						$statement -> execute();
					}
					catch(AccesTableException $e)
					{
						print($e->getMessage());
					}
					$this->deconnexion();
				}

				/**
				* Fonction qui permet de changer le mot de passe d'un utilisateur quand il l'a oublié.
				* @param String $mail l'adresse mail de l'utilisateur.
				* @param String $profil  le profil (etudiant / entreprise) de l'utilisateur.
				* @param String $new_password le nouveau mot de passe du compte.
				*/
				public function PasswdEdit($mail,$profil,$new_password){
					try
					{
						$this->connexion();
						$salt = chr(rand(48, 122)) ;
						for ($i = 0 ; $i < 11 ; $i++) //le "salt" sert à chiffrer le mot de passe, ici on va lui passer une chaine de 11 caractères
						{
							$salt .= chr(rand(48, 122)) ; //les caractères en question sont les codes ascii de chiffres et de lettres générés aléatoirement
						}
						if($profil=='entreprise'){
							$new_crypted_password = crypt($new_password, "$6$".$salt) ; //On chiffre le mot de passe à l'aide du sel ("$salt") créé ci-dessus
							$statement = $this->connexion->prepare("UPDATE entreprise SET mdpEnt = ? WHERE mailEnt = ?;");
							$statement->bindParam(1, $new_crypted_password);
							$statement->bindParam(2, $mail);
						}
						else if($profil=='etudiant'){
							$new_crypted_password = crypt($new_password, "$6$".$salt) ; //On chiffre le mot de passe à l'aide du sel ("$salt") créé ci-dessus
							$statement = $this->connexion->prepare("UPDATE etudiant SET mdpEtu = ? WHERE mailEtu = ?;");
							$statement->bindParam(1, $new_crypted_password);
							$statement->bindParam(2, $mail);
						}
						$statement->execute();
						$nbLignes = $statement->rowCount();
						if( $nbLignes == 0){
							$this->deconnexion();
							return false;
						}
						else{
							$this->deconnexion();
							return true;
						}
					}
					catch (AccesTableException $e)
					{
						print($e -> getMessage());
					}
				}


		    public function getNbReserver($nomEntreprise, $typeForm)
	{
		try {
			$this->connexion();
			$statement = $this->connexion->prepare('SELECT sum(nbcreneauxReserves) as nbCR FROM entnbresaffinscrits WHERE typeFormation= ? and nomEnt= ?');
                        $statement->bindParam(1,$typeForm);
                        $statement->bindParam(2,$nomEntreprise);
			$statement->execute();
			$tabResult = $statement->fetch();
			$ret[0] = $tabResult['nbCR'];
			$this->deconnexion();
			return $ret;
		}
		catch (AccesTableException $e)
		{
			print($e -> getMessage());
		}
	}

	      public function getNbChoix($idEnt,$nomEntreprise, $typeForm)
	{
		try {
			$this->connexion();
			//$statement = $this->connexion->prepare('SELECT sum(nbEtudinantsInscrits) as nbCR FROM entnbresaffinscrits WHERE typeFormation= ? and nomEnt= ?');
			$statement = $this->connexion->prepare('SELECT count(*) as nbCR FROM etudiant WHERE formationEtu= ? and listechoixEtu LIKE ?');
        		$statement->bindParam(1,$typeForm);
			$statement->bindValue(2,"%$idEnt%");
			$statement->execute();
			$tabResult = $statement->fetch();
			$ret[0] = $tabResult['nbCR'];
			$this->deconnexion();
			return $ret;
		}
		catch (AccesTableException $e)
		{
			print($e -> getMessage());
		}
	}

				/**
				* Fonction permettant de retourner un nombre suivant le nombre de places restantes d'une entreprise pour une formation
				* @param  int $idEntreprise l'identifiant de l'entreprise concernée.
				* @param  String $formation le nom de la formation.
				* @return int un entier variant selon le nombre de places encore disponibles.
				* 2 si la majorité des places est disponible
				* 1 si une minorité de places est disponible
				* 0 s'il ne reste plus que quelques places
				* -1 si aucune place n'est disponible
				*/
				public function getNbPlacesRestantes($idEntreprise,$formation){
					try {

						$nomEnt = $this->getNomEntreprise($idEntreprise);

						//Nombre de créneaux pour la journée
                        $nbCreneauxTmp = $this->getNbCreneaux();
                        $nbCreneaux = $nbCreneauxTmp[0] + $nbCreneauxTmp[1];

                        $nbCreneauxRes=$this->getNbReserver($nomEnt, $formation);
                        $nbPlacesTotal = $nbCreneauxRes[0];

                        $nbCreneauxCh=$this->getNbChoix($idEntreprise,$nomEnt, $formation);
                        $nbChoix = $nbCreneauxCh[0];

                        $this->connexion();



                         $this->deconnexion();

                        //Il reste la majorité des places
                        if($nbChoix < $nbPlacesTotal/2){
                        return 2;
                        }
                        //Il reste une minorité de places
                        else if($nbChoix <= $nbPlacesTotal-1){
                        return 1;
                         }
                       //Plus aucune place de disponible
                       else if($nbChoix >=$nbPlacesTotal+1){
                     return -1;
                        }
                       //Il ne reste plus que quelques places (jusqu'au nombre attendu + 2)
                      else{
                     return 0;
                     }

						//Nombre de stands organisés pour l'entreprise pour cette formation et nombre étudiants inscrits
					/*	$this->connexion();
						$statNbPlaces = $this->connexion->prepare('SELECT nbcreneauxReserves, nbEtudinantsInscrits FROM entnbresaffinscrits where typeFormation = ? and nomEnt = ?;');


						$statNbPlaces->bindParam(1,$formation);
						$statNbPlaces->bindParam(2,$nomEntreprise);

						$statNbPlaces->execute();

						$res = $statNbPlaces->fetch(PDO::FETCH_ASSOC);
						$nbTotalCreneaux = $res['nbcreneauxReserves'];
						$nbEtudiantsInscrits = $res['nbEtudinantsInscrits'];

						$this->deconnexion();

						//Il reste la majorité des places
						if($nbEtudiantsInscrits <= $nbTotalCreneaux/2){
							return 2;
						}
						//Il reste une minorité de places
						else if($nbEtudiantsInscrits <= $nbTotalCreneaux){
							return 1;
						}
						//Plus aucune place de disponible
						else if($nbEtudiantsInscrits >= $nbTotalCreneaux + 3){
							return -1;
						}
						//Il ne reste plus que quelques places (jusqu'au nombre attendu + 2)
						else{
							return 0;
						}*/

					} catch (AccesTableException $e) {
						print($e -> getMessage());
					}
				}







				/**
				* Méthode permettant de retourner le planning d'un étudiant
				* @param $idEtu l'identifiant de l'étudiant
				* @return le planning de l'étudiant sous la forme d'un tableau de tableaux avec
				* un tableau par créneau ( [0] => heureDebut, [1] => nomEntreprise )
				*/
				public function getEtuPlanning($idEtu)
				{
					try
					{
						$this->connexion();
						$statement = $this->connexion->prepare(
							"SELECT
							heurecreneau.heure AS heure, entreprise.nomEnt AS nomEnt
							from creneau,formation,entreprise,
							etudiant,heurecreneau where
							etudiant.IDEtu = ? and
							creneau.idFormation = formation.IDformation and
							formation.entPropose = entreprise.IDEnt and
							etudiant.IDEtu = creneau.idEtudiant and
							creneau.numeroCreneau = heurecreneau.Num order by 1 ASC");
						$statement->bindParam(1,$idEtu);
						$statement->execute();
						$tabResult = $statement->fetchAll();
						$this->deconnexion();
						$listeCreneaux=array();
						foreach ($tabResult as $creneau)
						{
							$listeCreneaux[]=array($creneau['heure'],$creneau['nomEnt']);
						}
						return $listeCreneaux;
					}
					catch (AccesTableException $e)
					{
						print($e -> getMessage());
					}
				}


				/**
				* Méthode permettant de retourner le planning d'une entreprise
				* @param $idEnt l'identifiant de l'entreprise
				* @return le planning de l'entreprise sous la forme d'un tableau de tableaux avec
				* un tableau par créneau ( [0] => heureDebut, [1] => nomFormation, [2] => prenomEtudiant, [3] => nomEtudiant )
				*/
				public function getEntPlanning($idEnt)
				{
					try
					{
						$this->connexion();
						$statement = $this->connexion->prepare(
							"SELECT heurecreneau.heure AS heure, formation.typeFormation AS formation, etudiant.prenomEtu as prenomEtu, etudiant.nomEtu AS nomEtu
							 from creneau,formation,entreprise,etudiant,heurecreneau
							 where
							 entreprise.IDEnt = ? and
							 creneau.idFormation = formation.IDformation and
							 formation.entPropose = entreprise.IDEnt and
							 etudiant.IDEtu = creneau.idEtudiant and
							 creneau.numeroCreneau = heurecreneau.Num order by 1 ASC");
						$statement->bindParam(1,$idEnt);
						$statement->execute();
						$tabResult = $statement->fetchAll();
						$this->deconnexion();
						$listeCreneaux=array();
						foreach ($tabResult as $creneau)
						{
							$listeCreneaux[]=array($creneau['heure'],$creneau['formation'],$creneau['prenomEtu'],$creneau['nomEtu']);
						}
						return $listeCreneaux;
					}
					catch (AccesTableException $e)
					{
						print($e -> getMessage());
					}
				}



				/**
				* Méthode qui permet de récupérer le nom et prénom d'un étudiant suivant son adresse mail
				*
				* @return le nom et le prénom de l'étudiant
				*/
				public function getEtudiantMail($mail)
				{
					try
					{
						$this->connexion() ;
						$statement = $this->connexion->prepare('SELECT nomEtu,prenomEtu FROM etudiant WHERE mailEtu=?;') ;
						$statement->bindParam(1, $mail);
						$statement->execute() ;
						$result = $statement->fetch();

						return array($result['nomEtu'],$result['prenomEtu']);
					}
					catch(AccesTableException $e)
					{
						print($e->getMessage()) ;
					}
					$this->deconnexion() ;
				}

				/**
				* Méthode qui permet de récupérer le nom d'une entreprise suivant son adresse mail
				*
				* @return le nom de l'utilisateur
				*/
				public function getNomEntrepriseMail($mail)
				{
					try
					{
						$this->connexion() ;
						$statement = $this->connexion->prepare('SELECT nomEnt FROM entreprise WHERE mailEnt=?;') ;
						$statement->bindParam(1, $mail);
						$statement->execute() ;
						$nomEntreprise = $statement->fetch()["nomEnt"] ;

						return $nomEntreprise;
					}
					catch(AccesTableException $e)
					{
						print($e->getMessage()) ;
					}
					$this->deconnexion() ;
				}

				/**
				* Fonction permettant d'avoir la liste des formations et leur nombre de créneaux la concernant
				*
				* @return    un tableau de formations avec pour chacune d'elle, les informations sur le nombre de créneaux affectés à la formation
				*/
				public function getNbCreneauxParFormation()
				{
					try
					{
						$this->connexion();
						$statement = $this->connexion->prepare('SELECT IDFormation, typeFormation, SUM(nbcreneauxReserves) as nbCreneauxReserves, SUM(NBCreneauxAffectes) as nbCreneauxAffectes, SUM(nbEtudinantsInscrits) as nbEtudiantsInscrits FROM entnbresaffinscrits GROUP BY typeFormation');
						$statement->execute();
						$tabResult = $statement->fetchAll(PDO::FETCH_ASSOC);
						$this->deconnexion();
						return $tabResult;
					}
					catch (AccesTableException $e)
					{
						print($e -> getMessage());
					}
				}

				///PROJET
				/**
				* Fonction permettant d'avoir la liste des formations et leur nombre de créneaux la concernant
				*
				* @return    un tableau de formations avec pour chacune d'elle, les informations sur le nombre de créneaux affectés à la formation
				*/
				public function getNbCreneauxParFormationResponsable($idResponsable)
				{
					try
					{
						$this->connexion();
						$statement = $this->connexion->prepare('SELECT IDFormation, typeFormation, SUM(nbcreneauxReserves) as nbCreneauxReserves, SUM(NBCreneauxAffectes) as nbCreneauxAffectes, SUM(nbEtudinantsInscrits) as nbEtudiantsInscrits FROM entnbresaffinscrits WHERE typeformation IN (SELECT typeformation from lienformationresp where IDresp = ?)GROUP BY typeFormation');
						$statement->bindParam(1,$idResponsable);
						$statement->execute();
						$tabResult = $statement->fetchAll(PDO::FETCH_ASSOC);
						$this->deconnexion();
						return $tabResult;
					}
					catch (AccesTableException $e)
					{
						print($e -> getMessage());
					}
				}
				///

				/**
				* Fonction permettant d'avoir pour une formation, les entreprises et le nombre de créneaux concernés
				* @param 		 $nomFormation le nom de la formation
				* @return    un tableau contenant les informations pour une entreprise
				*/
				public function getNbCreneauxFormation($nomFormation){
					try
					{
						$this->connexion();
						$statement = $this->connexion->prepare('SELECT * FROM entnbresaffinscrits where typeFormation = ?');
						$statement->bindParam(1,$nomFormation);
						$statement->execute();
						$tabResult = $statement->fetchAll(PDO::FETCH_ASSOC);
						$this->deconnexion();
						return $tabResult;
					}
					catch (AccesTableException $e)
					{
						print($e -> getMessage());
					}
				}

				/**
				*Méthode qui retourne toutes les heures des créneaux
				*@return la liste des créneaux
				*/
				public function getListeCreneaux(){
					try {
						$this->connexion();
						$statement = $this->connexion->prepare('SELECT heure FROM heurecreneau;');
						$statement->execute();
						$tabResult = $statement->fetchAll();
						$result = array();
						foreach ($tabResult as $value) {
							array_push($result, $value['heure']);
						}
						return $result;
					}
					catch (AccesTableException $e)
					{
						print($e->getMessage());
					}

				}

				public function getPlanning(){
					try{
						$this->connexion();
						$statement = $this->connexion->prepare('SELECT * from planning1 ORDER BY nomEnt, jurie,heure');
						$statement->execute();
						$result = $statement->fetchAll();
						return $result;
					}
					catch(AccesTableException $e)
					{
						print($e->getMessage()) ;
					}
					$this->deconnexion() ;
				}

				public function getPlanningResp($formation){
					try{
						$this->connexion();
						$statement = $this->connexion->prepare('SELECT * from planning1 where typeFormation IN (SELECT typeformation from formation where typeformation IN (Select typeformation from lienformationresp where IDresp = ?))');
						$statement->bindParam(1,$formation);
						$statement->execute();
						$result = $statement->fetchAll();
						return $result;
						//return array($result['typeFormation'],$result['nomEnt'],$result['nomEtu'],$result['prenomEtu'],$result['heure']);
					}
					catch(AccesTableException $e)
					{
						print($e->getMessage()) ;
					}
					$this->deconnexion() ;
				}
				/**
				* Méthode qui permet de récupérer le planning d'une entreprise.
				* @param  String  $nomEnt le nom de l'entreprise.
				* @return array   un tableau des créneaux de l'entreprise.
				*/
				public function getPlanningCsv($nomEnt){
					try {
						$this->connexion();
						$statement = $this->connexion->prepare('SELECT * FROM `planning` WHERE nomEnt=?;');
						$statement->bindParam(1,$nomEnt);
						$statement->execute();
						$tabResult = $statement->fetchAll();
						$this->deconnexion();
						return $tabResult;
					}
					catch (AccesTableException $e)
					{
						print($e->getMessage());
					}

				}

				public function getHeure($num){
					try {
						$this->connexion();
						$statement = $this->connexion->prepare('SELECT heure FROM heurecreneau WHERE num=?;');
						$statement->bindParam(1,$num);
						$statement->execute();
						$tabResult = $statement->fetch();
						$this->deconnexion();
						return $tabResult["heure"];
					}
					catch (AccesTableException $e)
					{
						print($e->getMessage());
					}
				}

				public function verifEtuSurCreneau($idEtu, $numCreneau){
					try {
						$this->connexion();
						$statement = $this->connexion->prepare('SELECT idEtudiant from creneau where idEtudiant = ? and numeroCreneau = ?');
						$statement->bindParam(1,$idEtu);
						$statement->bindParam(2,$numCreneau);
						$statement->execute();
						$res = $statement->fetch();
						$this->deconnexion();
						return $res;
					}
					catch (AccesTableException $e)
					{
						print($e->getMessage());
					}
				}

				public function verifEtuSurCreneauEntreprise($idFormation, $numCreneau){
					try {
						$this->connexion();
						$statement = $this->connexion->prepare('SELECT idEtudiant FROM creneau WHERE idFormation = ? and numeroCreneau = ?');
						$statement->bindParam(1,$idFormation);
						$statement->bindParam(2,$numCreneau);
						$statement->execute();
						$res = $statement->fetch();
						$this->deconnexion();
						return $res;
					}
					catch (AccesTableException $e)
					{
						print($e->getMessage());
					}
				}

				public function supprimerEtuCreneau($numCreneau, $idEtu)
				{
					$this->connexion();
					$statement = $this->connexion->prepare('DELETE FROM creneau WHERE numeroCreneau = ? AND idEtudiant= ?');
					$statement->bindParam(1, $numCreneau);
					$statement->bindParam(2, $idEtu);
					$statement->execute();
					$this->deconnexion();
					return;
				}

				public function ajouterEtuCreneau($numCreneau, $idFormation, $idEtu)
				{
					$heure_debut = "00:00:00";
					$heure_fin = "00:00:00";

					$this->connexion();
					$statement = $this->connexion->prepare('INSERT INTO creneau VALUES (?,?,?,?,?)');
					$statement->bindParam(1, $numCreneau);
					$statement->bindParam(2, $heure_debut);
					$statement->bindParam(3, $heure_fin);
					$statement->bindParam(4, $idFormation);
					$statement->bindParam(5, $idEtu);
					$statement->execute();
					$this->deconnexion();
					return;
				}

				public function getIdEtudiant($nomEtudiant){
					$this->connexion();
					$statement = $this->connexion->prepare('SELECT IDEtu FROM etudiant WHERE nomEtu = ?');
					$statement->bindParam(1, $nomEtudiant);
					$statement->execute();
					$res = $statement->fetch();
					$this->deconnexion();
					return $res;
				}

				public function getTousEtudiants(){
					$this->connexion();
					$statement = $this->connexion->prepare('SELECT * FROM etudiant ORDER BY nomEtu');
					$statement->execute();
					$res = $statement->fetchAll();
					$this->deconnexion();
					return $res;
				}

				public function getTousEntreprises() {
					$this->connexion();
					$statement = $this->connexion->prepare('SELECT * from entreprise order by nomEnt;');
					$statement->execute();
					$this->deconnexion();
					return $statement->fetchAll();
				}

				public function getTousFormations() {
					$this->connexion();
					$statement = $this->connexion->prepare('SELECT distinct typeFormation from formation order by typeFormation;');
					$statement->execute();
					$this->deconnexion();
					return $statement->fetchAll();
				}

				//PROJET
				public function getFormationsResponsable($IDresp) {
					$this->connexion();
					$statement = $this->connexion->prepare('SELECT  * from formation where typeformation IN (Select typeformation from lienformationresp where IDresp = ?)');
					$statement->bindParam(1, $IDresp);
					$statement->execute();
					$this->deconnexion();
					return $statement->fetchAll();
				}

				public function getFormationsResponsableBis($IDresp) {
					$this->connexion();
					$statement = $this->connexion->prepare('SELECT DISTINCT typeFormation from formation where typeformation IN (Select typeformation from lienformationresp where IDresp = ?)');
					$statement->bindParam(1, $IDresp);
					$statement->execute();
					$this->deconnexion();
					return $statement->fetchAll();
				}

				public function updateResponsable($IDresp, $oldIDresp, $nouveauNom, $nouveauPrenom, $num, $forms)
				{
						$this-> updateNomResp($oldIDresp, $nouveauNom);
						$this-> updatePrenomResp($oldIDresp, $nouveauPrenom);
						$this-> updateTel($oldIDresp, $num);
						$this-> updateMailResp($IDresp,$oldIDresp);
						$this-> updateIdResp($IDresp,$oldIDresp);
						$this->updateFormationsResp($IDresp, $oldIDresp,$forms);
						return;
				}

				public function updateMdpResp($IDresp,$newMdp){
					$this->connexion();
					$statement = $this->connexion->prepare('UPDATE responsable set mdpResp = ? where IDresp  = ?;');
					$statement->bindParam(1, $newMdp);
					$statement->bindParam(2, $IDresp);
					$statement->execute();
					$this->deconnexion();
					return ;
				}

				public function updateIdResp($IDresp, $oldIDresp) {
					$this->connexion();
					$statement = $this->connexion->prepare('UPDATE responsable set IDresp = ? where IDresp  = ?;');
					$statement->bindParam(1, $IDresp);
					$statement->bindParam(2, $oldIDresp);
					$statement->execute();
					$this->deconnexion();
					return ;
				}

				public function updateMailResp($IDresp, $oldIDresp) {
					$this->connexion();
					$statement = $this->connexion->prepare('UPDATE responsable set mailResp = ? where IDresp  = ?;');
					$statement->bindParam(1, $IDresp);
					$statement->bindParam(2, $oldIDresp);
					$statement->execute();
					$this->deconnexion();
					return ;
				}



				public function updateNomResp($IDresp, $nouveauNom) {
					$this->connexion();
					$statement = $this->connexion->prepare('UPDATE responsable set nomResp = ? where IDresp  = ?;');
					$statement->bindParam(1, $nouveauNom);
					$statement->bindParam(2, $IDresp);
					$statement->execute();
					$this->deconnexion();
					return ;
				}

				public function updatePrenomResp($IDresp, $nouveauPrenom) {
					$this->connexion();
					$statement = $this->connexion->prepare('UPDATE responsable set prenomResp = ? where IDresp = ?;');
					$statement->bindParam(1, $nouveauPrenom);
					$statement->bindParam(2, $IDresp);
					$statement->execute();
					$this->deconnexion();
					return ;
				}

				public function updateTel($IDresp, $num) {
					$this->connexion();
					$statement = $this->connexion->prepare('UPDATE responsable set numtelResp = ? where IDresp  = ?;');
					$statement->bindParam(1, $num);
					$statement->bindParam(2, $IDresp);
					$statement->execute();
					$this->deconnexion();
					return ;
				}

				public function updateFormationsResp($IDresp, $oldIDresp, $forms)
				{
					$this->deleteAllFormationsResp($oldIDresp);
					$this->ajoutLienFormationResp($IDresp, $forms);
				}

				public function deleteAllFormationsResp($IDresp)
				{
					$this->connexion();
					$statement = $this->connexion->prepare('DELETE FROM lienformationresp where IDresp  = ?;');
					$statement->bindParam(1, $IDresp);
					$statement->execute();
					$this->deconnexion();
					return ;
				}

				public function getEtudiantsResponsable($IDresp){
					$this->connexion();
					$statement = $this->connexion->prepare('SELECT * from etudiant where formationEtu IN (Select typeformation from lienformationresp where IDresp = ?)');
					$statement->bindParam(1, $IDresp);
					$statement->execute();
					$this->deconnexion();
					return $statement->fetchAll(PDO::FETCH_CLASS, "Etudiant");
				}

				public function getEtudiantsResponsableBis($IDresp){
					$this->connexion();
					$statement = $this->connexion->prepare('SELECT * from etudiant where formationEtu IN (Select typeformation from lienformationresp where IDresp = ?)');
					$statement->bindParam(1, $IDresp);
					$statement->execute();
					$this->deconnexion();
					return $statement->fetchAll(PDO::FETCH_ASSOC);
				}
				//
				public function getFormationsRecherchees($idEnt){
					$this->connexion();
					$statement = $this->connexion->prepare('SELECT formationsRecherchees from entreprise where IDEnt = ?');
					$statement->bindParam(1, $idEnt);
					$statement->execute();
					$this->deconnexion();
					$str = $statement->fetch();
					return $str;
				}

				public function getFormationsRechercheesTmp($idEnt){
					$this->connexion();
					$statement = $this->connexion->prepare('SELECT formationsRecherchees from temp_entreprise where IDEnt = ?');
					$statement->bindParam(1, $idEnt);
					$statement->execute();
					$this->deconnexion();
					$str = $statement->fetch();
					return $str;
				}

				public function getDateEvent(){
					$this->connexion();
					$statement = $this->connexion->prepare('SELECT dateEvenement FROM scriptconfig');
					$statement->execute();
					$this->deconnexion();
					$str = $statement->fetch();
					return $str;
				}

				public function getNumCreneauEtu($idEtu){
					$this->connexion();
					$statement = $this->connexion->prepare('SELECT numeroCreneau from creneau where idEtudiant = ?');
					$statement->bindParam(1, $idEtu);
					$statement->execute();
					$this->deconnexion();
					return $statement->fetchAll();
				}

				public function getHeureNumCreneau($numCreneau){
					$this->connexion();
					$statement = $this->connexion->prepare('SELECT heure from heurecreneau where num = ?');
					$statement->bindParam(1, $numCreneau);
					$statement->execute();
					$this->deconnexion();
					$str = $statement->fetch();
					return $str;
				}

				public function getNombreCreneau(){
					$this->connexion();
					$statement = $this->connexion->prepare('SELECT COUNT(*) FROM heurecreneau');
					$statement->execute();
					$this->deconnexion();
					$str = $statement->fetch();
					return $str;
				}

				public function getIdFormationEtu($idEtu){
					$this->connexion();
					$statement = $this->connexion->prepare('SELECT idFormation FROM creneau WHERE idEtudiant = ?');
					$statement->bindParam(1, $idEtu);
					$statement->execute();
					$this->deconnexion();
					$str = $statement->fetchAll();
					return $str;
				}

				public function getEtudiantCreneauDeLaFormation($idFormation){
					$this->connexion();
					$statement = $this->connexion->prepare('SELECT idEtudiant, numeroCreneau from creneau where idFormation = ?');
					$statement->bindParam(1, $idFormation);
					$statement->execute();
					$this->deconnexion();
					$str = $statement->fetchAll();
					return $str;
				}

				/*renvoie les étudiants d'une formation qui n'ont pas rendez-vous avec l'entreprise*/
				public function getEtudiantpourEntreprise($idformation, $idEntreprise){
					$this->connexion();
					$statement = $this->connexion->prepare('Select etudiant.nomEtu, etudiant.IDEtu
					from etudiant
					where
						etudiant.IDEtu not in
							( SELECT etudiant.IDEtu
							from etudiant, formation, creneau
							where
								formation.typeFormation=? and
								formation.entPropose=? and
								formation.IDformation=creneau.idFormation and
								creneau.idEtudiant=etudiant.IDEtu
							GROUP BY etudiant.idEtu) and
							etudiant.formationEtu=? ');
					$statement->bindParam(1, $idformation);
					$statement->bindParam(2, $idEntreprise);
					$statement->bindParam(3, $idformation);
					$statement->execute();
					$this->deconnexion();
					$str = $statement->fetchAll();
					return $str;
				}

  /*renvoie les étudiant ayants rendez-vous à un créneau donné*/
				public function getEtudiantCreneau($numcreneau){
					$this->connexion();
					$statement = $this->connexion->prepare('
						SELECT etudiant.nomEtu, etudiant.IDEtu FROM `creneau`, etudiant WHERE etudiant.IDEtu=creneau.idEtudiant and creneau.numeroCreneau=?
					');
					$statement->bindParam(1, $numcreneau);
					$statement->execute();
					$this->deconnexion();
					$str = $statement->fetchAll();
					return $str;
				}

				public function getEtuIns($idEnt)
				{
					 $this -> connexion();
                     $stmt = $this->connexion->prepare('
                     	SELECT IDEtu, nomEtu,`nomEnt`,`formationEtu`,`prenomEtu` FROM etudiant, entreprise WHERE IDEnt = ? and((listechoixEtu like concat("%,",`IDEnt`, ",%")) or (listechoixEtu like concat("",`IDEnt`, ",%")) or (listechoixEtu like concat("%,",`IDEnt`, ""))) and (nomEnt, nomEtu)  in (select nomEnt, nomEtu from planning1)
						');
                     $stmt ->bindParam(1, $idEnt);
					 $stmt -> execute();
					 $res = $stmt -> fetchAll(PDO::FETCH_ASSOC);
					 return $res;
				}


				 /**
                * Fonction qui permet supprimer une "formation"(offre) dans la table formation.
                * @param  int $idFormation         l'identifiant de la formation.
                */
                public function supprUneFormation($idFormation)
                {
                    try {
                        $this->connexion();
                        $statement = $this->connexion->prepare('DELETE FROM formation where idFormation=? ;');
                        $statement->bindParam(1,$idFormation);
                        $statement->execute();
                        $this->deconnexion();
                    } catch (AccesTableException $e) {
                        print($e -> getMessage());
                    }
                }

		        public function getEtudiantshorsPlan($idENT){

					$this -> connexion();
					$statement = $this->connexion->prepare('
						SELECT `formationEtu`,`IDEtu`, `nomEtu`,`nomEnt` FROM `etudiant`, `entreprise` WHERE `IDEnt` = ? and ((`listechoixEtu` like concat("%,",`IDEnt`, ",%")) or (`listechoixEtu` like concat("",`IDEnt`, ",%")) or (`listechoixEtu` like concat("%,",`IDEnt`, ""))) and (`nomEnt`, `nomEtu`) not in (select `nomEnt`, `nomEtu` from `planning1`) order by 1'
						);

					$statement->bindParam(1, $idENT);
					$statement->execute();
					$res = $statement -> fetchAll(PDO::FETCH_ASSOC);
					return $res;
                }

                public function getEntPlannig($idENT){

                	$this -> connexion();
					$statement = $this->connexion->prepare('
						select nomEtu,prenomEtu,typeFormation,numeroCreneau from creneau c, formation f, etudiant e where c.idFormation=f.IDformation and e.IDEtu = c.idEtudiant and f.entPropose=?'
					);
					$statement->bindParam(1, $idENT);
					$statement->execute();
					$res = $statement -> fetchAll(PDO::FETCH_ASSOC);
					return $res;
				}

				public function setjurie($idformation,$numjurie){
					$this -> connexion();
					$statement = $this->connexion->prepare('
						Insert INTO jurieformation VALUES (?,?)'
					);
					$statement->bindParam(1, $idformation);
					$statement->bindParam(2, $numjurie);
					$statement->execute();
				}
				public function setjurie2($nomformation,$ident,$numjurie){
					$this -> connexion();
					$statement = $this->connexion->prepare('
									select idformation from formation where entPropose=? and typeFormation=? order by 1 desc limit 1'
					);
					$statement->bindParam(1, $ident);
					$statement->bindParam(2, $nomformation);
					$statement->execute();
					$res = $statement -> fetchAll(PDO::FETCH_ASSOC);
					$this->setjurie($res[0]['idformation'],$numjurie);
				}
				public function updatejurie($idformation,$numjurie){
					$this -> connexion();
					$statement = $this->connexion->prepare('
						Update jurieformation set numjurie=? where idformation=?'
					);
					$statement->bindParam(2, $idformation);
					$statement->bindParam(1, $numjurie);
					$statement->execute();
				}
				public function updatejurie2($nomformation,$ident,$numjurie){
					$this -> connexion();
					$statement = $this->connexion->prepare('
									select idformation from formation where entPropose=? and typeFormation=? order by 1 desc limit 1'
					);
					$statement->bindParam(1, $ident);
					$statement->bindParam(2, $nomformation);
					$statement->execute();
					$res = $statement -> fetchAll(PDO::FETCH_ASSOC);
					$this->updatejurie($res[0]['idformation'],$numjurie);
				}
				public function getjurie(){

					$this -> connexion();
					$statement = $this->connexion->prepare('
								select * from jurieformation'
					);
					$statement->execute();
					$temp = $statement -> fetchAll(PDO::FETCH_ASSOC);
					$res=array();

					foreach ($temp as $row){
						$res[$row["idformation"]]=$row["numjurie"];
					}

					return $res;
				}
				public function getEntreprisenbjurie($ident){

					$this -> connexion();
					$statement = $this->connexion->prepare('
											select nbStands from entreprise where IDEnt=?'
					);
					$statement->bindParam(1, $ident);
					$statement->execute();
					$res = $statement -> fetchAll(PDO::FETCH_ASSOC);

					return ($res[0]);
				}

				public function getAllIdEntreprises(){
					$this -> connexion();
					$statement = $this->connexion->prepare('
											select IDEnt from entreprise'
					);
					$statement->execute();
					$res = $statement -> fetchAll(PDO::FETCH_ASSOC);

					return $res;
				}

				public function requete($requete){
                	$this->connexion();
                	$result = $this->connexion->query($requete);
                	return $result->fetchAll();
				}

				function my_simple_crypt( $string, $action = 'e' ) {
					// you may change these values to your own
					$secret_key = 'my_simple_secret_key';
					$secret_iv = 'my_simple_secret_iv';

					$output = false;
					$encrypt_method = "AES-256-CBC";
					$key = hash( 'sha256', $secret_key );
					$iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );

					if( $action == 'e' ) {
						$output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
					}
					else if( $action == 'd' ){
						$output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
					}
					//$encrypted = my_simple_crypt( 'Hello World!', 'e' );
					//$decrypted = my_simple_crypt( 'RTlOMytOZStXdjdHbDZtamNDWFpGdz09', 'd' );
					return $output;
				}



			}
			?>
