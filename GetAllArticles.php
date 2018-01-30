<?php
	require_once 'utils/database.php';
	require_once 'connectors/ArticleConnector.php';

	$ArticleConnector = new ArticleConnector($conn);

	$response['articles'] = $ArticleConnector->selectAll();
	$response['success'] = true;
?>