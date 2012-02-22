<?php

require_once(dirname(__FILE__).'/framework.php');

$city_id = $_GET['city'];

if(isset($city_id)) {

	$city = new city($city_id);
	
	$xml = $city->map();
	
	echo "<?xml version=\"1.0\"?>";
	echo $xml;

} else {

	die('Unknown City ID');

}

?>