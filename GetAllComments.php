<?php
	require_once 'utils/database.php';
	require_once 'connectors/CommentConnector.php';
	header("Access-Control-Allow-Headers: Content-Type");
	header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
	header("Access-Control-Allow-Origin: *");

	$CommentConnector = new CommentConnector($conn);

	$response['comments'] = $CommentConnector->selectAll();
	$response['success'] = true;

	echo(json_encode($response));
?>