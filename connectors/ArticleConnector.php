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
		public static $COLUMN_NO_VISITS = "no_visits";
		public static $COLUMN_REPORTED_BY = "reported_by";
		public static $COLUMN_CATEGORY = "category";
		public static $COLUMN_SCORE = "score";
		public static $COLUMN_ARTICLE_VOTERS = "article_voters";

		private $createStatement = NULL;
		private $selectStatement = NULL;
		private $selectAllStatement = NULL;
		private $updateStatement = NULL;
		private $addViewCountStatement = NULL;
		private $deleteStatement = NULL;
		private $upvoteStatement = NULL;
		private $downvoteStatement = NULL;

		function __construct($mysqli) {
			if($mysqli->connect_errno > 0){
				die('Unable to connect to database [' . $mysqli->connect_error . ']');
			}

			$this->mysqli = $mysqli;

			$this->createStatement = $mysqli->prepare("INSERT INTO " . ArticleConnector::$TABLE_NAME . "(`" . ArticleConnector::$COLUMN_TITLE . "`,`" . ArticleConnector::$COLUMN_DESCRIPTION . "`,`" . ArticleConnector::$COLUMN_URL_LINK . "`,`" . ArticleConnector::$COLUMN_REPORTED_BY . "`,`" . ArticleConnector::$COLUMN_CATEGORY . "`) VALUES(?,?,?,?,?)");
			$this->selectStatement = $mysqli->prepare("SELECT * FROM " . ArticleConnector::$TABLE_NAME . " WHERE `" . ArticleConnector::$COLUMN_ID . "` = ?");
			$this->selectAllStatement = $mysqli->prepare("SELECT * FROM " . ArticleConnector::$TABLE_NAME);
			$this->deleteStatement = $mysqli->prepare("DELETE FROM " . ArticleConnector::$TABLE_NAME . " WHERE `" . ArticleConnector::$COLUMN_ID . "` = ?");
			$this->addViewCountStatement = $mysqli->prepare("UPDATE " . ArticleConnector::$TABLE_NAME . " SET `" . ArticleConnector::$COLUMN_NO_VISITS . "` = `" . ArticleConnector::$COLUMN_NO_VISITS . "`+1 WHERE `" . ArticleConnector::$COLUMN_ID . "` =?");
			$this->upvoteStatement = $mysqli->prepare("UPDATE " . ArticleConnector::$TABLE_NAME . " SET `" . ArticleConnector::$COLUMN_UPVOTE . "` = `" . ArticleConnector::$COLUMN_UPVOTE . "`+1 WHERE `" . ArticleConnector::$COLUMN_ID . "` =?");
			$this->downvoteStatement = $mysqli->prepare("UPDATE " . ArticleConnector::$TABLE_NAME . " SET `" . ArticleConnector::$COLUMN_DOWNVOTE . "` = `" . ArticleConnector::$COLUMN_DOWNVOTE . "`+1 WHERE `" . ArticleConnector::$COLUMN_ID . "` =?");
		}

		public function create($title, $description, $url_link, $reported_by, $category) {
			$this->createStatement->bind_param("sssss", $title, $description, $url_link, $reported_by, $category);
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

		public function addViews($id) {
			$this->addViewCountStatement->bind_param("i", $id);
			if(!$this->addViewCountStatement->execute()) return false;

			return true;
		}

		public function upvote($id) {
			$this->upvoteStatement->bind_param("i", $id);
			if(!$this->upvoteStatement->execute()) return false;

			return true;
		}

		public function downvote($id) {
			$this->downvoteStatement->bind_param("i", $id);
			if(!$this->downvoteStatement->execute()) return false;

			return true;
		}
	}
?>
