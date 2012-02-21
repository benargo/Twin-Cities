<?php

function getCityRegion($id){
   $txt = file_get_contents(BASE_URI.'/config/config.xml');
   $cities = new SimpleXMLElement($txt);
   return $cities->city[$id]->name . ", " . $cities->city[0]->region;
   
}

?>