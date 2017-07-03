<?php
@include("config.awz.php");
$user = $_GET['u'];
if(empty($user)) $user = $_conf['defuser'];
if(!@preg_match("/[a-z0-9_]+/i", $user)) die("Invalid Username format, cannot process.");

@require_once('TwitterAPIExchange.php');
$settings = array(
    'oauth_access_token' => OAUTH_ACCESS_TOKEN,
    'oauth_access_token_secret' => OAUTH_ACCESS_TOKEN_SECRET,
    'consumer_key' => CONSUMER_KEY,
    'consumer_secret' => CONSUMER_SECRET
);

$link = new PDO("mysql:host=".$_conf['db']['host'].";dbname=".$_conf['db']['dbname'].";charset=UTF8",$_conf['db']['user'],$_conf['db']['pass']);
if(!$link) {
    die("Cannot connect database!");
}

// Reset all tweets as Deleted
$link->query("UPDATE favs SET deleted=1 WHERE favUID LIKE '".strtolower($user)."%'");

// Found Date
$today = time();

// If this is the first update, set Found Date as 'Initial (0)'
$stm = $link->query("SELECT COUNT(favUID) FROM favs WHERE favUID LIKE '".strtolower($user)."%'");
$res = $stm->fetch(PDO::FETCH_ASSOC);
if($res['COUNT(favUID)']==0) {
  $today = 0;
}

$twitter = new TwitterAPIExchange($settings);
$url = 'https://api.twitter.com/1.1/favorites/list.json';
$getfield = '?screen_name='.$user.'&count=100';
$requestMethod = 'GET';

$page=1;
while($page<38) {
    $endTweet = 0;
    $favs =  $twitter->setGetfield($getfield)
        ->buildOauth($url, $requestMethod)
        ->performRequest();
    $favs = json_decode($favs);
    if(@$favs->errors){
        $errTxt = "[API Error]<br>";
        foreach($favs->errors as $err) {
            $errTxt .= $err->message." (Code: ".$err->code.")<br>";
        }
        die($errTxt);   
    }
    
    foreach($favs as $twt) {
        $twt->text = str_replace("'","\\'",$twt->text);
        
        if($link->query("INSERT INTO favs VALUES ('".strtolower($user)."_".$twt->id."', ".$twt->id.",".$today.",'".$twt->text."','".$twt->user->screen_name."|".$twt->user->id."',0);")) 
            echo "New Tweet found: ".$twt->id."<br>";
        else $link->query("UPDATE favs SET deleted=0 WHERE favUID = '".strtolower($user)."_".$twt->id."';");
         
        $endTweet = $twt->id;
    }
    
    if(!@empty($endTweet)) {
      $getfield = '?screen_name='.$user.'&count=100&max_id='.$endTweet;
      $page++;
    } else {
      break;
    }
}

?>