<?php
	require_once 'utils/database.php';
	require_once 'connectors/CommentConnector.php';

	$id = $_GET['id'];

	$CommentConnector = new CommentConnector($conn);

	$response['comments'] = $CommentConnector->selectAll();
	$response['success'] = true;
?>