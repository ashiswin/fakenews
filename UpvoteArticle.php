<?php
	require_once 'utils/database.php';
	require_once 'connectors/ArticleConnector.php';

	if (isset($_POST['id'])) {
		$id = $_POST['id'];

		$ArticleConnector = new ArticleConnector($conn);

		if(!$ArticleConnector->upvote($id)) {
			$response['success'] = false;
			$response['message'] = "Failed to upvote article!";
		}
		else {
			$response['success'] = true;
		}
	} else {
		$response['success'] = false;
		$response['message'] = "POST empty";
 	}
 	echo(json_encode($response));
?>