<?php
session_start();

require_once('dbcon.php');

function number_to_image($num)
{
	$arr = array();
	
	while($num > 9)
	{
		$i = $num%10;
		$arr[] = $i;
		$num = (int)($num/10);
	}
	$arr[] = $num;
	while(count($arr) < 8)
		$arr[] = 0;
		
	$arr = array_reverse($arr);
	for($i=0; $i<count($arr); $i++)
		echo '<img src="images/'.$arr[$i].'.png" />';
		
}

$total = 0;
$positive = 0;
$hashtags = array('apple','html5','ipad');
for($a=0; $a<count($hashtags); $a++)
{
	$hashtag = $hashtags[$a];
	$select_query = "SELECT COUNT(*) from tweet_".$hashtag;
	$result = mysql_query($select_query);
	$row = mysql_fetch_array($result);
	$total += $row['0'];
	
	$select_query = "SELECT COUNT(*) from tweet_".$hashtag." WHERE positive=1";
	$result = mysql_query($select_query);
	$row = mysql_fetch_array($result);
	$positive += $row['0'];
}

$positive = (int)($positive*100/$total);
$negative = 100 - $positive;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" >
<head>

<TITLE>Blue Legos - Flash vs Html5</TITLE>
<META NAME="Keywords" CONTENT="ipad, no flash, blue legos, adobe, apple, html5, flash">
<META NAME="Description" CONTENT="The chronicling the debate of Flash vs HTML5">
<META NAME="Author" CONTENT="cartisien@cartisien.com">
<meta name="google-site-verification" content="WwQruWzJ6yGeOPa1Ra1YvPX4Klp68pXKrcP9vNHERfo" />

<script src="js/cufon-yui.js" type="text/javascript"></script>
<script src="js/Whitney_HTF_900.font.js" type="text/javascript"></script>

<script src="js/jquery.js"  type="text/javascript" ></script> 	
<script src="js/jquery-ui.js" type="text/javascript"></script> 		

<script src="js/script.js" type="text/javascript"></script>

<link rel="stylesheet" href="css/style.css" type="text/css" />

<link rel="stylesheet" type="text/css" href="css/jquery-ui.css"> 

<script type="text/javascript">

	Cufon.replace('#rating_div_1', {textShadow: '3px 3px #003665'});
	Cufon.replace('#rating_div_2');
	Cufon.replace('#recent_quote_div', {textShadow: '3px 3px #00294c'});
	Cufon.replace('#number_of_tweets_div');

</script>

</head>
<body>

<center>
<div class="header_white_bg"></div>
    
<div class="holder">

    <div class="top">
		
		<img class="top_bg" src="images/top_bg_new.png" />
		
		<div class="header">			
			<div class="facebook_connect">
					<iframe src="http://www.facebook.com/plugins/like.php?href=http://www.bluelegos.com&layout=standard&show_faces=false&width=450&action=like&colorscheme=light&height=35"
						scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:255px; height:35px;" allowTransparency="true">
					</iframe>                            
		
			</div>
		</div>
	
        <div class="social">
            <a href="http://digg.com/apple/Blue_Legos"><img src="images/btn_digg.png" /></a>
            <a href="http://www.facebook.com/#!/pages/Blue-Legos/282973925546"><img src="images/btn_facebook.png" /></a>
            <a href="http://www.twitter.com/bluelegos"><img src="images/btn_twitter.png" /></a>
        </div>
		
        <div class="rating" id="rating">
			<table border='0' align='center' width='580px'>
			<tr id="rating_div_1"><td  align='right'><?php echo $positive; ?></td><td class='small2' valign='bottom' align='left' style='padding-bottom: 25px; width: 40px;'>%</td>
			<td width='40px' class='small4'>VS</td><td align='right' width='150px'><?php echo $negative; ?></td><td class='small2' valign='bottom' align='left' style='padding-bottom: 25px;'>%</td><td></td></tr>
			<tr id="rating_div_2"><td colspan='3' class='small1'>Don't care about the Flash debate</td>
			<td colspan='2' class='small1'>Want Flash on all devices</td><td width='25px'></td></tr>
			</table><img class="divider" src="images/divider.png" />		
        </div>
		</br>
        <div class="recent_quote" id="recent_quote">
		<img class="divider" alt="divider" src="images/divider.png" />
        </div>
		
        <div class="number_of_tweets" id="number_of_tweets_div">
			Currently searching over
			<div class="tweet_count" id="tweet_count">
			<?php
				number_to_image($total);
			?>
			</div>
			tweets
			<div class="twitter_logo"><a href="http://www.twitter.com/bluelegos"><img style="margin-top:-20px;" src="images/twitter_logo.png" /></a></div>
			<img class="divider" alt="divider" src="images/divider.png" />
        </div>        
    </div>	

	<div class="post_tweet">
		<table align="center" width="960px"><tr>
		<td align="left">		
		<img onmouseover="this.src='images/btn_post_a_tweet_over.png';" 
			 onmouseout="this.src='images/btn_post_a_tweet.png';" 
			 onclick="post_tweet_dialog()"
                         alt="Post a Tweet"
			 src="images/btn_post_a_tweet.png" />
		</td>
		<td id="filter_by" align="right">
		<img alt="Filter By: " src="images/filter_by_text.png" />
		<img onclick="filter_by('html5')" 
			 onmouseover="this.src='images/btn_html5_hover.png';" onmouseout="this.src='images/btn_html5.png';" alt="#html5" src="images/btn_html5.png" />
		<img onclick="filter_by('apple')" alt="#apple" src="images/btn_apple_over.png" />
		<img onclick="filter_by('ipad')" alt="#ipad" src="images/btn_ipad.png" /></td>
		</tr></table>
	</div>

	<img class="divider" alt="divider" src="images/divider_light.png" />
	<br/><br/>

    <div id="recent_tweets_holder">
    </div>

	<br/>
	<img class="divider" alt="divider" src="images/divider.png" />
	<br/><br/>	

	<div class="load_more">
		<img onmouseover="this.src='images/btn_load_more_over.png';" 
			 onmouseout="this.src='images/btn_load_more.png';" 
			 onclick="showRecentTweets()"
                         alt="Load More"
			 src="images/btn_load_more.png" />
	</div>
	
