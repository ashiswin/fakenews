<?php
	require_once 'utils/database.php';
	require_once 'connectors/CommentConnector.php';
	require_once 'connectors/CommentVotesConnector.php';
	header("Access-Control-Allow-Headers: Content-Type");
	header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
	header("Access-Control-Allow-Origin: *");

	if (!isset($_GET['id'])) {
		$response['success'] = false;
		$response['message'] = "Wrong GET params";
	}
	else {
		$id = $_GET['id'];

		$CommentConnector = new CommentConnector($conn);

		$response['comment'] = $CommentConnector->select($id);
		$response['success'] = true;	

		// get all the children comments
		$children_ids = explode(',', $response['comment']['children']);
		$children = array();
		foreach ($children_ids as $child) {
			array_push($children,$CommentConnector->select($child));
		}
		$response['comment']['child_comments'] = $children;
		
		$voters = $CommentVotesConnector->selectByUser($result[UserConnector::$COLUMN_ID]);
		$response['comment']["comment_voters"] = array();
		for($i = 0; $i < count($voters); $i++) {
			array_push($response['comment']["comment_voters"], $voters[$i]['user_id']);
		}
	}

	echo(json_encode($response));
?>
