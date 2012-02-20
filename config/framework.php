<?php // framework.php

/*********************************************************
 * @file: framework.php
 * @package: twincities
 * @created: 19 January 2012
 * @updated: 20 February 2012
 * @author: 10008548, 09011635 & 10011585
 * 
 * This is a group component for the DSA coursework.
 *********************************************************/

// Turn session handling on
session_start();

// Turn PHP errors on
error_reporting(E_ALL);

/** Constants **/
switch ($_SERVER['HTTP_HOST']) { // Check to see what server we're running on
	case 'web02.cems.uwe.ac.uk': // UWE Live Server
		define('BASE_URL', 'http://www.cems.uwe.ac.uk/~b2-argo/dsa_assign/app');
		define('BASE_URI', '/nas/students/b/b2-argo/unix/public_html/dsa_assign/app');
		break;
	case 'isa.cems.uwe.ac.uk': // UWE Development Server
		define('BASE_URL', 'http://isa.cems.uwe.ac.uk/~b2-argo/dsa_assign/app');
		define('BASE_URI', '/nas/students/b/b2-argo/unix/public_html/dsa_assign/app');
		break;
	case 'projects.benargo.com': // Personal Development Server
		define('BASE_URL', 'http://projects.benargo.com/twincities');
		define('BASE_URI', '/home/benargo.com/v7.1/projects/twincities');
		break;
}

	
/** Global Variables **/
$config_file = BASE_URL.'/config/config.xml';
$num_cities = get_num_cities($config_file);


/** API Keys **/
$key = array();
$key['google']         = 'AIzaSyDkvWzY29Ocjimb6kxJRVzmYXPeNwcmGBQ';
$key['instagram']      = '0aa87e24750c40b5af6fa4a9f0d9f503';
$key['twitter']        = 'wEmzdLTUruTFWsDWUkFA';

// Set the timezone to GMT
@date_default_timezone_set("GMT"); 


/** Function: Get file through UWE proxy **/
function get_file($uri) {

/*********************************************************
 * @function: get_file
 * @author: Chris Wallace
 * @created: 30 November 2009
 * @updated: 20 January 2012
 * @source: http://www.cems.uwe.ac.uk/~pchatter/php/dsa/dsa_utility.phps
 *
 * This function will get any file through the UWE proxy. 
 *
 * It has been adapted so that if we
 * are running on our local testing server, we do not
 * need to use this function, as Ben's private server
 * does not have proxy requirements.
 *********************************************************/

	// Conditional: Do we need to use the proxy?
	if(stristr($_SERVER['HTTP_HOST'], 'cems.uwe.ac.uk')) { // Conditional @value: Yes
	
		// Create a context for the PHP file_get_contents function
		$context = stream_context_create(array('http'=> array('proxy'=>'proxysg.uwe.ac.uk:8080', 'header'=>'Cache-Control: no-cache'))); 
	
		// Get the contents of the requested URI
		$contents = file_get_contents($uri, false, $context); 
	
	} else { // Conditional @value: No
	
		// Get the contents of the requres URI without use of the proxy
		$contents = file_get_contents($uri, false);
	
	} // End Conditional
	
	// And return the contents of the file
	return $contents;
	
}

function get_num_cities() {
	
	/*********************************************************
	 * @function: get_num_cities
	 * @parameter: $uri as URI
	 * @author: 10008548, 09011635 & 10011585
	 * @created: 23 January 2012
	 * @updated: N/A
	 *
	 * This function gets the number of given cities in the
	 * given XML configuration file.
	 *********************************************************/
	
	global $config_file;
	
	$xml = @simplexml_load_string(get_file($config_file), NULL, LIBXML_NOCDATA);
	
	if($xml) {
		
		$count = count($xml->city);
		
		return $count;
		
	} else {
	
		return false;
		
	}
	
}


/** Class: City **/
class city {

/*********************************************************
 * @class: city
 *
 * This class provides the framework for reading the XML
 * config files and building an object for each city we
 * will be working with.
 *
 * It is designed to be generic, so it can be applied to
 * any city, anywhere in the world.
 *********************************************************/
 	
 	/* Variables */
	private $id;
 	public $name;
	public $region;
	public $country;
	private $weather;
	private $news;
	private $map;
	private $twitter;
	
