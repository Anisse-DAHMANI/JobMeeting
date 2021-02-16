<?php
//PROJET

require_once 'util/utilitairePageHtml.php';

/**
 * Classe permettant l'affichage de la vue d'oubli de mot de passe.
 */
class vueGestionResp{


	/**
	 * Fonction permettant de générer la vue d'oubli de mot de passe.
	 */
	public function genererVueAjoutResp(){

		$util = new UtilitairePageHtml();
		echo $util->genereBandeauApresConnexion();
		$util->genereEnteteHtml();?>
<h2> Créer un nouveau responsable : </h2>

<style>
#tabModifEnt tr td{
padding: 15px;
border: 1px solid navy;
}
</style>

<form action="index.php?creerResp=1" method="post">
<div class="resptab" style="height:440px;">
<TABLE id="tabModifEnt">
  <CAPTION> Identité </CAPTION>
  <TR>
		 <TD> <label for="nomResp"> Nom</label>
		<br/>
		<input required type="text" name="nomResp" id="nomResp" placeholder="Nom" <?php if (isset($_POST["nomResp"])) 
		{
			echo "value='".$_POST["nomResp"]."'";
		} ?>>
		<p id="messageNomResp" style="color:red"></p>
		<label for="prenomResp"> Prénom</label>
		<br/>
		<input required type="text" name="prenomResp" id="prenomResp" placeholder="Prenom" <?php if (isset($_POST["prenomResp"])) 
		{
			echo "value='".$_POST["prenomResp"]."'";
		} ?>>
		<p id="messagePrenomResp" style="color:red"></p>
		<label for="email"> Adresse e-mail</label>
		<br/>
		<input required type="text" name="email" id="email" placeholder="Email" <?php if (isset($_POST["email"])) 
		{
			echo "value='".$_POST["email"]."'";
		} ?>>
		 <p id="messageEmail" style="color:red"></p>
		<label for="numTelResp"> Numéro de téléphone</label>
		<br/>
		 <input required type="text" id ="numTelResp" name="numTelResp" placeholder="Telephone" <?php if (isset($_POST["numTelResp"])) 
		{
			echo "value='".$_POST["numTelResp"]."'";
		} ?>>
		 <p id="messageTel" style="color:red"></p>

		 <label for="mdpresp"> Mot de passe </label>
		 <br />
		 <input required type="password" id ="mdpresp" name="mdpresp" placeholder="Mot de passe"  <?php if (isset($_POST["mdpresp"])) 
		{
			echo "value='".$_POST["mdpresp"]."'";
		} ?>>
		 <p id="mdp" style="color:red"></p>
		<label for="nomFormResp"> Nom(s) formation(s) (ctlr+clic pour sélection multiple)</label>
		<br/>
		<select required name="formations[]" multiple="multiple"> 
  
		<?php

		$dao = new Dao();
		$formations = $dao->getAllFormationsBis();
		foreach($formations as $form)
		{
			echo "<option value=".$form[0].">".$form[0]."</option>";
		}
			?>
		</select>
		</TD>
		 <TD> 	<input type="submit" name="creer_responsable" value="confirmer"/> </TD>
		</TABLE>
</div>
</form>

		<?php

		echo $util->generePied();
		
	}


	public function genererVueAjoutEtu(){
		$util = new UtilitairePageHtml();
		echo $util->genereBandeauApresConnexion();
		$util->genereEnteteHtml();?>
<h2> Créer un nouveau etudiant : </h2>

<style>
#tabModifEnt tr td{
padding: 15px;
border: 1px solid navy;
}
</style>

