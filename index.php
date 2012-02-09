<?php

// Include the configuration file
require_once(dirname(__FILE__).'/config/framework.php');

// Define $cities as an array which will hold each of our cities
$cities = array();


// Loop through the number of cities and create a new city object
for($i = 0; $i < $num_cities; $i++) {
	
	$city = new city($i);
	
	array_push($cities, $city);

}

?><!DOCTYPE HTML>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="author" content="Ben Argo">
	<meta name="author" content="Rachel Borkala">
	<meta name="author" content="Richard George">
	
	<title>DSA Twin Cities</title>
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>/styles/twintown.css" />
	<script src="<?php echo BASE_URL; ?>/scripts/jquery-1.7.1.min.js"></script>
</head>

<body>

	<header><!-- Define Header -->
	
		<h1>Twin Towns</h1>
		<h2><?php
		
		foreach($cities as $city) {
			
			echo $city->name;
			echo '<br />';
			
		} ?>
	
	</header><!-- End Header -->

	<nav id="main"><!-- Define Navigation/Menu -->
		
		<ul>
			<li><a href="news">News</a></li>
			<li><a href="weather">Weather</a></li>
			<li><a href="map">Map</a></li>
			<li><a href="instagram">Instagram</a></li>
			<li><a href="ebay">eBay</a></li>
			<li><a href="twitter">Twitter</a></li>
	
		<ul>

	</nav><!-- End Navigation -->

	<section id="primary-content-area"><!-- Main content area -->
	
		<article><!-- Article (to load content via AJAX) -->
		
			<?php if(isset($_GET['app'])) {
			
				/** This is a fallback in case the user does not support JavaScript **/
				
				// Switch through the possible applications
				switch ($_GET['app']) {

					/* News */
					case 'news':

						require(__DIR__.'/config/news.php');

						break;

					/* Weather */
					case 'weather':

						require(__DIR__.'/config/weather.php');

						break;

					/* Map */
					case 'map':

						break;

					/* Instagram */
					case 'instagram':

						require(__DIR__.'/config/instagram.php');

						break;

					/* Richard */
					case 'ebay':
					
						require(__DIR__.'/config/ebay.php');

						break;

					/* Twitter */
					case 'twitter':
					
						require(__DIR__.'/config/twitter.php');

						break;

				}
			
			} else {
			
				// Print out the welcome message
				
			} ?>
			
		</article><!-- End of Article -->

	</section><!-- End of Main content area -->

	<footer><!-- Footer -->
		<small>
			<p>Ben Argo - 10008548</p>
			<p>Rachel Borkala - 10011585</p>
			<p>Richard George - 09011635</p>
		</small>
	</footer><!-- End of Footer -->

</body>

</html>

