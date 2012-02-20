<?php // twitter.php

/*********************************************************
 * @file: twitter.php
 * @package: twincities
 * @created: 24 January 2012
 * @updated: 20 February 2012
 * @author: 10011585
 * 
 * 
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
		
					?><li><?php
					 	// Insert comments
						$date = strtotime($tweet->created_at);
						
						echo date('jS F Y \a\t H:i',$date);
						
						$link = "http://twitter.com/" . $tweet->user->screen_name . "/status/" . $tweet->id;

						echo "<br />";

						$tweettext = preg_replace('/[^(\x20-\x7F)]*/','', $tweet->text);

						echo "<a href=\"".$link."\">".$tweettext."</a>";

						echo "<br />";
						echo "<br />";
						echo "</li>";
		
				}
		?></ul></section><?php
	}
	
}

?>