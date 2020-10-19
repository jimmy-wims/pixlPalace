<?php
	/*
		crée par Schnellbach Tanguy et Wims Jimmy
	*/
	
//-----------------------------palacewall et mypalace --------------------------------------------------------------------------

	function menueoption($idcom,$mail,$idp,$maildupost,$option)//fonction qui affiche les boutons
	{	
		if($option==0)
		{
			$lien="post.php";
		}
		else
		{
			$lien="mypalace.php";
		}
		echo '	<div class="menueoption">'."\n";
		echo '		<form method="post" action="'.$lien.'">'."\n".''; //on crée le bouton j'aime
		if(mysqli_num_rows(mysqli_query($idcom,"SELECT * FROM `aimepas` WHERE adresse_mail=\"$mail\" and id_post=$idp"))>0) //on verifi si le j'aime n'existe pas déjà
		{	//si l'id_post appartient à la base aime on change l'apparence du bouton j'aime
			echo '<a href="#"><input class="aime" type="image" src="../image/non_actif.png" name="jaimepas_'.$idp.'"/></a>'."\n";
		}
		else if(isset($_POST["jaimepas_".$idp."_x"]))//on regarde si la personne a cliqué sur un bouton //sinon on l'ajoute
		{
			if(mysqli_num_rows(mysqli_query($idcom,"SELECT profil.nom,profil.prenom FROM `aime`,profil WHERE profil.adresse_mail=aime.adresse_mail and aime.adresse_mail=\"$mail\" and aime.id_post=$idp"))>0)
			{	//si le bouton j'aime est cliqué on le supprime 
				mysqli_query($idcom,"delete from `aime` where adresse_mail=\"$mail\" and id_post=$idp;");
			}
			mysqli_query($idcom,"INSERT INTO `aimepas`(`id_aimepas`, `adresse_mail`, `id_post`) VALUES (0,\"$mail\",$idp)");
			$identite=mysqli_fetch_array(mysqli_query($idcom,"SELECT profil.prenom,profil.nom FROM profil WHERE profil.adresse_mail=\"$mail\""));
			$profil=mysqli_fetch_array(mysqli_query($idcom,"select adresse_mail,contenue from post where id_post=$idp"));
			$contenue="$identite[0] $identite[1] à mis un j'aime pas sur le post : $profil[1]";
			mysqli_query($idcom,"INSERT INTO notification VALUES (0,\"$profil[0]\",\"$contenue\",\"".date("Y-m-d H:i:s")."\")");
			mysqli_query($idcom,"Update stats_perso Set stats_perso.PV=stats_perso.PV-1 where stats_perso.adresse_mail=\"".$maildupost."\"");// on retire 1 de vie au mec
			mysqli_query($idcom,"Update stats_perso Set stats_perso.PV=stats_perso.PV-1 where stats_perso.adresse_mail=\"".$mail."\"");// on retire 1 de vie faut pas déconner les 2
			mysqli_query($idcom,"Update stats_perso Set stats_perso.MANA=stats_perso.MANA-1 where stats_perso.adresse_mail=\"".$mail."\"");// on retire 1 mana
			echo '<a href="#"><input class="aime" type="image" src="../image/non_actif.png"  name="jaimepas_'.$idp.'"/></a>'."\n";
		}
		else
		{
				echo '<a href="#"><input class="aime" type="image" src="../image/non_inactif.png" name="jaimepas_'.$idp.'"/></a>'."\n";
		}
		echo '</div>'."\n";
		echo '<div class="menueoption">'."\n";
		$liste=mysqli_query($idcom,"SELECT profil.nom,profil.prenom FROM `aime`,profil WHERE profil.adresse_mail=aime.adresse_mail and aime.adresse_mail=\"$mail\" and aime.id_post=$idp");
		$tabliste=mysqli_fetch_array(mysqli_query($idcom,"SELECT profil.nom,profil.prenom FROM `aime`,profil WHERE profil.adresse_mail=aime.adresse_mail and aime.id_post=$idp"));
		if(mysqli_num_rows($liste)>0) //on verifie si le j'aime n'existe pas déjà
		{	//si l'id_post appartient à la base aime on change l'apparence du bouton j'aime
				echo '	<a href="#"><input class="aime" type="image" src="../image/oui_actif.png" name="jaime2_'.$idp.'"/><span class="infobulle">'.$tabliste[0].'</span></a>'."\n";
		}
		else if(isset($_POST["jaime2_".$idp."_x"]))//on regarde si la personne a cliqué sur un bouton //sinon on l'ajoute
		{
			if(mysqli_num_rows(mysqli_query($idcom,"SELECT * FROM `aimepas` WHERE adresse_mail=\"$mail\" and id_post=$idp"))>0)
			{	//si le bouton j'aime pas est cliqué on le supprime 
				mysqli_query($idcom,"delete from `aimepas` where adresse_mail=\"$mail\" and id_post=$idp;");
			}
			mysqli_query($idcom,"INSERT INTO `aime`(`id_aime`, `adresse_mail`, `id_post`) VALUES (0,\"$mail\",$idp)");
			$identite=mysqli_fetch_array(mysqli_query($idcom,"SELECT profil.prenom,profil.nom FROM profil WHERE profil.adresse_mail=\"$mail\""));
			$profil=mysqli_fetch_array(mysqli_query($idcom,"select adresse_mail,contenue from post where id_post=$idp"));
			$contenue="$identite[0] $identite[1] à mis un j'aime sur le post : $profil[1]";
			mysqli_query($idcom,"Update stats_perso Set stats_perso.PV=stats_perso.PV+1 where stats_perso.adresse_mail=\"".$maildupost."\"");// on ajoute 1 de vie au mec
			mysqli_query($idcom,"Update stats_perso Set stats_perso.XP=stats_perso.XP+2 where stats_perso.adresse_mail=\"".$maildupost."\"");// on ajoute 2 xp	
			echo '<a href="#"><input class="aime" type="image" src="../image/oui_actif.png" name="jaime2_'.$idp.'"/><span class="infobulle">'.$tabliste[0].'</span></a>'."\n";
		}
		else
		{
				echo '<a href="#"><input class="aime" type="image" src="../image/oui_inactif.png"  name="jaime2_'.$idp.'"/><span class="infobulle">'.$tabliste[0].'</span></a>'."\n";
		}
		echo "</form>\n";
		echo '</div>'."\n";
		unset($liste);
		unset($tabliste);
	}
	
	function post_beta($idcom,$mail,$number)//envoyer une image ou un texte
	{
		echo '<form enctype="multipart/form-data" method="post">'."\n".'<input type="hidden" name="MAX_FILE_SIZE" value="250000" />'."\n".'<input type="hidden" name="rdm" value="0" />'."\n".'<textarea class="textarea_post" rows="4" cols="50" maxlength="500" name="'.$number.'" >'."\n".'</textarea > <br/>'."\n";
		
		echo '<input type="file" id="bouton-envoyer'.$number.'" name="file'.$number.'" size=50 style="visibility:hidden" />'."\n";//obliger de mettre un id différent pour chaque balise sinon ça ne fpas
		echo '<label for="bouton-envoyer'.$number.'" class="bouton-envoyer" >[&deg;o]</label> '."\n";
		echo '<select id="type" name="typedepost'.$number.'"/>'."\n".'<option value=0>public</option>'."\n".'<option value=1>amis</option>'."\n".'<option value=2>privé</option>'."\n".'</select>'."\n";
		echo '<input type="submit" class="bouton_poste" name="envoie'.$number.'" value="=>"/>'."\n";
		echo '</form>'."\n";
		if(isset($_POST[$number])||isset($_POST["file$number"]) )//metre une condition pour vide et image!=vide
		{
			mysqli_query($idcom,"INSERT INTO `post`(`id_post`, `adresse_mail`, `contenue`, `cercle`,`postref`, `datepost`) VALUES (0,\"".$_SESSION['mail']."\",\"".$_POST[$number]."\",".$_POST["typedepost$number"].",".($number=="alpha"?0:intval($number)).", \"".date("Y-m-d H:i:s")."\")");
			$ref_post=mysqli_fetch_array(mysqli_query($idcom,"SELECT post.id_post,post.adresse_mail FROM post ORDER BY datepost DESC LIMIT 0, 1"));
			envoyerimg($idcom,$mail,$ref_post,"file".$number,0);
			mysqli_query($idcom,"Update stats_perso Set stats_perso.XP=stats_perso.XP+1 where stats_perso.adresse_mail=\"".$mail."\"");
			unset($_POST[$number]);
			unset($_POST["file$number"]);
			if(isset($_SESSION["rdm"]))
			$_SESSION["rdm"]=$_SESSION["rdm"]+$_SESSION["rdm"];
		}	
		
	}

	function envoyerimg($idcom,$mail,$ref_post,$number,$profil) //inserer une image dans la base de donnee
	{
		$ret= false;
		$img_taille = 0;
		$taille_max = 250000;
		$ret= is_uploaded_file($_FILES[$number]['tmp_name']);
		if (!$ret) 
		{
		    return false;
		}
		else
		{
			// Le fichier a bien été reçu
			$img_taille = $_FILES[$number]['size'];
			echo $img_taille;
			if ($img_taille > $taille_max) 
			{
				echo "Trop gros !";
				return false;
			}
			$img_type = $_FILES[$number]['type'];
			$img_nom  = $_FILES[$number]['name'];
			$img_blob =file_get_contents($_FILES[$number]['tmp_name']);
			mysqli_query($idcom,"INSERT INTO `images` (`img_id`, `img_nom`, `img_taille`, `img_type`, `img_desc`, `img_blob`, `id_post`, `adresse_mail`, `profil_img`) VALUES ('0', '".$img_nom."', '".$img_taille."', '".$img_type."', 'description','".addslashes($img_blob)."', '".$ref_post[0]."', '".$ref_post[1]."', '$profil')");
			return true;
		}
	}

	function amis($idcom,$mail,$mail2)//retourne toute les infos des amis
	{
		$post=mysqli_query($idcom, "SELECT * FROM amis WHERE( adresse_mail=\"$mail\" and adresse_amis=\"$mail2\" and adresse_mail in (select adresse_amis from amis where adresse_mail=\"$mail2\" and adresse_amis=\"$mail\"))");
		return $post;
	}

	function afficher_publicaton($idcom,$mail,$post,$ordre,$type,$option) //gere l'affichage des publications
	{
		$post=mysqli_query($idcom, "SELECT prenom,nom,contenue,post.adresse_mail,post.cercle,post.id_post,post.postref FROM `post`,`profil` WHERE( post.adresse_mail=profil.adresse_mail and post.postref=".$post." )ORDER BY datepost $ordre");
		$ordre="ASC";
		while($row=mysqli_fetch_array($post))	//on énumére les id_post présent dans la table post
		{	
			if($type==0)
			{
				if($row["cercle"]==0 ) //post public
				{
					publication($idcom,$row,$mail,$type,$ordre,$option);
				}
			}
			if($type==1)
			{	//post amis
				if(($row["cercle"]==1 && (mysqli_num_rows(amis($idcom,$mail,$row["adresse_mail"]))>0 ))||($row["cercle"]==1&& $row["adresse_mail"]==$mail))
				{
					publication($idcom,$row,$mail,$type,$ordre,$option);
				}
			}
			if($type==2)
			{	//post prive
				if($row["cercle"]==2&&$row["adresse_mail"]==$mail)
				{
					publication($idcom,$row,$mail,$type,$ordre,$option);
				}
			}
			if($type==4)
			{
				if(($row["cercle"]==0) || ( $row["cercle"]==1 && (mysqli_num_rows(amis($idcom,$mail,$row["adresse_mail"]))>0)||($row["cercle"]==1 && $row["adresse_mail"]==$mail))||($row["cercle"]==2 &&$row["adresse_mail"]==$mail))
				{
					publication($idcom,$row,$mail,4,$ordre,$option);
				}
			}
		}
	}
	
	function publication($idcom,$row,$mail,$type,$ordre,$option) //affiche les images et le texte lié au post 
	{
		if($mail==$row["adresse_mail"])
		{
			echo "\n".'<div id="'.$row["id_post"].'" class=postperso>'."\n";
		}
		else
		{
			echo "\n".'<div id="'.$row["id_post"].'" class=postautre>'."\n";
		}
		$requette="SELECT images.img_id,images.img_blob FROM `images` WHERE images.profil_img=1 and images.adresse_mail=\"".$row["adresse_mail"]."\"";
		$img=mysqli_fetch_array(mysqli_query($idcom,$requette));
		echo '<form method="post" action="../mypalace/mypalace.php"><input type="hidden" name="photo" value="'.$row["adresse_mail"].'" /><input class="minimoi" type="image"  src="data:image/jpeg;base64,'.base64_encode( $img['img_blob'] ).'" ></form>'."\n";
		echo ' '.$row["nom"].' '.$row["prenom"].' <br/>	'."\n";
		echo '<div class="contenue">';
		echo $row["contenue"];
		echo "	<br/>"."\n";
		if(mysqli_num_rows(mysqli_query($idcom,"SELECT * FROM `images` WHERE (images.id_post=".$row["id_post"].")"))>0)
		{
			$requette='SELECT images.img_id,images.img_blob FROM `images` WHERE images.id_post='.$row["id_post"].'';
			$img=mysqli_fetch_array(mysqli_query($idcom,$requette));
			echo '<img class="imagepost"  src="data:image/jpeg;base64,'.base64_encode($img['img_blob']).'" />'."\n";
		}
		echo '</div>';
		menueoption($idcom,$mail,$row["id_post"],$row["adresse_mail"],$option);
		echo '<div class="menueoption">';
		echo '	<div class="repondrepere">repondre'."\n".'		<div class="repondre">'."\n";
		post_beta($idcom,$mail,$row["id_post"]);
		echo "		</div>\n	</div></div>\n";
		if(mysqli_num_rows(mysqli_query($idcom, "SELECT prenom,nom,contenue,post.adresse_mail,cercle,post.id_post,post.postref,post.datepost FROM `post`,`profil` WHERE( post.adresse_mail=profil.adresse_mail and post.postref=".$row["id_post"].")"))>0)
		{
			afficher_publicaton($idcom,$mail,$row["id_post"],$ordre,4,$option);
		}
		echo "</div>\n";
	}
	//---------------------------------------------------------------------mypalace------------------------------------------------------------------------
	function imageprofil($idcom,$mail)	//affiche la photo de profil et les barre de vie et de mana
	{
		echo '<div class="profil">'."\n";
		$img=mysqli_fetch_array(mysqli_query($idcom,"SELECT img_id,img_blob FROM `images` WHERE images.profil_img=1 and images.adresse_mail=\"$mail\""));
		echo '<img class="profilimage" src="data:image/jpeg;base64,'.base64_encode($img['img_blob']).'"/>'."\n";
		// echo '		<img class="profilimage" src="../image/photo.php?id='.$img[0].'" />'."\n";
		echo '		<br/><br/>'."\n".'	<span class="texte_blanc"> Vie :'."\n".'		<div class="vie">'."\n".'			<div class="barre_de_vie">'."\n".'			</div>'."\n".'		</div>'."\n".'		<br/>'."\n".'		Magie : </span>'."\n".'		<div class="mana">'."\n".'			<div class="barre_de_mana">'."\n".'			</div>'."\n".'		</div>'."\n".'	</div>'."\n\n";
		echo "<br/><br/>";
	}

	//---------------------------------------------------------------------mypalace et mes_contact------------------------------------------------------------------------

	function convertie($var,$num)	//change certains caracteres d'une adresse mail 
	{
		if($num==0)
		{
			$var=preg_replace("/\./","*","$var");
			$var=preg_replace("/@/","/","$var");
		}
		else
		{
			$var=preg_replace("/\*/",".","$var");
			$var=preg_replace("/\//","@","$var");
		}
		return $var;
	}
	
