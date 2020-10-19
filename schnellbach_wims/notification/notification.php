<?php 
	/*
		crée par Schnellbach Tanguy et Wims Jimmy
	*/
	session_start();
	if(!isset($_SESSION["mail"]))
	{
		header("location:../connexion/accueil.php");
	}
	$mail=$_SESSION["mail"];
	include("../base_de_donne/accessql.php");
	include("../fonction/function.php");
?>
<html>
	<head>
		<title>Pix-L-Palace</title>
		<link rel="icon" type="image/png" href="../image/logo.png"/>
		<?php 
			include("../fonction/couleur.php");
			$back=1;
			include("../css/style.php");
		?>
	</head>
	<body class="fond">
		<?php include("../fonction/en_tete.php"); ?> 
		<div class="titre">
			Mes Notifications
			<hr/>
		</div>
		<br/><br/>
		<?php	
			$notif=mysqli_query($idcom,"SELECT * FROM `notification` WHERE adresse_mail=\"$mail\"");
			while($row=mysqli_fetch_array($notif))
			{
				//on affiche les notifications lié à l'utilisateur
				echo "<span class=\"texte_blanc\"> $row[contenue_notif]</span><br/><br/>";
				echo "$row[date_notif] <br/>";
				echo "<hr/><br/><br/><br/>";
			}
			mysqli_close($idcom);
		?>
	</body>
</html>
