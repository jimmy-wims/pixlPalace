<?php
	/*
		crée par Schnellbach Tanguy et Wims Jimmy
	*/
	define('pagencours',$_SERVER['PHP_SELF'],true);
	if (isset($_COOKIE['couleur']))//si le cookie existe
	{
		if(isset($_POST['bouton']))// si le cookie existe et qu'il a été posté
		{
			setcookie('couleur',$_POST['bouton'],time()+60*60*24*60);
			$coul=$_POST['bouton'];// cool prend la valeur de posté
			$_SESSION['couleur']=$coul;
		}
		else	// si le cookie existe mais pas et n'est pas posté
		{
			$coul=$_COOKIE['couleur'];
			$_SESSION['couleur']=$coul;
		}
	}
	else	//si le cookie n'existe pas
	{
		if(isset($_POST['bouton']))// si le cookie n'existe pas mais qu'il a été posté
		{
			$coul=$_POST['bouton'];
			setcookie('couleur',$_POST['bouton'],time()+60*60*24*60);
			$_SESSION['couleur']=$coul;
		}
		else
		{
			$coul="1232061f";
		}
	}
	function colorpanel() //fonction qui va permettre à l'utilisateur de choisir la couleur qu'il veut
	{
		$a=0;
		$pattern ='#^[0-9A-Fa-f][0-9A-Fa-f][0-9A-Fa-f][0-9A-Fa-f][0-9A-Fa-f][0-9A-Fa-f]$#';
		echo '<tr>'."\n";
		for($i=0xFF;$i>0x00;$i=$i-0x22)
		{
			for($j=0xFF;$j>0x00;$j=$j-0x77)
			{	
				for($k=0xFF;$k>0x00;$k=$k-0x11)
				{
					echo '<td> <input type="submit" class="couleurpanel" id="cube'.$i.$j.$k.'" style="background-color:#'.dechex($i).dechex($j).dechex($k).';" class=\'#'.dechex($i).dechex($j).dechex($k).';\' name="bouton" value="#'.dechex($i).dechex($j).dechex($k).'" /></td>'."\n";	
				}
			}
			echo '</tr>'."\n".'<tr>'."\n";
		}
		echo '</tr>';
	}
			if(isset($_POST['bouton']))	
				$_SESSION['btn']=$_POST['bouton'];