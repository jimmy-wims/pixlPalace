<?php
	/*
		crée par Schnellbach Tanguy et Wims Jimmy
	*/
	session_start();
	if(!isset($_SESSION["mail"]))
	{
		header("location:../connexion/accueil.php");
	}
	if(isset($_POST["photo"]))
	{
		$_SESSION["personne"]=$_POST["photo"];
	}
	$mail=$_SESSION["mail"];
	$pers=$_SESSION["personne"];
	include("../fonction/function.php");
	include("../base_de_donne/accessql.php");
	setNiveau($idcom,$mail);
	$personne=mysqli_query($idcom,"select adresse_mail from amis where adresse_amis=\"$mail\"");
	while($res=mysqli_fetch_array($personne))
	{
		$res[0]=convertie($res[0],0);
		if(isset($_POST["$res[0]_x"]))
		{
			$res[0]=convertie($res[0],1);
			$_SESSION['personne']="$res[0]";
			header("location:mypalace.php");
		}
	}
	$personne=mysqli_query($idcom,"select adresse_mail from amis where adresse_amis=\"$mail\"");
	while($res=mysqli_fetch_array($personne))
	{
		$res[0]=convertie($res[0],0);
		if(isset($_POST["amis$res[0]"]))	//si l'utilisateur a clique sur le bouton accepter demande
		{
			$res[0]=convertie($res[0],1);
			mysqli_query($idcom,"INSERT INTO `amis` VALUES (0,\"$mail\",\"$res[0]\", \"".date("Y-m-d H:i:s")."\")");
			$identite=mysqli_fetch_array(mysqli_query($idcom,"SELECT nom,prenom FROM profil where adresse_mail=\"$mail\""));
			$contenue="$identite[1] $identite[0] à accepté votre demande en amis";
			mysqli_query($idcom,"INSERT INTO notification VALUES (0,\"$res[0]\",\"$contenue\",\"".date("Y-m-d H:i:s")."\")");
		}
		if(isset($_POST["refus$res[0]"]))	//si l'utilisateur a clique sur le bouton refuse demande
		{
			$res[0]=convertie($res[0],1);
			mysqli_query($idcom,"DELETE FROM amis where adresse_mail=\"$res[0]\" and adresse_amis=\"$mail\"");
		}
		if(isset($_POST["suppr$res[0]"]))	//si l'utilisateur a clique sur le bouton supprimer
		{
			$res[0]=convertie($res[0],1);
			mysqli_query($idcom,"DELETE FROM amis where adresse_mail=\"$res[0]\" and adresse_amis=\"$mail\"");
			mysqli_query($idcom,"DELETE FROM amis where adresse_mail=\"$mail\" and adresse_amis=\"$res[0]\"");
		}
	}
	if(isset($_POST["changer"]))	//si l'utlisateur clique sur le bouton pour changer ses informations
	{
		$name=$_POST["nom"];
		$first=$_POST["prenom"];
		$m=$_POST["adresse_mail"];
		mysqli_query($idcom,"update profil set adresse_mail=\"$m\",nom=\"$name\",prenom=\"$first\" where adresse_mail=\"$mail\"");
		$_SESSION['mail']=$m;
	}
	if(isset($_POST["envoie"]))	//pour changer la photo de profil
	{
		$tab=array(0,"$mail");
		mysqli_query($idcom,"update images set profil_img=0 where profil_img=1 and adresse_mail=\"$mail\"");
		envoyerimg($idcom,$mail,$tab,"file",1);
	}
	
	echo "<html> \n";
	echo "	<head> \n";
		echo '		<link rel="icon" type="image/png" href="../image/logo.png" />'."\n";
		echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
		//on va chercher le css et on l'affiche
		include("../fonction/couleur.php");
		$back=1;
		include("../css/style.php");
	echo "	</head> \n";
	echo "	<body class=\"fond\">\n";
	if($pers!=$mail)
	{
		if(isset($_POST["amis"]))//si une demande d'amis a ete posté
		{
			mysqli_query($idcom,"INSERT INTO `amis` VALUES (0,\"$mail\",\"$pers\", \"".date("Y-m-d H:i:s")."\")");
			$identite=mysqli_fetch_array(mysqli_query($idcom,"SELECT nom,prenom FROM profil where adresse_mail=\"$mail\""));
			if(mysqli_num_rows(mysqli_query($idcom, "select * from amis where adresse_mail=\"$pers\" and adresse_amis=\"$mail\""))>0)//si une demande d'amis a été fait
			{
				$contenue="$identite[1] $identite[0] à accepté votre demande";
			}
			else
			{
				$contenue="$identite[1] $identite[0] vous à demandé en amis";
			}
				//on envoie une notification à chaque fois
			mysqli_query($idcom,"INSERT INTO notification VALUES (0,\"$pers\",\"$contenue\",\"".date("Y-m-d H:i:s")."\")");
		}
		if(isset($_POST["refus"]))//si une demande d'amis a ete posté
		{
			mysqli_query($idcom,"DELETE FROM amis where adresse_mail=\"$pers\" and adresse_amis=\"$mail\"");
		}
		if(mysqli_num_rows(mysqli_query($idcom, "SELECT * FROM Amis WHERE( Amis.Adresse_mail=\"$mail\" and Amis.Adresse_amis=\"$pers\" )"))>0)//si il sont amis
		{
			if(mysqli_num_rows(mysqli_query($idcom, "SELECT * FROM Amis WHERE( Amis.Adresse_mail=\"$pers\" and Amis.Adresse_amis=\"$mail\" )"))>0)
			{
				echo '<div class="demandeamis"> vous êtes amis</div>';
			}
			else
			{
				echo '<div class="demandeamis">Votre demande d\'amis est en attente</div>';
			}
		}
		else
		{ 
			if(mysqli_num_rows(mysqli_query($idcom, "SELECT * FROM Amis WHERE( Amis.Adresse_mail=\"$pers\" and Amis.Adresse_amis=\"$mail\" )"))>0)
			{
				echo '<div class="demandeamis"><form action="../mypalace/mypalace.php" method="post"><input type="submit" name="amis" value="confirmer la demande ?"/><input type="submit" name="refus" value="refuser la demande ?"/></form></div>';
			}
			else
			{
				echo '<div class="demandeamis"><form action="../mypalace/mypalace.php" method="post"><input type="submit" name="amis" value="demander en amis"/></form></div>';
			}
		}
	}
	include("../fonction/en_tete.php");
	imageprofil($idcom,$pers);
