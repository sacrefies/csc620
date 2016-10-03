<?php
require_once 'settings.php';
require_once 'TwitterAPIExchange.php';
require_once 'mysqlDB.php';


/**
 * Convert tweets to an array of stdClass objects.
 */
function toArray($tweets) {
    $record = array();
    foreach ($tweets->statuses as $tweet){
        $t = new stdClass();
        $t->sender = $tweet->user->name;
        $t->text = $tweet->text;
        $t->time = $tweet->created_at;
        $t->image = $tweet->user->profile_image_url;
        $record[] = $t;
    }
    // print_r($record);
    return $record;
}


function initTweetAPI() {
    global $oauth_access_token;
    global $oauth_access_token_secret;
    global $consumer_key;
    global $consumer_secret;


    $twitter_api_auth = array(
        'oauth_access_token' => $oauth_access_token,
        'oauth_access_token_secret' => $oauth_access_token_secret,
        'consumer_key' => $consumer_key,
        'consumer_secret' => $consumer_secret
    );
    return new TwitterAPIExchange($twitter_api_auth);
}


function searchTweetsJSON($twitterAPI, $keywords) {
    global $twitter_url;
    global $method;
    $params = '?q=' .urlencode($keywords) .'&src=typd&count=200';
    $result = $twitterAPI->setGetfield($params)
    ->buildOauth($twitter_url, $method)
    ->performRequest();
    // echo $result;
    return json_decode($result);
}


function formatTime($datetime = '') {
    return date("Y-m-d H:i:s", strtotime($datetime));
}


function persistTweets($data) {
    global $dsn;
    global $username;
    global $dbpass;

    $db = new MySQLDB($dsn, $username, $dbpass);
    $db->connect();

    // clean up
    $sql = "DELETE FROM tweet";
    $db->exec($sql);

    foreach ($data as $r) {
        $date = formatTime($r->time);
        $query = "INSERT INTO tweet (user, tweet, avatar, twit_time) VALUES ('$r->sender', '$r->text', '$r->image', '$date')";
        $db->exec($query);
    }
    $db->disconnect();
}

if(isset($_POST['inputKeywords']))
{
    echo '<h1>Processing...</h1>';

    date_default_timezone_set('America/New_York');
    $keywords = $_POST['inputKeywords'];
    // echo $keywords;
    $raw = searchTweetsJSON(initTweetAPI(), $keywords);
    // print_r(toArray($raw));
    persistTweets(toArray($raw));
    // go to result page
    header( 'Location: search_result.html?keywords='.urlencode($keywords) ) ;
}
?>
