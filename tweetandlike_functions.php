<?php
// Used to pull the link on twitter and create a tweet button
function tweetandlike_twitter_link($settings = array()){
	$link = '<a href="http://twitter.com/share"';
	foreach ($settings as $key => $value) {
		if ($value !== '') $link .= ' data-'.$key.'="'.$value.'"';
	}
	$link .= ' class="twitter-share-button">Tweet';
	$link .= '</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>';

	return $link;
}

// Used to pull Like button on facebook
function tweetandlike_fb_link($settings = array(), $iframe = false){			
	if (!$iframe) {
		$buttons = '<fb:like ';
		if ( !empty($settings) ) {
			foreach ($settings as $key => $value) {
				$buttons .= ' ' . $key . '="'. $value .'"';
			}
			$buttons .= '>';
		}
	} else {		
		$buttons = '<iframe src="http://www.facebook.com/plugins/like.php?';
		if (!empty($settings)) {
			foreach ($settings as $key => $value) {
				if ($value != '') $buttons .= $key.'='.$value.'&';
			}
			$buttons .= 'scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:'.$settings['width'].'px; height:25px;" allowTransparency="true" ></iframe>';
		}		
	}
	return $buttons;
}	

//Used to pull the google +1 button
function tweetandlike_g_plusone($settings = array()) {
	$gplus = '<g:plusone';
	
	if ( !empty($settings) ) {
		foreach ($settings as $key => $val) {
			$gplus .=  ' ' . $key . '= "'.$val.'"';
		}
		$gplus .= '></g:plusone>';
	}
	
	return $gplus;
}

// function used when the page is not supplied with $post->ID
// http://www.webcheatsheet.com/PHP/get_current_page_url.php

function curPageURL() {
 $pageURL = 'http';
 
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 
 $pageURL = str_replace('www.', '', $pageURL);
 
 return $pageURL;
}
?>