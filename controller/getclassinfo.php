<?php
session_start();
require "/controller.php";
if(isset($_SESSION["logged"]) && $_SESSION["logged"]=="yessir"){
	if($_SERVER['REQUEST_METHOD']=='POST' && !isset($_POST['req'])){
		if($_SESSION["userrole"] == "sales"){
			print_r("ACCESS DENIED YOU ARE NOT AUTHORIZED TO DO SO");
		}else{	
			$user = $_POST;
			//Validations of inputs
			if(isset($_POST['name'])){
				if(isset($_POST['description'])){
						$_POST['description'] = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
						$_POST['name'] = filter_var($_POST['name'], FILTER_SANITIZE_STRING);

						//Validate ID
						if(!is_nan($_POST["classid"]*1) || $_POST["classid"] == ""){$id = $_POST["classid"];}
						
						
						//Validate Image
						if($_FILES["classimg"]["error"] == 0){
							
							$validimg = validateimg("../uploads/class/", $_FILES["classimg"]);
							
							if ($validimg == 1){
								$imgcon = file_get_contents($_FILES["classimg"]["tmp_name"]);
								$imgcon = base64_encode($imgcon);
								$user["image"]=$imgcon;
								if($id!=""){
									updateClass($id, $user);
								}else{
									createClass($user);
								}
								
							} 
							
						}else{
							$user["image"]=$_POST['classimgprev'];
							if($id!=""){
								updateClass($id, $user);
							}else{
								createClass($user);
							}
						}
						
		}}}
		$path = "../view/studclasspage/studclasspage.php";
		header("Location: ".$path);
		exit();
		//$ans3 =; Get the union table with which students in which class
	}elseif($_SERVER['REQUEST_METHOD']=='POST' && $_POST['req'] == "delete"){
		if($_SESSION["userrole"] == "sales"){
			print_r("ACCESS DENIED YOU ARE NOT AUTHORIZED TO DO SO");
		}else{
			$user = $_POST;
			$id = $user['classid'];
			$ansdel = deleteClass($id);
			$ans = [];
			$ans['stud']= getAllStudents();
			$ans['class'] = getAllClasses();
			$ans2=json_encode($ans);
			print_r($ans2);
		}
		 
		//$ans3 =; Get the union table with which students in which class
}}else{
	header("Location: loginpage.php"); 
}