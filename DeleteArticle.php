<?php
	require_once 'utils/database.php';
	require_once 'connectors/ArticleConnector.php';
	require_once 'connectors/CommentConnector.php';
	header("Access-Control-Allow-Headers: Content-Type");
	header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
	header("Access-Control-Allow-Origin: *");

	$id = $_POST['id'];

	$ArticleConnector = new ArticleConnector($conn);
	$CommentConnector = new CommentConnector($conn);

	$response['article'] = $ArticleConnector->delete($id);
	if($CommentConnector->deleteByArticle($id)){
		$response['success'] = true;
	} else {
		$response['success'] = false;
		$response['message'] = "Comments for article are not deleted";
	}

	echo(json_encode($response));
?>