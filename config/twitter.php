<html>
<head>
	<title>Twitter feed from Oxford, UK and Grenoble, France.</title>
	
	<link rel="stylesheet" href="styles/twintown.css" />
	
</head>


<body>


<article>
<h1>Twitter</h1>
<ul>
<?php

$request1 = 'https://api.twitter.com/1/statuses/user_timeline.xml?user_id=19603191&count=10&exclude_replies=true';


$result1 = simplexml_load_file($request1);

$tweets = $result1->status;

foreach	($tweets as $tweet) {
	echo "<li>";
	$date = strtotime($tweet->created_at);
	
	echo date('jS F Y \a\t H:i',$date);	
		
	$link = "http://twitter.com/" . $tweet->user->screen_name . "/status/" . $tweet->id;
	
	
	echo "<br>";
	
	$tweettext = preg_replace('/[^(\x20-\x7F)]*/','', $tweet->text);
	
	
	echo "<a href=\"".$link."\">".$tweettext."</a>";
	
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

$request2 = 'https://api.twitter.com/1/statuses/user_timeline.xml?user_id=41094890&count=10&exclude_replies=true';

$result2 = simplexml_load_file($request2);

// http://twitter.com/<username>/status/<ID>

$tweets = $result2->status;

foreach	($tweets as $tweet) {
	echo "<li>";
	
	$date = strtotime($tweet->created_at);
	
	echo date('jS F Y \a\t H:i',$date);	
	
	$link = "http://twitter.com/" . $tweet->user->screen_name . "/status/" . $tweet->id;
	
	echo "<br>";
	
	$tweettext = preg_replace('/[^(\x20-\x7F)]*/','', $tweet->text);
  	
	echo "<a href=\"".$link."\">".$tweettext."</a>";
	
	echo "<br>";
	echo "<br>";
	echo "</li>";
	    
}



?>
</ul>
</article>

</body>
</html>