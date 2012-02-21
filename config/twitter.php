<?php // twitter.php

/*********************************************************
 * @file: twitter.php
 * @package: twincities
 * @created: 24 January 2012
 * @updated: 20 February 2012
 * @author: 10008548
 * 
 * This file is required by index.php. It pulls in the
 * Twitter API, based on the ID for each Twitter profile.
 * (this is defined in the XML config file).
 * Each tweet links to the permalink. 
 *********************************************************/

// Check if we're being called properly
if(defined('BASE_URI')) {

	// Echo the page title
	?><h1>Twitter</h1><?php
	

	foreach($cities as $city) {
		
		?><section class="city twitter">
			<h2><?php echo $city->name; ?></h2>
			<ul><?php
		
				$tweets = $city->twitter();
		
				foreach($tweets as $tweet) {
				
						// Link to permalink. User screen name and I.D will change depending on tweet.
						$link = "http://twitter.com/" . $tweet->user->screen_name . "/status/" . $tweet->id;
					
						// Echo tweet link.
						echo "<a href=\"$link\" target=\"_blank\">";
			?><li><?php
					 	// Convert the string into date format.
						$date = strtotime($tweet->created_at);
						
						// Echo date in specified format.
						echo '<strong>'.date('jS F Y \a\t H:i').'</strong>';
						
						echo "<br />";

						// Replace unwanted characters with ASCII character set.
						$tweettext = preg_replace('/[^(\x20-\x7F)]*/','', $tweet->text);

						echo $tweettext;

						echo "<br />";
						echo "<br />";
						
						// Close off the list.
						echo "</li>";
						echo "</a>";
						echo "<br>";
		
				}
		?></ul></section><?php
	}
	
}

?>