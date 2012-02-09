<html>
<head>
	<title>Twitter feed from Oxford, UK and Grenoble, France.</title>
	
	<link rel="stylesheet" href="styles/twintown.css" />
	
</head>


<body>

<pre>





<article>
<h1>Twitter</h1>
<ul>
<?php

$request1 = 'https://api.twitter.com/1/statuses/user_timeline.xml?user_id=19603191&count=10&trim_user=true&exclude_replies=true';


$result1 = simplexml_load_file($request1);



$tweets = $result1->status;

foreach	($tweets as $tweet) {
	echo "<li>";
	echo $tweet->created_at;
	
	
	echo "<br>";
	
	$tweettext = preg_replace('/[^(\x20-\x7F)]*/','', $tweet->text);
	
	echo $tweettext;
	
	echo "</li>";
	
	
	echo "<br>";
	echo "<br>";
}

?>
</ul>
</article>

<article>
<ul>

<?php

$request2 = 'https://api.twitter.com/1/statuses/user_timeline.xml?user_id=41094890&count=10&trim_user=true&exclude_replies=true';

$result2 = simplexml_load_file($request2);

$tweets = $result2->status;



foreach	($tweets as $tweet) {
	echo "<li>";
	echo $tweet->created_at;
	
	echo "<br>";
	
	$tweettext = preg_replace('/[^(\x20-\x7F)]*/','', $tweet->text);
  	
	echo $tweettext;
	
	echo "<br>";
	echo "<br>";
	echo "</li>";
	    
}



?>
</ul>
</article>

</pre>
</body>
</html>