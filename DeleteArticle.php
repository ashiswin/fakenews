<?php
	require_once 'utils/database.php';
	require_once 'connectors/ArticleConnector.php';

	$id = $_POST['id'];

	$ArticleConnector = new ArticleConnector($conn);

	$response['article'] = $ArticleConnector->delete($id);
	$response['success'] = true;

	echo(json_encode($response));
?>