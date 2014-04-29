<?php 

if(!isset($_POST['username'])) {
	throw new Exception('Missing Twitter username');
}
$twitter_username = $_POST['username'];


// Twitter key and tokens
$consumerkey = "";
$consumersecret = "";
$accesstoken = "";
$accesstokensecret = "";
if (empty($consumerkey) || empty($consumersecret) || empty($accesstoken) || empty($accesstokensecret)) {
	throw new Exception('Twitter keys and tokens NOT provided');
}

require_once("library/twitteroauth/twitteroauth.php");
$connection = new TwitterOAuth($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);


/**
 * API in order to retrieve the last 5 tweet for a twitter username
 */
$last_tweet = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$twitter_username."&count=5");

if($connection->http_code != 200) {
	throw new Exception('Request NOT successfull');
}
?>

<h1>User: <?php echo htmlspecialchars($twitter_username); ?></h1>
<p>Last 5 Tweet:</p>
<ul>
  <?php foreach ($last_tweet as $tweet): ?>
      <li><?php echo $tweet->text ?></li>
  <?php endforeach; ?>
</ul>


<?php
/**
 * API in order to retrieve tweets count, follower and following for a twitter username
 */
$user_info = $connection->get("https://api.twitter.com/1.1/users/show.json?screen_name=".$twitter_username);

if($connection->http_code != 200) {
	throw new Exception('Request NOT successfull');
}
?>

<dl>
  <dt>Total Tweet:</dt>  <dd><?php echo htmlspecialchars($user_info->statuses_count); ?></dd>
  <dt>Follower:</dt>  <dd><?php echo htmlspecialchars($user_info->followers_count); ?></dd>
  <dt>Following:</dt>  <dd><?php echo htmlspecialchars($user_info->friends_count); ?></dd>
</dl>