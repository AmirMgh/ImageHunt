<?php
include('search_image.php');
include('image_process.php');
include_once('db.php');

function submitTags ($user, $imgSrc, $imgTag) {
    $db = new ImageHuntDB();
    
    $resultUrls = getGoogleImageURL($imgTag);
    $foundImage = matchImage($resultUrls, $imgSrc);
    
    /*foreach($resultUrls as $url) {
   	 print("<img style='width:100px;height:100px;' src='".$url."'><br>");
    }*/
    $db->insert_user($user);

    if ($foundImage) {
    
   	 $db->update_leaderboard($user, 10);
   	 echo json_encode("You found the image");
   	 } else {
   	 echo json_encode("Try another image.");
   	 }
    
    $db->log_user_activity($user, hash('md5',$imgSrc), 0, $imgTag);
}

$imgTag = $_GET['tag'];
$imgSrc = $_GET['imgSrc'];
$user = $_GET['user'];

submitTags($user, $imgSrc, $imgTag);

//print("<img style='width:100px;height:100px;' src='".$imgSrc."'><br>");

?>