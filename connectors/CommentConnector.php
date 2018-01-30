<?php
	class CommentConnector {
		private $mysqli = NULL;

		public static $TABLE_NAME = "comments";
		public static $COLUMN_ID = "id";
		public static $COLUMN_USERID = "userId";
		public static $COLUMN_CONTENT = "content";
		public static $COLUMN_TITLE = "title";
		public static $COLUMN_DATE_ADDED = "date_added";
		public static $COLUMN_UPVOTE = "upvote";
		public static $COLUMN_DOWNVOTE = "downvote";
		public static $COLUMN_ARTICLEID = "articleId";


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

			$this->createStatement = $mysqli->prepare("INSERT INTO " . CommentConnector::$TABLE_NAME . "(`" . CommentConnector::$COLUMN_USERID . "`,`" . CommentConnector::$COLUMN_CONTENT . "`,`" . CommentConnector::$COLUMN_TITLE . "`,`" . CommentConnector::$COLUMN_ARTICLEID . "`) VALUES(?,?,?,?,?)");
			$this->selectStatement = $mysqli->prepare("SELECT * FROM " . CommentConnector::$TABLE_NAME . " WHERE `" . CommentConnector::$COLUMN_ID . "` = ?");
			$this->selectAllStatement = $mysqli->prepare("SELECT * FROM " . CommentConnector::$TABLE_NAME);
			$this->deleteStatement = $mysqli->prepare("DELETE FROM " . CommentConnector::$TABLE_NAME . " WHERE `" . CommentConnector::$COLUMN_ID . "` = ?");
		}

		public function create($userId, $content, $title, $articleId) {
			$this->createStatement->bind_param("issi", $userId, $content, $title, $articleId);
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