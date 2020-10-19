<?php
	/*
		crée par Schnellbach Tanguy et Wims Jimmy
	*/
	session_start();
	if(isset($_COOKIE['nom'])&&(isset($_COOKIE['prenom']))) //on crée des cookies pour stocker les reponses ecrit dans les zones de saisie
	{
		$nom=$_COOKIE['nom'];
		$prenom=$_COOKIE['prenom'];
	}
	else
	{
		if(isset($_POST['nom'])&&(isset($_POST['prenom'])))
		{
			$n=$_POST['nom'];
			setcookie("nom",$n,time()+3600);
			$p=$_POST['prenom'];
			setcookie("prenom",$p,time()+3600);
		}
	}
	if(isset($_COOKIE['mail']))
	{
		$mail=$_COOKIE['mail'];
	}
	else
	{
		if(isset($_POST['mail']))
		{
			$m=$_POST['mail'];
			setcookie("mail",$m,time()+3600);
		}
	}
	include("../base_de_donne/accessql.php");	//on se connexte à la base de donner
	include("../fonction/function.php");	//on fait appel au fonction
	
	function get_ip()	//fonction qui retourne l'adresse IP
	{
		// IP si internet partagé
		if (isset($_SERVER['HTTP_CLIENT_IP'])) 
		{
			return $_SERVER['HTTP_CLIENT_IP'];
		}
		// IP derrière un proxy
		elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) 
		{
			return $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		// Sinon : IP normale
		else 
		{
			return (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
		}
	}
	
	if(isset($_POST["envoie"]))	//si on clique sur le bouton soumettre
	{
		if((isset($_POST["nom"]))&&(isset($_POST["prenom"]))&&(isset($_POST["mail"]))&&(isset($_POST["password"]))&&(isset($_POST["date"]))&&(isset($_POST["sexe"])))
		{	//on regarde si tout les champs sont remplis
			$nom=$_POST["nom"];
			$prenom=$_POST["prenom"];
			$adresse=$_POST["mail"];
			$pass=$_POST["password"];
			$date=$_POST["date"];
			if($_POST["sexe"]=="femme")
			{
				$sexe=0;
			}
			else
			{
				$sexe=1;
			}
			$pattern ='#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#';	
			if(preg_match($pattern,$adresse))	//on regarde si l'adresse mail est au bon format
			{
				$present=false;
				$mail = mysqli_query($idcom, "SELECT adresse_mail FROM profil");
				$i=0;
				while ( $row = mysqli_fetch_array($mail))	//on enumere toute les adresse mail deja stocker dans la base 
				{
					if($adresse==$row[$i])	//on regarde si l'adresse mail est déjà présente
					{
						$present=$present||true;
					}
					else
					{
						$present=$present||false;
					}
					$i+1;
				}
				if($present==false) //si l'adresse mail n'est pas presente
				{	
					$passh=password_hash($pass, PASSWORD_DEFAULT);
					mysqli_query($idcom,"insert into profil values(\"$adresse\",\"$prenom\",\"$nom\",\"$passh\",\"$date\",\"$sexe\")"); //on rentre toute les infos dans les tables
					mysqli_query($idcom,"insert into stats_perso values(\"$adresse\",100,100,0,0)");
					$blob=file_get_contents('../image/defaut.jpg');
					mysqli_query($idcom,"INSERT INTO `images` VALUES (0,\"$nom\",1743,'jpeg','description','".addslashes($blob)."',0,\"$adresse\",1)");
					$ip = get_ip();
					mysqli_query($idcom,"INSERT INTO `info`(`adresse_mail`, `ip`, `Systeme_exploitation`, `machine`, `date_installation`, `Version`, `type_processeur`) VALUES (\"$adresse\",\"$ip\",\"".php_uname('s')."\",\"".php_uname('n')."\",\"".php_uname('r')."\",\"".php_uname('v')."\",\"".php_uname('m')."\")");
					$_SESSION['mail']=$adresse;
					header('Location:../palacewall/post.php'); //on rafraichit
				}
				else
				{
					$probleme1=true;	//si il y a un probleme
				}
			}
			else
			{
				$probleme2=true;
			}
		}
		else
		{
			$probleme3=true;
		}
	}
	mysqli_close($idcom);
?>
<html>
	<head>
		<title>Pix-l-Palace</title>
		<link rel="icon" type="image/png" href="../image/logo.png"/>
		<?php
			$back=0;
			include("../css/style.php");	//on inclut le css
		?>
	</head>
	<body class="fond">
		<p class="titre">Pix-l-Palace</p>
		<br/>
		<img class="logo" src="../image/logo.png" alt="image"/>
		<p>
			<form class="texte" method="post" action="accueil.php">	
				<input class="formulaire" type="text" name="nom" value="<?php if(isset($nom))echo "$nom";?>"  placeholder="nom"/>
				<input class="formulaire" type="text" name="prenom" value="<?php if(isset($prenom))echo "$prenom";?>" placeholder=" prenom"/>
				<br/><br/>
				adresse mail : <input class="formulaire"type="text" name="mail" value="<?php if(isset($mail))echo "$mail";?>" placeholder="adresse mail"/>
				<br/><br/>
				mot de passe : <input class="form_petit" type="password" name="password"/>
				<br/><br/>
				date de naissance(jour/mois/annee) :<input class="form_petit"  type="date" name="date"/>
				<br/><br/>
				<input type="radio" name="sexe" value="femme"/>Femme 
				<input type="radio" name="sexe" value="homme"/>Homme
				<br/><br/>
				<input class="envoi" type="submit" name="envoie" value="Soumettre"/>
			</form>
		</p>
		<br/>
		<?php
			//on affiche un message d'erreur si il ya un probleme
			if(isset($probleme1))
				echo "<span class=\"attention\">Probleme :Email déjà utilisé</span>";
			if(isset($probleme2))
				echo "<span class=\"attention\">Probleme : Email invalide,format(pseudo@operateur.domaine)</span>";
			if(isset($probleme3))
				echo "<span class=\"attention\">Probleme :Champs vide</span>";
		?>
		<p class="texte"> Vous êtes déjà inscrit ?<a class="lien" href="connexion.php">Se connecter</a></p>
	</body>
</html>