<form action="index.php?creerResp=1" method="post" enctype="multipart/form-data">
<div class="resptab" style="height:440px;">
<TABLE id="tabModifEnt">
  <CAPTION> Identité </CAPTION>
  <TR>
		 <TD> <label for="nomResp"> Nom</label>
		<br/>
		<input required type="text" name="nomResp" id="nomResp" placeholder="Nom" <?php if (isset($_POST["nomResp"])) 
		{
			echo "value='".$_POST["nomResp"]."'";
		} ?>>
		<p id="messageNomResp" style="color:red"></p>
		<label for="prenomResp"> Prénom</label>
		<br/>
		<input required type="text" name="prenomResp" id="prenomResp" placeholder="Prenom" <?php if (isset($_POST["prenomResp"])) 
		{
			echo "value='".$_POST["prenomResp"]."'";
		} ?>>
		<p id="messagePrenomResp" style="color:red"></p>
		<label for="email"> Adresse e-mail</label>
		<br/>
		<input required type="text" name="email" id="email" placeholder="Email" <?php if (isset($_POST["email"])) 
		{
			echo "value='".$_POST["email"]."'";
		} ?>>
		 <p id="messageEmail" style="color:red"></p>
		<label for="numTelResp"> Numéro de téléphone</label>
		<br/>
		 <input required type="text" id ="numTelResp" name="numTelResp" placeholder="Telephone" <?php if (isset($_POST["numTelResp"])) 
		{
			echo "value='".$_POST["numTelResp"]."'";
		} ?>>
		 <p id="messageTel" style="color:red"></p>

		 <label for="mdpresp"> Mot de passe </label>
		 <br />
		 <input required type="password" id ="mdpresp" name="mdpresp" placeholder="Mot de passe"  <?php if (isset($_POST["mdpresp"])) 
		{
			echo "value='".$_POST["mdpresp"]."'";
		} ?>>
		 <p id="mdp" style="color:red"></p>
		<label for="nomFormResp"> Nom formation</label>
		<br/>
		<select required name="formations"> 
		<?php

		$dao = new Dao();
		$formations = $dao->getAllFormationsBis();
		echo count($formations);
		foreach($formations as $form)
		{
			echo "<option value=".$form[0].">".$form[0]."</option>";
		}
			?>
		</select>
		<br/>
		<label for="nomEntre"> Nom(s) entreprises(s) (ctlr+clic pour sélection multiple)</label>
		<br/>
		<select required name="entreprises[]" multiple="multiple"> 
		<?php
		$entreprises = $dao->getAllEntreprisesBis();
		foreach($entreprises as $ent){
			echo "<option value=".str_replace(' ', '_', $ent->getNomEnt()).">".str_replace(' ', '_', $ent->getNomEnt())."</option>";
		}
		?>
		</select>
		<br>
		<br>
		<label>CV<label>
		<br>
		<input type="hidden" name="MAX_SIZE" value=1048576>
		<input type="file" name="cv" required />
		</TD>
		 <TD> 	<input type="submit" name="creer_etudiant" value="confirmer"/> </TD>
		</TABLE>
</div>
</form>

		<?php

		echo $util->generePied();
		
	}

	public function genererVueAjoutEnt(){
		$util = new UtilitairePageHtml();
		echo $util->genereBandeauApresConnexion();
		$util->genereEnteteHtml();?>
<h2> Créer une nouvelle entreprise : </h2>

<style>
#tabModifEnt tr td{
padding: 15px;
border: 1px solid navy;
}
</style>

