<?php
	require_once 'utils/database.php';
	require_once 'connectors/CommentConnector.php';
	require_once 'connectors/CommentVotesConnector.php';
	header("Access-Control-Allow-Headers: Content-Type");
	header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
	header("Access-Control-Allow-Origin: *");

	if (isset($_POST['comment_id'])) {
		$comment = $_POST['comment_id'];
		$user = $_POST['user_id'];
		$upvote = 1;
		
		$CommentConnector = new CommentConnector($conn);
		$CommentVotesConnector = new CommentVotesConnector($conn);
		
		if(!$CommentConnector->updateUpvote($comment) || !$CommentVotesConnector->create($comment, $user, $upvote)) {
			$response['success'] = false;
			$response['message'] = "Failed to upvote comment!";
		}
		else {
			$response['success'] = true;
		}
	} else {
		$response['success'] = false;
		$response['message'] = "POST empty";
 	}
 	echo(json_encode($response));
?>
