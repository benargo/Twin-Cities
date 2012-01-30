<?php // ajax.php

/*********************************************************
 * @file: ajax
 * @package: twincities
 * @created: 23 January 2012
 * @updated: 24 January 2012
 * @author: 10008548, 09011635 & XXXXXXXX
 * 
 * This is the server side script which is handled by AJAX
 *********************************************************/

// Include the framework
require_once(__DIR__.'/framework.php');

// Define $cities as an array which will hold each of our cities
$cities = array();

// Loop through the number of cities and create a new city object
for($i = 0; $i < $num_cities; $i++) {
	
	$city = new city($i);
	
	array_push($cities, $city);

}

// We need it to run via $_GET['app'] so add a conditional
if($_GET['app']) { // Yes we had a result

	// Switch through the possible applications
	switch ($_GET['app']) {
		
		/* News */
		case 'news':
			
			require(__DIR__.'/news.php');
			
			break;
		
		/* Weather */
		case 'weather':
		
			require(__DIR__.'/weather.php');
		
			break;
			
		/* Map */
		case 'map':
			
			break;
		
		/* Instagram */
		case 'instagram':
		
			require(__DIR__.'/instagram.php');
		
			break;
		
		/* Richard */
		case 'ebay':
		
			break;
			
		/* Twitter */
		case 'twitter':
		
			break;
		
	}
	
} else {
	
	// Return a 403 Error Code
	header('HTTP/1.1 403 Forbidden');
	
}