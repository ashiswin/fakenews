<?php
	require_once 'utils/database.php';
	require_once 'connectors/ArticleConnector.php';

	$title = $_POST['title'];
	$description = $_POST['description'];
	$url_link = $_POST['url_link'];
	$date_added = $_POST['date_added'];
	$upvote = $_POST['upvote'];
	$downvote = $_POST['downvote'];

	$ArticleConnector = new ArticleConnector($conn);

	if(!$ArticleConnector->create($title, $description, $url_link, $date_added, $upvote, $downvote)) {
		$response['success'] = false;
		$response['message'] = "Failed to create article!";
	}
	else {
		$response['success'] = true;
	}

	echo(json_encode($response));
?>