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
	?><h1>Google Maps</h1><?php
	
	foreach($cities as $city) { ?><section class="city map">
		<h2><?php echo $city->name; ?></h2>

    <!-- you can use tables or divs for the overall layout -->
    <table border=1>
      <tr>
        <td>
           <div id="map_<?php echo $city->name; ?>" style="width: 550px; height: 450px"></div>
        </td>
        <td width = 150 valign="top" style="text-decoration: underline; color: #4444ff;">
           <div id="side_bar_<?php echo $city->name; ?>"></div>
        </td>
      </tr>
    </table>


    <noscript><b>JavaScript must be enabled in order for you to use Google Maps.</b> 
      However, it seems JavaScript is either disabled or not supported by your browser. 
      To view Google Maps, enable JavaScript by changing your browser options, and then 
      try again.
    </noscript>


    <script type="text/javascript">
    //<![CDATA[

    if (GBrowserIsCompatible()) {
      // this variable will collect the html which will eventualkly be placed in the side_bar
      var side_bar_html = "";
    
      // arrays to hold copies of the markers used by the side_bar
      // because the function closure trick doesnt work there
      var gmarkers = [];

      // A function to create the marker and set up the event window
      function createMarker(point,name,html) {
        var marker = new GMarker(point);
        GEvent.addListener(marker, "click", function() {
          marker.openInfoWindowHtml(html);
        });
        // save the info we need to use later for the side_bar
        gmarkers.push(marker);
        // add a line to the side_bar html
        side_bar_html += '<a href="javascript:myclick(' + (gmarkers.length-1) + ')">' + name + '<\/a><br>';
        return marker;
      }


      // This function picks up the click and opens the corresponding info window
      function myclick(i) {
        GEvent.trigger(gmarkers[i], "click");
      }


      // create the map
      var map = new GMap2(document.getElementById("map_<?php echo $city->name; ?>"));
      map.addControl(new GLargeMapControl());
      map.addControl(new GMapTypeControl());
      map.setCenter(new GLatLng(<?php echo $city->map->lat; ?>,<?php echo $city->map->long; ?>), 5);


      // Read the data from example.xml
      GDownloadUrl("<?php echo BASE_URL; ?>/config/map.xml?city=<?php echo $city->id; ?>", function(doc) {
        var xmlDoc = GXml.parse(doc);
        var markers = xmlDoc.documentElement.getElementsByTagName("marker");
          
        for (var i = 0; i < markers.length; i++) {
          // obtain the attribues of each marker
          var lat = parseFloat(markers[i].getAttribute("lat"));
          var lng = parseFloat(markers[i].getAttribute("lng"));
          var point = new GLatLng(lat,lng);
          var html = markers[i].getAttribute("html");
          var label = markers[i].getAttribute("label");
          // create the marker
          var marker = createMarker(point,label,html);
          map.addOverlay(marker);
        }
        // put the assembled side_bar_html contents into the side_bar div
        document.getElementById("side_bar_<?php echo $city->name; ?>").innerHTML = side_bar_html;
      });
    }

    else {
      alert("Sorry, the Google Maps API is not compatible with this browser");
    }

    // This Javascript is based on code provided by the
    // Community Church Javascript Team
    // http://www.bisphamchurch.org.uk/   
    // http://econym.org.uk/gmap/

    //]]>
    </script></section><?php }
} ?>
