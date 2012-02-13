<?php // weather.php

/*********************************************************
 * @file: weather.php
 * @package: twincities
 * @created: 24 January 2012
 * @updated: 24 January 2012
 * @author: 10008548, 09011635 & XXXXXXXX
 * 
 * This file is required by index.php
 *********************************************************/

// Make sure we're being called properly
if(defined('BASE_URI')) {

	?><h1>Weather</h1><?php

	foreach($cities as $city) {
	
		?>
	
		<section class="city weather">
		
			<h2><?php echo $city->name; ?></h2><?php
		
			$xml = $city->weather();
		
			if($xml) {
			
				?><h3>Current Conditions</h3>
			
				<table>
					<tr>
						<td><strong>Conditions:</strong></td>
						<td colspan="2"><img src="http://www.google.com<?php echo $xml->weather->current_conditions->icon['data']; ?>" alt="<?php echo $xml->weather->current_conditions->condition['data']; ?>" /><?php echo $xml->weather->current_conditions->condition['data']; ?></td>
					</tr>
					<tr>
						<td><strong>Temperature:</strong></td>
						<td><?php echo $xml->weather->current_conditions->temp_f['data']; ?>&deg;F</td>
						<td><?php echo $xml->weather->current_conditions->temp_c['data']; ?>&deg;C</td>
					</tr>
					<tr>
						<td><strong>Humidity:</strong></td>
						<td colspan="2"><?php echo substr($xml->weather->current_conditions->humidity['data'], 10); ?></td>
					</tr>
					<tr>
						<td><strong>Wind:</strong></td>
						<td colspan="2"><?php echo substr($xml->weather->current_conditions->wind_condition['data'], 6); ?></td>
					</tr>
				</table>
			
				<h3>Forecast</h3>
			
				<table>
				<?php
			
				foreach($xml->weather->forecast_conditions as $forecast) { 
				
					// Convert from fahrenheit into celcius
					$low_c = round((5/9)*($forecast->low['data']-32), 0);
					$high_c = round((5/9)*($forecast->high['data']-32), 0);
				
					?>
			
					<tr>
						<td colspan="3"><strong><?php echo $forecast->day_of_week['data']; ?></strong></td>
					</tr>
					<tr>
						<td><strong>Conditions:</strong></td>
						<td colspan="2"><img src="http://www.google.com<?php echo $forecast->icon['data']; ?>" alt="<?php echo $forecast->condition['data']; ?>" /><?php echo $forecast->condition['data']; ?></td>
					</tr>
					<tr>
						<td><strong>Temperature:</strong></td>
						<td><p>Low: <?php echo $forecast->low['data']; ?>&deg;F</p>
							 <p>High: <?php echo $forecast->high['data']; ?>&deg;F</p></td>
						<td><p>Low: <?php echo $low_c; ?>&deg;C</p>
							 <p>High: <?php echo $high_c; ?>&deg;C</p></td>
					</tr>
				<?php
				} ?></table><?php
			
			
			} else {
		
				echo '<p class="error">Unable to retrieve weather.</p>';
			
			} ?>
		
		</section><?php

	} 

} ?>