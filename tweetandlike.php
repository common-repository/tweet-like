<?php

/*
 * Plugin Name:   Tweet & Like
 * Version:       1.2.4
 * Plugin URI:	  http://www.kurtpolinar.com/projects/tweet-and-like-plugin/
 * Description:   Adds Facebook Like button and Twitter button on your sites content. It has an option to add AddThis Bookmarking Services. Plus Google +1 button.
 * Author:        Kurt Polinar
 * Author URI:    http://www.kurtpolinar.com
 */

	require_once "tweetandlike_html_form_functions.php";
	require_once "tweetandlike_templates.php";
	require_once "tweetandlike_functions.php"; 
 
 // Define global variable for options
	
	global $tweetandlike_include_addthis;
	global $tweetandlike_use_plain_view;
	global $tweetandlike_twitter_layout;
	global $tweetandlike_twitter_text;
	global $tweetandlike_twitter_url;
	global $tweetandlike_twitter_language;
	global $tweetandlike_twitter_recommend_mentioned;
	global $tweetandlike_fb_layout;
	global $tweetandlike_fb_showfaces;
	global $tweetandlike_fb_verbtodisplay;
	global $tweetandlike_fb_font;
	global $tweetandlike_fb_colorscheme;
	
	
	$tweetandlike_include_addthis = get_option('tweetandlike_include_addthis');
	$tweetandlike_use_plain_view = get_option('tweetandlike_use_plain_view');

	// Twitter Settings
	$tweetandlike_twitter_layout = get_option('tweetandlike_twitter_layout');
	$tweetandlike_twitter_text = get_option('tweetandlike_twitter_text');
	$tweetandlike_twitter_url = get_option('tweetandlike_twitter_url');
	$tweetandlike_twitter_language = get_option('tweetandlike_twitter_language');
	$tweetandlike_twitter_recommend_mentioned = get_option('tweetandlike_twitter_recommend_mentioned');

	$tweetandlike_twitter_text = ($tweetandlike_twitter_text || $tweetandlike_twitter_text != '') ? $tweetandlike_twitter_text:$tweetandlike_title;
	$tweetandlike_twitter_url = ($tweetandlike_twitter_url || $tweetandlike_twitter_url != '') ? $tweetandlike_twitter_url:$tweetandlike_permalink;


	// Facebook Settings
	$tweetandlike_fb_layout = get_option('tweetandlike_fb_layout');
	$tweetandlike_fb_showfaces = get_option('tweetandlike_fb_showfaces');
	$tweetandlike_fb_verbtodisplay = get_option('tweetandlike_fb_verbtodisplay');
	$tweetandlike_fb_font = get_option('tweetandlike_fb_font');
	$tweetandlike_fb_colorscheme = get_option('tweetandlike_fb_colorscheme');
 
// Make it work with WordPress before version 2.6
if (!defined('WP_CONTENT_URL')) {
	define('WP_CONTENT_URL', get_option('siteurl') . '/wp-content');
}

// return the path to where this plugin is currently installed
function get_plugin_url_tweetandlike() {
	// WP < 2.6
	if ( !function_exists('plugins_url') )
		return get_option('siteurl') . '/wp-content/plugins/' . plugin_basename(dirname(__FILE__));

	return plugins_url(plugin_basename(dirname(__FILE__)));
}

// Add the link to the settings page in the settings sub-header
function tweetandlike_menu_setup(){
	add_options_page('tweetandlike', 'Tweet & Like', 10, __FILE__, 'tweetandlike_page');
}

// Actual function that handles the settings sub-page
function tweetandlike_page(){	
	require_once "tweetandlike_settings_page.php";
}

function tweetandlike_header() {
	global $tal_addthis, $tal_gplusone, $tal_fbsendlike, $tal_css;
	$include_gplusone = get_option('tweetandlike_g_include');
	$include_addthis = get_option('tweetandlike_include_addthis');	
	
	$tal_css = str_replace('PLUGIN_URL', get_plugin_url_tweetandlike(), $tal_css);
	
	echo $tal_css;
	echo $tal_fbsendlike;
	
	if ($include_gplusone) {
		echo $tal_gplusone;
	}
	
	if ($include_addthis) {
		echo $tal_addthis;
	}
	
}