//---------------------------------------------------------------------style------------------------------------------------------------------------
	function niveaudevie($idcom,$mail) //retourne le nombre de point de vie
	{
		$intvie=mysqli_fetch_array(mysqli_query($idcom, "SELECT  `PV` FROM `stats_perso` WHERE (stats_perso.adresse_mail=\"$mail\");"));

		return $intvie[0];
	}
	
	function niveaudemana($idcom,$mail)	//retourne le nombre de point de mana
	{
		$intvie=mysqli_fetch_array(mysqli_query($idcom, "SELECT  `MANA` FROM `stats_perso` WHERE (stats_perso.adresse_mail=\"$mail\");"));

		return $intvie[0];
	}
// -------------------------------------------------------------------toutes les pages-------------------------------------------------------------------
	function setNiveau($idcom,$mail)
	{
		$row=mysqli_fetch_array(mysqli_query($idcom, "SELECT  `niveau`,`XP` FROM `stats_perso` WHERE (stats_perso.adresse_mail=\"$mail\");"));
		$objectif=(($row["niveau"]+1)*100)/2;
		if($row["XP"]>=$objectif)
			mysqli_query($idcom,"Update stats_perso Set stats_perso.niveau=stats_perso.niveau+1 where stats_perso.adresse_mail=\"$mail\"");
	}
?>
