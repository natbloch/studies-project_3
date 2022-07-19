<?php
session_start();
if(isset($_SESSION["logged"])){
	$path = "../studclasspage/studclasspage.php";
	header("Location: ".$path); 
	exit();
}
require_once "../header.php";
require_once "/loginnav.php";
require_once "../footerscripts.php";
?>
<script src="scriptlogin.js"></script>
<?php
require_once "../footer.php";
?>