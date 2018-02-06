<?php
	require_once 'utils/database.php';
	require_once 'connectors/CommentConnector.php';
	header("Access-Control-Allow-Headers: Content-Type");
	header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
	header("Access-Control-Allow-Origin: *");

	$id = $_POST['id'];

	$CommentConnector = new CommentConnector($conn);

	$response['comment'] = $CommentConnector->delete($id);
	$response['success'] = true;

	echo(json_encode($response));
?>