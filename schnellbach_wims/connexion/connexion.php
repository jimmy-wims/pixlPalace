<?php
	/*
		crée par Schnellbach Tanguy et Wims Jimmy
	*/
	session_start();
	if(isset($_COOKIE['mail']))
	{
		$mail=$_COOKIE['mail'];	
		$_SESSION['mail']=$_COOKIE['mail'];
	}
	else
	{
		if(isset($_POST['mail']))
		{
			$m=$_POST['mail'];
			setcookie("mail",$m,time()+3600);
		}
	}
	include("../base_de_donne/accessql.php"); //on se connecte à la base
	include("../fonction/function.php"); //on inclut les fonction
	if((isset($_POST['envoie']))&&($_POST['mail']!="")&&(isset($_POST['password'])))
	{
		$mail=$_POST['mail'];
		$password=$_POST['password'];
		$resultat= mysqli_query($idcom, "SELECT mot_de_passe FROM profil where adresse_mail=\"$mail\"");
		$row=mysqli_fetch_array($resultat);
		if(password_verify($password, $row[0]))	//on regarde si le mot de passe saisie est le bon
		{
			$_SESSION['mail']=$mail;
			header("location:../palacewall/post.php");
		}
		else
			$bon=false;
	}
	mysqli_close($idcom);
?>

<html>
	<head>
		<title>Connexion</title>
		<?php
			$back=0;
			include("../css/style.php");
		?>
		<link rel="icon" type="image/png" href="../image/logo.png"/>
	</head>
	<body class="fond">
		<div class="bande">
			<p class="titre">Connexion</p>
			<br/><br/>
			<p>
				<form class="identification" method="post"  class="forme" action="connexion.php">  <br>
					<input class="champ" type="text" value="" placeholder=" e-mail" name="mail" value="<?php if(isset($mail)) echo "$mail";?>"/>
					<br/><br/><br/>
					<input class="champ" type="password" placeholder=" mot de passe" name="password"/>
					<br/><br/><br/>
					<input class="bouton_connexion" type="submit" name="envoie" value="connexion"/>
				</form>
			</p>
			<?php
				if(isset($bon))
					if($bon==false)	////on affiche un message d'erreur si il ya un probleme
						echo "<p class='identification'>Probleme avec l'email ou le mot de passe</p>";
			?>
			<p> Vous n'êtes pas encore inscrit ?<a class="lien" href="accueil.php">S'inscrire</a></p>
		</div>
	</body>
</html>