<form action="index.php?creerResp=1" method="post">
<div class="resptab" style="height:440px;">
<TABLE id="tabModifEnt">
  <CAPTION> Identité </CAPTION>
  <TR>
		 <TD> <label for="nomResp"> Nom de l'entreprise</label>
		<br/>
		<input required type="text" name="nomResp" id="nomResp" placeholder="Nom entreprise" <?php if (isset($_POST["nomResp"])) 
		{
			echo "value='".$_POST["nomResp"]."'";
		} ?>>
		<p id="messageNomResp" style="color:red"></p>

		
		<label for="prenomContact"> Prénom du contact</label>
		<br/>
		<input required type="text" name="prenomContact" id="prenomContact" placeholder="Prénom du contact" <?php if (isset($_POST["prenomContact"])) 
		{
			echo "value='".$_POST["prenomContact"]."'";
		} ?>>
		<p id="messageprenomContact" style="color:red"></p>

		
		<label for="nomContact"> Nom du contact</label>
		<br/>
		<input required type="text" name="nomContact" id="nomContact" placeholder="Nom du contact" <?php if (isset($_POST["nomContact"])) 
		{
			echo "value='".$_POST["nomContact"]."'";
		} ?>>
		<p id="messagenomContact" style="color:red"></p>


		<label for="mdpresp"> Mot de passe </label>
		 <br />
		 <input required type="password" id ="mdpresp" name="mdpresp" placeholder="Mot de passe"  <?php if (isset($_POST["mdpresp"])) 
		{
			echo "value='".$_POST["mdpresp"]."'";
		} ?>>
		 <p id="mdp" style="color:red"></p>
		</TD>
		<TD><label for="email"> Adresse e-mail</label>
		<br/>
		<input required type="text" name="email" id="email" placeholder="Email" <?php if (isset($_POST["email"])) 
		{
			echo "value='".$_POST["email"]."'";
		} ?>>
		 <p id="messageEmail" style="color:red"></p>


		<label for="numTelResp"> Numéro de téléphone</label>
		<br/>
		 <input required type="text" id ="numTelResp" name="numTelResp" placeholder="Telephone" <?php if (isset($_POST["numTelResp"])) 
		{
			echo "value='".$_POST["numTelResp"]."'";
		} ?>>
		 <p id="messageTel" style="color:red"></p>

		 <label for="adresseEnt">Adresse de l'entreprise</label>
		 <br />
		 <input required type="text" id ="adresseEnt" name="adresseEnt" placeholder="Adresse"  <?php if (isset($_POST["adresseEnt"])) 
		{
			echo "value='".$_POST["adresseEnt"]."'";
		} ?>>
		 <p id="messageadresseEnt" style="color:red"></p>
		
		 <label for="villeEnt">Ville de l'entreprise </label>
		 <br />
		 <input required type="text" id ="villeEnt" name="villeEnt" placeholder="Ville"  <?php if (isset($_POST["villeEnt"])) 
		{
			echo "value='".$_POST["villeEnt"]."'";
		} ?>>
		 <p id="messagevilleEnt" style="color:red"></p>

		 <label for="cpEnt">Code postal de l'entreprise </label>
		 <br />
		 <input required type="text" id ="cpEnt" name="cpEnt" placeholder="Code postal"  <?php if (isset($_POST["cpEnt"])) 
		{
			echo "value='".$_POST["cpEnt"]."'";
		} ?>>
		 <p id="messagecpEnt" style="color:red"></p>

		</TD>
		<TD>
		<label for="nomFormResp">Formation(s) recherchée(s) (ctlr+clic pour sélection multiple) </label>
		<br/>
		<select required name="formations[]" multiple="multiple"> 
		<?php

		$dao = new Dao();
		$formations = $dao->getAllFormationsBis();
		
		foreach($formations as $form)
		{
			echo "<option value=".$form[0].">".$form[0]."</option>";
		}
			?>
		</select>
		<br/>
		<label for="nbRecruteurs"> Nombre de recruteurs</label>
		<br/>
		<input required type="number" name="nbRecruteurs" id="nbRecruteurs" placeholder="Nombre de recruteurs" <?php if (isset($_POST["nbRecruteurs"])) 
		{
			echo "value='".$_POST["nbRecruteurs"]."'";
		} ?>>
		<p id="messagenbRecruteurs" style="color:red"></p>

		<label for="nbPlaces"> Nombre de places</label>
		<br/>
		<input required type="number" name="nbPlaces" id="nbPlaces" placeholder="Nombre de places" <?php if (isset($_POST["nbPlaces"])) 
		{
			echo "value='".$_POST["nbPlaces"]."'";
		} ?>>
		<p id="messagenbPlaces" style="color:red"></p>
		<label for="nbStands"> Nombre de stands</label>
		<br/>
		<input required type="number" name="nbStands" id="nbStands" placeholder="Nombre de stands" <?php if (isset($_POST["nbStands"])) 
		{
			echo "value='".$_POST["nbStands"]."'";
		} ?>>
		<p id="messagenbStands" style="color:red"></p>
		<label for="nbRepas"> Nombre de repas</label>
		<br/>
		<input required type="number" name="nbRepas" id="nbRepas" placeholder="Nombre de repas" <?php if (isset($_POST["nbRepas"])) 
		{
			echo "value='".$_POST["nbRepas"]."'";
		} ?>>
		<p id="messagenbRepas" style="color:red"></p>

		</select>
		</TD>
		 <TD> 	<input type="submit" name="creer_entreprise" value="confirmer"/> </TD>
		</TABLE>
