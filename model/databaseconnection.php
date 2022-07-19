<?php
	class DbConn{
		private static $instance = null;
		private $host = "127.0.0.1";
		private $user = "root";
		private $pass = "";
		private $dbname = "school_db";
		
		private function __construct(){
			try{
				$this -> conn = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this -> user, $this ->pass);
				$this -> conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this -> conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
			}
			
			catch(PDOException $e){
				$this->error = $e->getMessage();
			}
		}
		
		public static function getInstance() {
			if(self::$instance === null) {
				self::$instance = new DbConn();
			}
			return self::$instance;
		}
		
		public function query($query){
				$stmt = $this -> conn->prepare($query);
				$stmt->execute();
				return $stmt;		
		}
	}
?>