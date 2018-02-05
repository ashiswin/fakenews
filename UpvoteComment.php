<?php
	require_once 'utils/database.php';
	require_once 'connectors/CommentConnector.php';

	if (isset($_POST['id'])) {
		$id = $_POST['id'];
		$upvote = $_POST['upvote'];

		$CommentConnector = new CommentConnector($conn);

		if(!$CommentConnector->updateUpvote($id, $upvote)) {
			$response['success'] = false;
			$response['message'] = "Failed to update comment upvote!";
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