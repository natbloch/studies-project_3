<?php
session_start();
if($_SERVER['REQUEST_METHOD']=='GET'){
if(!isset($_SESSION["logged"]) || $_SESSION["logged"] != "yessir"){
	$path = "../loginpage/loginpage.php";
	header("Location: ".$path); 
	exit();
}
	require_once "../header.php";
	//SHow different nav bar for sales or else
	require_once "../navbar.php";

	require_once "/studclasscont.php";
	require_once "../footerscripts.php";
	?>
	<script src="scriptstudclass.js"></script>
	<?php
	require_once "../footer.php";
}
?>