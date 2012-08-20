<?php
require_once('dbcon.php');

$negative_strings = array('suck', 'fail', 'hate', 'horrible', 'terrible', 'bad', 'awful', 'shitty', 'shit', 'crap', 'who', 'cares', 'asshole', 'shit', 'epic', 'crash', 'crashing', 'flash', 'js', 'javascript', 'bluelego', '@dealsplus');

$hashtags = array('apple','html5','ipad');

for($a=0; $a<count($hashtags); $a++)
{
	$page_limit = 15;
	
	$hashtag = $hashtags[$a];
	
	//cache tweets for hashtag
	$since_id = 1;
	//fetch the status id of latest fetched tweet
	$select_query = "SELECT MAX(status_id) FROM tweet_".$hashtag;
	$result = mysql_query($select_query);
	$row = mysql_fetch_array($result);
	if($row[0])
		$since_id = $row[0];	

	for($i = 1; $i<=$page_limit; $i++)
	{
		$url = "http://search.twitter.com/search.json?q=%23".$hashtag."&since_id=".$since_id."&rpp=100&page=".$i;
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$json = curl_exec($ch);
		curl_close($ch);

		$search_res = json_decode($json);
		$total = count($search_res->results);

		foreach($search_res->results as $tweet) 
		{		
			$status_id = $tweet->id;
			$screen_name = $tweet->from_user;
			$author_url = "http://twitter.com/".$screen_name;
			$profile_image_url = $tweet->profile_image_url;
			$source = $tweet->source;		
			$created_at =  $tweet->created_at;
			$text = $tweet->text;
			
			$positive = 1;
			for($j=0; $j<count($negative_strings); $j++)
			{
				if(substr_count($text, $negative_strings[$j]))
				{
					$positive = 0;
					break;
				}
			}
			
			$insert_query = "INSERT INTO tweet_".$hashtag." VALUES('', '$status_id', '$screen_name', '$author_url', '$profile_image_url', '$source', '$created_at', '$text', '$positive')";
			$result = mysql_query($insert_query);				
		}

		if($total < 100)
			break;
	}
	
	for($k=0; $k<10000000; $k++)
		;

}

?>