?>
	<div class='couleur' >
			<?php
				if($mail==$pers)
				{
					echo '<form method="post" action=mypalace.php>';
					echo '<table class="table">';
					colorpanel(); //affiche un grand nombre de carré qui permette de changer de couleur
					echo '</table>';
					echo '</form>';
				}
				else 
				{
					echo '<form method="post" action="../message/messagerie.php">';
						echo '<input type="hidden" name="destinataire" value="'.$pers.'" /><input type="submit" name="Contacter" value="Contacter"/>';
						echo '</form> ';
					echo '<br/><br/><br/><br/><br/><br/><br/><br/>';
				}
			?>
	</div>
<?php
	if($pers==$mail)
	{	//on selectione toute les infos de l'utilisateur
		$info=mysqli_fetch_assoc(mysqli_query($idcom,"SELECT info.ip,info.Systeme_exploitation,info.machine,info.date_installation,info.Version,info.type_processeur,profil.prenom,profil.nom,profil.date_naissance,profil.adresse_mail,profil.mot_de_passe FROM info,profil WHERE (info.adresse_mail=profil.adresse_mail and  profil.adresse_mail=\"".$mail."\")"));
	}
	else
	{	//si ce n'est pas la page de l'utilisateur, il aura acces à moins d'informations
		$info=mysqli_fetch_assoc(mysqli_query($idcom,"SELECT profil.prenom,profil.nom,profil.date_naissance,profil.adresse_mail FROM profil WHERE(profil.adresse_mail=\"$pers\")"));
	}
	$info2=mysqli_fetch_assoc(mysqli_query($idcom,"SELECT  stats_perso.XP,stats_perso.niveau,stats_perso.Pv,stats_perso.mana FROM stats_perso WHERE (stats_perso.adresse_mail=\"$pers\")"));
	$info3=mysqli_query($idcom,"SELECT post.datepost,profil.nom,profil.prenom,post.contenue FROM aime,post,profil WHERE ( aime.adresse_mail=\"$mail\" and aime.id_post=post.id_post  and profil.adresse_mail=post.adresse_mail)");
	$info4=mysqli_query($idcom,"SELECT post.datepost,profil.nom,profil.prenom,post.contenue FROM aimepas,post,profil WHERE ( aimepas.adresse_mail=\"$pers\" and aimepas.id_post=post.id_post  and profil.adresse_mail=post.adresse_mail)");
	echo '<div class=stat>';
	echo'<a onclick="javascript:visibilite(\'stat1\');" href="#"><div class="choix">infos privees</div></a><a onclick="javascript:visibilite(\'stat2\');" href="#"><div class="choix">stats</div></a><a onclick="javascript:visibilite(\'stat3\');" href="#"><div class="choix">posts bleue</div></a><a onclick="javascript:visibilite(\'stat4\');" href="#"><div class="choix">posts rouge</div></a><a onclick="javascript:visibilite(\'stat5\');" href="#"><div class="choix">liste amis</div></a>';
	echo '<div class=statinterieur>';
	echo '<div id="stat1">';
	echo '<table class="stats">  '."\n";
	echo '<form enctype="multipart/form-data" method="post" action="../mypalace/mypalace.php" >';
	$i=0;
	foreach($info as $result => $nom)
	{	//on affiche les informations personnelle de la personne
		echo '<tr><th>'.$result.' </th>'."\n".'<td> <input type="text" name="'.$result.'" value="'.$nom.'"';if($i<=5)echo 'readonly="readonly"';else $tab[]=$result;echo '/></td></tr>'."\n";
		$i=$i+1;
	}
	if($pers==$mail)
	{	
		//on crée un bouton pour changer les informations
		echo '<tr><td><input type="submit" name="changer" value="valider"/></td></tr>';
		echo '</form> ';
	}
	echo '<form enctype="multipart/form-data" method="post">'."\n".'<input type="hidden" name="MAX_FILE_SIZE" value="250000" />'."\n".'<input type="hidden" name="rdm" value="0" />';
	echo '<tr><td>';
	echo '<input type="file" name="file" size=50 />'."\n";
	echo '</td><td>';
		//bouton pour changer de photo
	echo '<input type="submit" name="envoie" value="changer de photo"/>'."\n";
	echo '</td></tr>';
	echo '</form>'."\n";
	echo '</table>';
	echo '</div>';
	echo '<div id="stat2" style="display:none;" >';
	echo '<table class="stats" >';
	foreach ($info2 as $result => $nom) 
	{
		//affiche les stats de l'utilisateur
		echo '<tr>';
		echo '<td>'.$result.' </td>'."\n".'<td> '.$nom.'  '."\n".'</td>'."\n";
		echo '<td><img class="plus" src="../image/'.$result.'.png"/></td>';
		echo '</tr>';
	}
	if($mail==$pers)
	{
		//créer un bouton qui permettra à l'utlisateur de télécharger le fichier xml avec ses infos 
		echo '<form method="post" action="info_profil.php" >';
		echo '<tr><td>';
		echo '<input type="hidden" name="consultation" value="'.$mail.'"/><input type="submit" name="consulter" value="consulter"/>';
		echo '</td></tr>';
		echo '</form>';
	}
	echo '</table>';
	echo '</div>';
	echo '<div id="stat3" style="display:none;" >';
	echo '<table class="stats">';
	while($row=mysqli_fetch_array($info3))
	{	//affiche les posts où la personne à mis un j'aime
		echo '<tr>';
		echo '<th> post de '.$row['nom'].' '.$row['prenom'].' </th>'."\n".'<td> '.$row['contenue'].'</td>'.'<td> publié le : '.$row['datepost'].'</td>'."\n";
		echo '</tr>';
	}
	echo '</table>';
	echo '</div>';
	echo '<div id="stat4" style="display:none;" >';
	echo '<table class="stats">';
	while($row=mysqli_fetch_array($info4))
	{	//affiche les posts où la personne à mis un j'aime pas
		echo '<tr>';
		echo '<td> post de '.$row['nom'].' '.$row['prenom'].' </td>'."\n".'<td> '.$row['contenue'].'</td>'.'<td> publié le : '.$row['datepost'].'</td>'."\n";
		echo '</tr>';
	}
	echo '</table>';
	echo '</div>';
	echo '<div id="stat5" style="display:none;" >';
	if($pers==$mail)
	{
		echo '<table class="stats">';
		echo '<form method="post" action="mypalace.php" >';
		$amis=mysqli_query($idcom,"select nom,prenom,adresse_mail from profil where adresse_mail in (select adresse_mail from amis where adresse_amis=\"$mail\" and adresse_mail NOT IN (select adresse_amis from amis where adresse_mail=\"$mail\"))");
		while($row=mysqli_fetch_array($amis))
		{
			$photo=mysqli_fetch_assoc(mysqli_query($idcom,"SELECT img_blob from images WHERE adresse_mail=\"$row[adresse_mail]\" and profil_img=1"));
			$var="$row[adresse_mail]";
			$var=convertie($var,0);
			echo '<tr>';
				//affiche la photo des personnes qui ont demandé l'utilisateur en amis
			echo "<td><input class=\"img_petit\" type=\"image\" src=\"data:image/jpeg;base64,".base64_encode( $photo['img_blob'] )."\" name=\"$var\"/></td>";
			echo "<td>$row[prenom] $row[nom] </td>";
				//crée deux boutons permettant d'accepter ou refuser la demande en amis
			echo '<td><input type="submit" name="amis'.$var.'" value="confirmer"/><input type="submit" name="refus'.$var.'" value="refuser"/></form></div></td>';
			echo '</tr>';
		}
		$amis=mysqli_query($idcom,"select nom,prenom,adresse_mail from profil where adresse_mail in (select adresse_mail from amis where adresse_amis=\"$mail\" and adresse_mail in (select adresse_amis from amis where adresse_mail=\"$mail\"))");
		while($row=mysqli_fetch_array($amis))
		{
			$photo=mysqli_fetch_assoc(mysqli_query($idcom,"SELECT img_blob from images WHERE adresse_mail=\"$row[adresse_mail]\" and profil_img=1"));
			$var="$row[adresse_mail]";
			$var=convertie($var,0);
			echo '<tr>';
				//affiche la photo des amis de l'utilisateur
			echo "<td><input class=\"img_petit\" type=\"image\" src=\"data:image/jpeg;base64,".base64_encode( $photo['img_blob'] )."\" name=\"$var\"/></td>";
			echo "<td>$row[prenom] $row[nom]</td>";
			//crée un bouton permettant de supprimer les amis
			echo '<td><input type="submit" name="suppr'.$var.'" value="supprimer"/></td>';
			echo '</tr>';
		}
		echo '</form>';
		echo '<form method="post" action="info_amis.php" >';
		echo '<tr><td>';
			//créer un bouton qui permettra à l'utlisateur de télécharger le fichier xml avec l'infos de ses amis 
		echo '<input type="hidden" name="consultation" value="'.$mail.'" /><input type="submit" name="consulter" value="consulter"/>';
		echo '</td></tr>';
		echo '</form> ';
		echo '</table>';
	}
	else
	{
		//si ce n'est pas la page de l'utilisateur, il n'aura pas accés à l'onglet liste d'amis
		echo '<table class="stats"><tr><th> ';
		echo 'vous ne pouvez pas consulter cette partie si vous n etes pas la personne';
		echo '</tr></th></table>';
	}
	echo '</div>';
	echo '</div>';
