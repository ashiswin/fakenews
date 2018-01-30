<?php
	require_once 'utils/database.php';
	require_once 'connectors/UserConnector.php';

	$UserConnector = new UserConnector($conn);

	$response['users'] = $UserConnector->selectAll();
	$response['success'] = true;

	echo(json_encode($response));
?>