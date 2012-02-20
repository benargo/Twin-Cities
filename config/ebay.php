<?php 

include('ebay-uk.php');

function foo() {
  global $results;
}


foo();

include('ebay-us.php');

function bar() {
  global $results1;
}


bar();

 ?>