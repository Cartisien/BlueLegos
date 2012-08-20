<?php
require_once('date.php');
require_once('dbcon.php');

$query = $_GET['q'];

$select_query = "SELECT * from tweet_".$query." ORDER BY status_id DESC LIMIT 0,1";
$result = mysql_query($select_query);
$row = mysql_fetch_array($result);

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

<table border='0' align='center' width="60%">
<tr id='recent_quote_div'>
<td valign='top' width='30px'><div style='color: #00294c;' id='quote_mark'>"</div></td>
<td align='left'>
<div>
<?php echo $description; ?>
&nbsp;<a style='color: #00294c;' id='quote_mark'>"</a>
</div>
</td></tr>
<tr height='15px'>
</tr>
<tr>
<td>
</td>
<td align="right">
	<table style="font-family: arial;">
	<tr><td><a href='<?php echo $author_url; ?>'><img width='50px' src="<?php echo $image_url; ?>"/></a></td>
	<td align='left'><div class="username"><a href='<?php echo $author_url; ?>'><?php echo $username ?></a></div> 
	<div class="small3" style='margin-top: 2px;'>Posted <?php echo $datediff?> from <?php echo $source; ?></div></td>			
	</tr></table>
</td></tr>

</table>
<img class="divider" alt="divider" src="images/divider.png" />


