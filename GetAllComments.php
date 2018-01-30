<?php
	require_once 'utils/database.php';
	require_once 'connectors/CommentConnector.php';

	$CommentConnector = new CommentConnector($conn);

	$response['comments'] = $CommentConnector->selectAll();
	$response['success'] = true;
?>