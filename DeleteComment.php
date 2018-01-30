<?php
	require_once 'utils/database.php';
	require_once 'connectors/CommentConnector.php';

	$id = $_POST['id'];

	$CommentConnector = new CommentConnector($conn);

	$response['comment'] = $CommentConnector->delete($id);
	$response['success'] = true;

	echo(json_encode($response));
?>