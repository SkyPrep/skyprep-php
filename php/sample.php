<?php
	require('src/api.php');

	$api_key = 'YOUR_API_KEY';
	$acct_key = 'sample.skyprepapp.com';

	$s = new SkyPrepApi($api_key, $acct_key);

	$data = $s->testConnection();

	if ($data['message'] == 'success') {
		echo "Successful connection to the API\n";
	}

	$s->createUser([
		"email" => 'newuser@sampledomain.com',
		"first_name" => 'New',
		"last_name" => "User",
		'admin' => false,
		"user_identifier" => '12345'
	]);

	$s->getMaterials();
	echo print_r($s->getUsers());
	echo print_r($s->getUser(["user_id" => $s->getUsers()[0]['id']]));





?>
