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
	
<!DOCTYPE html>
<HTML>
<HEAD>
<META CHARSET=utf-8>
<meta name="tanguy schnellbach-jimmy wims">

<TITLE> programmation</TITLE>
<?php
include("../css/style.php");
?>
</HEAD> 

<frameset rows="10%,*">
<?php
include("../css/style.php");
?>
 <a href="../palacewall/post.php"> <frame NAME="entete" src="retour.php"></a>
	
<frameset cols="25%,*">
 bonjour
  <frame NAME="cadre1" src="mes_contacts.php">
  <frame NAME="cadre2" src="messagerie.php">
</frameset> 


</HTML> 
