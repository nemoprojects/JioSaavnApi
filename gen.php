<?php
error_reporting(0);

$song_name = $_GET['song'];
$song_name = urlencode($song_name);
//$song_name = urlencode("on my way alan walker");

$req1 = file_get_contents("https://www.jiosaavn.com/api.php?__call=autocomplete.get&_format=json&_marker=0&cc=in&includeMetaTags=1&query=$song_name");
$req1 = json_decode($req1, true);

$id = $req1['songs']['data']['0']['id'];

$req2 = file_get_contents("https://www.jiosaavn.com/api.php?__call=song.getDetails&cc=in&_marker=0%3F_marker%3D0&_format=json&pids=$id");
$req2 = json_decode($req2, true);
$link = $req2[$id]['media_preview_url'];
$link = str_replace("preview", "aac", $link);
if ($req2[$id]['320kbps'] == "true" ){
	$final = str_replace("_96_p.mp4", "_320.mp4", $link);
}
else {
	$final = str_replace("_96_p.mp4", "_160.mp4", $link);
}
$file_url = $final;
header('Content-Type: audio/mp4');
header("Content-Transfer-Encoding: Binary"); 

readfile($file_url); 
?>