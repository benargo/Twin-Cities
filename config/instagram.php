<?php // news.php

/*********************************************************
 * @file: news.php
 * @package: twincities
 * @created: 24 January 2012
 * @updated: 24 January 2012
 * @author: 10008548, 09011635 & XXXXXXXX
 * 
 * This file is required by index.php. It pulls in the
 * Instagram API, based on the geocode information for our
 * given cities (this is defined in the XML config file).
 * Once it has the Instagram API it has two functions. One
 * of them being rendering all photos for the given cities
 * and the other one being a large-scale view of a certain
 * photo.
 *********************************************************/


// Check if we're being called properly
if(defined('BASE_URI')) {

	// Echo the page title
	?><h1>Instagram</h1><?php
	
	// If we're trying to load a large copy
	if(($_GET['task'] == "view_large") && (isset($_GET['id']))) {
		
		// Get the individual photo in JSON format
		$app = $city->instagram_large($_GET['id']);
		
		if($app) {
			// Print out the HTML
		?><section class="city instagram_large">
			
			<h2>Viewing Large Photo</h2>
			
			<p id="back_to_all"><a href="./instagram" title="Back">&larr; Back to all photos</a></p>
			
			<div class="clear"></div>
			
			<p><a href="<?php echo $app->link; ?>" class="permalink" target="_blank"><img src="<?php echo $app->images->standard_resolution->url; ?>" alt="Standard resolution" /></a></p>
			
			<p>Taken by <em><?php echo $app->user->full_name; ?></em> on <?php echo date('jS F Y - H:i:s', $app->created_time); ?></p>
				
			<?php if(isset($app->caption)) { ?><p><?php echo $app->caption->text; ?></p><?php } 
		
		} else { // We couldn't get any photo back
	
			// So show all the thumbnails
			instagram_all_cities();
		
		}
	
	} else { instagram_all_cities(); } // Show all thumbnails
}


/* Function: instagram_all_cities */
function instagram_all_cities() {

	// Include the global array $cities
	global $cities;

	// For each of the registered cities
	foreach($cities as $city) {

		?><section class="city instagram">

		<h2><?php echo $city->name; ?></h2><?php

		// We'll get the data in JSON format
		$app = $city->instagram();
	
		foreach($app->data as $item) {
	
			?><a href="instagram?task=view_large&amp;id=<?php echo $item->id; ?>" class="ig_thumbnail">
					<img src="<?php echo $item->images->thumbnail->url; ?>" alt="Thumbnail" />
				</a>
			<?php
		
		} ?><div class="clear"></div></section><?php
	
	}
	
}
 
?>