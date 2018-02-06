<?php
	require_once 'utils/database.php';
	require_once 'connectors/CommentConnector.php';
	header("Access-Control-Allow-Headers: Content-Type");
	header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
	header("Access-Control-Allow-Origin: *");

	if (isset($_GET['id'])) {
		$id = $_GET['id'];

		$CommentConnector = new CommentConnector($conn);
		$response['comments'] = $CommentConnector->selectForArticle($id);
		$response['success'] = true;
		
		// get all the children comments
		$result = array();
		foreach ($response['comments'] as $comment) {
			$children_ids = explode(',', $comment['children']);
			$children = array();

			foreach ($children_ids as $child) {
			array_push($children,$CommentConnector->select($child));
			$comment['child_comments'] = $children;
			}
			array_push($result, $comment);
		}
		$response['comments'] = $result;

	} else {
		$response['success'] = false;
		$response['message'] = "GET empty";
 	}
 	echo(json_encode($response));
?>