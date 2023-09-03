<?php
include("./php-gracenote/Gracenote.class.php");

// You will need a Gracenote Client ID to use this. Visit https://developer.gracenote.com/
// for more information.

$clientID  = "1185387493-C7B0D27B2EBE40720B577DD696E509B3"; // Put your Client ID here.
$clientTag = "C7B0D27B2EBE40720B577DD696E509B3"; // Put your Client Tag here.
$userID = "279604306884904768-5DFD582AAD90261A5F1BEBF23997EC5D";
$utaten = "https://utaten.com/lyric/";
$youtube = "https://www.google.co.jp/search?q=youtube";

/* You first need to register your client information in order to get a userID.
Best practice is for an application to call this only once, and then cache the userID in
persistent storage, then only use the userID for subsequent API calls. The class will cache
it for just this session on your behalf, but you should store it yourself. */
$api = new Gracenote\WebAPI\GracenoteWebAPI($clientID, $clientTag); // If you have a userID, you can specify as third parameter to constructor.
$userID = $api->register();
//echo "UserID = ".$userID."\n";
//
//// Once you have the userID, you can search for tracks, artists or albums easily.
//echo "\n\nSearch Tracks:\n";
//$results = $api->searchTrack("Kings Of Convenience", "Riot On An Empty Street", "Homesick");
//var_dump($results);
//
//echo "\n\nSearch Best Track:\n";
//$results = $api->searchTrack("Kings Of Convenience", "Riot On An Empty Street", "Homesick", Gracenote\WebAPI\GracenoteWebAPI::BEST_MATCH_ONLY);
//var_dump($results);
//
//echo "\n\nSearch Artist:\n";
//$results = $api->searchArtist("Kings Of Convenience");
//var_dump($results);
//
//echo "\n\nSearch Album:\n";
//$results = $api->searchAlbum("Kings Of Convenience", "Riot On An Empty Street");
//var_dump($results);
//
//echo "\n\nFetch Album:\n";
//$results = $api->fetchAlbum("5026977-5C6DC28B1E1ADB1D028FF248DDFAEB55");
//var_dump($results);
//
//echo "\n\nAlbum Toc:\n";
//$results = $api->albumToc("150 20512 30837 50912 64107 78357 90537 110742 126817 144657 153490 160700 175270 186830 201800 218010 237282 244062 262600 272929");
//var_dump($results);
$api = new Gracenote\WebAPI\GracenoteWebAPI($clientID, $clientTag, $userID);
$results = $api->searchArtist("YUKI");
$randam = mt_rand(0,count($results));
$randam2 = mt_rand(0,count($results[$randam]["tracks"]));
//var_dump($results[$randam]);
if ($randam == null) {
	sleep(10);
} else if ($randam2 == null) {
	sleep(10);
}
$album = $results[$randam];
$track = $results[$randam]["tracks"][$randam2];
$trackinfo = array_shift($api->searchTrack("YUKI", $album["album_title"], $track["track_title"], Gracenote\WebAPI\GracenoteWebAPI::BEST_MATCH_ONLY));
?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
		<meta charset="utf-8">
		<meta http-equiv="Pragma" content="no-cache">
		<meta http-equiv="Cache-Control" content="no-cache">
		<meta http-equiv="Expires" content="0">
		<title>今日のゆきんこ</title>
		<meta http-equiv="Content-Style-Type" content="text/css" />
		<meta http-equiv="Content-Script-Type" content="text/javascript" />
		<link href="./css/common.css" rel="stylesheet" type="text/css" media="all" />
	</head>
	<body>
		<div class="maincontents">
			<h1>今日のゆきんこ</h1>
			<h2>Album Title　：　<?php echo $trackinfo["album_title"]; ?></h2>
			<h2>Album Year　：　<?php echo $trackinfo["album_year"]; ?></h2>
			<img src="<?php echo $trackinfo["album_art_url"]; ?>">
			<h3>Track Title　：　<?php echo $trackinfo["tracks"][0]["track_title"]; ?></h3>
			<h4>歌詞情報</h4>
			<iframe src="<?php echo $utaten .  $trackinfo["tracks"][0]["track_artist_name"] . "/" . $trackinfo["tracks"][0]["track_title"];?>" sandbox="allow-same-origin allow-forms allow-scripts" name="utaten" width="700px" height="800px">
			この部分はインラインフレームを使用しています。
			</iframe><br />
			<a href="https://www.youtube.com/channel/UCwYZk061Aw91ZtIid0fmkQg" target="_blank">YUKI Channel</a>
		</div>
	</body>
</html>
