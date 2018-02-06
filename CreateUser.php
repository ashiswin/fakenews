<?php
	require_once 'utils/database.php';
	require_once 'connectors/UserConnector.php';
	header("Access-Control-Allow-Headers: Content-Type");
	header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
	header("Access-Control-Allow-Origin: *");

	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$email = $_POST['email'];
	$passwordHash = $_POST['passwordHash'];
	$salt = $_POST['salt'];

	$UserConnector = new UserConnector($conn);

	if(!$UserConnector->create($first_name, $last_name, $email, $passwordHash, $salt)) {
		$response['success'] = false;
		$response['message'] = "Failed to create user!";
	}
	else {
		$response['success'] = true;
	}

	echo(json_encode($response));
?>