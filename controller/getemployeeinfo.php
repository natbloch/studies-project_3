<?php
session_start();
require "/controller.php";
if(isset($_SESSION["logged"]) && $_SESSION["logged"]=="yessir" && $_SESSION["userrole"] != "sales"){
	if($_SERVER['REQUEST_METHOD']=='PUT'){
		$ans = getAllEmployees();
		$ans2 = json_encode($ans);
		print_r($ans2);
	}elseif($_SERVER['REQUEST_METHOD']=='POST' && !isset($_POST['req'])){
		if($_SESSION["userrole"] == "manager" && $_POST['role'] != "sales"){
			print_r("ACCESS DENIED YOU ARE NOT AUTHORIZED TO DO SO");
		}else{
			$user = $_POST;

			//Validations of inputs
			if (isset($_POST['email']) && isEmail($_POST['email'])) {
				if(isset($_POST['name'])){
					if(isset($_POST['phone']) && (!is_nan($_POST['phone']))){
						if(isset($_POST['role']) && ($_POST['role'] == "sales" || $_POST['role'] == "manager" || $_POST['role'] == "owner")){
						$_POST['email'] = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
						$_POST['name'] = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
						
						
						//Password
						if($_SESSION["userrole"] == "manager"){
							$user['password'] = "";
						}elseif($_SESSION["userrole"] == "owner"){
							$iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
							$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
							$key = "This is a very secret key";
							$pass1 = $_POST['adminpass'];
							$crypttext = mcrypt_encrypt(MCRYPT_BLOWFISH, $key, $pass1, MCRYPT_MODE_ECB, $iv);
							$user['password'] = $crypttext;
						}
						//Validate ID
						if(!is_nan($_POST["adminid"]*1) || $_POST["adminid"] == ""){$id = $_POST["adminid"];}
						
						//Validate Image
						if($_FILES["adminimg"]["error"] == 0){
							$validimg = validateimg("../uploads/employee/", $_FILES["adminimg"]);
							
							if ($validimg == 1){
								$imgcon = file_get_contents($_FILES["adminimg"]["tmp_name"]);
								$imgcon = base64_encode($imgcon);
								$user["image"]=$imgcon;
								if($id!=""){
									updateEmployee($id, $user);
								}else{
									$ans = createEmployee($user);
								}
								
							} 
							
						}else{
							$user["image"]=$_POST['adminimgprev'];
							if($id!=""){
								updateEmployee($id, $user);
							}else{
								createEmployee($user);
							}
						}
						
		}}}}}
		$path = "../view/adminpage/adminpage.php";
		header("Location: ".$path);
		exit();
	}elseif($_SERVER['REQUEST_METHOD']=='POST' && $_POST['req'] == "delete"){
		if($_SESSION["userrole"] == "sales" || $_SESSION["userrole"] == "manager"){
			print_r("ACCESS DENIED YOU ARE NOT AUTHORIZED TO DO SO");
		}else{
			$user = $_POST;
			$id = $user['adminid'];
			$ans = deleteEmployee($id);
		}
			$ansadmin = getAllEmployees();
			$ansadmin2=json_encode($ansadmin);
			print_r($ansadmin2);
	}
}else{
	header("Location: loginpage.php"); 
}