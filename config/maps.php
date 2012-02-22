<?php // instagram.php

/*********************************************************
 * @file: instagram.php
 * @package: twincities
 * @created: 24 January 2012
 * @updated: 24 January 2012
 * @author: 10008548
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
	
	// Get the individual photo in JSON format
	$xml = $city->map();
	
	print_r($xml);

}

?>