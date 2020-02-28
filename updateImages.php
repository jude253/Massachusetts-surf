<?php
//this runs 2x per day with a cron job to update the maps stored in the file directory of this webapp.
function callAPI($method, $url, $data){ //found this code on the internet somewhere
   $curl = curl_init();
   switch ($method){
      case "POST":
         curl_setopt($curl, CURLOPT_POST, 1);
         if ($data)
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
         break;
      case "PUT":
         curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
         if ($data)
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);			 					
         break;
      default:
         if ($data)
            $url = sprintf("%s?%s", $url, http_build_query($data));
   }
   // OPTIONS:
   curl_setopt($curl, CURLOPT_URL, $url);
   curl_setopt($curl, CURLOPT_HTTPHEADER, array(
      'APIKEY: 111111111111111111111',
      'Content-Type: application/json',
   ));
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
   // EXECUTE:
   $result = curl_exec($curl);
   if(!$result){die("Connection Failure");}
   curl_close($curl);
   return $result;
}

function saveImgTo($image_link,$folder,$filename) { //found this code on the internet somewhere
    $split_image = pathinfo($image_link);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL , $image_link);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/525.13 (KHTML, like Gecko) Chrome/0.A.B.C Safari/525.13");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    $response= curl_exec ($ch);
    curl_close($ch);
    $file_name = "images/mapImages/$folder/$filename.".$split_image['extension'];
    $file = fopen($file_name , 'w') or die("X_x");
    fwrite($file, $response);
    fclose($file);
    
}

function updateImgs() { //takes like five minutes, but saves all the charts to their folders from API Call.  run only at midnight because it takes a while!
    $charts_api_url = "http://magicseaweed.com/api/ad8f2245ae1d67e90d037af0dea211ff/forecast/?spot_id=377&fields=charts.*"; //call API with only charts in the response
    
    $response = json_decode(callAPI('get',$charts_api_url,false)); //decode response so it can be parsed
    
    for($index = 0; $index < 40; $index++) { //go through array element and saves these 4 charts to local file
        
//        echo($response[$index]->charts->swell); debugging purposes
        saveImgTo($response[$index]->charts->swell,"swell",$index);
        saveImgTo($response[$index]->charts->wind,"wind",$index);
        saveImgTo($response[$index]->charts->pressure,"pressure",$index);
        saveImgTo($response[$index]->charts->period,"period",$index);
    }
}

updateImgs();

?>