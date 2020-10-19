<?php
	/*
		crée par Schnellbach Tanguy et Wims Jimmy
	*/
	session_start();
	if(!isset($_SESSION['mail']))
	{
		header("location:../connexion/accueil.php");
	}
	if((isset($_POST["destinataire"]))||(isset($_SESSION["destinataire"])))
	{
		if((isset($_POST["destinataire"])))
			$_SESSION['destinataire']=$_POST["destinataire"];
		include("../base_de_donne/accessql.php");
		include("../fonction/function.php");
		$mail=$_SESSION['mail'];
		$dest=$_SESSION['destinataire'];
		function ecrire($chaine,$classe)	//fonction qui va permettre de cou per un message et de l'ecrire sur plusieurs lignes
		{
			echo "<div class=\"$classe\">";
			$taille=strlen($chaine);
			if($taille>40)
			{
				$i=0;
				while($i!=$taille)
				{
					echo "$chaine[$i]";
					$i=$i+1;
					if($i%40==0)
					{
						echo "<br/>";
					}
				}
				echo "<br/>";
			}
			else
			{
				echo "$chaine <br/>";
			}
			echo "</div>";
		}
		$personne=mysqli_query($idcom,"select adresse_mail from amis where adresse_amis=\"$mail\"");
		while($res=mysqli_fetch_array($personne))
		{
			//on regarde si l'une des photo à été cliqué dans la liste des contacts
			$res[0]=convertie($res[0],0);
			if(isset($_POST["$res[0]_x"]))
			{
				$res[0]=convertie($res[0],1);
				$_SESSION['destinataire']="$res[0]";
				header("location:messagerie.php#bas");
			}
		}
		if((isset($_POST['envoie']))&&($_POST['message']!=""))	//si un l'utilisateur veut envoyer un message
		{
			$message=$_POST['message'];
				//on insere le message dans la table message 
			mysqli_query($idcom,"INSERT INTO message VALUES (0,\"$mail\",\"$dest\",\"$message\",\"".date("Y-m-d H:i:s")."\")");
			$identite=mysqli_fetch_array(mysqli_query($idcom,"SELECT nom,prenom FROM profil where adresse_mail=\"$mail\""));
			$contenue="$identite[1] $identite[0] vous à envoyé un message";
				//on insere une notification
			mysqli_query($idcom,"INSERT INTO notification VALUES (0,\"$dest\",\"$contenue\",\"".date("Y-m-d H:i:s")."\")");
			header("location:messagerie.php#bas" ); //on rafraichit
		}
	}
?>
<html>
	<head>
		<title>Messagerie</title>
		<link rel="icon" type="image/png" href="../image/logo.png"/>
		<?php
			include("../fonction/couleur.php");
			$back=1;
			include("../css/style.php");
			echo '</head>';
		?>
	<body class="fond">
		<?php
			echo '<div class=wallpost>';
			echo '<div class=postperso>';
			if((isset($_POST["destinataire"]))||(isset($_SESSION["destinataire"])))
			{	
				//on cré la liste des contact
				$identite=mysqli_query($idcom,"SELECT nom,prenom FROM profil where adresse_mail=\"$dest\"");
				$row=mysqli_fetch_array($identite);
				echo "<p class=\"titre_mess\">$row[prenom] $row[nom]</p>";
				echo '<br/><br/><br/>';
				$nos_mess=mysqli_query($idcom,"(SELECT contenue,adresse_mail,date_message FROM message where adresse_mail=\"$mail\" and mail_destinataire=\"$dest\")UNION(SELECT contenue,adresse_mail,date_message FROM message where adresse_mail=\"$dest\" and mail_destinataire=\"$mail\") order by date_message");
				while($mess=mysqli_fetch_array($nos_mess)) //on selectionne les messages
				{
					if($mess['adresse_mail']==$mail)
					{
						$style="moi";
					}
					else{$style="autre";}
					ecrire($mess['contenue'],"$style");// on affiche les messages
					echo "<br>";
				}
				echo "<br><br><br><br>";
				echo "<div id=\"bas\">";
				echo "<br/><br/><br/>";
				echo "</div>";
				echo "</div>";
				echo "</div>";
				mysqli_close($idcom);
			}
		?>
		<div class="saisie">
			<hr/>
			<form method="post" action="messagerie.php"  target="cadre2"/>
				<textarea class="zone" name="message" placeholder="Dites quelque chose ..." value="" maxlength="500"></textarea/>
				<input type="submit" name="envoie" value="envoyer"/>
			</form>
		</div>
	</body>
</html>
