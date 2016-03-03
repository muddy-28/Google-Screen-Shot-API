<?php

function get_url_contents($url){  
  if (function_exists('file_get_contents')) {  
    $result = @file_get_contents($url);  
  }  
  if ($result == '') {  
    $ch = curl_init();  
    $timeout = 30;  
    curl_setopt($ch, CURLOPT_URL, $url);  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);  
    $result = curl_exec($ch);  
    curl_close($ch);  
  }  

  return $result;  
}

$sites = "http://www.envoyerit.com/
http://www.envoyerit.com/school/
http://www.envoyerit.com/eagale_management
http://www.envoyerit.com/proj_mgm";

$sites = preg_split('/\r\n|\r|\n/', $sites);


echo "
<style>
img {float: left; margin: 15px; }
</style>
";

foreach($sites as $site) 
{
    $image = get_url_contents("https://www.googleapis.com/pagespeedonline/v1/runPagespeed?url=$site&screenshot=true&strategy=mobile");
		$image = json_decode($image, true); 
		$image = $image['screenshot']['data'];	
        $image = str_replace(array('_','-'),array('/','+'),$image); 
	
	echo "<img src=\"data:image/jpeg;base64,".$image."\" border='1' />";
	

}

?>