function tweetandlike($content){
	global $post;
	
	// Get the $post values on post/page
	$tweetandlike_permalink = (!empty($post->ID)) ? get_permalink($post->ID) : curPageURL();
	$tweetandlike_enclink = urlencode($tweetandlike_permalink);
	$tweetandlike_enctitle = urlencode(get_the_title($post->ID));
	$tweetandlike_title = get_the_title($post->ID);
	
	$tweetandlike_include_addthis = get_option('tweetandlike_include_addthis');
	$tweetandlike_use_plain_view = get_option('tweetandlike_use_plain_view');

	// Twitter Settings
	$tweetandlike_twitter_layout = get_option('tweetandlike_twitter_layout');
	$tweetandlike_twitter_text = get_option('tweetandlike_twitter_text');
	$tweetandlike_twitter_url = get_option('tweetandlike_twitter_url');
	$tweetandlike_twitter_language = get_option('tweetandlike_twitter_language');
	$tweetandlike_twitter_recommend_mentioned = get_option('tweetandlike_twitter_recommend_mentioned');

	$tweetandlike_twitter_text = ($tweetandlike_twitter_text || $tweetandlike_twitter_text != '') ? $tweetandlike_twitter_text:$tweetandlike_title;
	$tweetandlike_twitter_url = ($tweetandlike_twitter_url || $tweetandlike_twitter_url != '') ? $tweetandlike_twitter_url:$tweetandlike_permalink;


	// Facebook Settings
	$tweetandlike_fb_layout = get_option('tweetandlike_fb_layout');
	$tweetandlike_fb_showfaces = (get_option('tweetandlike_fb_showfaces')) ? 'true':'false';
	$tweetandlike_fb_iframe = (get_option('tweetandlike_fb_iframe')) ? 'true':'false';	
	$tweetandlike_fb_verbtodisplay = get_option('tweetandlike_fb_verbtodisplay');
	$tweetandlike_fb_font = get_option('tweetandlike_fb_font');
	$tweetandlike_fb_colorscheme = get_option('tweetandlike_fb_colorscheme');
	$tweetandlike_fb_send = get_option('tweetandlike_fb_send');
	$tweetandlike_fb_width = get_option('tweetandlike_fb_width');
	
	// Google +1 Settings
	$tweetandlike_g_size = get_option('tweetandlike_g_size');
	$tweetandlike_g_include = get_option('tweetandlike_g_include');

	// Get the options and try to locate where the tweetandlike will show on the post/page
	$show_at = get_option('tweetandlike_show_at');
	$display_in  = get_option('tweetandlike_display_in');
	$show_at_bottom = (strstr($show_at, 'bottom')) ? true:false;
	$show_at_top = (strstr($show_at, 'top')) ? true:false;

	// Determine where the Tweet and Like buttons appear	
	$show_on = array(
		'homepage' => get_option('tweetandlike_homepage'),
		'frontpage' => get_option('tweetandlike_frontpage'),
		'categories' => get_option('tweetandlike_categories'),		
		'post' => get_option('tweetandlike_post'),
		'page' => get_option('tweetandlike_page'),
	);

	// Get the random title or set the default title
	$taf_default_title = get_option('tweetandlike_enctitle');
	$taf_titles = explode(',', get_option('tweetandlike_random_title'));
	$taf_title = $taf_titles[array_rand($taf_titles)];
	
	// New html elements for buttons
	$tweetandlikebox = '';
	// If there is box
	if (!$tweetandlike_use_plain_view) $tweetandlikebox .= '<div class="tweetandlike-box">';
	
	// Set heading title for buttons
	if ($taf_default_title != '') {
		$tweetandlikebox .= '<h4 id="tweetandlike-heading">'.$taf_default_title.'</h4>';
	} else {
		$tweetandlikebox .= '<h4 id="tweetandlike-heading">'.$taf_title.'</h4>';
	}
	
	$tweetandlikebox .= '<ul id="tweetandlike-buttons">';
	
	// Shows if addthis is included
	if ($tweetandlike_include_addthis) {
		$tweetandlikebox .= '<li class="addthis_default_style first"><a class="addthis_button_compact addthis-box" addthis:url="'.$tweetandlike_permalink.'" addthis:title="'.$tweetandlike_enctitle.'">Share</a></li>';
	}
	
	// Default twitter button
	$tweetandlikebox .= '<li>'.tweetandlike_twitter_link(array('title'=>$tweetandlike_enctitle, 'count'=>$tweetandlike_twitter_layout, 'text'=>$tweetandlike_twitter_text, 'url'=>$tweetandlike_twitter_url, 'lang'=>$tweetandlike_twitter_language, 'via'=>$tweetandlike_twitter_recommend_mentioned)).'</li>';
	
	// Shows if g +1 is included
	if ($tweetandlike_g_include) {
		$tweetandlikebox .= '<li>'.tweetandlike_g_plusone(array('size' => $tweetandlike_g_size, 'href' => $tweetandlike_enclink)).'</li>';
	}	
	
	// Default facebook buttons
	$tweetandlikebox .= '<li>'.tweetandlike_fb_link(array('href'=>$tweetandlike_enclink, 'send' =>$tweetandlike_fb_send, 'layout'=>$tweetandlike_fb_layout, 'show_faces'=>$tweetandlike_fb_showfaces, 'action'=>$tweetandlike_fb_verbtodisplay, 'font'=>$tweetandlike_fb_font, 'colorscheme'=>$tweetandlike_fb_colorscheme, 'width' => $tweetandlike_fb_width), $tweetandlike_fb_iframe).'</li>';
	$tweetandlikebox .= '</ul>';
	
	if (!$tweetandlike_use_plain_view) $tweetandlikebox .= '</div>';
	
	// This is the content of the post without the buttons
	$actual_content = $content;

	if ($show_at_bottom) $content = $content.$tweetandlikebox;
	else if ($show_at_top) $content = $tweetandlikebox.$content;
	else $content = $tweetandlikebox.$content.$tweetandlikebox;

	$show_it = ( ($show_on['homepage'] && is_home()) || ($show_on['frontpage'] && is_front_page()) || ($show_on['categories'] && is_category()) || ($show_on['post'] && is_single()) || ($show_on['page'] && is_page()));
	return ($show_it && !in_array($post->ID, explode(',', get_option('tweetandlike_exlclude')))) ? $content:$actual_content;
	
}

