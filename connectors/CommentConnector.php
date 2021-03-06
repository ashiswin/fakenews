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
		public static $COLUMN_CHILD_OF = "child_of";
		public static $COLUMN_CHILDREN = "child_comments";
		public static $COLUMN_CHILDREN_COUNT = "children";

		private $createStatement = NULL;
		private $selectStatement = NULL;
		private $selectAllStatement = NULL;
		private $selectForArticleStatement = NULL;
		private $updateChildrenStatement = NULL;
		private $updateUpvoteStatement = NULL;
		private $updateDownvoteStatement = NULL;
		private $deleteStatement = NULL;
		private $deleteByArticleStatement = NULL;

		function __construct($mysqli) {
			if($mysqli->connect_errno > 0){
				die('Unable to connect to database [' . $mysqli->connect_error . ']');
			}

			$this->mysqli = $mysqli;

			$this->createStatement = $mysqli->prepare("INSERT INTO " . CommentConnector::$TABLE_NAME . "(`" . CommentConnector::$COLUMN_USERID . "`,`" . CommentConnector::$COLUMN_CONTENT . "`,`" . CommentConnector::$COLUMN_TITLE . "`,`" . CommentConnector::$COLUMN_ARTICLEID . "`,`" . CommentConnector::$COLUMN_CHILD_OF . "`) VALUES(?,?,?,?,?)");
			$this->selectStatement = $mysqli->prepare("SELECT * FROM " . CommentConnector::$TABLE_NAME . " WHERE `" . CommentConnector::$COLUMN_ID . "` = ?");
			$this->selectAllStatement = $mysqli->prepare("SELECT * FROM " . CommentConnector::$TABLE_NAME);
			$this->selectForArticleStatement = $mysqli->prepare("SELECT * FROM " . CommentConnector::$TABLE_NAME . " WHERE `" . CommentConnector::$COLUMN_ARTICLEID . "` = ? AND `" . CommentConnector::$COLUMN_CHILD_OF . "` IS NULL OR `" . CommentConnector::$COLUMN_ARTICLEID . "` = ? AND `" . CommentConnector::$COLUMN_CHILD_OF . "`=0");
			$this->deleteStatement = $mysqli->prepare("DELETE FROM " . CommentConnector::$TABLE_NAME . " WHERE `" . CommentConnector::$COLUMN_ID . "` = ?");
			$this->deleteByArticleStatement = $mysqli->prepare("DELETE FROM " . CommentConnector::$TABLE_NAME . " WHERE `" . CommentConnector::$COLUMN_ARTICLEID . "` = ?");
			$this->updateChildrenStatement = $mysqli->prepare("UPDATE " . CommentConnector::$TABLE_NAME . " SET `" . CommentConnector::$COLUMN_CHILDREN . "` =? WHERE `" . CommentConnector::$COLUMN_ID . "` =?");
			$this->updateUpvoteStatement = $mysqli->prepare("UPDATE " . CommentConnector::$TABLE_NAME . " SET `" . CommentConnector::$COLUMN_UPVOTE . "` = `" . CommentConnector::$COLUMN_UPVOTE . "`+1 WHERE `" . CommentConnector::$COLUMN_ID . "` =?");
			$this->updateDownvoteStatement = $mysqli->prepare("UPDATE " . CommentConnector::$TABLE_NAME . " SET `" . CommentConnector::$COLUMN_DOWNVOTE . "` = `" . CommentConnector::$COLUMN_DOWNVOTE . "`+1 WHERE `" . CommentConnector::$COLUMN_ID . "` =?");
		}

		public function create($userId, $content, $title, $articleId, $child_of) {
			$this->createStatement->bind_param("issii", $userId, $content, $title, $articleId, $child_of);
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

		public function selectForArticle($id) {
			$this->selectForArticleStatement->bind_param("ii", $id, $id);
			if(!$this->selectForArticleStatement->execute()) return false;

			$result = $this->selectForArticleStatement->get_result();
			$resultArray = $result->fetch_all(MYSQLI_ASSOC);
			return $resultArray;
		}

		public function delete($id) {
			$this->deleteStatement->bind_param("i", $id);
			if(!$this->deleteStatement->execute()) return false;

			return true;
		}

		public function deleteByArticle($id) {
			$this->deleteByArticleStatement->bind_param("i", $id);
			if(!$this->deleteByArticleStatement->execute()) return false;

			return true;
		}

		public function updateChildren($id, $children) {
			$this->updateChildrenStatement->bind_param("si", $children, $id);
			if(!$this->updateChildrenStatement->execute()) return false;

			return true;
		}

		public function updateUpvote($id) {
			$this->updateUpvoteStatement->bind_param("i", $id);
			if(!$this->updateUpvoteStatement->execute()) return false;

			return true;
		}

		public function updateDownvote($id) {
			$this->updateDownvoteStatement->bind_param("i", $id);
			if(!$this->updateDownvoteStatement->execute()) return false;

			return true;
		}
	}
?>
