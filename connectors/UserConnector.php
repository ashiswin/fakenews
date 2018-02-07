<?php
	class UserConnector {
		private $mysqli = NULL;

		public static $TABLE_NAME = "users";
		public static $COLUMN_ID = "id";
		public static $COLUMN_FIRST_NAME = "first_name";
		public static $COLUMN_LAST_NAME = "last_name";
		public static $COLUMN_EMAIL = "email";
		public static $COLUMN_PASSWORDHASH = "passwordHash";
		public static $COLUMN_SALT = "salt";
		public static $COLUMN_ADMIN = "admin";


		private $createStatement = NULL;
		private $selectStatement = NULL;
		private $selectByEmailStatement = NULL;
		private $selectAllStatement = NULL;
		private $updateStatement = NULL;
		private $deleteStatement = NULL;
		function __construct($mysqli) {
			if($mysqli->connect_errno > 0){
				die('Unable to connect to database [' . $mysqli->connect_error . ']');
			}

			$this->mysqli = $mysqli;

			$this->createStatement = $mysqli->prepare("INSERT INTO " . UserConnector::$TABLE_NAME . "(`" . UserConnector::$COLUMN_FIRST_NAME . "`,`" . UserConnector::$COLUMN_LAST_NAME . "`,`" . UserConnector::$COLUMN_EMAIL . "`,`" . UserConnector::$COLUMN_PASSWORDHASH . "`,`" . UserConnector::$COLUMN_SALT . "`,`" . UserConnector::$COLUMN_ADMIN"`) VALUES(?,?,?,?,?,?)");
			$this->selectStatement = $mysqli->prepare("SELECT `" . UserConnector::$COLUMN_ID . "`,`" . UserConnector::$COLUMN_FIRST_NAME . "`,`" . UserConnector::$COLUMN_LAST_NAME . "`,`" . UserConnector::$COLUMN_EMAIL . "," . UserConnector::$COLUMN_ADMIN . "` FROM " . UserConnector::$TABLE_NAME . " WHERE `" . UserConnector::$COLUMN_ID . "` = ?");
			$this->selectByEmailStatement = $mysqli->prepare("SELECT * FROM " . UserConnector::$TABLE_NAME . " WHERE `" . UserConnector::$COLUMN_EMAIL . "` = ?");
			$this->selectAllStatement = $mysqli->prepare("SELECT `" . UserConnector::$COLUMN_ID . "`,`" . UserConnector::$COLUMN_FIRST_NAME . "`,`" . UserConnector::$COLUMN_LAST_NAME . "`,`" . UserConnector::$COLUMN_EMAIL . "`,`" . UserConnector::$COLUMN_ADMIN . "` FROM " . UserConnector::$TABLE_NAME);
			$this->deleteStatement = $mysqli->prepare("DELETE FROM " . UserConnector::$TABLE_NAME . " WHERE `" . UserConnector::$COLUMN_ID . "` = ?");
		}

		public function create($first_name, $last_name, $email, $passwordHash, $salt, $admin) {
			$this->createStatement->bind_param("sssssi", $first_name, $last_name, $email, $passwordHash, $salt, $admin);
			return $this->createStatement->execute();
		}

		public function select($id) {
			$this->selectStatement->bind_param("i", $id);
			if(!$this->selectStatement->execute()) return false;

			$result = $this->selectStatement->get_result();
			$resultArray = $result->fetch_assoc();
			$this->selectStatement->free_result();
			
			return $resultArray;
		}

		public function selectByEmail($email) {
			$this->selectByEmailStatement->bind_param("s", $email);
			if(!$this->selectByEmailStatement->execute()) return false;

			$result = $this->selectByEmailStatement->get_result();
			$resultArray = $result->fetch_assoc();
			$this->selectByEmailStatement->free_result();
			
			return $resultArray;
		}

		public function selectAll() {
			if(!$this->selectAllStatement->execute()) return false;
			$result = $this->selectAllStatement->get_result();
			$resultArray = $result->fetch_all(MYSQLI_ASSOC);
			return $resultArray;
		}

		public function delete($id) {
			$this->deleteStatement->bind_param("i", $id);
			if(!$this->deleteStatement->execute()) return false;

			return true;
		}
	}
?>