</div>
</form>

		<?php

		echo $util->generePied();
		
	}




	/**
	 * Fonction permettant de générer la vue d'oubli de mot de passe.
	 */
	public function genererVueAjoutResp_valider(){

		
		$util = new UtilitairePageHtml();
		echo $util->genereBandeauApresConnexion();
		$util->genereEnteteHtml(); ?>
		<h2> Le responsable a bien été créé </h2>

<style>
#tabModifEnt tr td{
padding: 15px;
border: 1px solid navy;
}
</style>

<form action="index.php?creerResp=1" method="post">
<div class="resptab" style="height:440px;">
<TABLE id="tabModifEnt">
  <CAPTION> Identité </CAPTION>
  <TR>
		 <TD> <label for="nomResp"> Nom</label>
		<br/>
		<input required type="text" name="nomResp" id="nomResp" placeholder="Nom">
		<p id="messageNomResp" style="color:red"></p>
		<label for="prenomResp"> Prénom</label>
		<br/>
		<input required type="text" name="prenomResp" id="prenomResp" placeholder="Prenom" >
		<p id="messagePrenomResp" style="color:red"></p>
		<label for="email"> Adresse e-mail</label>
		<br/>
		<input required type="text" name="email" id="email" placeholder="Email" >
		 <p id="messageEmail" style="color:red"></p>
		<label for="numTelResp"> Numéro de téléphone</label>
		<br/>
		 <input required type="text" id ="numTelResp" name="numTelResp" placeholder="Telephone" >
		 <p id="messageTel" style="color:red"></p>

		 <label for="mdpresp"> Mot de passe </label>
		 <br />
		 <input required type="password" id ="mdpresp" name="mdpresp" placeholder="Mot de passe">
		 <p id="mdp" style="color:red"></p>
		<label for="nomFormResp"> Nom(s) formation(s) (ctlr+clic pour sélection multiple)</label>
		<br/>
		<select required name="formations[]" multiple="multiple" >
		
  
		<?php

		$dao = new Dao();
		$formations = $dao->getAllFormationsBis();
		foreach($formations as $form)
		{
			echo "<option value=".$form[0].">".$form[0]."</option>";
		}
			?>
		
		</select>
		</TD>
		 <TD> 	<input type="submit" name="creer_responsable" value="confirmer"/> </TD>
		</TABLE>
</div>
</form>

		<?php

		echo $util->generePied();
		
	}



	public function genererVueAjoutEtu_valider(){

		
		$util = new UtilitairePageHtml();
		echo $util->genereBandeauApresConnexion();
		$util->genereEnteteHtml(); ?>
		<h2> L'étudiant a bien été créé </h2>

		<style>
#tabModifEnt tr td{
padding: 15px;
border: 1px solid navy;
}
</style>

