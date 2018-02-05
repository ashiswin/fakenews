<?php
	require_once 'utils/database.php';
	require_once 'connectors/CommentConnector.php';

	if (isset($_POST['id'])) {
		$id = $_POST['id'];

		$CommentConnector = new CommentConnector($conn);

		if(!$CommentConnector->updateDownvote($id)) {
			$response['success'] = false;
			$response['message'] = "Failed to downvote comment!";
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