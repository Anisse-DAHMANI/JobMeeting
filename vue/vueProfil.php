<?php


require_once 'util/utilitairePageHtml.php';
require_once __DIR__."/../modele/dao/dao.php";
require_once __DIR__."/../modele/dao/dao_2016.php";
require_once __DIR__."/../modele/formationV2.php";

/**
 * Classe permettant l'affichage des comptes étudiant / entreprise pour l'administrateur.
 */
class VueProfil{


/**
 * Fonction permettant l'affichage d'un compte étudiant / entreprise.
 * @param  String       $type    le type du compte de l'utilisateur.
 * @param  Utilisateur  $profil  le profil du compte de l'utilisateur.
 */
public function afficherProfil($type,$profil){
	if (isset($_SESSION['type_connexion'])) {
		$util = new UtilitairePageHtml();
		echo $util->genereBandeauApresConnexion();
	}
	else {
		$util = new UtilitairePageHtml();
		echo $util->genereBandeauAvantConnexion();
	}

	if (isset($_SESSION['type_connexion'])) {
		echo '<div id="main">';
	}
	else {
		echo '<div id="login">';
	}
?>



	<!-- Description profil -->
<?php
	if ($type=="etudiant") {
		$_SESSION['testProfil']=$profil;
		$_SESSION['testType']=$type;
		echo '<div class="titre_profil"><br/>Profil Etudiant</div>
		<br/>
		<span class="categorie_profil">Nom :</span> '.$profil->getNomEtu().'
		<br/><br/><span class="categorie_profil">Prénom :</span> '.$profil->getPrenomEtu().'
		<br/><br/><span class="categorie_profil">Email :</span> <a href="mailto:'.$profil->getMailEtu().'">'.$profil->getMailEtu().'</a>
		<br/><br/><span class="categorie_profil">Téléphone :</span> '.$profil->getNumTelEtu().'
		<br/><br/><span class="categorie_profil">Formation :</span> '.$profil->getFormationEtu().'
		<br/><br/> <i> <a href="cv/'.$profil->getMailEtu().'.pdf"> Télécharger le CV de '.$profil->getPrenomEtu().' '.$profil->getNomEtu().' </a> </i>
		';
		//Permet à l'administrateur de modifier un compte étudiant
		$dao = new Dao();
		$id = $profil->getID();
		$tabFormations = $dao->getListeFormations();
		if ($_SESSION['type_connexion'] == "admin") {
			$_SESSION['idUser'] = $id;
			$_SESSION['type_modification'] = "Etu";

			//<!-- Nom -->
			?>
			<script>
	      //On surligne les cases non valides
	      function surligne(champ, erreur) {
	      if(erreur)
	        champ.style.backgroundColor = "#fba";
	      else
	        champ.style.backgroundColor = "";
	      }

	      function verifString(champ, txt, longMax) {
	        if(champ.value.length > longMax) {
	          surligne(champ, true);
	          document.getElementById(txt).innerHTML = longMax + " caractères maximum autorisé";
	          return true;
	        } else {
	          surligne(champ, false);
	          document.getElementById(txt).innerHTML = "";
	          return false;
	        }
	      }

	      function verifNombre(champ, txt, longMax) {
	        if(champ.value.length > longMax || (!/^\d+$/.test(champ.value) && champ.value.length != 0)) {
	          surligne(champ, true);
	          document.getElementById(txt).innerHTML = "Un nombre de taille maximum " + longMax + " est attendu";
	          return true;
	        } else {
	          surligne(champ, false);
	          document.getElementById(txt).innerHTML = "";
	          return false;
	        }
	      }

	      function verifTelephone(champ, txt) {
	        if(champ.value.length != 10 || !/^\d+$/.test(champ.value)) {
	          surligne(champ, true);
	          document.getElementById(txt).innerHTML = "Format invalide";
	          return true;
	        } else {
	          surligne(champ, false);
	          document.getElementById(txt).innerHTML = "";
	          return false;
	        }
	      }


	      function verifEmail(champ, txt){
	        var reg = new RegExp("^[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*@[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*[\.]{1}[a-z]{2,6}$", "i");
	        if(!reg.test(champ.value)) {
	          surligne(champ, true);
	          document.getElementById(txt).innerHTML = "L\'e-mail n\'est pas valide.";
	          return true;
	        } else {
	          surligne(champ, false);
	          document.getElementById(txt).innerHTML = "";
	          return false;
	        }
	      }

	      function verifMdp(txt){
	        var passw = document.getElementById("passw");
					var passwBis = document.getElementById("passwBis");
	        if (passw.value != passwBis.value) {
	          surligne(passw, true);
	          surligne(passwBis, true);
	          document.getElementById(txt).innerHTML = "Les 2 valeurs sont différentes";
	          return true;
	        } else if (passw.value.length > 20 || passw.value.length < 5) {
	          surligne(passw, true);
	          surligne(passwBis, true);
	          document.getElementById(txt).innerHTML = "Le mot de passe doit faire 5 à 20 caractères";
	          return true;
	        } else {
	          surligne(passw, false);
	          surligne(passwBis, false);
	          document.getElementById(txt).innerHTML = "";
	          return false;
	        }
	      }
	      </script>


				<script type="text/javascript">
					EnableSubmit = function(val)
					{
					    var sbmt = document.getElementById("submit");

					    if (val.checked == true)
					    {
					        sbmt.disabled = false;
					    }
					    else
					    {
					        sbmt.disabled = true;
					    }
					}
				</script>
				<script>
				VerifSubmit = function()
					{
					html = html.replace(/</g, "&lt;").replace(/>/g, "&gt;");
					var passw = document.getElementById("passw");
					var passwBis = document.getElementById("passwBis");
						if (passw.value != passwBis.value) {
								alert("Les mots de passe ne coïncident pas.");
						        return false;
						}
						if (/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i.test(document.getElementById("mail").value))
						  {
						    return true;
						  }
						  else {
						  	alert("L\'adresse email n'est pas correcte !");
						 	return false;
						  }
					}
				</script>
			<?php
			echo'

			<!--Les scripts pour vérifier chaque case-->

			<br></br></br>
			----------------------------------------------------<br/><br/>

			<h2>Pour effectuer des changements : </h2>

			<style>
			#tabModifEnt tr td{
	    padding: 15px;
	    border: 1px solid navy;
			}
			</style>

			<form action="index.php" method="post" onSubmit="return VerifSubmit();">
			<div class="resptab" style="height:440px;">
			<TABLE id="tabModifEnt">
		  	<CAPTION> Identité </CAPTION>
		  	<TR>
		 			<TD> <label for="nomEtu"> Nom</label>
					<br/>
					<input required type="text" name="nomEtu" id="nomEtu" value="'.$profil->getNomEtu().'" onblur="verifString(this, \'messageNomEtu\', 20)">
					<p id="messageNomEtu" style="color:red"></p>
					<label for="prenomEtu"> Prénom</label>
					<br/>
					<input required type="text" name="prenomEtu" id="prenomEtu" value="'.$profil->getPrenomEtu().'" onblur="verifString(this, \'messagePrenomEtu\', 20)">
					<p id="messagePrenomEtu" style="color:red"></p>
					<label for="email"> Adresse e-mail</label>
					<br/>
					<input required type="text" name="email" id="email" value="'.$profil->getMailEtu().'" onblur="verifEmail(this, \'messageEmail\')">
		 			<p id="messageEmail" style="color:red"></p>
					<label for="numTelEtu"> Numéro de téléphone</label>
					<br/>
		 			<input required type="text" id ="numTelEtu" name="numTelEtu" value="'.$profil->getNumTelEtu().'" onblur="verifTelephone(this, \'messageTel\')">
		 			<p id="messageTel" style="color:red"></p>
					<label for="nomFormEtu"> Nom de la formation</label>
					<br/>
					<select id ="nomFormEtu" name="nomFormEtu">
					';
					foreach ($tabFormations as $formation) {
						if($formation->getInitiales() == $profil->getFormationEtu()) {?>
							<option value = "<?=$formation->getInitiales()?>" selected = "selected"><?=$formation->getInitiales()?></option>
						<?php
						}else{
						?>
						<option value = "<?=$formation->getInitiales()?>"><?=$formation->getInitiales()?></option>
						<?php
						}

					}
					echo '
					</TD>
		 			<TD> 	<input type="submit" name="modification_etudiant_identite" value="confirmer"/> </TD>
					</TABLE>
			</div>
			</form>

			<form action="index.php" method="post" >
			<div class="resptab" style="height:250px;">
			<TABLE id="tabModifEnt">
		  	<CAPTION> Modifier le mot de passe </CAPTION>
				<TR>
		 			<TD>
					<label for="passw"> Nouveau mot de passe</label>
					<br/>
					<input required type="password" name="mdpNouveau1" id="passw">
					<br/><br/>
					<label for="passwBis"> Confirmez</label>
					<br/>
					<input required type="password" name="mdpNouveau2" onblur="verifMdp(\'messageMdp\')" id="passwBis">
					<p id="messageMdp" style="color:red"></p>
					</TD>
		 			<TD> 	<input type="submit" name="modification_etudiant_motdepasse" value="confirmer"/> </TD>
			</TABLE>
			</div>
			</form>

			';
			?>
				<?php
				$etudiantCourant = $profil;
				$listeEntreprises = $dao->getEntreprisesParFormation($etudiantCourant->getFormationEtu());

					if ($etudiantCourant->getListeChoixEtu() == "") {
						echo "<br/>L'étudiant n'a pas encore fait de choix.";
					}
					else {
						echo "<br/><b>Liste des choix de l'étudiant : </b><br /><br />";
						$choix = explode(",",$etudiantCourant->getListeChoixEtu());
						$compteur = 1;
						$newList = $etudiantCourant->getListeChoixEtu();
						foreach ($choix as $entreprise) {
							$truc = $dao->getEnt(intval($entreprise));
							if (isset($truc[0])) {
								$objEnt = $truc[0];
								echo "Choix ".$compteur." : ";
								echo '<a href="index.php?profil='.$objEnt->getId().'&type=Ent">'.$objEnt->getNomEnt().'</a><br/><br/>';
								$compteur = $compteur + 1;
							}
							else {
								echo "Le choix ".$compteur." n'existe plus. Il a été retiré de la liste de choix de l'étudiant.<br/><br/>";
								$compteur = $compteur + 1;
								if (strpos($newList, $entreprise.',') != false) {
									$newList = str_replace($entreprise.',', "", $newList);
								}
								else {
									$newList = str_replace($entreprise, "", $newList);
								}
								$dao->editChoixEtudiant($_SESSION['idUser'],$newList);
							}
						}
					}
				?>

				<br/>

		           <?php
		           $dateNow = new DateTime("now");
				$tabConfig = $dao->getConfiguration();
		$dateLimitEtu = new DateTime($tabConfig['dateFinInscription']);

		//Correction du décalage d'une journée
		$dateLimitEtu->setTime(23,59,59);
																if ($dateNow > $dateLimitEtu) {
		           echo "<b>Vous ne pouvez plus modifier les choix de l'étudiant. ";
		           echo "Choix des entreprises terminé depuis le  ".date_format($dateLimitEtu, "d/m/Y")."</b><br>";
		           }
		           else {
		           ?>

							 Vous pouvez modifier les choix de l'étudiant. Le premier choix sera favorisé par rapport aux suivants. Les doublons ne permettront pas l'envoi du formulaire.<br><br>
		            <?php

		            echo "<b>Attention, la fin des choix des entreprises est prévue le ".date_format($dateLimitEtu, "d/m/Y")." au soir.</b><br>";
		            ?>

				<br/><br/>



				<form action="index.php" method="POST" onsubmit="return verifier();">
					<br/>
					<select id="ent1" name="choix1" onchange="Changement1()" >
						<option value="Faire un choix...">Faire un choix...</option>
						<?php
							foreach ($listeEntreprises as $entreprise) {
								echo '<option value="'.$entreprise->getId().'">'.$entreprise->getNomEnt().'</option>';
							}
						?>
					</select>
					<br/><br/>
					<select id="ent2" name="choix2" onchange="Changement2()" style="visibility:hidden;">
						<option value="Faire un choix...">Faire un choix...</option>
						<?php
							foreach ($listeEntreprises as $entreprise) {
								echo '<option value="'.$entreprise->getId().'">'.$entreprise->getNomEnt().'</option>';
							}
						?>
					</select>
					<br/><br/>
					<select id="ent3" name="choix3" onchange="Changement3()" style="visibility:hidden;">
						<option value="Faire un choix...">Faire un choix...</option>
						<?php
							foreach ($listeEntreprises as $entreprise) {
								echo '<option value="'.$entreprise->getId().'">'.$entreprise->getNomEnt().'</option>';
							}
						?>
					</select>


					<br/><br/>

					<select id="ent4" name="choix4" onchange="Changement4()" style="visibility:hidden;">
						<option value="Faire un choix...">Faire un choix...</option>
						<?php
							foreach ($listeEntreprises as $entreprise) {
								echo '<option value="'.$entreprise->getId().'">'.$entreprise->getNomEnt().'</option>';
							}
						?>
					</select>

					<br/><br/>
					<input type="submit" value="Valider les changements" name="changementListeEtu"/>

				</form>

				<script>
		function Changement1() {
					if (document.getElementById("ent1").value == "Faire un choix...") {
						document.getElementById("ent2").style.visibility = "hidden";
						document.getElementById("ent3").style.visibility = "hidden";
						document.getElementById("ent4").style.visibility = "hidden";
						document.getElementById("ent2").value = "Faire un choix...";
						document.getElementById("ent3").value = "Faire un choix...";
						document.getElementById("ent4").value = "Faire un choix...";

					}
					else {
						document.getElementById("ent2").style.visibility = "";
					}
				}

		function Changement2() {
					if (document.getElementById("ent2").value == "Faire un choix...") {
						document.getElementById("ent3").style.visibility = "hidden";
						document.getElementById("ent4").style.visibility = "hidden";
						document.getElementById("ent3").value = "Faire un choix...";
						document.getElementById("ent4").value = "Faire un choix...";


					}
					else {
						document.getElementById("ent3").style.visibility = "";
					}
				}

		function Changement3() {
					if (document.getElementById("ent3").value == "Faire un choix...") {
						document.getElementById("ent4").style.visibility = "hidden";
						document.getElementById("ent4").value = "Faire un choix...";


					}
					else {
						document.getElementById("ent4").style.visibility = "";
					}
				}


			function Changement4() {
				}


				function verifier() {
					var value1 = document.getElementById("ent1").value;
					var value2 = document.getElementById("ent2").value;
					var value3 = document.getElementById("ent3").value;
					var value4 = document.getElementById("ent4").value;


					if (value1 == "Faire un choix...") {
						return true;
					}
					if (value2 == "Faire un choix..." && value1 != "Faire un choix...") {
						return true;
					}
					if (value3 == "Faire un choix..." && value2 != value1) {
						return true;
					}
					if (value4 == "Faire un choix..." && value3 != value2 && value3 != value1 && value2 != value1) {
						return true;
					}
					if (value1 != "Faire un choix" &&
						  value2 != "Faire un choix" &&
						  value3 != "Faire un choix" &&
						  value4 != "Faire un choix" &&
						  value3 != value2 && value3 != value1 && value2 != value1 &&
							value4 != value1 && value4 != value2 && value4 != value3){
						return true;
					}
					return false;
				}
				</script>
				<?php
			echo '</body> </html>';
	}
}
}
	if ($type=="entreprise") {
		$_SESSION['testProfil']=$profil;
		$_SESSION['testType']=$type;
		$dispo = "";
		if ($profil->getTypeCreneau() == "journee") {
			$dispo = "Journée.";
		}
		if ($profil->getTypeCreneau() == "matin") {
			$dispo = "Matinée.";
		}
		if ($profil->getTypeCreneau() == "apres_midi") {
			$dispo = "Après-midi.";
		}
		echo '<div class="titre_profil"><br/>Profil Entreprise</div>
		<br/><br/>
		<span class="categorie_profil">Nom de l\'entreprise :</span> '.$profil->getNomEnt().'
		<br/><br/>
		<span class="categorie_profil">Ville de l\'entreprise :</span> '.$profil->getVilleEnt().'
		<br/><br/>
		<span class="categorie_profil">Code Postal :</span> '.$profil->getCodePostal().'
		<br/><br/>
		<span class="categorie_profil">Adresse :</span> '.$profil->getAdresseEnt().'
		<br/><br/>
		<span class="categori e_profil">Disponibilité :</span> '.$dispo.'
		<br/><br/>
		<span class="categorie_profil">Nombre de stands en simultané :</span> '.$profil->getNbStands().'
		<br/><br/>
		<span class="categorie_profil">Description de l\'offre :</span> '.$profil->getOffre().'
		<br/><br/>

		';
    $dao = new Dao();
    $id = $profil->getID();
		$nomEnt = $profil->getNomEnt();
		$listesFormationsRecherchees= $dao->getFormationsEntreprise($id);

		$fichier = glob("offre/".$nomEnt."_offre_"."*");

		// Il faut récupérer l'id de l'étudiant qui consulte l'entreprise
		// Récupérer sa formation
		// Afficher les offres de sa formations uniquement
		if(count($fichier)>0){
			foreach ($fichier as $lien) {
					echo"<a class=\"offreRecord\" href=\"$lien\"> <i> Télécharger l'offre d'emploi <i> </a> <br>";
			}
		}

    if ($_SESSION['type_connexion'] == "admin") {
			$_SESSION['idUser'] = $id;
			$_SESSION['type_modification'] = "Ent";
			?>
			<script>
	      //On surligne les cases non valides
	      function surligne(champ, erreur) {
	      if(erreur)
	        champ.style.backgroundColor = "#fba";
	      else
	        champ.style.backgroundColor = "";
	      }

	      function verifString(champ, txt, longMax) {
	        if(champ.value.length > longMax) {
	          surligne(champ, true);
						champ.value = "";
	          document.getElementById(txt).innerHTML = longMax + " caractères maximum autorisé";
	          return true;
	        } else {
	          surligne(champ, false);
	          document.getElementById(txt).innerHTML = "";
	          return false;
	        }
	      }

	      function verifNombre(champ, txt, longMax) {
	        if(champ.value.length > longMax || (!/^\d+$/.test(champ.value) && champ.value.length != 0)) {
	          surligne(champ, true);
	          document.getElementById(txt).innerHTML = "Un nombre de taille maximum " + longMax + " est attendu";
						champ.value = "";
	          return true;
	        } else {
	          surligne(champ, false);
	          document.getElementById(txt).innerHTML = "";
	          return false;
	        }
	      }

	      function verifCodePostal(champ, txt) {
	        if(champ.value.length != 5 || !/^\d+$/.test(champ.value)) {
	          surligne(champ, true);
	          document.getElementById(txt).innerHTML = "Le code postal doit être rentré au format 44000";
						champ.value = "";
	          return true;
	        } else {
	          surligne(champ, false);
	          document.getElementById(txt).innerHTML = "";
	          return false;
	        }
	      }

	      function verifTelephone(champ, txt) {
	        if(champ.value.length != 10 || !/^\d+$/.test(champ.value)) {
	          surligne(champ, true);
	          document.getElementById(txt).innerHTML = "Format invalide";
	          return true;
	        } else {
	          surligne(champ, false);
	          document.getElementById(txt).innerHTML = "";
	          return false;
	        }
	      }


	      function verifEmail(champ, txt){
	        var reg = new RegExp("^[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*@[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*[\.]{1}[a-z]{2,6}$", "i");
	        if(!reg.test(champ.value)) {
	          surligne(champ, true);
	          document.getElementById(txt).innerHTML = "L\'e-mail n\'est pas valide.";
						champ.value = "";
	          return true;
	        } else {
	          surligne(champ, false);
	          document.getElementById(txt).innerHTML = "";
	          return false;
	        }
	      }

	      function verifMdp(txt){
	        var passw = document.getElementById("passw");
					var passwBis = document.getElementById("passwBis");
	        if (passw.value != passwBis.value) {
	          surligne(passw, true);
	          surligne(passwBis, true);
						passw.value = "";
						passwBis.value = "";
	          document.getElementById(txt).innerHTML = "Les 2 valeurs sont différentes";
	          return true;
	        } else if (passw.value.length > 20 || passw.value.length < 5) {
	          surligne(passw, true);
	          surligne(passwBis, true);
						passw.value = "";
						passwBis.value = "";
	          document.getElementById(txt).innerHTML = "Le mot de passe doit faire 5 à 20 caractères";
	          return true;
	        } else {
	          surligne(passw, false);
	          surligne(passwBis, false);
	          document.getElementById(txt).innerHTML = "";
	          return false;
	        }
	      }
	      </script>


				<script type="text/javascript">
					EnableSubmit = function(val)
					{
					    var sbmt = document.getElementById("submit");

					    if (val.checked == true)
					    {
					        sbmt.disabled = false;
					    }
					    else
					    {
					        sbmt.disabled = true;
					    }
					}
				</script>
				<script>
				VerifSubmit = function()
					{
					html = html.replace(/</g, "&lt;").replace(/>/g, "&gt;");
					var nb_repas = document.getElementById("nb_repas");
					var checkboxRepas = document.getElementById("checkbox_repas");
					var passw = document.getElementById("passw");
					var passwBis = document.getElementById("passwBis");
						if (checkboxRepas.checked == true) {
						    if (nb_repas.value == "" || nb_repas.value == null)
						    {
						    	alert("Vous n\'avez pas précisé combien de repas seront à prévoir.");
						        return false;
						    }
						}
						if (passw.value != passwBis.value) {
								alert("Les mots de passe ne coïncident pas.");
						        return false;
						}
						if (/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i.test(document.getElementById("mail").value))
						  {
						    return true;
						  }
						  else {
						  	alert("L\'adresse email n'est pas correcte !");
						 	return false;
						  }
					}
				</script>
			<?php
			// Si l'entreprise n'est pas une entreprise temporaire
			if(sizeof($dao -> getEnt($id)) != 0){
				$listeFormations = $dao -> getFormationsAffichage($id);
				$nombreEntretiensTotal = 0;
			?>

					<h3>Formations</h3>
					<table class="tabFormationsEntrepriseTitres">
						<thead>
							<tr>
								<td> Nom de la formation </td>
								<td> Debut des entretiens</td>
								<td> Fin des entretiens</td>
								<td> Nombre d'entretiens </td>
								<td> &nbsp;&nbsp;&nbsp; </td>
							</tr>
						</thead>
					</table>
					<?php
					//affichage formation + horaire
					foreach ($listeFormations as $formation) {
						$nomFormation = $formation[1];
						$creneauDebut = $formation[2];
						$creneauFin = $formation[3];
						$nbEntretiens = $creneauFin - $creneauDebut + 1 ;
						$nombreEntretiensTotal += $nbEntretiens;
						?>
						<table class="tabFormationsEntreprise">
						<thead title = "Cliquez pour comparer avec d'autres entreprises.">

							<tr>
								<td><?=$nomFormation?></td>
								<td><?=$creneauDebut?></td>
								<td><?=$creneauFin?></td>
								<td><?=$nbEntretiens?></td>
								<td>V</td>
						 	</tr>
						</thead>
						<tbody>
							<tr class = "tabFormationsEntreprise_ssEntete">
								<td>Entreprises proposées</td>
								<td>Nombre de créneaux affectés</td>
								<td>Nombre d'étudiants inscrits</td>
								<td>Nombre de créneaux réservés</td>
								<td></td>
							</tr>
						<?php
						$tabCreneaux = $dao->getNbCreneauxFormation($formation[1]);

						$tabTmp = array();

						// Récupération des ID des entreprises
						foreach ($tabCreneaux as $elt) {
							$idTmp = $dao->getIdEntreprise($elt['nomEnt']);
							$elt['idEnt'] = $idTmp;
							$tabTmp[] = $elt;
						}
							$nbTotalCreneauxAffectes = 0;
							$nbTotalEtudiantsInscrits = 0;
							$nbTotalCreneauxReserves = 0;

							foreach ($tabTmp as $elt) {
								$nbTotalCreneauxAffectes += $elt['NBCreneauxAffectes'];
								$nbTotalEtudiantsInscrits += $elt['nbEtudinantsInscrits'];
								$nbTotalCreneauxReserves += $elt['nbcreneauxReserves'];

								$idFormation = $elt['IDformation'];
							?>
							<tr>
								<td>
									<a href="index.php?profil=<?=$elt['idEnt']?>&type=Ent"><?=$elt['nomEnt']?></a>
								</td>
								<td><?=$elt['NBCreneauxAffectes']?></td>
								<td><?=$elt['nbEtudinantsInscrits']?></td>
								<td><b><?=$elt['nbcreneauxReserves']?></b></td>
								<td></td>
							</tr>
							<?php
							}
							?>
							<tr>
								<td><b>TOTAUX <?=$nomFormation?></b></td>
								<td><b><?=$nbTotalCreneauxAffectes?></b></td>
								<td><b><?=$nbTotalEtudiantsInscrits?></b></td>
								<td><b><?=$nbTotalCreneauxReserves?></b></td>
								<td></td>
							</tr>
						</tbody>
					</table>

					<?php
						}
					?>
					<table class = "tabFormationsEntrepriseTitres">
						<tr id = "">
							<td></td><td></td><td>Total de créneaux : </td>
							<td><?=$nombreEntretiensTotal?></td>
							<td> &nbsp; </td>
						</tr>
					</table>

						<script type = "text/javascript">

							var tableaux = document.getElementsByClassName('tabFormationsEntreprise');
							for(var i = 0; i <= tableaux.length; i++){
								tableau = tableaux[i];
								if (typeof tableau != 'undefined') {
									(function(){
										var entete = tableau.tHead;
										var corps = tableau.tBodies[0];
										corps.style.display = 'none';
										entete.addEventListener('click',function(){affiche_masque(entete,corps);},false);
									})(i);
								}
						}


							function affiche_masque(entete,unCorps) {
								console.log(unCorps);console.log(this);
								    if (unCorps.style.display === 'none') {
								        unCorps.style.display = '';
												entete.rows[0].cells[4].textContent = "Λ";
								    } else {
								        unCorps.style.display = 'none';
												entete.rows[0].cells[4].textContent = "V";
								    }
							}


						</script>
<?php


			echo '<br></br></br>
			----------------------------------------------------<br/>

			<h2>Pour effectuer des changements : </h2>';

			?>
			<form  action="index.php" method="post">
				<div id="tabModifEnt">
					<h3>Modifier créneau formation</h3>
					<table id = "tabModifEntCreneaux">
						<tr>
							<th>Nom de la formation </th>
							<th>Début des entretiens </th>
							<th>Fin des entretiens </th>
							<th>N°jury</th>
							<th>Nombre d'entretiens </th>
						</tr>
						<?php
						$dao = new Dao_2016();
						$daov2 = new Dao();
				        $tabConfig = $dao->getConfiguration();
						$tabNum = $dao->getNumCreneau();
						$classFormation = "Formation";
						$listeFormation = $dao -> getFormationsAffichage($id);
						$nbjury = $daov2->getEntreprisenbjurie($id);
                        $nbjury = $nbjury['nbStands'];
				        $nombreEntretiensTotal = 0;
								$tabjury= $daov2->getjurie();
								/*echo "<pre>";
								var_dump($tabjury);
                                var_dump($listeFormation);
								echo "</pre>";*/
								//affichage formation + horaire dans des select
			        			foreach ($listeFormation as $formation) {
									$creneauDebut = $formation[2];
									$creneauFin = $formation[3];
			 	         			echo "<tr id='formation'>\n";
			    	      			echo "<td>";
			 	         			echo $formation[1]; //nom formation
			   		       			echo "</td>";
				          			echo "<td>";
					  				// remplace les espaces du nom de la formation par des underscores
						  			$selId = $formation[0];
									echo "\n<select class = 'debEntModif' name='debEntreModif_$selId'>\n";
									echo "\t<option value='default' disabled>Veuillez séléctionner une valeur</option>";
									foreach ($tabNum as $value) {
										if ($value == $formation[2]) {
										echo "\t<option value='$value' selected>$creneauDebut</option>\n"; //creneau debut = affichage humain indéxé à partir de 1
										} else {
											echo "\t<option value='$value'>".$value."</option>\n";
										}
									}
									echo "</select>\n";
									echo "</td>";
			         				echo "<td>";
									echo "\n<select class = 'finEntModif' name='finEntreModif_$selId'>\n";
									echo "\t<option value='default' selected disabled>Veuillez séléctionner une valeur</option>";
									foreach ($tabNum as $value) {
										if ($value == $formation[3]) {
											echo "\t<option value='$value' selected>$creneauFin</option>\n";
										} else {
											echo "\t<option value='$value'>".$value."</option>\n";
										}
									}
                                    echo "</select>\n";
                                    echo "</td>";
                                    echo "<td>";
                                    echo "\n<select class = 'finEntModif' name='jurieModif_$selId'>\n";
                                    echo "\t<option value='default' selected disabled>Veuillez séléctionner une valeur</option>";
                                   for($i = 1; $i <= $nbjury; $i++) {
                                        if (isset($tabjury[intval($formation[0])]) and $i == intval($tabjury[$formation[0]])) {
                                            echo "\t<option value='$i' selected>$i</option>\n";
                                        } else {
                                            echo "\t<option value='$i'>".$i."</option>\n";
                                        }
                                   }

									echo "</select>\n";
									echo "</td>";
			         				echo "<td class = 'celluleNbEntretiens'>";
			          				$nbEntretiens = $formation[3] - $formation[2] +1;
									$nombreEntretiensTotal += $nbEntretiens;
			            			echo $nbEntretiens; // nb Entretiens
			            			echo "</td>";
			            			echo "</tr>";
			        			}
									echo "<tr id = 'celluleNbEntretiensTotal'>";
									echo "<td class = 'celluleCacheeEnt'></td>";
									echo "<td class = 'celluleCacheeEnt'></td><td class = 'celluleCacheeEnt'></td><td>Total : </td>";
									echo "<td>".$nombreEntretiensTotal;
									echo "</td>";
									echo "</tr>"
?>
								</table>
								<input type="submit" name="modCreneauxFormationEntreprise" value="confirmer">
							</div>
			</form>
							</br>
						
						<h3>Ajouter un créneau formation</h3>
						<form action="index.php" method="post">
							<div id="tabModifEnt">
							<table id = "tabModifEntCreneaux"> <!--  a modifier pour le css --> 
								<tr>
									<th>Nom de la formation </th>
									<th>Début des entretiens </th>
									<th>Fin des entretiens </th>
                                    <th>N° jury </th
								</tr>
							
<?php
							$dao =new Dao();
							$formation = $dao -> getEntFormationrechercher($id);
							
							echo "<tr>
									<td>
										<select name='selectformation'>
										<option value=0 selected disabled>Veuillez séléctionner une valeur</option>"; 
										foreach ($formation as $value){
											echo "<option value=".$value.">".$value."</option>";
										}
								echo "
									</select>
									</td>
									<td>
									<select name='creneauDebut'>
										<option value=0 selected >Veuillez séléctionner une valeur</option>";
										foreach ($tabNum as $value) {										
											echo "<option value=".$value." >".$value."</option>";										
										}
								echo "
									</select>
									</td>
									<td>
										<select name='creneauFin'>
										<option value='default' selected disabled>Veuillez séléctionner une valeur</option>";
										foreach ($tabNum as $value) {										
											echo "<option value=".$value.">".$value."</option>";										
										}
								echo "
										</select>
									</td>";

                                echo "<td>";
                                echo "\n<select name='jurieAdd'>\n";
                                echo "\t<option value='default' selected disabled>Veuillez séléctionner une valeur</option>";

                                for($i = 1; $i <= $nbjury; $i++) {
                                    echo "\t<option value='$i'>".$i."</option>\n";
                                }

                                echo "</select>\n";
                                echo "</td>";

								echo"</tr>
								";

?>
							</table>
							</div>
							<input type="submit" name="ajoutCreneauxFormationEntreprise" value="Ajouter">
						</form>

			<?php
		} // Fin de la condition vérifiant que l'entreprise n'est pas une entreprise temporaire



			echo '<form action="index.php" method="post" onSubmit="return VerifSubmit();">
			<TABLE id="tabModifEnt">
		  	<CAPTION> Organisation </CAPTION>
		  	<TR>
		 			<TD> <label for="disponibiliteSociete"/> Disponibilité
					<br/>
					<select required name="disponibiliteSociete"/>';

						if ($profil->getTypeCreneau() == "matin") {
							echo '<option value="matin" selected >Matin</option>
							<option value="apres_midi">Après-midi</option>
							<option value="journee"> Journée</option>
							';
						}
						if ($profil->getTypeCreneau() == "apres_midi") {
							echo '<option value="matin">Matin</option>
							<option value="apres_midi" selected >Après-midi</option>
							<option value="journee"> Journée</option>
							';
						}
						if ($profil->getTypeCreneau() == "journee") {
							echo '<option value="matin">Matin</option>
							<option value="apres_midi">Après-midi</option>
							<option value="journee" selected> Journée</option>
							';
						}
					echo '</select>
					<br/><br/>
					<label for="nbRecruteursSociete"/> Nombre de recruteurs
					<br/>
					<input required type="number" name="nbRecruteursSociete" min="1" max="20" value="'.$profil->getNbRecruteurs().'" >
					<br/><br/>
					<label for="nbStandsSociete"/> Nombre de sessions en parallèle
					<br/>
					<input required type="number" name="nbStandsSociete" min="1" max="10" value="'.$profil->getNbStands().'" >
					<br/><br/>
					<label for="nbRepasSociete"/> Nombre de repas prévus
					<br/>
					<input required type="number" min="0" max="10" name="nbRepasSociete" value="'.$profil->getNbRepas().'" onblur="verifNombre(this, \'messageNbRepas\', 3)">
		 			<p id="messageNbRepas" style="color:red"></p>
		 			<TD> 	<input type="submit" name="modification_entreprise_organisation" value="confirmer"/> </TD>
			</TABLE>
			</form></br>

			<form action="index.php" method="post">
			<TABLE id="tabModifEnt">';
		 						$compteur = 0;
		 						$formationsRecherchees = explode(",",$profil->getFormationsRecherchees());
								$listeFormations = $dao->getListeFormations();
								$listeDepartements = array();
									echo '<CAPTION> Formations recherchées</CAPTION>
							  	<TR>
							 			<TD> ';
									foreach ($listeFormations as $formation) {
										if(!in_array($formation->getDepartement(), $listeDepartements)) {
											array_push($listeDepartements, $formation->getDepartement());
										}
									}
									foreach ($listeDepartements as $departement) {
										echo '<span><b>Département '.$departement.' :</b></span>
												<br/>';
										foreach ($listeFormations as $formation) {
											if($formation->getDepartement() == $departement) {
												echo '<input type="checkbox" name="formation['.$compteur.']" value="'.$formation->getInitiales().'" onClick="EnableSubmit(this)" ';
												if (in_array($formation->getInitiales(), $formationsRecherchees)) {
													echo 'checked ';
												}
												echo '><a id="lienFormation" href="'. $formation->getLien() .'" target="_blank">'.$formation->getDescription().' </a></option>';
												$fichier = glob("offre/".$profil->getNomEnt().'_offre_'.$formation->getInitiales().'*'.'.pdf');
												if(count($fichier)>0){
													foreach ($fichier as $lien) {
														echo'<a class="offreRecord" href="'.$lien.'"> <br> [Voir l\'offre enregistrée] </a>';
													}
												}
												echo "<br>";
												$compteur = $compteur + 1;
											}
										}
									}

			 		echo '<TD> 	<input type="submit" name="modification_entreprise_formations" value="confirmer"/> </TD>
				</TABLE>
				</form></br>';


				echo '
				<form action="index.php" method="post" >
					<TABLE id="tabModifEnt">
				  	<CAPTION> Informations sur la société </CAPTION>
				  	<TR>
				 			<TD> <label for="nomSociete"> Nom </label>
								<br/>
								<input required id = "nomSociete" type="text" name="nomSociete" value="'.$profil->getNomEnt().'" onblur="verifString(this, \'messageNom\', 20)">
								<p id="messageNom" style="color:red"></p>
								<label for="villeSociete"> Ville </label>
								<br/>
								<input required id = "villeSociete" type="text" name="villeSociete" value="'.$profil->getVilleEnt().'" onblur="verifString(this, \'messageVille\', 20)">
								<p id="messageVille" style="color:red"></p>
								<label for="codePostalSociete"> Code postal </label>
								<br/>
								<input required id = "codePostalSociete" type="text" name="codePostalSociete" value="'.$profil->getCodePostal().'" onblur="verifCodePostal(this, \'messageCP\')">
								<p id="messageCP" style="color:red"></p>
								<label for="adresseSociete"> Adresse </label>
								<br/>
								<input required id = "adresseSociete" type="text" name="adresseSociete" value="'.$profil->getAdresseEnt().'" onblur="verifString(this, \'messageAdresse\', 30)">
					 			<p id="messageAdresse" style="color:red"></p>
								<label for="offre_txt"> Offre d\'emploi</label>
								<br/>
								<textarea name=offre_txt rows="8" cols="80">'.$profil->getOffre().'</textarea>
							</TD>
				 			<TD>
								<input type="submit" name="modification_entreprise_informations" value="confirmer"/>
							</TD>
						</TR>
					</TABLE>
				</form>
				<br/>

			<form action="index.php" method="post" >
			<TABLE id="tabModifEnt">
		  	<CAPTION> Contact </CAPTION>
		  	<TR>
		 			<TD> <label for="nomContactSociete"/> Nom du contact
					<br/>
					<input required type="text" name="nomContactSociete" value="'.$profil->getNomContact().'" onblur="verifString(this, \'messageNomContact\', 20)">
					<p id="messageNomContact" style="color:red"></p>
					<label for="prenomContactSociete"/> Prénom du contact
					<br/>
					<input required type="text" name="prenomContactSociete" value="'.$profil->getPrenomContact().'" onblur="verifString(this, \'messagePrenomContact\', 20)" >
					<p id="messagePrenomContact" style="color:red"></p>
					<label for="emailSociete"/> Email
					<br/>
					<input required type="text" name="emailSociete" value="'.$profil->getMailEnt().'" onblur="verifEmail(this, \'messageEmail\')">
					<p id="messageEmail" style="color:red"></p>
					<label for="numTelSociete"/> Téléphone
					<br/>
					<input required type="text" name="numTelSociete" value="'.$profil->getNumTelContact().'" onblur="verifTelephone(this, \'messageTel\')">
		 			<p id="messageTel" style="color:red"></p></TD>
		 			<TD> 	<input type="submit" name="modification_entreprise_contact" value="confirmer"/> </TD>
			</TABLE>
			</form>
			<br/>

			<form action="index.php" method="post" >
			<TABLE id="tabModifEnt">
		  	<CAPTION> Modifier le mot de passe </CAPTION>
		  	<TR>
		 			<TD>
					<label for="mdpNouveau1"/> Nouveau mot de passe
					<br/>
					<input required type="password" name="mdpNouveau1" id="passw">
					<br/><br/>
					<label for="mdpNouveau2"/> Confirmez
					<br/>
					<input required type="password" name="mdpNouveau2" onblur="verifMdp(\'messageMdp\')" id="passwBis">
					<p id="messageMdp" style="color:red"></p> </TD>
		 			<TD> 	<input type="submit" name="modification_entreprise_motdepasse" value="confirmer"/> </TD>
			</TABLE>
			</form><br><br>';

		}
	}

