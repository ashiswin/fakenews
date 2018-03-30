<?php
	class UserConnector {
		private $mysqli = NULL;

		public static $TABLE_NAME = "articleVotes";
		public static $COLUMN_ARTICLEID = "articleId";
		public static $COLUMN_USERID = "userId";
		public static $COLUMN_UPVOTE = "upvote";


		private $createStatement = NULL;
		private $selectByArticleStatement = NULL;
		private $selectByUserStatement = NULL;
		private $updateStatement = NULL;
		private $deleteStatement = NULL;
		function __construct($mysqli) {
			if($mysqli->connect_errno > 0){
				die('Unable to connect to database [' . $mysqli->connect_error . ']');
			}

			$this->mysqli = $mysqli;

			$this->createStatement = $mysqli->prepare("INSERT INTO " . UserConnector::$TABLE_NAME . "(`" . UserConnector::$COLUMN_ARTICLEID . "`, `" . UserConnector::$COLUMN_USERID . "`, `" . UserConnector::$COLUMN_UPVOTE . "`) VALUES(?,?,?)");
			$this->selectByArticleStatement = $mysqli->prepare("SELECT * WHERE `" . UserConnector::$COLUMN_ARTICLEID . "` = ?");
			$this->selectByUserStatement = $mysqli->prepare("SELECT * WHERE `" . UserConnector::$COLUMN_USERID . "` = ?");
			$this->deleteStatement = $mysqli->prepare("DELETE FROM " . UserConnector::$TABLE_NAME . " WHERE `" . UserConnector::$COLUMN_ARTICLEID . "` = ? AND `" . UserConnector::$COLUMN_USERID . "` = ?");
		}

		public function create($article, $user, $upvote) {
			$this->createStatement->bind_param("iii", $article, $user, $upvote);
			return $this->createStatement->execute();
		}

		public function selectByArticle($article) {
			$this->selectByArticleStatement->bind_param("i", $article);
			if(!$this->selectByArticleStatement->execute()) return false;
			$result = $this->selectByArticleStatement->get_result();
			$resultArray = $result->fetch_all(MYSQLI_ASSOC);
			return $resultArray;
		}

		public function selectByUser($user) {
			$this->selectByUserStatement->bind_param("i", $user);
			if(!$this->selectByUserStatement->execute()) return false;
			$result = $this->selectByUserStatement->get_result();
			$resultArray = $result->fetch_all(MYSQLI_ASSOC);
			return $resultArray;
		}
		
		public function delete($article, $user) {
			$this->deleteStatement->bind_param("ii", $article, $user);
			if(!$this->deleteStatement->execute()) return false;

			return true;
		}
	}
?>