	/* Function: Object Construction */
	public function __construct($id) {
		
		/*********************************************************
		 * @function: __construct
		 * @visibility: public
		 * @parameter: $file as a file
		 * @parameter: $id as integer
		 * @author: 10008548, 09011635 & 10011585
		 * @created: 20 January 2012
		 * @updated: 20 February 2012
		 *
		 * This function builds an instance of the city object.
		 * It creates a simple XML object of the passed config 
		 * file to read the information about the city we're 
		 * looking up from the XML configuration file, and 
		 * subsequently sets object variables accordingly for 
		 * later use.
		 *********************************************************/
	
		global $config_file;
	
		$xml = @simplexml_load_string(get_file($config_file), NULL, LIBXML_NOCDATA);
		
		// Conditional: Did we get a valid config file?
		if($xml) { // Conditional @value: Yes
			
			// Process each of the cities in this config file
			foreach($xml->city as $city) {
			
				// Check if it's the city we're after
				if($city['id'] == $id) {
				
					// Set the object's variables.
					$this->id = $city['id'];
					$this->name = (string) $city->name;
					$this->region = (string) $city->region;
					$this->country = (string) $city->country;
					$this->weather = (string) $city->weather;
					$this->news = (string) $city->news;
					$this->map = $city->map;
					$this->twitter = $city->twitter;
				
				}

			}

			return true;
			
		} else { // Conditional @value: No
			
				return false;
			
		}
		
	}
	
	
	/* Function: Get City Weather */
	public function weather() {
	
		/*********************************************************
		 * @function: weather
		 * @visibility: public
		 * @author: 10008548, 09011635 & 10011585
		 * @created: 20 January 2012
		 * @updated: N/A
		 *
		 * This function gets the XML feed from the object's
		 * weather variable, and returns a SimpleXMl object which
		 * can be used for processing and displaying the local
		 * weather.
		 *
		 * Google's API service will form the basis of collecting
		 * weather data for both cities, and as such the SimpleXML
		 * object that will be returned will normally be in the
		 * same format.
		 *
		 * An example of the returned XML object can be found at
		 * http://www.google.co.uk/ig/api?weather=Bristol+UK
		 * This is an example for Bristol, UK, as demonstrated
		 * in the DSA lectures.
		 *
		 * I had a little bit of help from http://bena.ws/zn9ndX
		 *********************************************************/
		
		$file = get_file($this->weather);
		$xml = iconv("GB18030", "utf-8", $file);
		$xml = @simplexml_load_string($xml, NULL, LIBXML_NOCDATA);

		
		// Conditional: Is the returned object a valid SimpleXML string?
		if($xml) { // Conditional @value: Yes
		
			return $xml;
		
		} else { // Conditional @value: No
			
			return false;
			
		}
	}
	
	/* Function: News */
	public function news() {
		
		/*********************************************************
		 * @function: news
		 * @visibility: public
		 * @author: 10008548, 09011635 & 10011585
		 * @created: 20 January 2012
		 * @updated: N/A
		 *
		 * This function gets the RSS feed from the object's
		 * new variable, and returns a SimpleXMl object which
		 * can be used for processing and displaying the news.
		 *********************************************************/
		
		$xml = @simplexml_load_string(get_file($this->news), NULL, LIBXML_NOCDATA);
		
		// Conditional: Is the returned object a valid SimpleXML string?
		if($xml) { // Conditional @value: Yes
		
			return $xml;
		
		} else { // Conditional @value: No
		
			return false;
			
		}
		
	}
	
	public function map() {
		
		/*********************************************************
		 * @function: map
		 * @visibility: public
		 * @author: 10008548, 09011635 & 10011585
		 * @created: 20 January 2012
		 * @updated: N/A
		 *
		 * This function gets the configuration file for the
		 * Google Maps API, and then downloads and returns an
		 * object which can be used to render the map.
		 *********************************************************/
		
		// Pull in the global hash $key so that we can use the Google Maps API key.
		global $key;
		
		// Set latitude and longitude for the centre of the map.
		$latitude = $this->map->lat;
		$longitude = $this->map->long;
		
		// Set the radius of the map (in meters)
		$scale = $this->map->scale;
		
		// Build the Google Maps URI
		$uri = 'https://maps.googleapis.com/maps/api/place/search/xml?key='. $key['google'] .'&location='. $latitude .','. $logitude .'&radius='. $scale;
		// (Leave the rest of the parameters as default);
		
		$xml = @simplexml_load_string(get_file($uri), NULL, LIBXML_NOCDATA);
		
		// Conditional: Is the returned XML file valid?
		if($xml) { // Conditional @value: Yes
			
			// Return the SimpleXML string as an object
			return $xml;
			
		} else { // Conditional @value: No 
			
			return false;
			
		}
	
	}
	

