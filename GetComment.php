<?php
	require_once 'utils/database.php';
	require_once 'connectors/CommentConnector.php';

	$id = $_GET['id'];

	$CommentConnector = new CommentConnector($conn);

	$response['comment'] = $CommentConnector->select($id);
	$response['success'] = true;	

	// get all the children comments
	$children_ids = explode(',', $response['comment']['children']);
	$children = array();
	foreach ($children_ids as $child) {
		array_push($children,$CommentConnector->select($child));
	}
	$response['comment']['child_comments'] = $children;

	echo(json_encode($response));
?>