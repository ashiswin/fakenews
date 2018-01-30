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


		private $createStatement = NULL;
		private $selectStatement = NULL;
		private $selectAllStatement = NULL;
		private $updateStatement = NULL;
		private $deleteStatement = NULL;
		function __construct($mysqli) {
			if($mysqli->connect_errno > 0){
				die('Unable to connect to database [' . $mysqli->connect_error . ']');
			}

			$this->mysqli = $mysqli;

			$this->createStatement = $mysqli->prepare("INSERT INTO " . UserConnector::$TABLE_NAME . "(`" . UserConnector::$COLUMN_FIRST_NAME . "`,`" . UserConnector::$COLUMN_LAST_NAME . "`,`" . UserConnector::$COLUMN_EMAIL . "`,`" . UserConnector::$COLUMN_PASSWORDHASH . "`,`" . UserConnector::$COLUMN_SALT . "`) VALUES(?,?,?,?,?,?)");
			$this->selectStatement = $mysqli->prepare("SELECT * FROM " . UserConnector::$TABLE_NAME . " WHERE `" . UserConnector::$COLUMN_ID . "` = ?");
			$this->selectAllStatement = $mysqli->prepare("SELECT * FROM " . UserConnector::$TABLE_NAME);
			$this->deleteStatement = $mysqli->prepare("DELETE FROM " . UserConnector::$TABLE_NAME . " WHERE `" . UserConnector::$COLUMN_ID . "` = ?");
		}

		public function create($first_name, $last_name, $email, $passwordHash, $salt) {
			$this->createStatement->bind_param("sssss", $first_name, $last_name, $email, $passwordHash, $salt);
			return $this->createStatement->execute();
		}

		public function select($id) {
			$this->selectStatement->bind_param("i", $id);
			if(!$this->selectStatement->execute()) return false;

			return true;
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