<?php
	require_once 'utils/database.php';
	require_once 'connectors/ArticleConnector.php';

	$id = $_GET['id'];

	$ArticleConnector = new ArticleConnector($conn);

	$response['article'] = $ArticleConnector->select($id);
	$response['success'] = true;
?>