// This is for the shortcode
function tweetandlike_buttons ($atts) {
	global $post;
	
	extract( shortcode_atts( array(
		'size' => 'standard', // standard, tall
		'type' => 'horizontal', // horizontal, vertical
		'align' => 'left' // left, right
	), $atts ) );
	
	$g_size = 'medium';
	$twitter_count = 'horizontal';
	$fb_layout = 'standard';
	
	if ($size == 'tall') {
		$g_size = 'tall';
		$twitter_count = 'vertical';
		$fb_layout = 'box_count';
	}
	
	// Facebook Settings	
	$tweetandlike_fb_verbtodisplay = get_option('tweetandlike_fb_verbtodisplay');
	$tweetandlike_fb_font = get_option('tweetandlike_fb_font');
	$tweetandlike_fb_colorscheme = get_option('tweetandlike_fb_colorscheme');	
	
	// Twitter Settings	
	$tweetandlike_twitter_url = get_option('tweetandlike_twitter_url');
	$tweetandlike_twitter_language = get_option('tweetandlike_twitter_language');
	$tweetandlike_twitter_recommend_mentioned = get_option('tweetandlike_twitter_recommend_mentioned');
	
	// Get the $post values on post/page
	$tweetandlike_permalink = get_permalink($post->ID);
	$tweetandlike_enclink = urlencode($tweetandlike_permalink);
	$tweetandlike_enctitle = urlencode(get_the_title($post->ID));
	$tweetandlike_title = get_the_title($post->ID);	
	
	$buttons = '<ul id="tweetandlike-'. $size . '-' . $type .'-buttons" class="'. $align .'-'. $size .'-'. $type .'">';
	$buttons .= '<li class="first">' . tweetandlike_g_plusone(array('size' => $g_size)) . '</li>';
	$buttons .= '<li>' . tweetandlike_twitter_link(array('title'=>$tweetandlike_enctitle, 'count'=>$twitter_count, 'url'=>$tweetandlike_twitter_url, 'lang'=>$tweetandlike_twitter_language, 'via'=>$tweetandlike_twitter_recommend_mentioned)) . '</li>';
	$buttons .= '<li class="last">' . tweetandlike_fb_link(array('href'=>$tweetandlike_enclink, 'layout'=>$fb_layout, 'show_faces'=>'false', 'action'=>$tweetandlike_fb_verbtodisplay, 'font'=>$tweetandlike_fb_font, 'colorscheme'=>$tweetandlike_fb_colorscheme), '100') . '</li>';
	$buttons .= '</ul>';
	
	return $buttons;
}

