<?php
//This file loads data from the MySQL DB into the current page

function getSpotIds() { //this function goes the table spotnames and returns an array of spot_id's
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
        $sql = "SELECT spot_id FROM spotnames ORDER BY state, spotname";
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

function getBackGroundColor($solidRating,$fadedRating){ //turns the MSW ratings into colors for the bar chart
    $input = $solidRating-$fadedRating;
    switch ($input) {
        case 0:
            return "rgb(91, 8, 13)";
        case 1:
            return "rgb(122, 36, 36)";
        case 2:
            return "rgb(85, 150, 92)";
        case 3:
            return "rgb(6, 186, 0)";
        case 4:
            return "rgb(224, 142, 11)";
        case 5:
            return "rgb(242, 216, 19)";
        default:
            return "rgb(91, 8, 13)";
    }
    
}

function getCredentials($filename) { //gets database login and table info from another file so it is all edited in one spot
    $iniFile = parse_ini_file($filename,true);
    return $iniFile["dbInfo"];
}

function getPageData($spotIds) { //this function gets the data for each spot_id in the array of spot_id's and then gets the row data from the mySql quert and adds it to the JSON of pageData that this function returns.  The data for each spot is stored under pageData[$Spot_id]
    $credentials = getCredentials("surf.ini");
    $host = $credentials["host"];
    $dbusername = $credentials["dbusername"];
    $dbpassword = $credentials["dbpassword"];
    $dbname = $credentials["dbname"];
    
    $pageData;
    // Create connection
    $conn = new mysqli($host,$dbusername,$dbpassword,$dbname);    
    if(mysqli_connect_error()){ //if there is an error print it
            die('Connect Error ('.mysqli_connect_errno().')'.mysqli_connect_error());
    }
    else{ //if there is no error run this query for each spot_id
        foreach ($spotIds as $spot_id){
            $sql = "SELECT orderid, DATE_FORMAT(times,'%a %m/%d %I:00%p') AS times, minBreakHeight, maxBreakHeight, height, period, swellCompDir, solidRating, fadedRating, windSpeed, windCompDir, spotname, state FROM reqdata join spotnames on reqdata.spot_id = spotnames.spot_id where reqdata.spot_id = $spot_id";
            
            
            if ($conn->query($sql)){
                $result = $conn->query($sql);
                if ($result->num_rows > 0){ // output data of each row AND create the pageData JSON
                    while($row = $result->fetch_assoc()) {
                        # put data in JSON format
                        $rowNum = $row['orderid'];
                        $pageData[$spot_id]['tableData']['times'][$rowNum] = $row['times'];
                        $pageData[$spot_id]['tableData']['avgHeight'][$rowNum] = round(($row['maxBreakHeight']+ $row['minBreakHeight'])/2,1);
                        $pageData[$spot_id]['tableData']['height'][$rowNum] = $row['height'];
                        $pageData[$spot_id]['tableData']['period'][$rowNum] = $row['period'];
                        $pageData[$spot_id]['tableData']['swellCompDir'][$rowNum] = $row['swellCompDir'];
                        $pageData[$spot_id]['tableData']['color'][$rowNum] = getBackGroundColor($row['solidRating'],$row['fadedRating']); //background color is created
                        $pageData[$spot_id]['tableData']['windSpeed'][$rowNum] = $row['windSpeed'];
                        $pageData[$spot_id]['tableData']['windCompDir'][$rowNum] = $row['windCompDir'];
                        if($rowNum == 0 ){
                            $pageData[$spot_id]['spotname'] = $row['spotname'];
                            $pageData[$spot_id]['state'] = $row['state'];
                            }
                        
                    }
                }else {
                    echo "0 results";
                }
                
            }else{
                echo "Error:".$sql."<br>".$conn->error;
            }
        
        }
    $conn->close();
    }
    #var_dump($pageData[377]['tableData']['height']); // for debugging purposes
    return $pageData;
}
?>