<?php // news.php

/*********************************************************
 * @file: news.php
 * @package: twincities
 * @created: 24 January 2012
 * @updated: 24 January 2012
 * @author: 10008548, 09011635 & XXXXXXXX
 * 
 * This file is required by index.php
 *********************************************************/

if(defined('BASE_URI')) {

	?><h1>News</h1><?php

	foreach($cities as $city) {
	
		?>
	
		<section class="city news">
	
		<h2><?php echo $city->name; ?></h2><?php
	
		$xml = $city->news();
	
		if($xml) {
	
			// We only want the first 5 news items, so set this up
			$i = 0;
	
			foreach($xml->channel->item as $item) {
				
				if($i <= 4) {
	
					?><a href="<?php echo $item->link; ?>" title="<?php echo $item->title; ?>" target="_blank">
			
						<h3><?php echo $item->title; ?></h3>
			
						<time pubdate><?php echo $item->pubDate; ?></time>
			
						<p><?php echo $item->description; ?></p>
			
					</a><?php
				
				$i++;
				
				}
		
			}
	
		} else {
		
			echo '<p class="error">Unable to retrieve news.</p>';
	
		}
	
		?>
	
		</section><?php
		

	}

} ?>