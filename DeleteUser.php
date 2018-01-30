<?php
	require_once 'utils/database.php';
	require_once 'connectors/UserConnector.php';

	$id = $_POST['id'];

	$UserConnector = new UserConnector($conn);

	$response['user'] = $UserConnector->delete($id);
	$response['success'] = true;

	echo(json_encode($response));
?>