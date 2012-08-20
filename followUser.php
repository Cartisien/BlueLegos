<?php
session_start();
require_once('twitteroauth/twitteroauth.php');
require_once('config.php');

if(isset($_GET['screen_name']))
	$_SESSION['screen_name'] = $_GET['screen_name'];

/* If access tokens are not available redirect to connect page. */
if (empty($_SESSION['access_token']) || empty($_SESSION['access_token']['oauth_token']) || empty($_SESSION['access_token']['oauth_token_secret'])) {
	$_SESSION['callback'] = 'followUser.php';
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
	
	$screen_name = $_SESSION['screen_name'];
	$url = "http://api.twitter.com/1/users/show.json?screen_name=".$screen_name;

	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_TIMEOUT, 60);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$json = curl_exec($ch);
	curl_close($ch);

	$res = json_decode($json);
	
	$uid = $res->id;	
	
	$connection->post('friendships/create/'.$uid, array());

	unset($_SESSION['callback']);
	unset($_SESSION['screen_name']);
	
	header('location: index.php');
}

?>