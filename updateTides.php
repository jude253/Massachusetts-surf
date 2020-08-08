<?php
//I am sure that the time_zone on this page will need some considerstions when being sent from my server.  The server is 2hrs behind east coast.

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
//    var_dump($url);
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
    
    //if needed to see raw response, use the following line:
    #print_r(json_decode($result));
   if(!$result){die("Connection Failure");}
   curl_close($curl);
   return $result;
}

function insertReplaceTide24hr($responsearray, $stationid, $state) { //inserts or replaces all (0-24) rows of data for given stationid (response is API resonse from NOAA)
    $credentials = getCredentials("surf.ini");
    $host = $credentials["host"];
    $dbusername = $credentials["dbusername"];
    $dbpassword = $credentials["dbpassword"];
    $dbname = $credentials["dbname"];
    $table = "tide24hr";
    
    // Create connection to mySQL database
    $conn = new mysqli($host,$dbusername,$dbpassword,$dbname);
        
    if(mysqli_connect_error()){
        die('Connect Error ('.mysqli_connect_errno().')'.mysqli_connect_error());
    }
    else{
        for ($orderid = 0; $orderid < 24; $orderid++){ //for each datapoint returned or each hour in a day
            $times = $responsearray["predictions"][$orderid]["t"];
            echo($responsearray["predictions"][$orderid]["t"]);
            $tideHeight = round($responsearray["predictions"][$orderid]["v"],2);
            
            echo($tideHeight);
            #This query will instert the 24 rows from station into tide24hr, if it is already in table, it will update the data already there
            #in req table primary key = (state,orderid), so each state/station will only have 24 rows.
            
            $sql = "INSERT INTO $table (stationid,state,orderid,times,tideHeight)
            
            values 
            
            ('$stationid','$state','$orderid','$times','$tideHeight') 
            
            ON DUPLICATE KEY UPDATE 
            
            stationid = '$stationid',
            state = '$state',
            orderid = '$orderid',
            times = '$times',
            tideHeight = '$tideHeight'";
            
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

function insertReplaceTideHilo($responsearray, $stationid, $state) { //inserts or replaces all (0-24) rows of data for given stationid (response is API resonse from NOAA)
    $credentials = getCredentials("surf.ini");
    $host = $credentials["host"];
    $dbusername = $credentials["dbusername"];
    $dbpassword = $credentials["dbpassword"];
    $dbname = $credentials["dbname"];
    $table = "tidehilo";
    
    // Create connection to mySQL database
    $conn = new mysqli($host,$dbusername,$dbpassword,$dbname);
        
    if(mysqli_connect_error()){
        die('Connect Error ('.mysqli_connect_errno().')'.mysqli_connect_error());
    }
    else{
        for ($orderid = 0; $orderid < count($responsearray["predictions"]); $orderid++){ //for each datapoint returned or each hour in a day
            $times = $responsearray["predictions"][$orderid]["t"];
            $tideHeight = round($responsearray["predictions"][$orderid]["v"],2);
            $type = $responsearray["predictions"][$orderid]["type"];
            
            echo($tideHeight);
            #This query will instert the 24 rows from station into tide24hr, if it is already in table, it will update the data already there
            #in req table primary key = (state,orderid), so each state/station will only have 24 rows.
            
            $sql = "INSERT INTO $table (stationid,state,orderid,times,tideHeight,type)
            
            values 
            
            ('$stationid','$state','$orderid','$times','$tideHeight','$type') 
            
            ON DUPLICATE KEY UPDATE 
            
            stationid = '$stationid',
            state = '$state',
            orderid = '$orderid',
            times = '$times',
            tideHeight = '$tideHeight',
            type = '$type'";
            
            if ($conn->query($sql)){
                echo "New hilo record $orderid is inserted sucessfully <br>";
            }
            else{
                echo "Error:".$sql."<br>".$conn->error;
            }
        }
    
        $conn->close();
    }
    
}

function deleteRowsTideHilo() { //deletes all rows in $table = tidehilo
    $credentials = getCredentials("surf.ini");
    $host = $credentials["host"];
    $dbusername = $credentials["dbusername"];
    $dbpassword = $credentials["dbpassword"];
    $dbname = $credentials["dbname"];
    $table = "tidehilo";
    
    // Create connection to mySQL database
    $conn = new mysqli($host,$dbusername,$dbpassword,$dbname);
        
    if(mysqli_connect_error()){
        die('Connect Error ('.mysqli_connect_errno().')'.mysqli_connect_error());
    }
    else{   
            $sql = "DELETE FROM $table"; //delete 
            
            if ($conn->query($sql)){
                echo "Successfully deleted $table <br>";
            }
            else{
                echo "Error:".$sql."<br>".$conn->error;
            }

    
        $conn->close();
    }
    
}

function getCredentials($filename) { //gets database login and table info from another file so it is all edited in one spot
    $iniFile = parse_ini_file($filename,true);
    return $iniFile["dbInfo"];
}

function getStationIds() { //this funtion goes through the table states and returns the state and stationid for all the rows.
    $credentials = getCredentials("surf.ini");
    $host = $credentials["host"];
    $dbusername = $credentials["dbusername"];
    $dbpassword = $credentials["dbpassword"];
    $dbname = $credentials["dbname"];
    
    $stateStationMap;
    // Create connection
    $conn = new mysqli($host,$dbusername,$dbpassword,$dbname);    
    if(mysqli_connect_error()){
            die('Connect Error ('.mysqli_connect_errno().')'.mysqli_connect_error());
    }
    else{
        $sql = "SELECT state, stationid FROM states";
        if ($conn->query($sql)){
            $result = $conn->query($sql);
            if ($result->num_rows > 0){ // output data of each row
                while($row = $result->fetch_assoc()) {
                    #echo ($row['spot_id']); # for future debugging purposes
                    $stateStationMap[$row['state']] = $row['stationid'];
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
    
    return $stateStationMap;
}

function updateTide24hr(){
    $stateStationMap = getStationIds(); //gets map from Mysql with State as key and stationid as value

    foreach ($stateStationMap as $state => $stationid) {
        $data24Hr = array(
            'begin_date' => date("Ymd"),
            'range' => '24',
            'station' => $stationid,
            'product' => 'predictions',
            'datum' => 'MLLW',
            'interval' => 'h',
            'units' => 'english',
            'time_zone' => 'lst_ldt',
            'application' => 'surfcheckmass',
            'format' => 'json'
        );
        
        //NOTE: had to change api endpoint url from https://tidesandcurrents.noaa.gov/api/datagetter to https://api.tidesandcurrents.noaa.gov/api/prod/datagetter
        $response = json_decode(callAPI('GET',"https://api.tidesandcurrents.noaa.gov/api/prod/datagetter", $data24Hr),true);

        //leaving the var dump below incase of future issues
        #var_dump($response,true);
        
        insertReplaceTide24hr($response,$stationid,$state);

    }
    
    
    
}


//figure out what is really different between all of the processes, make it so all the different parts are easy to access and change. ie queries and api calls

function updateTideHilo(){
    $stateStationMap = getStationIds(); //gets map from Mysql with State as key and stationid as value

    deleteRowsTideHilo(); //because there are varying amounts of tides for the next 5 days, delete all rows previously in table to avoid extra datapoints
    foreach ($stateStationMap as $state => $stationid) {
        $datahilo = array(
            'begin_date' => date("Ymd"),
            'range' => '120',
            'station' => $stationid,
            'product' => 'predictions',
            'datum' => 'MLLW',
            'interval' => 'hilo',
            'units' => 'english',
            'time_zone' => 'lst_ldt',
            'application' => 'surfcheckmass',
            'format' => 'json'

        );

        
        //NOTE: had to change api endpoint url from https://tidesandcurrents.noaa.gov/api/datagetter to https://api.tidesandcurrents.noaa.gov/api/prod/datagetter
        $response = json_decode(callAPI('GET',"https://api.tidesandcurrents.noaa.gov/api/prod/datagetter", $datahilo),true);
        
        //leaving the var dump below incase of future issues
        #var_dump($response,true);
        
        insertReplaceTideHilo($response,$stationid,$state);
        

    }
}
       

updateTideHilo();
updateTide24hr();