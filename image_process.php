<?php
function sampleImage($filename){
	// Get new dimensions
	list($width, $height) = getimagesize($filename);
	$new_width = 4;//$width * $percent;
	$new_height = 4;//$height * $percent;
	// Resample
	$image_p = imagecreatetruecolor($new_width, $new_height);
	if (isJPG($filename)) {
		$image = imagecreatefromjpeg($filename);
	} else if (isGIF($filename)) {
		$image = imagecreatefromgif($filename);
	} else if (isPNG($filename)) {
		$image = imagecreatefrompng($filename);
	}
	imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
	$samples = array(
		"red" => array(),
		"green" => array(),
		"blue" => array()
	);
	//sample
	for($x = 0; $x < $new_width; $x++){
		for($y = 0; $y < $new_height; $y++){
			$rgb = imagecolorat($image_p, $x, $y);
			$r = ($rgb >> 16) & 0xFF;
			$g = ($rgb >> 8) & 0xFF;
			$b = $rgb & 0xFF;
			//var_dump($r, $g, $b);
			$samples["red"][] = $r/255.0;
			$samples["green"][] = $g/255.0;
			$samples["blue"][] = $b/255.0;
		}
	}
	return $samples;
}

function isGIF ($filename) {
	return endsWith($filename,"gif");
}

function isJPG ($filename) {
	return endsWith($filename,"jpg") || endsWith($filename,"jpeg");
}

function isPNG ($filename) {
	return endsWith($filename,"png");
}

function manDistance($v1, $v2){
	$len = count($v1["red"]);
	$dist = 0.0;
	for($inx = 0; $inx < $len; $inx++){
		$diff = abs($v1["red"][$inx] - $v2["red"][$inx]) + abs($v1["green"][$inx] - $v2["green"][$inx]) + abs($v1["blue"][$inx] - $v2["blue"][$inx]);
		$dist += $diff / 3.0;
		//print($diff."<br/>");
	}
	return $dist/16.0;
}

function saveImage($url, $filename){
	$ch = curl_init($url);
	$fp = fopen($filename, 'wb');
	curl_setopt($ch, CURLOPT_FILE, $fp);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_exec($ch);
	curl_close($ch);
	fclose($fp);
}

function matchImage($urls, $basefilename) {
	$vec1 = sampleImage($basefilename);
	foreach ($urls as $url) {
		$localfile = "tmp/".rand(10000,20000);
		$idx = strrpos($url,'.');
		$localfile .= substr($url,$idx);
		saveImage($url, $localfile);
		$vec2 = sampleImage($localfile);
		$dist = manDistance($vec1, $vec2);
		if ($dist < 0.12) {
			return True;
		}
	}
	return False;
}

/*$files = Array('images/asian_1.jpg', 'images/asian_2.jpg', 'images/obama1.jpg', 'images/cartoon_1.jpg', 'images/cartoon_2.jpg', 'images/cartoon_3.png', 'images/cartoon_4.gif', 'images/tree_1.jpg', 'images/tree_2.jpg', 'images/obama_2.jpg', 'images/obama_3.jpg');
$compares = Array(Array(0,1), Array(0,2), Array(2,3), Array(3,4), Array(5,6), Array(7,8), Array(2, 9), Array(9, 10));
// 0: asian 1 and 2
// 1: asian and obama
// 2: obama and cartoon
// 3: cartoon 1 and cartoon 2
// 4: cartoon 3 and cartoon 4
// 5: tree 1 and tree 2
*/
/*
 * USAGE
$urls = Array(
		'http://i.huffpost.com/gen/947814/thumbs/o-OBAMA-PORTRAIT-570.jpg',
		'http://media.npr.org/assets/img/2012/01/20/obama20_sq-6f9b96594e0aed00c1be3884cd0f8266508ee364-s6-c10.jpg',
		'http://upload.wikimedia.org/wikipedia/commons/f/f9/Obama_portrait_crop.jpg',
		'http://images.politico.com/global/2012/12/04/121204_barack_obama_ap_605.jpg',
		'http://i.huffpost.com/gen/947814/thumbs/o-OBAMA-PORTRAIT-570.jpg'
		);
$ret = matchImage($urls, 'images/obama_2.jpg');
*/
?>