<form action="index.php?creerResp=1" method="post" enctype="multipart/form-data">
<div class="resptab" style="height:440px;">
<TABLE id="tabModifEnt">
  <CAPTION> Identité </CAPTION>
  <TR>
		 <TD> <label for="nomResp"> Nom</label>
		<br/>
		<input required type="text" name="nomResp" id="nomResp" placeholder="Nom" <?php if (isset($_POST["nomResp"])) 
		{
			echo "value='".$_POST["nomResp"]."'";
		} ?>>
		<p id="messageNomResp" style="color:red"></p>
		<label for="prenomResp"> Prénom</label>
		<br/>
		<input required type="text" name="prenomResp" id="prenomResp" placeholder="Prenom" <?php if (isset($_POST["prenomResp"])) 
		{
			echo "value='".$_POST["prenomResp"]."'";
		} ?>>
		<p id="messagePrenomResp" style="color:red"></p>
		<label for="email"> Adresse e-mail</label>
		<br/>
		<input required type="text" name="email" id="email" placeholder="Email" <?php if (isset($_POST["email"])) 
		{
			echo "value='".$_POST["email"]."'";
		} ?>>
		 <p id="messageEmail" style="color:red"></p>
		<label for="numTelResp"> Numéro de téléphone</label>
		<br/>
		 <input required type="text" id ="numTelResp" name="numTelResp" placeholder="Telephone" <?php if (isset($_POST["numTelResp"])) 
		{
			echo "value='".$_POST["numTelResp"]."'";
		} ?>>
		 <p id="messageTel" style="color:red"></p>

		 <label for="mdpresp"> Mot de passe </label>
		 <br />
		 <input required type="password" id ="mdpresp" name="mdpresp" placeholder="Mot de passe"  <?php if (isset($_POST["mdpresp"])) 
		{
			echo "value='".$_POST["mdpresp"]."'";
		} ?>>
		 <p id="mdp" style="color:red"></p>
		<label for="nomFormResp"> Nom formation</label>
		<br/>
		<select required name="formations"> 
		<?php

		$dao = new Dao();
		$formations = $dao->getAllFormationsBis();
		echo count($formations);
		foreach($formations as $form)
		{
			echo "<option value=".$form[0].">".$form[0]."</option>";
		}
			?>
		</select>
		<br/>
		<label for="nomEntre"> Nom(s) entreprises(s) (ctlr+clic pour sélection multiple)</label>
		<br/>
		<select required name="entreprises[]" multiple="multiple"> 
		<?php
		$dap = new Dao();
		$entreprises = $dao->getAllEntreprisesBis();
		foreach($entreprises as $ent){
			echo "<option value=".str_replace(' ', '_', $ent->getNomEnt()).">".str_replace(' ', '_', $ent->getNomEnt())."</option>";
		}
		?>
		</select>
		<br>
		<br>
		<label>CV<label>
		<br>
		<input type="hidden" name="MAX_SIZE" value=1048576>
		<input type="file" name="cv" required />
		</TD>
		 <TD> 	<input type="submit" name="creer_etudiant" value="confirmer"/> </TD>
		</TABLE>
</div>
</form>

		<?php

		echo $util->generePied();
		
		
	}

	public function genererVueAjoutEnt_valider(){

		
		$util = new UtilitairePageHtml();
		echo $util->genereBandeauApresConnexion();
		$util->genereEnteteHtml(); ?>
		<h2> L'entreprise a bien été créé </h2>
		<style>
#tabModifEnt tr td{
padding: 15px;
border: 1px solid navy;
}
</style>