?>
		<script type="text/javascript">
			// affichage des div au clic
			var divPrecedent=document.getElementById('stat1');
			function visibilite(divId)
			{
				divPrecedent.style.display='none';
				divPrecedent=document.getElementById(divId);
				divPrecedent.style.display='';
			}	
		</script>
		<div class="wall">
			<br><br><br><br>
			<?php
				//affichage des posts public de l'utilisateur
				echo '<span class="texte_blanc">Post public</span>';
				$name=mysqli_fetch_array(mysqli_query($idcom,"select nom,prenom,adresse_mail from profil where adresse_mail=\"$mail\""));
				echo '<div class="wallpost"><div class="wallpost2">';
				$post=mysqli_query($idcom, "SELECT prenom,nom,contenue,post.adresse_mail,post.cercle,post.id_post,post.postref FROM `post`,`profil` WHERE( post.adresse_mail=profil.adresse_mail and post.postref=0 and post.cercle!=2 and post.adresse_mail=\"$pers\")ORDER BY datepost DESC");
				while($row=mysqli_fetch_array($post))	//on énumére les id_post présent dans la table post
				{
					echo "\n".'<div id="'.$row["id_post"].'" class=postperso>'."\n";
					$requette="SELECT images.img_blob FROM `images` WHERE images.profil_img=1 and images.adresse_mail=\"".$row["adresse_mail"]."\"";
					$img=mysqli_fetch_array(mysqli_query($idcom,$requette));
					echo '<form method="post" action="../mypalace/mypalace.php"><input type="hidden" name="photo" value="'.$row["adresse_mail"].'" /><input class="minimoi" type="image" src="data:image/jpeg;base64,'.base64_encode( $img['img_blob'] ).'" ></form>'."\n";
					echo ' '.$row["nom"].' '.$row["prenom"].' <br/>	'."\n";
					echo '<div class="contenue">';
					echo $row["contenue"];
					echo "	<br/>"."\n";
					if(mysqli_num_rows(mysqli_query($idcom,"SELECT * FROM `images` WHERE (images.id_post=".$row["id_post"].")"))>0)
					{
						$requette='SELECT images.img_blob FROM `images` WHERE images.id_post='.$row["id_post"].'';
						$img=mysqli_fetch_array(mysqli_query($idcom,$requette));
						echo '<img class="imagepost" src="data:image/jpeg;base64,'.base64_encode( $img['img_blob'] ).'" />'."\n";
					}
					echo '</div>';
					menueoption($idcom,$mail,$row["id_post"],$row["adresse_mail"],1);
					echo '<div class="menueoption">';
					echo '	<div class="repondrepere">repondre'."\n".'		<div class="repondre">'."\n";
					post_beta($idcom,$mail,$row["id_post"]);
					echo "		</div>\n	</div></div>\n";
					if(mysqli_num_rows(mysqli_query($idcom, "SELECT prenom,nom,contenue,post.adresse_mail,cercle,post.id_post,post.postref,post.datepost FROM `post`,`profil` WHERE( post.adresse_mail=profil.adresse_mail and post.postref=".$row["id_post"].")"))>0)
					{
						afficher_publicaton($idcom,$mail,$row["id_post"],"DESC",4,1);
					}
					echo "</div>\n";
				}
				echo '</div></div>';
				if($mail==$pers)
				{	//on affiche les post prive de l'utilisateur
					echo '<span class="texte_blanc">Post privé</span>';
					echo '<div class="wallpost"><div class="wallpost2" >';
					afficher_publicaton($idcom,$pers,0,"DESC",2,1);//on affiche les post privee
					echo '</div></div>';
				}
				mysqli_close($idcom);
			?>
		</div>
	</body>
</html>
