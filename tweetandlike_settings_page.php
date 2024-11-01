	<?php
		$fb_language = array();
		$xml = simplexml_load_file('http://www.facebook.com/translations/FacebookLocales.xml');

		// Loop for languages on FB - getting the englishName
		foreach ($xml as $language) {
			$_show = $language->englishName;
			$_value = $language->codes->code->standard->representation;
			$fb_language[''.$_value.''] = $_show;
		}
	?>

	<?php
		if ($_GET['donate_hide'] == true) {
			add_option('tweetandlike_donate_hide', true);
		}
	?>
	<?php //this is where you update your options on settings page. You can use HTML. ?>
	<link rel="stylesheet" href="<?php echo get_plugin_url_tweetandlike() ?>/style.css" type="text/css" />

	<div class="wrap" style="width: 700px;">
		<h2>Tweet & Like Settings</h2>
		<?php if(!get_option('tweetandlike_donate_hide')): ?>
		<div id="message" class="updated">
			<p style="font-weight: bold;">
				Thanks for using this plugin! If you love this plugin and you are satisfied with the results, isn't it worth atleast a few dollar? <a href="http://kurtpolinar.com/tweet-and-like-donations">Donations</a> help me to continue developing and supporting this free software. <br />
				* <a href="http://kurtpolinar.com/tweet-and-like-donations">Sure, no problem!</a> * <a href="?page=tweet-like/tweetandlike.php&donate_hide=true">Sure, but I already did!</a> * <a href="?page=tweet-like/tweetandlike.php&donate_hide=true">No thanks, go away!</a>
			</p>
		</div>
		<?php endif; ?>
		<p>Tweet & Like plugin adds both twitter and facebook button (Like plugin) and extends the functionality of your blog to tweet and like blog post or pages.</p>
		<?php
		/* These three items below must stay if you want to be able to easily save
			data in your settings pages. */
		?>
		<form name="tweetandlike" method="post" action="options.php">
		<?php wp_nonce_field('update-options'); ?>
		<input type="hidden" name="action" value="update" />

		<?php
		/* You need to add each field in this area (separated by commas) that you want to update
		   every time you click "Save"
		*/
		?>
		<input type="hidden" name="page_options" value="tweetandlike_enctitle, tweetandlike_random_title, tweetandlike_show_at, tweetandlike_homepage, tweetandlike_frontpage, tweetandlike_categories, tweetandlike_archive, tweetandlike_post, tweetandlike_page, tweetandlike_exlclude, tweetandlike_include_addthis, tweetandlike_use_plain_view, tweetandlike_fb_layout, tweetandlike_fb_send, tweetandlike_fb_showfaces, tweetandlike_fb_width, tweetandlike_fb_verbtodisplay, tweetandlike_fb_font, tweetandlike_fb_colorscheme, tweetandlike_fb_language, tweetandlike_fb_iframe, tweetandlike_twitter_layout, tweetandlike_twitter_text, tweetandlike_twitter_url, tweetandlike_twitter_language, tweetandlike_twitter_recommend_mentioned, tweetandlike_g_size, tweetandlike_g_include" />
		<fieldset>
			<legend>General Settings</legend>

			<label>Title:<br /></label> <?php tweetandlike_htmlform_textbox('tweetandlike_enctitle', '', array('size'=>'35'))?><br />
			<small>This will show above Twitter and Facebook Like buttons. Leave this blank and use the Random Title instead</small>

			<label>Random Title (optional):<br /></label> <?php tweetandlike_htmlform_textarea('tweetandlike_random_title', '')?><br />
			<small>You can enter as many titles as you want and it will randomly generated on each post/page. Separate each title with a comma ",".</small>

			<label>Show At:<br /></label> <?php tweetandlike_htmlform_dropdown('tweetandlike_show_at', array('bottom'=>'bottom', 'top'=>'top', 'both'=>'both'))?><br />
			<small>Tweet & Like will show on specific section of the post/page</small>

			<label>Show On:<br /></label> <br />
			<label>&nbsp;</label>
			<ul>
				<li><?php tweetandlike_htmlform_checkbox('tweetandlike_homepage')?> Home Page</li>
				<li><?php tweetandlike_htmlform_checkbox('tweetandlike_frontpage')?> Front Page</li>
				<li><?php tweetandlike_htmlform_checkbox('tweetandlike_categories')?> Categories</li>
				<li><?php tweetandlike_htmlform_checkbox('tweetandlike_post')?> Post</li>
				<li><?php tweetandlike_htmlform_checkbox('tweetandlike_page')?> Page</li>
			</ul><br />
			<small>See the difference between the Home Page & Front page <a href="http://codex.wordpress.org/Conditional_Tags">here</a></small>

			<!--
			<label>Display in:<br /></label> <?php //tweetandlike_htmlform_dropdown('tweetandlike_display_in', array('post'=>'post', 'page'=>'page', 'both'=>'both'), 'both')?><br />
			<small>Select whether you display the buttons on post, page or both</small>
			-->
			<label>Exclude:<br /></label> <?php tweetandlike_htmlform_textbox('tweetandlike_exlclude', '', array('size'=>'35'))?><br />
			<small>You can enter post/page ID (delimited by comma ",") where you don't want the buttons to show</small>

			<label>Include AddThis:<br /></label> <?php tweetandlike_htmlform_checkbox('tweetandlike_include_addthis')?><br />
			<small>Check to include Addthis Bookmark Service along with Tweet & Like buttons</small>

			<label>Plain View:<br /></label> <?php tweetandlike_htmlform_checkbox('tweetandlike_use_plain_view')?><br />
			<small>Check to use Tweet & Like without a background.</small>

			<label>Shortcode:<br /></label> <?php tweetandlike_htmlform_textbox('tweetandlike_shortcode', '[tweetandlike_buttons]', array('size'=>'35'))?><br />
			<small>
				You can copy this shortcode and place it anywhere on your site, you can also put it in widgets. You can customize it by adding options size: {standard, tall}, type: {vertical, horizontal}, align: {left, right}.
				The code will look like this: [tweetandlike_buttons size="standard" type="horizontal" align="left"]
			</small>
		</fieldset>
		<br />
		<input type="submit" class="button" value="Save Settings" style="font-weight: bold;" />
		<br />
		<br />
		<fieldset>
			<legend>Facebook Like Settings</legend>

			<label>Layout Style:<br /></label>
			<?php tweetandlike_htmlform_dropdown('tweetandlike_fb_layout', array('standard', 'button_count', 'box_count'), 'standard'); ?>
			<small>Determine the size and amount of social context next to the button</small>

			<label>Send:<br /></label>
			<?php tweetandlike_htmlform_checkbox('tweetandlike_fb_send'); ?>
			<small>Include send button.</small>

			<label>Show Faces:<br /></label> <?php tweetandlike_htmlform_checkbox('tweetandlike_fb_showfaces')?><br />
			<small>Show profile pictures below the button</small>

			<label>Width:<br /></label> <?php tweetandlike_htmlform_textbox('tweetandlike_fb_width', '350')?><br />
			<small>The width of the button, in pixels</small>

			<label>Verb to Display:<br /></label> <?php tweetandlike_htmlform_dropdown('tweetandlike_fb_verbtodisplay', array('like', 'recommend'), 'like')?><br />
			<small>The verb to display in the button. Currently "like" and "recommend" are supported.</small>

			<label>Font:<br /></label> <?php tweetandlike_htmlform_dropdown('tweetandlike_fb_font', array('arial', 'lucida grande', 'segoe ui', 'tahoma', 'trebuchet ms', 'verdana'), '')?><br />
			<small>The font of the button</small>

			<label>Color Scheme:<br /></label> <?php tweetandlike_htmlform_dropdown('tweetandlike_fb_colorscheme', array('light', 'dark'), 'light')?><br />
			<small>The color scheme of the button</small>

			<label>Language:<br /></label> <?php tweetandlike_htmlform_dropdown('tweetandlike_fb_language', $fb_language, 'en_US')?><br />
			<small>Language used on buttons</small>
			
			<label>iFrame:<br /></label> <?php tweetandlike_htmlform_checkbox('tweetandlike_fb_iframe')?><br />
			<small>Use iframe instead of <a href="https://developers.facebook.com/docs/reference/javascript/">Javascript IDK</a> to better display the buttons on Internet Explorer. If used, facebook button send will not work.</small>
		</fieldset>
		<br />
		<input type="submit" class="button" value="Save Settings" style="font-weight: bold;" />
		<br />
		<br />
		<fieldset>
			<legend>Twitter Button Settings</legend>

			<label>Button Style:<br /></label>
			<?php tweetandlike_htmlform_dropdown('tweetandlike_twitter_layout', array('vertical'=>'Vertical Count', 'horizontal'=>'Horizontal Count', 'none'=>'No Count'), 'horizontal'); ?>
			<small>Determine the button style on twitter tweet button</small>

			<label>Tweet Text:<br /></label> <?php tweetandlike_htmlform_textbox('tweetandlike_twitter_text', '', array('size'=>'35'))?><br />
			<small>This is the text that people will include in their Tweet when they share from your website. If blank, it uses the title of the page the button is on.</small>

			<label>Tweet URL:<br /></label> <?php tweetandlike_htmlform_textbox('tweetandlike_twitter_url', '', array('size'=>'35'))?><br />
			<small>Suggest a default Tweet for users. If blank, it uses the URL for the page the button is on.</small>

			<label>Language:<br /></label> <?php tweetandlike_htmlform_dropdown('tweetandlike_twitter_language', array('eng'=>'English', 'fr'=>'French', 'de'=>'German', 'es'=>'Spanish', 'ja'=>'Japanese'))?><br />
			<small>This is the language that the button will render in on your website. People will see the Tweet dialog in their selected language for Twitter.com</small>

			<label>Recommend people to follow:<br /></label> <?php tweetandlike_htmlform_textbox('tweetandlike_twitter_recommend_mentioned', '', array('size'=>'35'))?><br />
			<small>This user will be @ mentioned in the suggested Tweet</small>

		</fieldset>
		<br />
		<input type="submit" class="button" value="Save Settings" style="font-weight: bold;" />
		<br />
		<br />
		<fieldset>
			<legend>Google +1 Settings</legend>

			<label>Size:<br /></label> <?php tweetandlike_htmlform_dropdown('tweetandlike_g_size', array('small' => 'Small (15px)', 'standard' => 'Standard (24px)', 'medium' => 'Medium (20px)', 'tall' => 'Tall (60px)'), 'medium')?><br />
			<small>The size of the button shown.</small>

			<!--
			<label>Language:<br /></label> <?php //tweetandlike_htmlform_dropdown('tweetandlike_g_language', array('arial', 'lucida grande', 'segoe ui', 'tahoma', 'trebuchet ms', 'verdana'), '')?><br />
			<small>+1 Annotations are currently only available in US English on Google.com</small>
			-->

			<label>Include button:<br /></label> <?php tweetandlike_htmlform_checkbox('tweetandlike_g_include')?><br />
			<small>Include Google +1 button</small>
		</fieldset>
		<br />
		<input type="submit" class="button" value="Save Settings" style="font-weight: bold;" />
		<br />
	</div>