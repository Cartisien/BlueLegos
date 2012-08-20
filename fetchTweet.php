<?php
require_once('date.php');
require_once('dbcon.php');

$query = $_GET['q'];
$page = $_GET['page'];
$start = 20 * ($page-1);

$select_query = "SELECT * from tweet_".$query." ORDER BY status_id DESC LIMIT ".$start.",20";
$result = mysql_query($select_query);

$count = 0;

while($row = mysql_fetch_array($result)) 
{	
	$count++;
	
	$description = $row['text'];

	$description = preg_replace("#(^|[\n ])@([^ \"\t\n\r<]*)#ise", "'\\1<a href=\"http://www.twitter.com/\\2\" >@\\2</a>'", $description);//changes @ tags
	$description = preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t<]*)#ise", "'\\1<a href=\"\\2\" >\\2</a>'", $description);//changes urls 
	$description = preg_replace('/(^|\s)#(\w+)/', '\1<a href="http://search.twitter.com/search?q=%23\2">#\2</a>', $description);//changes hash tags
	
	$date =  strtotime($row['created_at']);
	$dayMonth = date('d M', $date);
	$year = date('y', $date);
	$datediff = date_diff($theDate, $date);

	$username = $row['screen_name'];
	$statusid = $row['status_id'];
	$author_url = $row['author_url'];
	$image_url = $row['profile_image_url'];
	$source = html_entity_decode($row['source']);	
?>

<div class="recent_tweets" onmouseover="show_rollover_button(this);" onmouseout="hide_rollover_button(this);">
	<table border='0' class="tweet" align='right'>
	<tr>
	<td width='60px' align='center'><a href='<?php echo $author_url; ?>'><img width='50px' src="<?php echo $image_url; ?>"/></a></td>
	<td align='left'><div class="username hlink"><a href='<?php echo $author_url; ?>'><?php echo $username; ?></a>:</div>
									 <?php echo $description; ?>
									 <div class="small3 hlink"><?php echo $datediff?> from <?php echo $source; ?></div>
	</td>
	<td width='180px' align='center' valign='bottom'>
		<div style="display: none;">
			<img onmouseover="this.src='images/btn_retweet_over.png';"
					 onmouseout="this.src='images/btn_retweet.png';"
					 onclick="reTweet('<?php echo $row['text']; ?>')"
					 src="images/btn_retweet.png" />
			<img onmouseover="this.src='images/btn_follow_over.png';"
					 onmouseout="this.src='images/btn_follow.png';"
					 onclick="followUser('<?php echo $username; ?>')"
					 src="images/btn_follow.png" />
		</div>
	</td>
	</tr>
	</table>
	<?php
		if($count != 20)
		{
			echo '<img class="divider" alt="divider" src="images/tweet_divider.png" />';        
		}
	?>
</div>

<?php
}
?>