/**
*** Commented for widgets is not working
***

function tweetandlike_register_widgets(){
	register_sidebar_widget('Tweet & Like', 'tweetandlike_widget');

	// Comment this line out if you DON'T want to provide widget preferences
   register_widget_control('Tweet & Like', 'tweetandlike_widget_control');
}

if (get_option("tweetandlike_widget_title")) {
   $tweetandlike_widget_title = get_option("tweetandlike_widget_title");
}
else {
   $tweetandlike_widget_title = "Tweet & Like";
}

function tweetandlike_widget($args) {
	global $tweetandlike_widget_title;
	global $post;
	
	global $tweetandlike_include_addthis;
	global $tweetandlike_use_plain_view;
	global $tweetandlike_twitter_layout;
	global $tweetandlike_twitter_text;
	global $tweetandlike_twitter_url;
	global $tweetandlike_twitter_language;
	global $tweetandlike_twitter_recommend_mentioned;
	global $tweetandlike_fb_layout;
	global $tweetandlike_fb_showfaces;
	global $tweetandlike_fb_verbtodisplay;
	global $tweetandlike_fb_font;
	global $tweetandlike_fb_colorscheme;
	
	// Get the $post values on post/page
	$tweetandlike_permalink = get_permalink($post->ID);
	$tweetandlike_enclink = urlencode($tweetandlike_permalink);
	$tweetandlike_enctitle = urlencode(get_the_title($post->ID));
	$tweetandlike_title = get_the_title($post->ID);

	extract($args);

	// Output the actual widget...
	echo $before_widget;
	echo $before_title . $tweetandlike_widget_title . $after_title;
?>
	<div style="height: 75px;">
	<p>
		<div style="float: left; margin-right: 10px; height: 100px;"><?php echo tweetandlike_twitter_link(array('title'=>$tweetandlike_enctitle, 'url'=>$tweetandlike_permalink, 'count'=>'vertical', 'url'=>$tweetandlike_twitter_url, 'lang'=>$tweetandlike_twitter_language, 'via'=>$tweetandlike_twitter_recommend_mentioned)); ?></div>
		<div style="float: left;"><?php echo tweetandlike_fb_link(array('href'=>$tweetandlike_enclink, 'layout'=>'box_count', 'show_faces'=>'false', 'action'=>$tweetandlike_fb_verbtodisplay, 'font'=>$tweetandlike_fb_font, 'colorscheme'=>$tweetandlike_fb_colorscheme), '100') ?></div>
		<div style="float: left;"><?php echo tweetandlike_g_plusone(array('size'=>'tall')); ?></div>
	</p>
	</div>
<?php
	echo $after_widget;
}

function tweetandlike_widget_control() {
	global $tweetandlike_widget_title;

	// Example on how to set custom fields in widgets...
	if (isset($_POST["tweetandlike_widget_title"])) {
	  update_option("tweetandlike_widget_title", $_POST["tweetandlike_widget_title"]);
	}
?>
   <?php // Output the code for administrators to make changes ?>
   <label>Title:<br /></label> <?php htmlform_textbox('tweetandlike_widget_title', '', array('size'=>'38')); ?>
<?php
}
***
***
**/
// Uncomment below if widgets is uncommented
// add_action('plugins_loaded', 'tweetandlike_register_widgets');

//add action/filter
add_action('admin_menu', 'tweetandlike_menu_setup');
add_action('wp_head', 'tweetandlike_header');

add_shortcode('tweetandlike_buttons', 'tweetandlike_buttons');
add_filter('widget_text', 'do_shortcode');
add_filter('the_content', 'tweetandlike');
?>