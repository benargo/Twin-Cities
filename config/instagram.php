<?php // news.php

/*********************************************************
 * @file: news.php
 * @package: twincities
 * @created: 24 January 2012
 * @updated: 24 January 2012
 * @author: 10008548, 09011635 & XXXXXXXX
 * 
 * This file is required by ajax.php
 *********************************************************/

if(defined('BASE_URI')) {

	?><h1>Instagram</h1><?php
	
	foreach($cities as $city) {
	
		?><section class="city">
	
		<h2><?php echo $city->name; ?></h2><?php
	
		$xml = $city->instagram();
	
		
	
}
 
?>