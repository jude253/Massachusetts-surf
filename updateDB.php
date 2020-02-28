<?php 
//this runs 2x per day with a cron job to update mySQL database created for this webapp.
function callAPI($method, $url, $data){ //found this on the internet
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

function insertReplaceDB_spot($responsearray, $spot_id) { //inserts or replaces all (0-39) rows of data for given spot_id (response is API resonse from Magic Sea Weed)
    $credentials = getCredentials("surf.ini");
    $host = $credentials["host"];
    $dbusername = $credentials["dbusername"];
    $dbpassword = $credentials["dbpassword"];
    $dbname = $credentials["dbname"];
    $table = $credentials["dbtable"];
    $spot_id = $spot_id;  
    
    // Create connection to mySQL database
    $conn = new mysqli($host,$dbusername,$dbpassword,$dbname);
        
    if(mysqli_connect_error()){
        die('Connect Error ('.mysqli_connect_errno().')'.mysqli_connect_error());
    }
    else{
        for ($orderid = 0; $orderid < 40; $orderid++){
            $times = $responsearray[$orderid]->timestamp;
            $solidRating = $responsearray[$orderid]->solidRating;
            $fadedRating = $responsearray[$orderid]->fadedRating;
            
            #swell data
            
            $absMinBreakingHeight = $responsearray[$orderid]->swell->absMinBreakingHeight;
            $absMaxBreakingHeight = $responsearray[$orderid]->swell->absMaxBreakingHeight;
            $height = $responsearray[$orderid]->swell->components->combined->height;
            $height = round($height,2); #just in case this is sometimes super long as well, like the swellDir and windDir
            $period = $responsearray[$orderid]->swell->components->combined->period;
            $swellDir = $responsearray[$orderid]->swell->components->combined->direction;
            $swellDir = round($swellDir,2); #sometimes this can be like 10 digits long:
            $swellCompDir = $responsearray[$orderid]->swell->components->combined->compassDirection;
            $swellUnit = $responsearray[$orderid]->swell->unit;
            
            #wind data
            $windSpeed = $responsearray[$orderid]->wind->speed;
            $windDir = $responsearray[$orderid]->wind->direction;
            $windDir = round($windDir,2);  #sometimes this can be like 10 digits long;
            $windCompDir = $responsearray[$orderid]->wind->compassDirection;
            $windGusts = $responsearray[$orderid]->wind->gusts;
            $windUnit = $responsearray[$orderid]->wind->unit;
            
            
            #This query will instert the 40 rows from spot_id into req data, if it is already in table, it will update the data already there
            #in req table primary key = (spot_id,orderid), so each spot will only have 40 rows.
            
            $sql = "INSERT INTO $table
            
            (spot_id,orderid,times,solidRating,fadedRating,
            minBreakHeight,maxBreakHeight,height,period,swellDir,swellCompDir,swellUnit,
            windSpeed,windDir,windCompDir,windGusts,windUnit)
            
            values 
            ('$spot_id','$orderid',FROM_UNIXTIME('$times'),'$solidRating','$fadedRating',
            '$absMinBreakingHeight','$absMaxBreakingHeight','$height','$period','$swellDir','$swellCompDir','$swellUnit',
            '$windSpeed','$windDir','$windCompDir','$windGusts','$windUnit') 
            
            ON DUPLICATE KEY UPDATE 
            
            times = FROM_UNIXTIME('$times'),
            solidRating = '$solidRating',
            fadedRating = '$fadedRating',
            minBreakHeight = '$absMinBreakingHeight',
            maxBreakHeight = '$absMaxBreakingHeight',
            height = '$height',
            period = '$period',
            swellDir = '$swellDir',
            swellCompDir = '$swellCompDir',
            swellUnit = '$swellUnit',
            windSpeed = '$windSpeed',
            windDir = '$windDir',
            windCompDir = '$windCompDir',
            windGusts = '$windGusts',
            windUnit = '$windUnit'";
            
            
            if ($conn->query($sql)){
                echo "New record $orderid is inserted sucessfully <br>";
            }
            else{
                echo "Error:".$sql."<br>".$conn->error;
            }
        }
    
        $conn->close();
    }
    
}

function insertIntoDB($responsearray, $spot_id) { //inserts all (0-39) rows of data for given spot_id (response is API resonse from Magic Sea Weed) Doesn't replace exisiting. This was used at first to set up database, but now deprecated.
    $credentials = getCredentials("surf.ini");
    $host = $credentials["host"];
    $dbusername = $credentials["dbusername"];
    $dbpassword = $credentials["dbpassword"];
    $dbname = $credentials["dbname"];
    $table = $credentials["dbtable"];
    $spot_id = $spot_id;  
    
    // Create connection
    $conn = new mysqli($host,$dbusername,$dbpassword,$dbname);
        
    if(mysqli_connect_error()){
        die('Connect Error ('.mysqli_connect_errno().')'.mysqli_connect_error());
    }
    else{
        for ($orderid = 0; $orderid < 40; $orderid++){
            $times = $responsearray[$orderid]->timestamp;
            $solidRating = $responsearray[$orderid]->solidRating;
            $fadedRating = $responsearray[$orderid]->fadedRating;
            
            #swell data
            
            $absMinBreakingHeight = $responsearray[$orderid]->swell->absMinBreakingHeight;
            $absMaxBreakingHeight = $responsearray[$orderid]->swell->absMaxBreakingHeight;
            $height = $responsearray[$orderid]->swell->components->combined->height;
            $height = round($height,2); #just in case this is sometimes super long as well, like the swellDir and windDir
            $period = $responsearray[$orderid]->swell->components->combined->period;
            $swellDir = $responsearray[$orderid]->swell->components->combined->direction;
            $swellDir = round($swellDir,2); #sometimes this can be like 10 digits long:
            $swellCompDir = $responsearray[$orderid]->swell->components->combined->compassDirection;
            $swellUnit = $responsearray[$orderid]->swell->unit;
            
            #wind data
            $windSpeed = $responsearray[$orderid]->wind->speed;
            $windDir = $responsearray[$orderid]->wind->direction;
            $windDir = round($windDir,2);  #sometimes this can be like 10 digits long;
            $windCompDir = $responsearray[$orderid]->wind->compassDirection;
            $windGusts = $responsearray[$orderid]->wind->gusts;
            $windUnit = $responsearray[$orderid]->wind->unit;
            
            
             
            #This query will instert the 40 rows from spot_id into req data, so each spot will only have 40 rows.
            
            $sql = "INSERT INTO $table
            
            (spot_id,orderid,times,solidRating,fadedRating,
            minBreakHeight,maxBreakHeight,height,period,swellDir,swellCompDir,swellUnit,
            windSpeed,windDir,windCompDir,windGusts,windUnit)
            
            values 
            
            ('$spot_id','$orderid',FROM_UNIXTIME('$times'),'$solidRating','$fadedRating',
            '$absMinBreakingHeight','$absMaxBreakingHeight','$height','$period','$swellDir','$swellCompDir','$swellUnit',
            '$windSpeed','$windDir','$windCompDir','$windGusts','$windUnit')";
            
            
            if ($conn->query($sql)){
                #echo "New record $orderid is inserted sucessfully <br>";
            }
            else{
                echo "Error:".$sql."<br>".$conn->error;
            }
        }
    
        $conn->close();
    }
    
}

function getSpotIds() { //this funtion goes through the table spotnames and returns the spot_id for all the rows in the table, ie spots.
    $credentials = getCredentials("surf.ini");
    $host = $credentials["host"];
    $dbusername = $credentials["dbusername"];
    $dbpassword = $credentials["dbpassword"];
    $dbname = $credentials["dbname"];
    
    $spotIdArray;
    // Create connection
    $conn = new mysqli($host,$dbusername,$dbpassword,$dbname);    
    if(mysqli_connect_error()){
            die('Connect Error ('.mysqli_connect_errno().')'.mysqli_connect_error());
    }
    else{
        $sql = "SELECT spot_id FROM spotnames";
        if ($conn->query($sql)){
            $result = $conn->query($sql);
            if ($result->num_rows > 0){ // output data of each row
                while($row = $result->fetch_assoc()) {
                    #echo ($row['spot_id']); # for future debugging purposes
                    $spotIdArray[] = $row['spot_id'];
                }
            } else {
                echo "0 results";
            }
                
        }
        else{
            echo "Error:".$sql."<br>".$conn->error;
        }
    $conn->close();
    }
    
    return $spotIdArray;
}

function getCredentials($filename) { //gets database login and table info from another file so it is all edited in one spot
    $iniFile = parse_ini_file($filename,true);
    return $iniFile["dbInfo"];
}

function updateDB() { //gets all spot_id's in table spotnames then for each spot_id calls the api and updates the table reqdata in mysql.
    $spotIds = getSpotIds(); 
    for ($index = 0; $index < count($spotIds); $index++){
        $spot_id = $spotIds[$index];
        $response = callAPI('GET',"http://magicseaweed.com/api/ad8f2245ae1d67e90d037af0dea211ff/forecast/?spot_id=$spot_id&fields=timestamp,solidRating,fadedRating,swell.absMinBreakingHeight,swell.absMaxBreakingHeight,swell.unit,swell.components.combined.*,wind.*",false);
        $responsearray = json_decode($response);

        insertReplaceDB_spot($responsearray, $spot_id);
    }
    
    
}


updateDB()


?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
</body>
</html>