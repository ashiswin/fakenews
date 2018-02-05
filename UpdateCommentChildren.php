<?php
	require_once 'utils/database.php';
	require_once 'connectors/CommentConnector.php';

	if (isset($_POST['id'])) {
		$id = $_POST['id'];
		$children = $_POST['children'];

		$CommentConnector = new CommentConnector($conn);

		if(!$CommentConnector->updateChildren($id, $children)) {
			$response['success'] = false;
			$response['message'] = "Failed to update comment children!";
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