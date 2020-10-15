<!DOCTYPE html>
<html lang="en">
<head>
<?php
error_reporting(0);
$song_name = urlencode($_GET['song']);
$dl = $_GET['download'];
$req1 = file_get_contents("https://www.jiosaavn.com/api.php?__call=autocomplete.get&_format=json&_marker=0&cc=in&includeMetaTags=1&query=$song_name");
$req1 = json_decode($req1, true);
$id = $req1['songs']['data']['0']['id'];
$imageS = $req1['songs']['data']['0']['image'];
$image = str_replace('50x50', '500x500', $imageS);
$name = $req1['songs']['data']['0']['description'];
$name2 = "$name.m4a";
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
if ($dl == "true") {
    header("Content-type: audio/mp4"); 
    header("Pragma: public");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Content-Disposition: attachment; filename=\"". $name2 ."\"");
    ob_end_clean();
    readfile ($final);
    exit();
}
?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $name;?></title>
</head>

<body style="background-color:powderblue;">

<form action="" method="get">
<center>Name: <input type="text" style="font-size:16pt;" name="song"></center>
<center><input type="checkbox" id="download" name="download" value="true">
<label for="download">Direct download</label><br></center><br>
<center><input type="submit" style="font-size:15px;" ></center>
</form>

<h2 style="font-size:5vw;"><center><?php echo $name;?></center></h2>
<center><img src="<?php echo $image;?>" alt="Image" width="400" height="400"></center>

<center><audio controls>
 <source src="<?php echo $final; ?>" type="audio/mp4">
</audio>
</center>
</body>
</html>
