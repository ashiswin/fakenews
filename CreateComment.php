<?php
	require_once 'utils/database.php';
	require_once 'connectors/CommentConnector.php';

	if (isset($_POST['userId'])) {
		$userId = $_POST['userId'];
		$articleId = $_POST['articleId'];
		$content = $_POST['content'];
		$title = $_POST['title'];

		if (isset($_POST['child_of'])) {
			$child_of = $_POST['child_of'];
		} else {
			$child_of = null;
		}

		$CommentConnector = new CommentConnector($conn);

		if(!$CommentConnector->create($userId, $content, $title, $articleId, $child_of)) {
			$response['success'] = false;
			$response['message'] = "Failed to create comment!";
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