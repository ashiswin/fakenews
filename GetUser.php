<?php
	require_once 'utils/database.php';
	require_once 'connectors/UserConnector.php';
	header("Access-Control-Allow-Headers: Content-Type");
	header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
	header("Access-Control-Allow-Origin: *");

	$id = $_GET['id'];

	$UserConnector = new UserConnector($conn);

	$response['user'] = $UserConnector->select($id);
	$response['success'] = true;

	echo(json_encode($response));
?>