	/*********************************************************
	 * Individual Components:
	 *
	 * This section denotes the start of the DSA individual
	 * components, and are included in the following order:
	 * 1. Instagram by Ben Argo (10008548)
	 * 2. Twitter by Rachel Borkala (10011585s)
	 * 3. Ebay by Richard George (09011635)
	 *********************************************************/

	/* Function: Instagram */
	public function instagram() {

		/*********************************************************
		 * @file: framework.php
		 * @class: city
		 * @package: twincities
		 * @created: 19 January 2012
		 * @author: 10008548
		 * 
		 * This class provides the framework needed to
		 * connect to instagram's API, and download
		 * relevant photos related to our two twin cities.
		 *
		 * This is an individual component for the DSA coursework
		 * completed by Ben Argo (student number 10008548)
		 *********************************************************/

		// Import the API Keys
		global $key;

		// Use the location coordinates from the Google Maps
		$latitude = $this->map->lat;
		$longitude = $this->map->long;

		// Set the radius of the map (in meters)
		$scale = $this->map->scale;

		// Build the Instagram URI
		$uri = 'https://api.instagram.com/v1/media/search?lat='. $latitude .'&lng='. $longitude .'&distance='. $scale .'&client_id='. $key['instagram'];

		// Load the JSON object
		$json = @get_file($uri);

		// Conditional: Is the returned JSON file valid?
		if($json) { // Conditional @value: Yes

			// Create a new object with the decoded JSON
			$obj = json_decode($json);
			
			// Return the new object
			return $obj;

		} else { // Conditional @value: No 

			return false;

		}

	}
	
	/* Function: Instagram Large */
	public function instagram_large($id) {
		/*********************************************************
		 * @file: framework.php
		 * @class: city
		 * @package: twincities
		 * @created: 07 February 2012
		 * @author: 10008548
		 * 
		 * This class provides the framework needed to
		 * connect to instagram's API, and download
		 * a large copy of a specified image
		 *
		 * This is an individual component for the DSA coursework
		 * completed by Ben Argo (student number 10008548)
		 *********************************************************/
		
		// Import the API Keys
		global $key;
		
		// Build the Instagram URI
		$uri = 'https://api.instagram.com/v1/media/'. $id .'?client_id='. $key['instagram'];
		
		// Load the JSON object
		$json = @get_file($uri);
		
		// Conditional: Is the returned JSON file valid?
		if($json) { // Conditional @value: Yes
			
			// Create a new object with the decoded JSON
			$obj = json_decode($json);
			
			// Return the new object
			return $obj->data;
			
		} else { // Conditional @value: No
			
			return false;
		
		}
		
	}

	/* Function: Twitter */
	public function twitter() {
	
		/*********************************************************
		 * @file: framework.php
		 * @class: city
		 * @package: twincities
		 * @created: 20 January 2012
		 * @author: 10011585
		 * 
		 * This function provides the framework for generating the
		 * XML needed to run the twitter application.
		 *********************************************************/
		
		// Build the twitter URI
		$uri = 'https://api.twitter.com/1/statuses/user_timeline.xml?user_id='. $this->twitter .'&count=10&exclude_replies=true';
		
		$xml = @simplexml_load_string(get_file($uri), NULL, LIBXML_NOCDATA);
		
		// Conditional: Is the returned XML file valid?
		if($xml) { // Conditional @value: Yes
			
			// Get the statuses only
			$tweets = $xml->status;
			
			// Return the SimpleXML string as an object
			return $tweets;
			
		} else { // Conditional @value: No 
			
			return false;
			
		}
	
	
	}

	/* Function: Ebay */
	public function ebay() {
			
		/*********************************************************
		 * @file: framework.php
		 * @class: city
		 * @package: twincities
		 * @created: 20 February 2012
		 * @author: 09011635
		 * 
		 * This function provides the framework for generating the
		 * XML needed to run the twitter application.
		 *********************************************************/
		
		
		
	}

}

?>