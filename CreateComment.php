<?php
	require_once 'utils/database.php';
	require_once 'connectors/CommentConnector.php';

	$userId = $_POST['userId'];
	$content = $_POST['content'];
	$title = $_POST['title'];
	$date_added = $_POST['date_added'];
	$upvote = $_POST['upvote'];
	$downvote = $_POST['downvote'];

	$CommentConnector = new CommentConnector($conn);

	if(!$CommentConnector->create($userId, $content, $title, $date_added, $upvote, $downvote)) {
		$response['success'] = false;
		$response['message'] = "Failed to create comment!";
	}
	else {
		$response['success'] = true;
	}

	echo(json_encode($response));
?>