<?php
	require_once 'utils/database.php';
	require_once 'connectors/CommentConnector.php';

	$userId = $_POST['userId'];
	$content = $_POST['content'];
	$title = $_POST['title'];

	$CommentConnector = new CommentConnector($conn);

	if(!$CommentConnector->create($userId, $content, $title)) {
		$response['success'] = false;
		$response['message'] = "Failed to create comment!";
	}
	else {
		$response['success'] = true;
	}

	echo(json_encode($response));
?>