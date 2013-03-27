<?php
function search_image($inputString){
        $cleaninput = preg_replace('!\s+!', ' ', $inputString);
	$url = "https://ajax.googleapis.com/ajax/services/search/images?" .
       "v=1.0&rsz=8&q=" . str_replace(' ', "%20", $cleaninput);
	//print($url);

	// sendRequest
	// note how referer is set manually
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	//curl_setopt($ch, CURLOPT_REFERER, /* Enter the URL of your site here */);

	$body = curl_exec($ch);
	curl_close($ch);

	// now, process the JSON string
	$json = json_decode($body, true);
	return $json["responseData"]["results"];
}

function endsWith($haystack, $needle)
{
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }
    return (substr($haystack, -$length) === $needle);
}

function validateUrl ($url)
{
  return (endsWith($url,".jpg") or endsWith($url,".jpeg") or endsWith($url,".gif") or endsWith($url,".png"));
}

function getGoogleImageURL($keywords)
{
   $imageURLs = array();
   $results = search_image($keywords);
   $limitResultCounter = 5;
   foreach($results as $result)
      {
	$urlResult = $result["url"];
	if(validateUrl($urlResult) and $limitResultCounter > 0){
		$imageURLs[] = $urlResult;
		//print("<br>");
		//print($result["url"]);
		//print("<br>");
                $limitResultCounter -= 1;
	}
}
 return $imageURLs;
}
/*
$imageResultURL = getGoogleImageURL("Barack     Obama");
print_r ($imageResultURL);
*/
?>
