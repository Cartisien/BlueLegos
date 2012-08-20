var xmlhttp;
var xmlhttp2;
var current_filter = "";
var current_page;
var tweet;

function showRecentTweets()
{
    xmlhttp = GetXmlHttpObject();
    if (xmlhttp == null)
    {
        alert ("Sorry. Your browser does not support XMLHTTP. Cannot load tweets.");
        return;
    }

    var url="fetchTweet.php";
    url=url+"?q="+current_filter;
    url=url+"&rpp=20";
    url=url+"&page="+current_page;
    xmlhttp.onreadystatechange=stateChanged;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
	
	document.getElementById("recent_tweets_holder").innerHTML = "<div class='recent_tweets'>Loading...</div>";
}

function stateChanged()
{
    if (xmlhttp.readyState==4)
    {
        document.getElementById("recent_tweets_holder").innerHTML = xmlhttp.responseText;
        current_page++;
    }
}

function GetXmlHttpObject()
{
	if (window.XMLHttpRequest)
	{
		// code for IE7+, Firefox, Chrome, Opera, Safari
		return new XMLHttpRequest();
	}
	if (window.ActiveXObject)
	{
		// code for IE6, IE5
		return new ActiveXObject("Microsoft.XMLHTTP");
	}
	return null;
}

////////////////////////////
function showMostRecentTweet()
{
    xmlhttp2 = GetXmlHttpObject();
    if (xmlhttp2 == null)
    {
        alert ("Sorry. Your browser does not support XMLHTTP. Cannot load tweets.");
        return;
    }

    var url="fetchMostRecent.php";
    url=url+"?q="+current_filter;
    xmlhttp2.onreadystatechange=stateChanged2;
    xmlhttp2.open("GET",url,true);
    xmlhttp2.send(null);
	
	document.getElementById("recent_quote").innerHTML = "<div class='small3'>Loading...</div><img class='divider' alt='divider' src='images/divider.png' />";
}

function stateChanged2()
{
    if (xmlhttp2.readyState==4)
    {
        document.getElementById("recent_quote").innerHTML = xmlhttp2.responseText;
		Cufon.replace('#recent_quote_div', {textShadow: '2px 2px #00294c'});
		Cufon.replace('#quote_mark');
    }
}

////////////////////////////

function show_rollover_button(root)
{
    var rollover = root.getElementsByTagName('td')[2].getElementsByTagName('div')[0];    
    rollover.style.display = "block";
}

function hide_rollover_button(root)
{
    var rollover = root.getElementsByTagName('td')[2].getElementsByTagName('div')[0];
    rollover.style.display = "none";
}

function filter_by(str)
{
    //first change button image
    var html = "<img src=\"images/filter_by_text.png\" /> ";
    if(str == 'html5')
    {
        html += "<img onclick=\"filter_by('html5')\" alt=\"#html5\" src=\"images/btn_html5_over.png\" /> ";
        html += "<img onclick=\"filter_by('apple')\" onmouseover=\"this.src='images/btn_apple_hover.png';\" onmouseout=\"this.src='images/btn_apple.png';\" alt=\"#apple\" src=\"images/btn_apple.png\" /> ";
        html += "<img onclick=\"filter_by('ipad')\" onmouseover=\"this.src='images/btn_ipad_hover.png';\" onmouseout=\"this.src='images/btn_ipad.png';\" alt=\"#ipad\" src=\"images/btn_ipad.png\" /> ";
    }
    else if(str == 'apple')
    {
        html += "<img onclick=\"filter_by('html5')\" onmouseover=\"this.src='images/btn_html5_hover.png';\" onmouseout=\"this.src='images/btn_html5.png';\" alt=\"#html5\" src=\"images/btn_html5.png\" /> ";
        html += "<img onclick=\"filter_by('apple')\" alt=\"#apple\" src=\"images/btn_apple_over.png\" /> ";
        html += "<img onclick=\"filter_by('ipad')\" onmouseover=\"this.src='images/btn_ipad_hover.png';\" onmouseout=\"this.src='images/btn_ipad.png';\" alt=\"#ipad\" src=\"images/btn_ipad.png\" /> ";
    }
    else if(str == 'ipad')
    {
        html += "<img onclick=\"filter_by('html5')\" onmouseover=\"this.src='images/btn_html5_hover.png';\" onmouseout=\"this.src='images/btn_html5.png';\" alt=\"#html5\" src=\"images/btn_html5.png\" /> ";
        html += "<img onclick=\"filter_by('apple')\" onmouseover=\"this.src='images/btn_apple_hover.png';\" onmouseout=\"this.src='images/btn_apple.png';\" alt=\"#apple\" src=\"images/btn_apple.png\" /> ";
        html += "<img onclick=\"filter_by('ipad')\" alt=\"#ipad\" src=\"images/btn_ipad_over.png\" /> ";
    }
    
    var parent = document.getElementById('filter_by');
    parent.innerHTML = html;

    if(current_filter != str)
    {
		//this is a new filter
		//so also change most recent tweet
        current_filter = str;
        current_page = 1;

        showRecentTweets();
		showMostRecentTweet();
    }
    
    //then make changes to session and recent tweet div   
    
}

//////////////////////////////////
/////////modal box overlay
/////////////////////////////////
$(function() {
	// a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
	$("#dialog").dialog("destroy");
	
	$("#dialog-form").dialog({
		autoOpen: false,
		height: 300,
		width: 670,
		modal: true,
		close: function() {}
	});				
});

function post_tweet_dialog()
{
	document.getElementById('tweet').value = "";
	document.getElementById('character_count').innerHTML = 140;					
	$('#dialog-form').dialog('open');
}

function close_dialog()
{
	$("#dialog-form").dialog('close');
}

function dont_care()
{
	document.getElementById('tweet').value = "Apple seriously screwed up on not including Flash in iOS. What do you think? http://bit.ly/aT57SL #fail #bluelegos";	
	tweet_character_count();
}

function want_flash()
{
	document.getElementById('tweet').value = "I don't really care if the Apple rejects Flash. What do you think? http://bit.ly/aT57SL #bluelegos";	
	tweet_character_count();
}

function tweet_character_count()	
{
	var str = document.getElementById('tweet').value;
	if (str.length > 140)
		document.getElementById('tweet').value = str.substring(0, 140);
	else
		document.getElementById('character_count').innerHTML = 140 - str.length;					
}

function reTweet(str)
{
	str = "RT " + str;
	document.getElementById('tweet').value = str;
	if (str.length > 140)
		document.getElementById('tweet').value = str.substring(0, 140);
	else
		document.getElementById('character_count').innerHTML = 140 - str.length;					

	$('#dialog-form').dialog('open');
}

function followUser(username)
{
	window.location = "followUser.php?screen_name="+username;
}

function tweet_it()
{
	tweet = document.getElementById('tweet').value;
	$("#dialog-form").dialog('close');
	
	window.location = "postTweet.php?status="+escape(tweet);
}




