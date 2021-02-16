<?php


require_once 'util/utilitairePageHtml.php';
require_once __DIR__."/../modele/dao/dao.php";
require_once __DIR__."/../modele/dao/dao_2016.php";
require_once __DIR__."/../modele/formationV2.php";
require_once __DIR__."/../modele/bean/Responsable.php";
/**
 * Classe permettant l'affichage des comptes étudiant / entreprise pour l'administrateur.
 */
class vueMonCompte{
    public function afficherMonCompte($resp){
        $util = new UtilitairePageHtml();
		echo $util->genereBandeauApresConnexion();
        $profil = $resp[0];
        echo '<div class="titre_profil"><br/>Profil Responsable</div>
		<br/>
		<span class="categorie_profil">Nom :</span> '.strtoupper($profil->getnomResp()).'
		<br/><br/><span class="categorie_profil">Prénom :</span> '.ucfirst($profil->getprenomResp()).'
		<br/><br/><span class="categorie_profil">Email :</span> <a href="mailto:'.$profil->getmailresp().'">'.$profil->getmailresp().'</a>
		<br/><br/><span class="categorie_profil">Téléphone :</span> '.$profil->getnumtelResp().'
        ';
        
		$dao = new Dao();
		$id = $profil->getIDresp();
		$tabFormations = $dao->getListeFormations();

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
				<script type="text/javascript">
		
		function verif()
        {
            var new_mdp = document.getElementById("passw").value;
			var new_mdp_confirm = document.getElementById("passwBis").value;	

			var listRe = [{
   					 re: /[a-zA-Z]/g,
    				 count: 8,
    				 msg: "Votre mot de passe doit avoir au moins 8 lettres"
  			}];
 
			var ok = true;

			  var item = listRe[0];
  			  var match = new_mdp.match(item.re);
  			  if (null === match || match.length < item.count) {
				document.getElementById("lettres").innerHTML = "<div id = 'lettres' style='color:red;'>8 lettres</div>";
  			    <?php  ?>
				  ok = false;
  			  }
			else{
				document.getElementById("lettres").innerHTML = "<div id = 'lettres' style='color:green;'>8 lettres</div>";
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
					<input required type="hidden" name="oldID" id="oldID" value="'.$profil->getmailResp().'" onblur="verifString(this, \'messageNomEtu\', 20)">
					';
						
		echo '
		</select>
					';
				
					echo '
					</TD>
		 			<TD> 	<input type="submit" name="modification_identite_resp" value="confirmer"/> </TD>
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
					<div id = "lettres" style="color:red;">8 lettres</div>
					<br/><br/>
					<label for="passwBis"> Confirmez</label>
					<br/>
					<input required type="password" name="mdpNouveau2" id="passwBis"  onkeyup="verif();">
					<div id = "mdp_confirm" style="color:green;">mots de passe identiques</div>
					<p id="messageMdp" style="color:red"></p>
					</TD>
					
					<input required type="hidden" name="idResp" id="idResp" value="'.$profil->getmailResp().'">
		 			<TD> 	<input type="submit" id ="validation_mdp" name="modification_motdepasse_resp" value="confirmer"/> </TD>
			</TABLE>
			</div>
			</form>

			';
			?>
				<?php

echo $util->generePied();
    
}
}