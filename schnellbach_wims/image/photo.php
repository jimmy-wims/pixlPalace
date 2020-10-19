<?php
define("MYHOST","localhost");
define("MYUSER","root");
define("MYPASS","saladier");
$idcom=mysqli_connect("localhost","root","saladier","projet");
$id=$_GET['id'];
$img=mysqli_query($idcom,"SELECT * FROM `images` WHERE ( images.img_id=\"$id\")");

while ($row = mysqli_fetch_assoc($img)) {
       $imagedata=$row["img_blob"];
    }
$im = imagecreatefromstring($imagedata);
$width= imagesx($im);
$height=imagesy($im);

function pixelise($image,$a,$b){
	//header("Content-type: image/jpeg");
	$val1=($a+$b)*2/100;
	$val2=(($a+$b)/100)*4;
	$val3=(($a+$b)/100)*6;
	imagefilter($image, IMG_FILTER_PIXELATE,($a+$b)/100,0);

	$white=imagecolorallocate($image,127,255,0);
	
	$sizes[0]=$a;
	$sizes[1]=$b;
	$tab=array($val1,0);
	array_push($tab,$val1,$val3);
	array_push($tab,$val2,$val3);
	array_push($tab,$val2,$val2);
	array_push($tab,$val3,$val2);
	array_push($tab,$val3,$val1);
	array_push($tab,$sizes[0]-$val3,$val1);
	array_push($tab,$sizes[0]-$val3,$val2);
	array_push($tab,$sizes[0]-$val2,$val2);
	array_push($tab,$sizes[0]-$val2,$val3);
	array_push($tab,$sizes[0]-$val1,$val3);
	array_push($tab,$sizes[0]-$val1,$sizes[1]-$val3);
	array_push($tab,$sizes[0]-$val2,$sizes[1]-$val3);
	array_push($tab,$sizes[0]-$val2,$sizes[1]-$val2);
	array_push($tab,$sizes[0]-$val3,$sizes[1]-$val2);
	array_push($tab,$sizes[0]-$val3,$sizes[1]-$val1);
	array_push($tab,$val3,$sizes[1]-$val1);
	array_push($tab,$val3,$sizes[1]-$val2);
	array_push($tab,$val2,$sizes[1]-$val2);
	array_push($tab,$val2,$sizes[1]-$val3);
	array_push($tab,$val1,$sizes[1]-$val3);
	array_push($tab,$val1,$sizes[1]);
	array_push($tab,$val1,0);
	array_push($tab,$sizes[0],0);
	array_push($tab,$sizes[0],$sizes[1]);
	array_push($tab,$val1,$sizes[1]);
	array_push($tab,0,$sizes[1]);
	array_push($tab,0,0);
	imagefilledpolygon($image,$tab,28,$white);
	imagecolortransparent($image, $white);
	return imagepng($image); //renvoie une image sous format png
	imagedestroy($image);

}

pixelise($im,$width,$height); 

?>

