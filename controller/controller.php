<?php

require "../view/view.php";

require "../model/model.php";

function validateimg ($target_dir, $file){
	//Validate Image
	$target_dir = "../uploads/student/";
	$target_file = $target_dir . basename($file["name"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	
	
	// Check if image file is an image
	$check = getimagesize($file["tmp_name"]);
	if($check !== false) {
		$uploadOk = 1;
	} else {
		$uploadOk = 0;
	}

	// Check file size
	if ($file["size"] > 2000000) {
		print_r("picture is too large");
		$uploadOk = 0;
	}
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
		$uploadOk = 0;
	}
	// Check if $uploadOk 
	
	return $uploadOk;
};
function isEmail($email) {
    return preg_match('|^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]{2,})+$|i', $email);
};

?>