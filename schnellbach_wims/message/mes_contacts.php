<?php
	/*
		crée par Schnellbach Tanguy et Wims Jimmy
	*/
	session_start();
	if(!isset($_SESSION['mail']))
	{
		header("location:../connexion/accueil.php");
	}
	$mail=$_SESSION['mail'];
	include("../base_de_donne/accessql.php");	//connection à la base de donne
	include("../fonction/function.php");	//inclut les foctions
	// $personne=mysqli_query($idcom,"select adresse_mail from amis where adresse_amis=\"$mail\"");
	// while($res=mysqli_fetch_array($personne))	//on enonce tous les amis
	// {
		// $res[0]=convertie($res[0],0);
		// if(isset($_POST["$res[0]_x"]))	//si l'utilisateur clique sur la photo d'une personne
		// {
			// $res[0]=convertie($res[0],1);
			// $_SESSION['destinataire']="$res[0]";	//on initialise la valeur du destinataire
			// header("location:messagerie.php#bas");	//redirige vers la page messagerie.php
		// }	
	// }
?>
<html>
	<head>
		<title>Mes Contacts</title>
		<link rel="icon" type="image/png" href="../image/logo.png"/>
		<?php 
			$back=1;
			include("../fonction/couleur.php");
			include("../css/style.php"); //on inclut le css
		?>
	</head>
	<body class="fond">
	
		<div class="titre">
			Mes Contacts
			<hr/>
		</div>
			<?php	
				$contact=mysqli_query($idcom,"(select DISTINCT mail_destinataire from message where adresse_mail=\"$mail\") UNION (SELECT adresse_mail from message where mail_destinataire=\"$mail\")");
				while($row=mysqli_fetch_array($contact))
				{	//on énumere tous les amis
					echo '<div class="contact">';
					echo '<div class="contact2">';
					$nom=mysqli_fetch_array(mysqli_query($idcom,"SELECT prenom,nom FROM `profil` WHERE adresse_mail=\"$row[0]\""));
					echo "<span class=\"identite\"> $nom[0] $nom[1] </span> <br/><br/>";
					$img=mysqli_fetch_array(mysqli_query($idcom,"SELECT img_blob FROM `images` WHERE images.profil_img=1 and images.adresse_mail=\"$row[0]\""));
					//on affiche la photo de la personne
					echo '<form method="post" action="messagerie.php" target="cadre2"><input type="hidden" name="destinataire" value="'.$row[0].'" /><input class="mini_img" type="image"  src="data:image/jpeg;base64,'.base64_encode( $img['img_blob'] ).'" ></form>'."\n";
					echo '<br/>';
					$mess=mysqli_fetch_array(mysqli_query($idcom,"select contenue,date_message from message where date_message=(select max(date_message) from message where (adresse_mail=\"$mail\" and mail_destinataire=\"$row[0]\") or (adresse_mail=\"$row[0]\" and mail_destinataire=\"$mail\"))"));
					//on affiche le contenue
					if(isset($mess))
						echo "<span class=\"message\"> $mess[contenue] </span> <br/><br/>";
					echo '<hr/>';
					echo '</div>';
					echo '</div>';
				}
				mysqli_close($idcom);
			?>
	</body>
</html>
