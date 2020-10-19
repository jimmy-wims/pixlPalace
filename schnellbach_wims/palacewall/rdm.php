<?php
session_start();
if(isset($_SESSION['rdm'])){
$_SESSION['rdm']=0;
}
Header("Location: post.php");

?>
