<?php
	/*
		crée par Schnellbach Tanguy et Wims Jimmy
	*/
	if(isset($_SESSION['couleur']))
	{
		$coul=$_SESSION['couleur'];
	}
	else
	{
		$coul="#DF7401";
	}
	
	if(isset($back))
	{
		if($back==0)
		{
			$url="../image/background.JPG";
		}
		else
		{
			$url="../image/paysage.jpg";
		}
	}


	
echo "<style type='text/css'>\n";
	echo 'a:link{text-decoration:none; text-color: white;}'."\n";
	echo 'a{color: black;}'."\n";
	echo '.minimoi{height:50px;width:50px;cursor:URL("../image/epee2.png")4 12, auto;}';

	echo 'html, body{margin:0;padding:0;cursor:URL("../image/epee.php")4 12, auto;}'."\n";
	
	//accueil et connexion
	echo '.fond{margin:0;padding:0;background:url("'.$url.'") no-repeat center fixed;background-size: cover;cursor:URL("../image/epee.php")4 12, auto;}';

	echo '.logo{display:block;margin-left:15%;margin-top:1%;float:left;height:auto;width:32%;}';
	echo '.texte{color:white;margin-left:60%;margin-top:5%;font-size:16pt;}';
	echo '.formulaire{width:200;height:25;}';
	echo '.formulaire,.form_petit{border-radius: 10px;}';
	echo '.envoi,.bouton_connexion{font-size:16pt;font-style:bold;display:inline-block;background-color:#0FA45E ;border-style:double;border-radius:25px;cursor:pointer;}';
	echo '.lien{color:#7BABF2;cursor:URL("../image/epee2.png")4 12, auto;}';
	echo '.attention{color:red;font-size:16pt;font-weight:bold;}';
	
	//connexion
	echo '.bande{margin-left:30%;width:40%;height:100%;margin-top:0;background-color:white;}';
	echo '.identification{margin-left:25%;margin-top:15%;color:red;}';
	echo '.champ{height:5%;width:70%;border-radius:15px;}';
	echo '.bouton_connexion{margin-left:20%;}';

	echo '.table{BORDER-COLLAPSE:collapse;}'."\n";
	//fin couleur choisir 
	$test=99;
	$test2=200;
	$test3=300;
	echo '.titre{margin-top:0;text-align:center;font-size:30pt;font-weight:bold;background-color:#'.dechex(hexdec($coul)-$test).';}';
	echo '.menue{background-image: url("../image/fond.php");z-index:2;background-color:#'.dechex(hexdec($coul)-$test).';width:300%;height:20px;opacity:0.2;position:fixed;transition-duration: 0.7s;margin-bottom:5%;z-index:3;}'."\n";
	echo '.menue>.offre_groupee{display:none;}'."\n";
	echo '.menue:hover{height:25px;opacity:1;padding-bottom:50px; }'."\n";
	echo '.menue:hover > .offre_groupee{display:block;}'."\n";

	echo '.poster{height:40px;width:40px;}'."\n";
	echo '.menue1{background-color:white;display:inline-block;margin:5px 1%; vertical-align:middle;padding:5px;border-style:solid;border-color:black; }'."\n";
	echo '.menue1:hover{background-color:'.dechex(hexdec($coul)-$test2).';cursor:URL("../image/epee2.png")4 12, auto;}'."\n";
	echo 'form{ margin:0; padding:0; }';

	echo '.demandeamis{position:absolute;margin-top:15%;margin-left:60%;}';


	echo '.repondre{display:none;position:relative;height:10px;padding:2%;}'."\n";
	echo '.repondrepere{font-size: 13px;height:10px;margin:1%;transition-duration: 1s;opacity:0.4;padding:5px;}'."\n";
	echo '.repondrepere:hover{height:150px;opacity:1;}'."\n";
	echo '.repondrepere:hover > .repondre{display:block;opacity:1;}'."\n";



	echo '.choix{background-color:'.dechex(hexdec($coul)-$test).';vertical-align: middle;display:inline-block;margin-left:auto;margin:0% 1%; width:13%;border-width: 5px;padding:10px;border-color:white;border-color:black;opacity:0.95;}'."\n";
	echo '.choix:hover{background-color:'.dechex(hexdec($coul)-$test3).';opacity:0.95;cursor:URL("../image/epee2.png")4 12, auto;}';
	echo '.wall{width: 100%; text-align:center; }';
	echo '.wallpost{background-image: url("../image/fond.php"); margin: 0% 26% 5% 26%;padding:0% 1%;z-index:2;}'."\n";
	echo '.wallpost2{padding:1% 0%;background-image: url("../image/fond.php");background-attachment:fixed;}'."\n";
	echo '.postautre,.postperso,.commperso,.commautre{margin:0% 5%;height:auto;border-width: 5px;box-shadow: 0px 0px 10px 10px rgba(255, 255, 255,1);opacity:0.95;word-wrap:break-word;}'."\n";
	echo '.postautre,.postperso{Font-Weight: Bold;margin:30px 0px 30px 30px;padding:1% 0% 1% 1%;}'."\n";
	echo '.postautre,.commautre{background-image: url("../image/photob.php");background-color:#'.dechex(hexdec($coul)-$test2).';background-attachment:fixed; }'."\n";
	echo '.postperso,.commperso{background-color:#'.dechex(hexdec($coul)-$test).';}'."\n";
	echo '.commperso,.commautre{font-size:16;Font-Weight: Normal;}'."\n";
	echo '.commperso,.postperso{text-align:left;}'."\n";
	echo '.commautre,.postautre{text-align:right;}'."\n";
	echo '.contenue{margin:1% 3%;box-shadow: 2px -2px 1px 2px rgba(255, 255, 255,0.8);padding:5px;}';
	echo '.barroption{display:inline;}';

	echo '.profil{position:absolute;margin-left:11%;margin-top:3%;height:200px; width:200px;}'."\n";
	echo '.vie,.mana{width:200px;height:20px;border-style:double;border-radius:25px;padding:0%;}'."\n";
	echo '.barre_de_vie,.barre_de_mana{position:relative;background-color:red;height:20px;border-radius:25px 0px 0px 25px;margin:0px;}'."\n";
	echo '.barre_de_vie{background-color:red;width:'.niveaudevie($idcom,$mail).'%;}'."\n";
	echo '.barre_de_mana{background-color:blue;width:'.niveaudemana($idcom,$mail).'%;}'."\n";

	echo '.aime{height:30px; width:30px;cursor:URL("../image/epee2.png")4 12, auto;}';
	echo 'a >span{opacity:0; transform:scale(0) rotate(-12deg);transition:all .25s;position:absolute;}';
	echo 'a:hover>span{position:absolute;background-color:yellow;opacity:1;transform:scale(1) rotate(0); }';


	echo '.profilimage{height:200px; width:200px;}';


	echo '.stat{margin:5% 10%;border-width:5px;}'."\n";
	echo '.statinterieur{padding:10px;background-image: url("../image/fond.php");margin:0% 1%;background-attachment:fixed;}'."\n";

	echo '.stats,.stats2,.stats3,.stats4{ background-color:'.dechex(hexdec($coul)-$test).'; opacity:0.95; border-collapse: separate;border-spacing: 10px 10px;border-style:solid;border-color:black;}'."\n";
	echo '#stat1,#stat2,#stat3,#stat4{border: 1px solid #000 0.1;}';
	echo'.stats td,.stats th{box-shadow: -2px 2px 1px 2px rgba(255, 255, 255,0.8);padding:15px;}';


	echo '.textarea_post,.textarea_alpha{height:40px;width:40%;resize : none;padding:0% 2%;}'."\n";

	echo '.bouton_poste{ background-color: white;border:3px solid #F5C5C5; padding:5px;width:50px;height:30px;}'."\n";

	echo '.plus{width:10%;height:auto;}'."\n";
	echo '.bouton-envoyer{cursor:URL("../image/epee2.png")4 12, auto; border:1px solid #000000;}'."\n";


	echo 'select#type{background-repeat: no-repeat;   overflow: hidden;   width: 100px;	color: #fff;   background-color: #'.dechex(hexdec($coul)-$test3).';}'."\n";

	echo '.wallpost, .wallpost2,.menue{background-image: url("../image/fond.php");}';


	echo '.texte_blanc{color:white;font-size:16pt;font-weight:bold;}';
	echo '.img_petit{width:30%;height:auto;cursor:URL("../image/epee2.png")4 12, auto;}';

	echo "table {margin:0px;margin-bottom:0px;border-collapse:collapse;}"."\n";
	echo "td {padding: Opx;}"."\n";
	echo '.couleurpanel{border-style:none;font-size:0px;width:15px;cursor:URL("../image/epee2.png")4 12, auto;height:15px;margin:5%;}';
	echo '.couleur{margin:0% 25%;padding:80px;}'."\n";
	echo 'td .couleurpanel{animation: masuperanimation 2s;}';


	echo '.imagepost{max-height:500px;max-width:500px;}';

	echo '.menueoption{display:inline-block;padding-top:0px;position:relative;vertical-align: top;box-shadow: -2px 2px 1px 2px rgba(255, 255, 255,0.8);}'."\n";

	for($i=0xFF;$i>0x00;$i=$i-0x22){
			for($j=0xFF;$j>0x00;$j=$j-0x77){	
				for($k=0xFF;$k>0x00;$k=$k-0x11){
	echo '#cube'.$i.$j.$k.'{animation: animcube'.$i.$j.$k.' 2s;}'."\n";
	echo '@keyframes animcube'.$i.$j.$k.' {0% { transform:  translateX('.rand(-1800,1200).'px) translateY('.rand(-1000,1200).'px) rotate(-90deg);}100% { transform: translateX(0px) rotate(0deg);}}'."\n";
	}
	}
	}

	//mes_contacts
		echo '.contact{background-image: url("../image/fond.php");margin:5%;padding:5%;}';
	echo '.contact2{background-color:'.dechex(hexdec($coul)-843).';margin:auto;width:100%}';
	echo '.message{margin-left:5%;top:10%;border-radius:10px;background-color:#0489B1;}';
	echo '.identite{color:black;margin-left:10%;top:5%;font-size:14pt;}';

	//messagerie
	echo '.titre_mess{font-size:20pt;text-align:center;font-weight:bold;}';
	echo '.moi{margin-left:40%;height:auto;border-width: 5px;box-shadow: 0px 0px 10px 10px rgba(255, 255, 255,1);opacity:0.95;word-wrap:break-word;background-color:#'.dechex(hexdec($coul)-$test2).';}';
	echo '.autre{margin-right:40%;height:auto;border-width: 5px;box-shadow: 0px 0px 10px 10px rgba(255, 255, 255,1);opacity:0.95;word-wrap:break-word;background-color:#'.dechex(hexdec($coul)-$test).';}';
	echo '.zone{resize:none;height:50;width:35%;margin-left:35%;}';
	echo '.saisie{position:fixed;top:86%;left:0%;width:100%;height:14%;background-color:silver;}';
	echo '.mini_img{height:auto;width:35%;cursor:URL("../image/epee2.png")4 12, auto;}';
	echo'.nom{font-size:12pt;color:white;margin-left:5%;}';


	
	echo "</style>";
?>

