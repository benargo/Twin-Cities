<?php

	// Include the configuration file
	require_once(__DIR__.'/framework.php');

	$file = $_FILES['config'];
	
	// If there's a valid file
	if (is_uploaded_file($file['tmp_name'])) {
		
		if(move_uploaded_file($file['tmp_name'], BASE_URI. $file['tmp_name'])) {
			
			// Change the global variables	
			$config_file = BASE_URL.'/tmp/'.$file['tmp_name'];
			$num_cities = @get_num_cities();
			
			// This works out if we got a valid XML configuration file back
			if($num_cities) {
			
				// Unset the $cities array
				unset($cities);

				// And initialise a new copy of it
				$cities = array();

				// Update the $cities array to include the new cities
				for($i = 0; $i < $num_cities; $i++) {

					$city = @new city($i);
					
					// Yes the city it returned was a valid one
					if($city) {
						
						array_push($cities, $city);
						
					} else {
					
						die(invalid_upload());
					
					}



				} ?>

				<h1>Change of Configuration</h1>

				<p>Thanks for uploading your own configuration file.</p>

				<?php
	 		} else {
		
				die(invalid_upload());
			
			}
			
		}
		
	}

?>