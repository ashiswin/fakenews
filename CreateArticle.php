<?php
	require_once 'utils/database.php';
	require_once 'connectors/ArticleConnector.php';
	header("Access-Control-Allow-Headers: Content-Type");
	header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
	header("Access-Control-Allow-Origin: *");

	$title = $_POST['title'];
	$description = $_POST['description'];
	$url_link = $_POST['url_link'];
	$reported_by = $_POST['reported_by'];
	$category = $_POST['category'];
	
	$ArticleConnector = new ArticleConnector($conn);
	
	if(!$ArticleConnector->create($title, $description, $url_link, $reported_by, $category)) {
		$response['success'] = false;
		$response['message'] = "Failed to create article!";
	}
	else {
		$response['success'] = true;
	}

	echo(json_encode($response));
?>
