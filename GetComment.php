<?php
	require_once 'utils/database.php';
	require_once 'connectors/CommentConnector.php';

	$id = $_GET['id'];

	$CommentConnector = new CommentConnector($conn);

	$response['comment'] = $CommentConnector->select($id);
	$response['success'] = true;

	echo(json_encode($response));
?>