<?php
	require_once 'utils/database.php';
	require_once 'connectors/CommentConnector.php';

	if (isset($_GET['id'])) {
		$id = $_GET['id'];

		$CommentConnector = new CommentConnector($conn);
		$response['comments'] = $CommentConnector->selectForArticle($id);
		$response['success'] = true;
		
	} else {
		$response['success'] = false;
		$response['message'] = "GET empty";
 	}
 	echo(json_encode($response));
?>