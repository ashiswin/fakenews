<?php
	require_once 'utils/database.php';
	require_once 'connectors/ArticleConnector.php';
	header("Access-Control-Allow-Headers: Content-Type");
	header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
	header("Access-Control-Allow-Origin: *");
	
	$id = $_GET['id'];

	$ArticleConnector = new ArticleConnector($conn);

	$response['article'] = $ArticleConnector->select($id);
	$response['success'] = true;

	echo(json_encode($response));
?>
