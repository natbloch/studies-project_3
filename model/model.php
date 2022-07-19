<?php

//1-Connection to DB

	require '/databaseconnection.php';
	function sendToDbConn($sqlmess){
		$aa = DbConn::getInstance();
		$bb = $aa -> query ($sqlmess);
		return ($bb);
	}
	
	
//------------------------------------------
	
	
	
//2-Queries to DB
	function searchStudId($name, $email){
		$q = "SELECT StudentId FROM students WHERE Name='$name' AND Email='$email';";
		$data = sendToDbConn($q);
		$ans = $data->fetchAll();
		return($ans);
	}
	
	function searchClassId($name,$description){
		$q = "SELECT ClassId FROM classes WHERE Name='$name' AND Description='$description';";
		$data = sendToDbConn($q);
		$ans = $data->fetchAll();
		return($ans);
	}
	
	function searchEmployeeId($name,$email){
		$q = "SELECT EmployeeId FROM employees WHERE Name='$name' AND Email='$email';";
		$data = sendToDbConn($q);
		$ans = $data->fetchAll();
		return($ans);
	}
	
	function verifylogin($nameoremail,$password){
		$q = "SELECT Name,Role,ImageLink FROM employees WHERE (Name='$nameoremail' OR Email='$nameoremail') AND Password='$password';";
		$data = sendToDbConn($q);
		$ans = $data->fetchAll();
		if(empty($ans)){
			return "nologin";
		}else{
			return($ans);
		}
	}
	//$oh = verifylogin("nathanielbloch@gmail.com","123");
	//print_r ($oh);
	
	function getAllStudents(){
		$q = "SELECT * FROM students";
		$data = sendToDbConn($q);
		$ans = $data->fetchAll();
		return($ans);
	}
	
	function getAllClasses(){
		$q = "SELECT * FROM classes";
		$data = sendToDbConn($q);
		$ans = $data->fetchAll();
		return($ans);
	}
	
	function getAllEmployees(){
		$q = "SELECT EmployeeId,Name,Role,Email,Phone,ImageLink FROM employees";
		$data = sendToDbConn($q);
		$ans = $data->fetchAll();
		return($ans);
	}
	
	//$oh = getAllEmployees();
	//print_r ($oh);
	
	
	
	function createStudent($info){
		$q = "INSERT INTO students (Name, Phone, Email, ImageLink, ClassesTaken) VALUES ( \"{$info['name']}\", \"{$info['phone']}\", \"{$info['email']}\", \"{$info['image']}\", \"{$info['classes']}\");";
		$ans = sendToDbConn($q);
		return $ans;
	}
	
	function createEmployee($info){
		$q = "INSERT INTO employees (Name, Phone, Email, ImageLink, Role, Password) VALUES ( \"{$info['name']}\", \"{$info['phone']}\", \"{$info['email']}\", \"{$info['image']}\", \"{$info['role']}\", \"{$info['password']}\");";
		$ans = sendToDbConn($q);
	}
	
	function createClass($info){
		$q = "INSERT INTO classes (Name, Description, ImageLink) VALUES ( \"{$info['name']}\", \"{$info['description']}\", \"{$info['image']}\");";
		$ans = sendToDbConn($q);
	}
	
	/*$stud = array(
		'name' => 'LCap',
		'phone' => '05544465',
		'email' => 'lr@capri.com',
		'image' => 'gh.jpg',
		'classes' => '3' 
	);
	$emp = array(
		'name' => 'LCap',
		'phone' => '05544465',
		'email' => 'lr@capri.com',
		'image' => 'gh.jpg',
		'role' => 'sales',
		'password' => '1234'
	);
	$class = array(
		'name' => 'LCap',
		'description' => 'Blabla lorem ipsume burrrr',
		'image' => 'gh.jpg'
	);
	$oh = createClass($class);*/
	
	
	function updateStudent($id, $info){
		$q = "UPDATE students SET Name=\"{$info['name']}\",Phone=\"{$info['phone']}\", Email=\"{$info['email']}\",ImageLink=\"{$info['image']}\",ClassesTaken=\"{$info['classes']}\" WHERE StudentId=\"{$id}\";";
		$ans = sendToDbConn($q);
	
	}
	
	function updateClass($id, $info){
		$q = "UPDATE classes SET Name=\"{$info['name']}\",Description=\"{$info['description']}\",ImageLink=\"{$info['image']}\" WHERE ClassId=\"{$id}\";";
		$ans = sendToDbConn($q);
		
	}
	
	function updateEmployee($id, $info){
		$q = "UPDATE employees SET Name=\"{$info['name']}\",Phone=\"{$info['phone']}\", Email=\"{$info['email']}\",ImageLink=\"{$info['image']}\",Role=\"{$info['role']}\",Password=\"{$info['password']}\" WHERE EmployeeId=\"{$id}\";";
		$ans = sendToDbConn($q);
		
	}
	
	
	
	function deleteStudent($id){
		$q = "DELETE FROM students WHERE StudentId=\"{$id}\";";
		$ans = sendToDbConn($q);
		return($ans);
	}
	
	function deleteClass($id){
		$q = "DELETE FROM classes WHERE ClassId=\"{$id}\";";
		$ans = sendToDbConn($q);
		return($ans);
	}
	
	function deleteEmployee($id){
		$q = "DELETE FROM employees WHERE EmployeeId=\"{$id}\";";
		$ans = sendToDbConn($q);
		return($ans);
	}

/*
	public function getAllStudentsInCourse($courseId){
		$q = "SELECT student_course.student_id, students.name FROM `student_course` 
				INNER JOIN students on students.id = student_course.student_id
				WHERE student_course.course_id =$courseId";
		$stmt = $this -> conn->prepare($q);
		$stmt->execute();
		$data = $stmt->fetchAll();
		return $data;	
	}
	
	public function getAllCoursesOfStudent($studentId){
		$q = "SELECT student_course.course_id, courses1.name FROM `student_course` 
				INNER JOIN courses1 on courses1.id = student_course.course_id
				WHERE student_course.student_id =$studentId";
		$stmt = $this -> conn->prepare($q);
		$stmt->execute();
		$data = $stmt->fetchAll();
		return $data;	
	}
	
	public function insertCoursesOfStudent($data) {
		$insertData = [];
		foreach($data as $value) {
			 array_push($insertData,"(".$value['student_id'].",".$value['course_id'].")");
		}
		$str = implode(",", $insertData);
		// (),(),();
		$q = "INSERT INTO studentclass (StudentId, ClassId) VALUES " .$str .";";
		$stmt = $this -> conn->prepare($q);
    	$stmt->execute();
	}
	public function DeleteCourseOfStudent($data) {
		print_r('inside insert courses');
		print_r($data);
		$insertData = [];
		foreach($data as $value) {
			 array_push($insertData,"(".$value['student_id'].",".$value['course_id'].")");
		}
		$str = implode(",", $insertData);
		// (),(),();
		$q = "INSERT INTO student_course (student_id, course_id) values " .$str .";";
		$stmt = $this -> conn->prepare($q);
    	$stmt->execute();
	}
*/
?>
