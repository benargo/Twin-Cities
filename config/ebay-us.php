<?php

error_reporting(E_ALL);  // Turn on all errors, warnings, and notices for easier debugging
$endpoint1 = 'http://svcs.ebay.com/services/search/FindingService/v1';  // URL to call

include("xmlhandler1.php");

 

$query1 = getCityRegion1(1);

   // Create a PHP array of the item filters you want to use in your request
$filterarray1 = 
  array(
    array(
    'name' => 'MaxPrice',
    'value' => '25',
    'paramName' => 'Currency',
    'paramValue' => 'USD'),
    array(
    'name' => 'FreeShippingOnly',
    'value' => 'true',
    'paramName' => '',
    'paramValue' => ''),
    array(
    'name' => 'ListingType',
    'value' => array('AuctionWithBIN','FixedPrice','StoreInventory'),
    'paramName' => '',
    'paramValue' => ''),
  );

// Generates an XML snippet from the array of item filters
function buildXMLFilter1 ($filterarray1) {
  global $xmlfilter1;
  // Iterate through each filter in the array
  foreach ($filterarray1 as $itemfilter1) {
    $xmlfilter1 .= "<itemFilter>\n";
    // Iterate through each key in the filter
    foreach($itemfilter1 as $key1 => $value1) {
      if(is_array($value1)) {
        // If value is an array, iterate through each array value
        foreach($value1 as $arrayval1) {
          $xmlfilter1 .= " <$key1>$arrayval1</$key1>\n";
        }
      }
      else {
        if($value1 != "") {
          $xmlfilter1 .= " <$key1>$value1</$key1>\n";
        }
      }
    }
    $xmlfilter1 .= "</itemFilter>\n";
  }
  return "$xmlfilter1";
} // End of buildXMLFilter function

// Build the item filter XML code
buildXMLFilter1($filterarray1);

// Construct the findItemsByKeywords POST call
// Load the call and capture the response returned by the eBay API
// the constructCallAndGetResponse function is defined below
$resp1 = simplexml_load_string(constructPostCallAndGetResponse1($endpoint1, $query1, $xmlfilter1));

// Check to see if the call was successful, else print an error
if ($resp1->ack == "Success") {
  $results1 = '';  // Initialize the $results1 variable

  // Parse the desired information from the response
  foreach($resp1->searchResult->item as $item1) {
    $pic1   = $item1->galleryURL;
    $link1  = $item1->viewItemURL;
    $title1 = $item1->title;

    // Build the desired HTML code for each searchResult.item node and append it to $results1
    $results1 .= "<tr><td><img src=\"$pic1\"></td><td><a href=\"$link1\">$title1</a></td></tr>";
  }
}
else {  // If the response does not indicate 'Success,' print an error
  $results1  = "<h3>Oops! The request was not successful. Make sure you are using a valid ";
  $results1 .= "AppID for the Production environment.</h3>";
}

?>

<!-- Build the HTML page with values from the call response -->
<html>
<head>
<title>eBay Search results for <?php echo $query1; ?></title>
<style type="text/css">body {font-family: arial, sans-serif;} </style>
</head>
<body>

<h1>eBay Search results for <?php echo $query1; ?></h1>

<table>
<tr>
  <td>
    <?php echo $results1;?>
  </td>
</tr>
</table>

</body>
</html>

<?php
function constructPostCallAndGetResponse1($endpoint1, $query1, $xmlfilter1) {
  global $xmlrequest;

  // Create the XML request to be POSTed
  $xmlrequest1  = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
  $xmlrequest1 .= "<findItemsByKeywordsRequest xmlns=\"http://www.ebay.com/marketplace/search/v1/services\">\n";
  $xmlrequest1 .= "<keywords>";
  $xmlrequest1 .= $query1;
  $xmlrequest1 .= "</keywords>\n";
  $xmlrequest1 .= $xmlfilter1;
  $xmlrequest1 .= "<paginationInput>\n <entriesPerPage>3</entriesPerPage>\n</paginationInput>\n";
  $xmlrequest1 .= "</findItemsByKeywordsRequest>";

  // Set up the HTTP headers
  $headers1 = array(
    'X-EBAY-SOA-OPERATION-NAME: findItemsByKeywords',
    'X-EBAY-SOA-SERVICE-VERSION: 1.3.0',
    'X-EBAY-SOA-REQUEST-DATA-FORMAT: XML',
    'X-EBAY-SOA-GLOBAL-ID: EBAY-US',
    'X-EBAY-SOA-SECURITY-APPNAME: RichardG-7061-47eb-9a6c-66d2c8e8fadc',
    'Content-Type: text/xml;charset=utf-8',
  );

  $session1  = curl_init($endpoint1);                       // create a curl session
    curl_setopt($session1, CURLOPT_RETURNTRANSFER, TRUE); 
	curl_setopt($session1, CURLOPT_PROXY, 'proxysg.uwe.ac.uk:8080');  
  curl_setopt($session1, CURLOPT_POST, true);              // POST request type
  curl_setopt($session1, CURLOPT_HTTPHEADER, $headers1);    // set headers using $headers array
  curl_setopt($session1, CURLOPT_POSTFIELDS, $xmlrequest1); // set the body of the POST
  curl_setopt($session1, CURLOPT_RETURNTRANSFER, true);    // return values as a string, not to std out

  $responsexml1 = curl_exec($session1);                     // send the request
  curl_close($session1);                                   // close the session
  return $responsexml1;                                    // returns a string

}  // End of constructPostCallAndGetResponse function
?>