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
			<a href="../palacewall/post.php" target="blank">Retour</a>
			<hr/>
		</div>
		
	</body>
</html>
