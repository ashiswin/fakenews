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
		public static $COLUMN_CHILDREN = "children";

		private $createStatement = NULL;
		private $selectStatement = NULL;
		private $selectAllStatement = NULL;
		private $updateChildrenStatement = NULL;
		private $updateUpvoteStatement = NULL;
		private $updateDownvoteStatement = NULL;
		private $deleteStatement = NULL;

		function __construct($mysqli) {
			if($mysqli->connect_errno > 0){
				die('Unable to connect to database [' . $mysqli->connect_error . ']');
			}

			$this->mysqli = $mysqli;

			$this->createStatement = $mysqli->prepare("INSERT INTO " . CommentConnector::$TABLE_NAME . "(`" . CommentConnector::$COLUMN_USERID . "`,`" . CommentConnector::$COLUMN_CONTENT . "`,`" . CommentConnector::$COLUMN_TITLE . "`,`" . CommentConnector::$COLUMN_ARTICLEID . "`,`" . CommentConnector::$COLUMN_CHILD_OF . "`) VALUES(?,?,?,?,?)");
			$this->selectStatement = $mysqli->prepare("SELECT * FROM " . CommentConnector::$TABLE_NAME . " WHERE `" . CommentConnector::$COLUMN_ID . "` = ?");
			$this->selectAllStatement = $mysqli->prepare("SELECT * FROM " . CommentConnector::$TABLE_NAME);
			$this->deleteStatement = $mysqli->prepare("DELETE FROM " . CommentConnector::$TABLE_NAME . " WHERE `" . CommentConnector::$COLUMN_ID . "` = ?");
			$this->updateChildrenStatement = $mysqli->prepare("UPDATE " . CommentConnector::$TABLE_NAME . " SET `" . CommentConnector::$COLUMN_CHILDREN . "` =? WHERE `" . CommentConnector::$COLUMN_ID . "` =?");
			$this->updateUpvoteStatement = $mysqli->prepare("UPDATE " . CommentConnector::$TABLE_NAME . " SET `" . CommentConnector::$COLUMN_UPVOTE . "` =? WHERE `" . CommentConnector::$COLUMN_ID . "` =?");
			$this->updateDownvoteStatement = $mysqli->prepare("UPDATE " . CommentConnector::$TABLE_NAME . " SET `" . CommentConnector::$COLUMN_DOWNVOTE . "` =? WHERE `" . CommentConnector::$COLUMN_ID . "` =?");
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

		public function delete($id) {
			$this->deleteStatement->bind_param("i", $id);
			if(!$this->deleteStatement->execute()) return false;

			return true;
		}

		public function updateChildren($id, $children) {
			$this->updateChildrenStatement->bind_param("si", $children, $id);
			if(!$this->updateChildrenStatement->execute()) return false;

			return true;
		}

		public function updateUpvote($id, $upvote) {
			$this->updateUpvoteStatement->bind_param("ii", $upvote, $id);
			if(!$this->updateUpvoteStatement->execute()) return false;

			return true;
		}

		public function updateDownvote($id, $downvote) {
			$this->updateDownvoteStatement->bind_param("ii", $downvote, $id);
			if(!$this->updateDownvoteStatement->execute()) return false;

			return true;
		}
	}
?>