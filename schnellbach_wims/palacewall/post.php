<?php
	/*
		crée par Schnellbach Tanguy et Wims Jimmy
	*/
	session_start();
	if(!isset($_SESSION["mail"]))
	{
		header("location:../connexion/accueil.php");
	}
	if(isset($_SESSION["rdm"]))
	{
		if($_SESSION["rdm"]>=2)
		{
			header("Location:rdm.php");
		}
		else
		{
			$_SESSION["rdm"]=$_SESSION["rdm"]+1;
		}
	}
//------------------------------------------------------------------------------------fonction--------------------------------------------------------------------------
	include("../base_de_donne/accessql.php");
	include("../fonction/function.php");
	$_GLOBALS["mail"]=$_SESSION["mail"];
	$mail=$_GLOBALS["mail"];
	setNiveau($idcom,$mail);
//---------------------------------------------------------------------------------fin ---fonction--------------------------------------------------------------------------
?>
<!html PUBLIC >
	<head>
		<link rel="icon" type="image/png" href="../image/logo.png" />
		<?php
			//on va chercher le css et on l'affiche
			include("../fonction/couleur.php");
			$back=1;
			include("../css/style.php");
		?>
	</head>
	<body class="fond">
		<?php
			include("../fonction/en_tete.php");
		?>
		<div class="wall">
			<br/><br/><br/>
			<?php
				$name=mysqli_fetch_array(mysqli_query($idcom,"select nom,prenom from profil where adresse_mail=\"$mail\""));
				echo "<span class=\"texte_blanc\">Bonjour $name[1] $name[0] voulez vous publier votre humeur?</span><br/>"."\n\n";
				//on crée les bouton (public|amis|privé)
				post_beta($idcom,$mail,"alpha");
				echo'<a onclick="javascript:visibilite(\'public\');" href="#"><div class="choix">Public</div></a>'."\n".'<a onclick="javascript:visibilite(\'amis\');" href="#"><div class="choix">Amis</div></a>'."\n".'<a onclick="javascript:visibilite(\'privee\');" href="#"><div class="choix">Privées</div></a>'."\n";
				echo'<div  id="public" >';
				echo '<div class="wallpost"><div class="wallpost2">';
				afficher_publicaton($idcom,$mail,0,"DESC",0,0);//on affiche les post public 	
				echo '</div></div></div>';
				echo'<div id="amis" style="display:none;">';
				echo '<div class="wallpost"><div class="wallpost2">';
				afficher_publicaton($idcom,$mail,0,"DESC",1,0);//on affiche les post amsi
				echo '</div></div></div>';
				echo'<div id="privee"  style="display:none;">';
				echo '<div class="wallpost"><div class="wallpost2" >';
				afficher_publicaton($idcom,$mail,0,"DESC",2,0);//on affiche les post privee
				echo '</div></div></div>';
				mysqli_close($idcom);
			?>
		</div>
		<script type="text/javascript">
			// affichage des div au clic
			var divPrecedent=document.getElementById('public');
			function visibilite(divId)
			{
				divPrecedent.style.display='none';
				divPrecedent=document.getElementById(divId);
				divPrecedent.style.display='';
			}
		</script>
	</body>
</html>
