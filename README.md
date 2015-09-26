#SkyPrep PHP SDK

The SkyPrep PHP SDK is a thin-wrapper on top of the HTTP API (https://skyprep.com/api)
All JSON responses are automatically converted to similar PHP objects (associative array or regular indexed arrays).

Each API call is mapped to a corresponding method.
For example, get_all_users is mapped as $api->getAllUsers()

All parameters should be passed into the API as an associate array as well.
For example, to get user with ID 1000, you can call

$api->getUser([
	"user_id" => "1000"
]);

Notice that the parameter passed to the method is an associative array. The order of the parameters don't matter. An update_user call would look something like:

$api->updateUser([
	"user_id" => "1000",
	"first_name" => "James",
	"last_name" => "Doakes",
	"role" => "admin"
]);


In order to use the SkyPrep PHP SDK Wrapper, simply require 'api.php' in your project and instantiate an instance of the the API Library using your SkyPrep domain and API key.

The PHP SDK Wrapper uses the Guzzle PHP library, so the requirements for Guzzle must be met. If you're having connectivity issues related to Guzzle, please check the Guzzle documentation.

You'll need your API key and account key (domain that you use SkyPrep on) to get started.

Initialize an instance of the API Wrapper like so:

<?php

	require('/path/to/skyprepapi/api.php');

	$acctKey = 'myskyprepdomain.skyprepapp.com';

	$apiKey = 'abcdefgh123456789';

	$api = new SkyPrepApi($acctKey, $apiKey);

?>

The $api variable now has access to all the API calls available.

Test the connection first by running this:

<?php

	$response = $api->testConnection();

	if ($response['message'] == 'success') {

	 //We are now connected.

	}
?>
