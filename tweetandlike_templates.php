<?php
	global $tal_addthis, $tal_gplusone, $tal_fbsendlike, $tal_css;
	
	$tal_css = <<<CSS
		<link rel="stylesheet" href="PLUGIN_URL/tweetandlike-buttons.css" type="text/css" />
CSS;

	$tal_addthis = <<<TTT
	<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=xa-4cace20d7db12615"></script>
	
	<script type="text/javasctipt">
		<!--
		var addthis_config = {
			services_exclude: 'twitter',
			ui_cobrand: 'Tweet & Like'
		}
		-->	
	</script>
TTT;

	$tal_gplusone = <<<TTT
		<script type="text/javascript" src="http://apis.google.com/js/plusone.js"></script>
TTT;

	$tal_fbsendlike = <<<TTT
		<script type="text/javascript" src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>
		<script type="text/javascript">
			<!--
				$(document).ready(function() {
					$('body').append('
						<div id="fb-root"></div>						
					');				
				});
			 -->			 
			
			  window.fbAsyncInit = function() {
				FB.init({appId: '125571730831734', status: true, cookie: true,
						 xfbml: true});
			  };
			  (function() {
				var e = document.createElement('script'); e.async = true;
				e.src = document.location.protocol +
				  '//connect.facebook.net/en_US/all.js';
				document.getElementById('fb-root').appendChild(e);
			  }());
		</script>
TTT;
	
?>