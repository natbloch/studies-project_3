<?php
session_start();
require "/controller.php";
if(isset($_SESSION["logged"]) && $_SESSION["logged"]=="yessir"){
	if($_SERVER['REQUEST_METHOD']=='PUT'){
		$ans = [];
		$ans['stud']= getAllStudents();
		$ans['class'] = getAllClasses();
		$ans2=json_encode($ans);
		print_r($ans2);
		
	}elseif($_SERVER['REQUEST_METHOD']=='POST' && !isset($_POST['req'])){
		if($_SESSION["userrole"] == "sales"){
			print_r("ACCESS DENIED YOU ARE NOT AUTHORIZED TO DO SO");
		}else{
			$user = $_POST;
			//Validations of inputs
			if (isset($_POST['email']) && isEmail($_POST['email'])) {
				if(isset($_POST['name'])){
					if(isset($_POST['phone']) && (!is_nan($_POST['phone']))){
						$_POST['email'] = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
						$_POST['name'] = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
						
						
						$classes=[];
						if(isset($user["course"])){
							$classestaken = $user["course"];
							foreach($classestaken as $i => $k){
								array_push($classes, $i);
							}
						}
						
						//Validate and transfer classestaken
						$classes = implode(",", $classes);
						$user['classes'] = filter_var($classes, FILTER_SANITIZE_STRING);
						
						//Validate ID
						if(!is_nan($_POST["studid"]*1) || $_POST["studid"] == ""){$id = $_POST["studid"];}
						
						//Validate Image
						
						if($_FILES["studimg"]["error"] == 0){
							
							$validimg = validateimg("../uploads/student/", $_FILES["studimg"]);
							
							if ($validimg == 1){
								$imgcon = file_get_contents($_FILES["studimg"]["tmp_name"]);
								$imgcon = base64_encode($imgcon);
								$user["image"]=$imgcon;
								if($id!=""){
									updateStudent($id, $user);
								}else{
									$ans = createStudent($user);
								}
								
							} 
							
						}else{
							$user["image"]= $_POST['studimgprev'];
							if($id!=""){
								updateStudent($id, $user);
							}else{
								createStudent($user);
							}
							
						}
		}}}
		}
		$path = "../view/studclasspage/studclasspage.php";
		header("Location: ".$path);
		exit();
		
		//refresh*/
	}elseif($_SERVER['REQUEST_METHOD']=='POST' && $_POST['req'] == "delete"){
		if($_SESSION["userrole"] == "sales"){
			print_r("ACCESS DENIED YOU ARE NOT AUTHORIZED TO DO SO");
		}else{
			$user = $_POST;
			$id = $user['studid'];
			$ansdel = deleteStudent($id);
		}
		$ans = [];
		$ans['stud']= getAllStudents();
		$ans['class'] = getAllClasses();
		$ans2=json_encode($ans);
		print_r($ans2);
		//refresh
}}else{
	header("Location: loginpage.php"); 
}