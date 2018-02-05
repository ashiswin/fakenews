<?php
	class ArticleConnector {
		private $mysqli = NULL;

		public static $TABLE_NAME = "articles";
		public static $COLUMN_ID = "id";
		public static $COLUMN_TITLE = "title";
		public static $COLUMN_DESCRIPTION = "description";
		public static $COLUMN_URL_LINK = "url_link";
		public static $COLUMN_DATE_ADDED = "date_added";
		public static $COLUMN_UPVOTE = "upvote";
		public static $COLUMN_DOWNVOTE = "downvote";


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

			$this->createStatement = $mysqli->prepare("INSERT INTO " . ArticleConnector::$TABLE_NAME . "(`" . ArticleConnector::$COLUMN_TITLE . "`,`" . ArticleConnector::$COLUMN_DESCRIPTION . "`,`" . ArticleConnector::$COLUMN_URL_LINK . "`) VALUES(?,?,?)");
			$this->selectStatement = $mysqli->prepare("SELECT * FROM " . ArticleConnector::$TABLE_NAME . " WHERE `" . ArticleConnector::$COLUMN_ID . "` = ?");
			$this->selectAllStatement = $mysqli->prepare("SELECT * FROM " . ArticleConnector::$TABLE_NAME);
			$this->deleteStatement = $mysqli->prepare("DELETE FROM " . ArticleConnector::$TABLE_NAME . " WHERE `" . ArticleConnector::$COLUMN_ID . "` = ?");
		}

		public function create($title, $description, $url_link) {
			$this->createStatement->bind_param("sss", $title, $description, $url_link);
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