<?php
	require_once 'utils/database.php';
	require_once 'connectors/ArticleConnector.php';

	$title = $_POST['title'];
	$description = $_POST['description'];
	$url_link = $_POST['url_link'];

	$ArticleConnector = new ArticleConnector($conn);

	if(!$ArticleConnector->create($title, $description, $url_link)) {
		$response['success'] = false;
		$response['message'] = "Failed to create article!";
	}
	else {
		$response['success'] = true;
	}

	echo(json_encode($response));
?>