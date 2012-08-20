<?php
session_start();
require_once('twitteroauth/twitteroauth.php');
require_once('config.php');

if(isset($_GET['status']))
	$_SESSION['status'] = $_GET['status'];

/* If access tokens are not available redirect to connect page. */
if (empty($_SESSION['access_token']) || empty($_SESSION['access_token']['oauth_token']) || empty($_SESSION['access_token']['oauth_token_secret'])) {
	$_SESSION['callback'] = 'postTweet.php';
    header('Location: redirect.php');
}
else
{
	/* Get user access tokens out of the session. */
	$access_token = $_SESSION['access_token'];

	/* Create a TwitterOauth object with consumer/user tokens. */
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);

	/* If method is set change API call made. Test is called by default. */
	$content = $connection->get('account/verify_credentials');
	
	$status = str_replace("\\","",$_SESSION['status']);
	$connection->post('statuses/update', array('status' => $status));

	unset($_SESSION['callback']);
	unset($_SESSION['status']);
	
	header('location: index.php');
}

?>