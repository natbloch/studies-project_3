<?php
session_start();
require "/controller.php";

if($_SERVER['REQUEST_METHOD']=='POST') {
	
	if(isset($_SESSION["logged"])){
		$path = "../view/studclasspage/studclasspage.php";
		header("Location: ".$path);
		exit();
	}
	
	if($_POST['emailorname'] != ""){
		if($_POST['pass'] != ""){
			$name = filter_var($_POST['emailorname'], FILTER_SANITIZE_STRING);
			$passpre = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
			
			$iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
			$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
			$key = "This is a very secret key";
			$pass1 = $passpre;
			$crypttext = mcrypt_encrypt(MCRYPT_BLOWFISH, $key, $pass1, MCRYPT_MODE_ECB, $iv);
			$ans = verifylogin($name, $crypttext);
			if($ans === "nologin"){
				print_r("Login not successful");
			}else{
				$_SESSION["logged"] = "yessir";
				$_SESSION["username"] = $ans[0]['Name'];
				$_SESSION["userrole"] = $ans[0]['Role'];
				$_SESSION["userimage"] = $ans[0]['ImageLink'];
				$path = "../view/studclasspage/studclasspage.php";
				header("Location: ".$path);
				exit();
			}
		}
	}
}elseif($_SERVER['REQUEST_METHOD']=='GET'){
	session_destroy();
	$path = "../view/loginpage/loginpage.php";
	header("Location: ".$path);
	exit();
}