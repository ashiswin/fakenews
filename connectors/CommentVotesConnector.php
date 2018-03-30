<?php
	class CommentVotesConnector {
		private $mysqli = NULL;

		public static $TABLE_NAME = "commentVotes";
		public static $COLUMN_COMMENTID = "comment_id";
		public static $COLUMN_USERID = "user_id";
		public static $COLUMN_UPVOTE = "upvote";


		private $createStatement = NULL;
		private $selectByCommentStatement = NULL;
		private $selectByUserStatement = NULL;
		private $updateStatement = NULL;
		private $deleteStatement = NULL;
		function __construct($mysqli) {
			if($mysqli->connect_errno > 0){
				die('Unable to connect to database [' . $mysqli->connect_error . ']');
			}

			$this->mysqli = $mysqli;

			$this->createStatement = $mysqli->prepare("INSERT INTO " . CommentVotesConnector::$TABLE_NAME . "(`" . CommentVotesConnector::$COLUMN_COMMENTID . "`, `" . CommentVotesConnector::$COLUMN_USERID . "`, `" . CommentVotesConnector::$COLUMN_UPVOTE . "`) VALUES(?,?,?)");
			$this->selectByCommentStatement = $mysqli->prepare("SELECT * FROM " . CommentVotesConnector::$TABLE_NAME . " WHERE `" . CommentVotesConnector::$COLUMN_COMMENTID . "` = ?");
			$this->selectByUserStatement = $mysqli->prepare("SELECT * FROM " . CommentVotesConnector::$TABLE_NAME . " WHERE `" . CommentVotesConnector::$COLUMN_USERID . "` = ?");
			$this->deleteStatement = $mysqli->prepare("DELETE FROM " . CommentVotesConnector::$TABLE_NAME . " WHERE `" . CommentVotesConnector::$COLUMN_COMMENTID . "` = ? AND `" . CommentVotesConnector::$COLUMN_USERID . "` = ?");
		}

		public function create($comment, $user, $upvote) {
			$this->createStatement->bind_param("iii", $comment, $user, $upvote);
			return $this->createStatement->execute();
		}

		public function selectByComment($comment) {
			$this->selectByCommentStatement->bind_param("i", $comment);
			if(!$this->selectByCommentStatement->execute()) return false;
			$result = $this->selectByCommentStatement->get_result();
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
		
		public function delete($comment, $user) {
			$this->deleteStatement->bind_param("ii", $comment, $user);
			if(!$this->deleteStatement->execute()) return false;

			return true;
		}
	}
?>
