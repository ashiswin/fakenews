<?php
	require_once 'utils/random_gen.php';
	require_once 'utils/database.php';
	require_once 'connectors/UserConnector.php';

	header("Access-Control-Allow-Headers: Content-Type");
	header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
	header("Access-Control-Allow-Origin: *");

	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$admin = $_POST['admin'];
	
	$salt = random_str(10);
	$passwordHash = hash('sha512', ($password . $salt));

	$UserConnector = new UserConnector($conn);

	if(!$UserConnector->create($first_name, $last_name, $email, $passwordHash, $salt, $admin)) {
		$response['success'] = false;
		$response['message'] = "Failed to create user!";
	}
	else {
		$response['success'] = true;
	}

	echo(json_encode($response));
?>