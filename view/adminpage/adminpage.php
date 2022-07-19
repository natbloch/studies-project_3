<?php
session_start();
if(!isset($_SESSION["logged"]) || $_SESSION["logged"] != "yessir"){
	$path = "../loginpage/loginpage.php";
	header("Location: ".$path); 
	exit();
}
if($_SESSION["userrole"] == "sales"){
	$path = "../studclasspage/studclasspage.php";
	header("Location: ".$path); 
	exit();
}
require_once "../header.php";
//SHow different nav bar for sales or else
require_once "../navbar.php";

require_once "/admincont.php";
require_once "../footerscripts.php";
?>
<script src="scriptadmin.js"></script>
<?php
require_once "../footer.php";
?>