</div>

<div class="footer_blue_bg"></div>

<div class="footer">
	<div class="resources">
		<img src="images/resources_title.png" />
		<div style="padding-left: 25px;">
		<li><a href='http://www.redmondpie.com/how-to-install-flash-on-your-ipad-complete-how-to-guide/'>Install Flash on the iPad</a></li>
		<li><a href='http://www.apple.com/hotnews/thoughts-on-flash/'>Thoughts on Flash</a></li>
		<li><a href='http://www.readwriteweb.com/archives/does_html5_really_beat_flash_surprising_results_of_new_tests.php'>Does HTML5 Really Beat Flash? The Surprising Results of New Tests</a></li>
		<li><a href='http://theipadvocate.com/'>iPadvocate</a></li>
		<li><a href='http://www.openscreenproject.org/'>Open Screen Project</a></li>
		<li><a href='http://www.flashmobileblog.com/'>Flash Mobile Blog</a></li>
		<li><a href='http://blog.theflashblog.com/?p=1703'>The Flash Blog : Ultimate Browsing Experience</a></li>
		</div>
	</div>

	<div class="about">
		<img src="images/about_title.png" />
		<div style="padding-left: 15px;">
		With the release of the iPhone and iPad coupled with Apples stance on the inclusion of Flash support on Apple 
		products this site documents the ethos and current climate and thoughts about the lack of support for the most 
		widely used browser plugin.
		
		Join the discussion.
		</div>
	</div>

	<div class="sponsers">
		<img src="images/sponsers_title.png" />
		<div style="margin-left: 12px; display: block; width: 300px; height: 250px; background-color: #00284b;">
			<script type="text/javascript"><!--
			google_ad_client = "pub-4480063519861287";
			/* 300x250, created 9/28/10 */
			google_ad_slot = "5812658966";
			google_ad_width = 300;
			google_ad_height = 250;
			//-->
			</script>
			<script type="text/javascript"
			src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
			</script>  
		
		</div>
	</div>

	<br>
	<img src="images/divider_dark.png" />
	<br>	
	
	<div class="copyright">
		<img src="images/copyright.png" />
	</div>
	
	<div class="idea">
		<a  href="http://www.cartisien.com">
			<img src="images/idea.png" />
		</a>
	</div>
</div>

</center>

<div id="dialog-form">
	<form>
		<table border='0' height='265px' align='center'>
		<tr>
		<td width='350px' align="left"><div style="font-family: arial; font-size: 12pt; font-weight: bold; color: #2d2d2d;">Tweet your own message or use one of ours:</div></td>
		<td align="right"><div id="character_count" style="font-family: arial; font-size: 27pt; font-weight: bold; color: #0074d9;">140</div></td>
		</tr>
		<tr>
		<td colspan='2' ><textarea name="tweet" id="tweet" class="text ui-widget-content ui-corner-all" 
			style="width:580px; height: 110px; font-family: arial; font-size: 12pt; color: #2d2d2d; padding: 10px; background-color: #dedede;"
			onKeyDown='tweet_character_count();'
			onKeyUp='tweet_character_count();'></textarea></td>
		</tr>
		<tr>
		<td colspan='2' align='bottom'><div style="font-family: arial; font-size: 10pt; font-weight: bold; color: #2d2d2d;">Quickpost</div></td>
		</tr>
		<tr>
		<td align='left'>
		<img onclick="want_flash();" alt="Want Flash" src="images/btn_want_flash.png" />&nbsp;
		<img onclick="dont_care();" alt="Don't Care" src="images/btn_dont_care.png" />
		</td>
		<td align='right'>
		<img onclick="close_dialog();" alt="Close" src="images/btn_close.png" />&nbsp;
		<img onclick="tweet_it();" alt="Tweet" src="images/btn_tweet.png" />
		</td>
		</tr>
		</table>
	</form>
</div>

<script>
	filter_by('apple');
</script>

<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-7544992-3");
pageTracker._trackPageview();
} catch(err) {}</script>

<script type="text/javascript" src="http://include.reinvigorate.net/re_.js"></script>
<script type="text/javascript">
try {
reinvigorate.track("64b66-c322t1ee67");
} catch(err) {}
</script>

</body>
</html>
