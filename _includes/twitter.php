<?php
	$settings = array(
		'consumer_key' => "ZhLwWfKpnDGhDGKUObhLLAo0w",
		'consumer_secret' => "yRG4Zue9pnCF0zXj3TClkdnRjG2HXEJTXKDdCTb2DxJhQN98Xz",
		'oauth_access_token' => "1318250469085556736-mawlcsNIagT0INXQSQAsV97CCDadZl",
		'oauth_access_token_secret' => "SHRWeRdYF9gJxVXF9DEBkIIicwNHuQNZOvRIGiw9beKcf"
	);
	$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
	$twitterUsername = "ChiapasDesdeElC";
	$tweetCount = 4;
	$tokens = '_utils/tokens.php';
	is_file($tokens) AND include $tokens;
	require_once('_utils/twitter-api-oauth.php');
	
	$getfield = '?screen_name=' . $twitterUsername . '&count=' . $tweetCount;
	$twitter = new TwitterAPITimeline($settings);
	
	$json = $twitter->setGetfield($getfield)	
				  	->buildOauth($url)
				 	->performRequest();
				 			
	$twitter_data = json_decode($json, true);
	function timeAgo($dateStr) {
		$timestamp = strtotime($dateStr);	 
		$day = 60 * 60 * 24;
		$today = time();
		$since = $today - $timestamp;
		 
		 
		 if (($since / $day) < 1) {
		 
		 	$timeUnits = array(
				   array(60 * 60, 'h'),
				   array(60, 'm'),
				   array(1, 's')
			  );
			  
			  for ($i = 0, $n = count($timeUnits); $i < $n; $i++) { 
				   $seconds = $timeUnits[$i][0];
				   $unit = $timeUnits[$i][1];
			 
				   if (($count = floor($since / $seconds)) != 0) {
					   break;
				   }
			  }
		 
			  return "$count{$unit}";
			  
		 } else {
			  return date('j M', strtotime($dateStr));
		 }	 
	}
	
	
	function formatTweet($tweet) {
		$linkified = '@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@';
		$hashified = '/(^|[\n\s])#([^\s"\t\n\r<:]*)/is';
		$mentionified = '/(^|[\n\s])@([^\s"\t\n\r<:]*)/is';
		
		$prettyTweet = preg_replace(
			array(
				$linkified,
				$hashified,
				$mentionified
			), 
			array(
				'<a href="$1" class="link-tweet" target="_blank">$1</a>',
				'$1<a class="link-hashtag" href="https://twitter.com/search?q=%23$2&src=hash" target="_blank">#$2</a>',
				'$1<a class="link-mention" href="http://twitter.com/$2" target="_blank">@$2</a>'
			), 
			$tweet
		);
		
		return $prettyTweet;
	}
	
	echo '</ul>';
?>