		if($type=="responsable"){
		$_SESSION['testProfil']=$profil;
		$_SESSION['testType']=$type;
		echo '<div class="titre_profil"><br/>Profil Responsable</div>
		<br/>
		<span class="categorie_profil">Nom :</span> '.strtoupper($profil->getnomResp()).'
		<br/><br/><span class="categorie_profil">Prénom :</span> '.ucfirst($profil->getprenomResp()).'
		<br/><br/><span class="categorie_profil">Email :</span> <a href="mailto:'.$profil->getmailresp().'">'.$profil->getmailresp().'</a>
		<br/><br/><span class="categorie_profil">Téléphone :</span> '.$profil->getnumtelResp().'
		';
		//<br/><br/><span class="categorie_profil">Formation :</span> '.$profil->getFormationEtu().'
		//Permet à l'administrateur de modifier un compte étudiant
		$dao = new Dao();
		$id = $profil->getIDresp();
		$tabFormations = $dao->getListeFormations();
		if ($_SESSION['type_connexion'] == "admin") {
			$_SESSION['idUser'] = $id;
			$_SESSION['type_modification'] = "Etu";

			//<!-- Nom -->
			?>
			<script>
	      //On surligne les cases non valides
	      function surligne(champ, erreur) {
	      if(erreur)
	        champ.style.backgroundColor = "#fba";
	      else
	        champ.style.backgroundColor = "";
	      }

	      function verifString(champ, txt, longMax) {
	        if(champ.value.length > longMax) {
	          surligne(champ, true);
	          document.getElementById(txt).innerHTML = longMax + " caractères maximum autorisé";
	          return true;
	        } else {
	          surligne(champ, false);
	          document.getElementById(txt).innerHTML = "";
	          return false;
	        }
	      }

	      function verifNombre(champ, txt, longMax) {
	        if(champ.value.length > longMax || (!/^\d+$/.test(champ.value) && champ.value.length != 0)) {
	          surligne(champ, true);
	          document.getElementById(txt).innerHTML = "Un nombre de taille maximum " + longMax + " est attendu";
	          return true;
	        } else {
	          surligne(champ, false);
	          document.getElementById(txt).innerHTML = "";
	          return false;
	        }
	      }

	      function verifTelephone(champ, txt) {
	        if(champ.value.length != 10 || !/^\d+$/.test(champ.value)) {
	          surligne(champ, true);
	          document.getElementById(txt).innerHTML = "Format invalide";
	          return true;
	        } else {
	          surligne(champ, false);
	          document.getElementById(txt).innerHTML = "";
	          return false;
	        }
	      }


	      function verifEmail(champ, txt){
	        var reg = new RegExp("^[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*@[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*[\.]{1}[a-z]{2,6}$", "i");
	        if(!reg.test(champ.value)) {
	          surligne(champ, true);
	          document.getElementById(txt).innerHTML = "L\'e-mail n\'est pas valide.";
	          return true;
	        } else {
	          surligne(champ, false);
	          document.getElementById(txt).innerHTML = "";
	          return false;
	        }
	      }


	      </script>


				<script type="text/javascript">
					EnableSubmit = function(val)
					{
					    var sbmt = document.getElementById("submit");

					    if (val.checked == true)
					    {
					        sbmt.disabled = false;
					    }
					    else
					    {
					        sbmt.disabled = true;
					    }
					}
				</script>
				<script>
				/*VerifSubmit = function()
					{
					html = html.replace(/</g, "&lt;").replace(/>/g, "&gt;");
					var passw = document.getElementById("passw");
					var passwBis = document.getElementById("passwBis");
						if (passw.value != passwBis.value) {
								alert("Les mots de passe ne coïncident pas.");
						        return false;
						}
						if (/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i.test(document.getElementById("mail").value))
						  {
						    return true;
						  }
						  else {
						  	alert("L\'adresse email n'est pas correcte !");
						 	return false;
						  }
					}*/
				</script>
				<script type="text/javascript">
		
		function verif()
        {
            var new_mdp = document.getElementById("passw").value;
			var new_mdp_confirm = document.getElementById("passwBis").value;	

			var listRe = [{
   					 re: /[a-zA-Z]/g,
    				 count: 6,
    				 msg: "Votre mot de passe doit avoir au moins 6 lettres"
  			}, {
    				 re: /\d/g,
    				 count: 1,
    				 msg: "Votre mot de passe doit avoir au moins 1 chiffres"
  			}, {
    				 re: /[^A-Za-z0-9]/g,
    				 count: 1,
    				 msg: "Votre mot de passe doit posséder au moins 1 caractère spécial"
  			}, {
				re: /[A-Z]/g,
    				 count: 1,
    				 msg: "Votre mot de passe doit avoir au moins 1 majuscule"
			  }];
 
  			/*for (var i = 0; i < listRe.length; i++) {
  			  var item = listRe[i];
  			  var match = new_mdp.match(item.re);
  			  if (null === match || match.length < item.count) {
  			    alert(item.msg);
  			    <?php  ?>
  			  }
  			}*/
			var ok = true;

			  var item = listRe[0];
  			  var match = new_mdp.match(item.re);
  			  if (null === match || match.length < item.count) {
				document.getElementById("lettres").innerHTML = "<div id = 'lettres' style='color:red;'>6 lettres</div>";
  			    <?php  ?>
				  ok = false;
  			  }
			else{
				document.getElementById("lettres").innerHTML = "<div id = 'lettres' style='color:green;'>6 lettres</div>";
			}
			var item = listRe[1];
  			  var match = new_mdp.match(item.re);
  			  if (null === match || match.length < item.count) {
				document.getElementById("chiffre").innerHTML = "<div id = 'chiffre' style='color:red;'>1 chiffre</div>";
  			    <?php  ?>
				  ok = false;
  			  }
			else{
				document.getElementById("chiffre").innerHTML = "<div id = 'chiffre' style='color:green;'>1 chiffre</div>";
			}
			var item = listRe[2];
  			  var match = new_mdp.match(item.re);
  			  if (null === match || match.length < item.count) {
				document.getElementById("special").innerHTML = "<div id = 'special' style='color:red;'>1 caractère spécial</div>";
  			    <?php  ?>
				  ok = false;
  			  }
				else{
					document.getElementById("special").innerHTML = "<div id = 'special' style='color:green;'>1 caractère spécial</div>";
			}
				var item = listRe[3];
  			  var match = new_mdp.match(item.re);
  			  if (null === match || match.length < item.count) {
				document.getElementById("majuscule").innerHTML = "<div id = 'majuscule' style='color:red;'>1 majuscule</div>";
  			    <?php  ?>
				  ok = false;
  			  }
			else{
				document.getElementById("majuscule").innerHTML = "<div id = 'majuscule' style='color:green;'>1 majuscule</div>";
			}
			if(new_mdp == new_mdp_confirm)
			{
				document.getElementById("mdp_confirm").innerHTML = "<div id = 'mdp_confirm' style='color:green;'>mots de passe identiques</div>";
			}
			else{
				document.getElementById("mdp_confirm").innerHTML = "<div id = 'mdp_confirm' style='color:red;'>mots de passe identiques</div>";
				ok = false;
			}
			
			if(ok)
			{
				document.getElementById("validation_mdp").disabled = false;

			}
			else
			{
				document.getElementById("validation_mdp").disabled = true;
			}
        }   

		

		</script>
			<?php
			echo'

			<!--Les scripts pour vérifier chaque case-->

			<br></br></br>
			----------------------------------------------------<br/><br/>

			<h2>Pour effectuer des changements : </h2>

			<style>
			#tabModifEnt tr td{
	    padding: 15px;
	    border: 1px solid navy;
			}
			</style>

			<form action="index.php" method="post" onSubmit="return VerifSubmit();">
			<div class="resptab" style="height:440px;">
			<TABLE id="tabModifEnt">
		  	<CAPTION> Identité </CAPTION>
		  	<TR>
		 			<TD> <label for="nomResp"> Nom</label>
					<br/>
					<input required type="text" name="nomResp" id="nomResp" value="'.$profil->getnomResp().'" onblur="verifString(this, \'messageNomEtu\', 20)">
					<p id="messageNomResp" style="color:red"></p>
					<label for="prenomResp"> Prénom</label>
					<br/>
					<input required type="text" name="prenomResp" id="prenomResp" value="'.$profil->getprenomResp().'" onblur="verifString(this, \'messagePrenomEtu\', 20)">
					<p id="messagePrenomResp" style="color:red"></p>
					<label for="email"> Adresse e-mail</label>
					<br/>
					<input required type="text" name="email" id="email" value="'.$profil->getmailResp().'" onblur="verifEmail(this, \'messageEmail\')">
		 			<p id="messageEmail" style="color:red"></p>
					<label for="numTelResp"> Numéro de téléphone</label>
					<br/>
		 			<input required type="text" id ="numTelResp" name="numTelResp" value="'.$profil->getnumtelResp().'" onblur="verifTelephone(this, \'messageTel\')">
		 			<p id="messageResp" style="color:red"></p>
					<label for="nomFormResp"> formation(s) (a ressaisir entièrement)</label>
					<br/>
					<input required type="hidden" name="oldID" id="oldID" value="'.$profil->getmailResp().'" onblur="verifString(this, \'messageNomEtu\', 20)">
					<select required name="formations[]" multiple="multiple" style = "height : 100px; required"> 
					';
					

					$dao = new Dao();
					$formations = $dao->getAllFormationsBis();
					foreach($formations as $form)
					{
						echo "<option value=".$form[0].">".$form[0]."</option>";
					}
						
		echo '
		</select>
					';
				
					echo '
					</TD>
		 			<TD> 	<input type="submit" name="modification_resp_identite" value="confirmer"/> </TD>
					</TABLE>
			</div>
			</form>

			<form action="index.php" method="post" >
			<div class="resptab" style="height:250px;">
			<TABLE id="tabModifEnt">
		  	<CAPTION> Modifier le mot de passe </CAPTION>
				<TR>
		 			<TD>
					<label for="passw"> Nouveau mot de passe</label>
					<br/>
					<input required type="password" name="mdpNouveau1" id="passw"  onkeyup="verif();">
					<div id = "lettres" style="color:red;">6 lettres</div>
					<div id = "majuscule" style="color:red;">1 majuscule</div>
					<div id = "chiffre" style="color:red;">1 chiffre</div>
					<div id = "special" style="color:red;">1 caractère spécial</div>
					<br/><br/>
					<label for="passwBis"> Confirmez</label>
					<br/>
					<input required type="password" name="mdpNouveau2" onblur="verifMdp(\'messageMdp\')" id="passwBis" onkeyup="verif();">
					<div id = "mdp_confirm" style="color:green;">mots de passe identiques</div>
					<p id="messageMdp" style="color:red"></p>
					</TD>
					
					<input required type="hidden" name="idResp" id="idResp" value="'.$profil->getmailResp().'">
		 			<TD> 	<input type="submit" id ="validation_mdp" name="modification_resp_motdepasse" value="confirmer"/> </TD>
			</TABLE>
			</div>
			</form>

			';
			?>
				<?php
}
	}
	
?>



</div>
	<?php

	echo $util->generePied();

	?>
</body>
</html>

<?php
}
}
?>
