<?php

function getCityRegion1($id1){
   $txt1 = file_get_contents(BASE_URI.'/config/config.xml');
   $cities1 = new SimpleXMLElement($txt1);
   return $cities1->city[$id1]->name . ", " . $cities1->city[1]->country;
   

}

?>