<form action="index.php?creerResp=1" method="post">
<div class="resptab" style="height:440px;">
<TABLE id="tabModifEnt">
  <CAPTION> Identité </CAPTION>
  <TR>
		 <TD> <label for="nomResp"> Nom de l'entreprise</label>
		<br/>
		<input required type="text" name="nomResp" id="nomResp" placeholder="Nom entreprise" <?php if (isset($_POST["nomResp"])) 
		{
			echo "value='".$_POST["nomResp"]."'";
		} ?>>
		<p id="messageNomResp" style="color:red"></p>

		
		<label for="prenomContact"> Prénom du contact</label>
		<br/>
		<input required type="text" name="prenomContact" id="prenomContact" placeholder="Prénom du contact" <?php if (isset($_POST["prenomContact"])) 
		{
			echo "value='".$_POST["prenomContact"]."'";
		} ?>>
		<p id="messageprenomContact" style="color:red"></p>

		
		<label for="nomContact"> Nom du contact</label>
		<br/>
		<input required type="text" name="nomContact" id="nomContact" placeholder="Nom du contact" <?php if (isset($_POST["nomContact"])) 
		{
			echo "value='".$_POST["nomContact"]."'";
		} ?>>
		<p id="messagenomContact" style="color:red"></p>


		<label for="mdpresp"> Mot de passe </label>
		 <br />
		 <input required type="password" id ="mdpresp" name="mdpresp" placeholder="Mot de passe"  <?php if (isset($_POST["mdpresp"])) 
		{
			echo "value='".$_POST["mdpresp"]."'";
		} ?>>
		 <p id="mdp" style="color:red"></p>
		</TD>
		<TD><label for="email"> Adresse e-mail</label>
		<br/>
		<input required type="text" name="email" id="email" placeholder="Email" <?php if (isset($_POST["email"])) 
		{
			echo "value='".$_POST["email"]."'";
		} ?>>
		 <p id="messageEmail" style="color:red"></p>


		<label for="numTelResp"> Numéro de téléphone</label>
		<br/>
		 <input required type="text" id ="numTelResp" name="numTelResp" placeholder="Telephone" <?php if (isset($_POST["numTelResp"])) 
		{
			echo "value='".$_POST["numTelResp"]."'";
		} ?>>
		 <p id="messageTel" style="color:red"></p>

		 <label for="adresseEnt">Adresse de l'entreprise</label>
		 <br />
		 <input required type="text" id ="adresseEnt" name="adresseEnt" placeholder="Adresse"  <?php if (isset($_POST["adresseEnt"])) 
		{
			echo "value='".$_POST["adresseEnt"]."'";
		} ?>>
		 <p id="messageadresseEnt" style="color:red"></p>
		
		 <label for="villeEnt">Ville de l'entreprise </label>
		 <br />
		 <input required type="text" id ="villeEnt" name="villeEnt" placeholder="Ville"  <?php if (isset($_POST["villeEnt"])) 
		{
			echo "value='".$_POST["villeEnt"]."'";
		} ?>>
		 <p id="messagevilleEnt" style="color:red"></p>

		 <label for="cpEnt">Code postal de l'entreprise </label>
		 <br />
		 <input required type="text" id ="cpEnt" name="cpEnt" placeholder="Code postal"  <?php if (isset($_POST["cpEnt"])) 
		{
			echo "value='".$_POST["cpEnt"]."'";
		} ?>>
		 <p id="messagecpEnt" style="color:red"></p>

		</TD>
		<TD>
		<label for="nomFormResp">Formation(s) recherchée(s) (ctlr+clic pour sélection multiple) </label>
		<br/>
		<select required name="formations[]" multiple="multiple"> 
		<?php

		$dao = new Dao();
		$formations = $dao->getAllFormationsBis();
		
		foreach($formations as $form)
		{
			echo "<option value=".$form[0].">".$form[0]."</option>";
		}
			?>
		</select>
		<br/>
		<label for="nbRecruteurs"> Nombre de recruteurs</label>
		<br/>
		<input required type="number" name="nbRecruteurs" id="nbRecruteurs" placeholder="Nombre de recruteurs" <?php if (isset($_POST["nbRecruteurs"])) 
		{
			echo "value='".$_POST["nbRecruteurs"]."'";
		} ?>>
		<p id="messagenbRecruteurs" style="color:red"></p>

		<label for="nbPlaces"> Nombre de places</label>
		<br/>
		<input required type="number" name="nbPlaces" id="nbPlaces" placeholder="Nombre de places" <?php if (isset($_POST["nbPlaces"])) 
		{
			echo "value='".$_POST["nbPlaces"]."'";
		} ?>>
		<p id="messagenbPlaces" style="color:red"></p>
		<label for="nbStands"> Nombre de stands</label>
		<br/>
		<input required type="number" name="nbStands" id="nbStands" placeholder="Nombre de stands" <?php if (isset($_POST["nbStands"])) 
		{
			echo "value='".$_POST["nbStands"]."'";
		} ?>>
		<p id="messagenbStands" style="color:red"></p>
		<label for="nbRepas"> Nombre de repas</label>
		<br/>
		<input required type="number" name="nbRepas" id="nbRepas" placeholder="Nombre de repas" <?php if (isset($_POST["nbRepas"])) 
		{
			echo "value='".$_POST["nbRepas"]."'";
		} ?>>
		<p id="messagenbRepas" style="color:red"></p>

		</select>
		</TD>
		 <TD> 	<input type="submit" name="creer_entreprise" value="confirmer"/> </TD>
		</TABLE>
</div>
</form>

		<?php

		echo $util->generePied();
		
	}
}

?>
