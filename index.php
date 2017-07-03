<?php
@include("config.awz.php");
$user = $_GET['u'];
if(empty($user)) $user = $_conf['defuser'];
if(!@preg_match("/[a-z0-9_]+/i", $user)) die("Invalid Username format, cannot process.");

date_default_timezone_set('Asia/Bangkok');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Liked Tweets - @<?=$user;?></title>
	<link rel="stylesheet" href="css/bootstrap.min.css" />
	<style>
    tr,th{vertical-align:center;}
    </style>
</head>
<body>
<?php
$link = new PDO("mysql:host=".$_conf['db']['host'].";dbname=".$_conf['db']['dbname'].";charset=UTF8",$_conf['db']['user'],$_conf['db']['pass']);
if(!$link) {
    die("Cannot connect database!");
}
?>

<table class="table table-condensed">
    <tr><th>Status ID</th><th>Found Date</th><th width="80%">@<?=$user;?>'s Liked Tweets&nbsp;&nbsp;<a class="btn btn-sm btn-primary" href="update.php?u=<?=$user;?>">Update</a></th></tr>
<?php
  $stm = $link->query("SELECT * FROM favs WHERE favUID LIKE '".strtolower($user)."%' ORDER BY foundDate DESC, tweetID ASC");
    
  while($res = $stm->fetch(PDO::FETCH_ASSOC)) {
        echo "  <tr".(($res['deleted']==1)?" class='danger'":"")."><td rowspan='2'><a href='https://twitter.com/statuses/".$res['tweetID']."' target='_blank'>".$res['tweetID']."</a></td><td rowspan='2'>".( $res['foundDate'] ? date("d-m-Y H:i:s",$res['foundDate']) : "Initial" )."</td><th>@".$res['writer']."</th></tr><tr".(($res['deleted']==1)?" class='danger'":"")."><td>".nl2br($res['text'])."</td></tr>";
  }
?>
</table>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>