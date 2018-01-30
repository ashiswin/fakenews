<?php
	require_once 'utils/database.php';
	require_once 'connectors/UserConnector.php';

	$id = $_GET['id'];

	$UserConnector = new UserConnector($conn);

	$response['users'] = $UserConnector->selectAll();
	$response['success'] = true;
?>