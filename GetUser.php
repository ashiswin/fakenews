<?php
	require_once 'utils/database.php';
	require_once 'connectors/UserConnector.php';

	$id = $_GET['id'];

	$UserConnector = new UserConnector($conn);

	$response['user'] = $UserConnector->select($id);
	$response['success'] = true;
?>