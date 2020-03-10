<?php 




function getSpotIds() {
    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "gfjl6v9q";
    $dbname = "surf";
    
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

function getPageData($spotIds) {
    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "gfjl6v9q";
    $dbname = "surf";
    
    $pageData;
    // Create connection
    $conn = new mysqli($host,$dbusername,$dbpassword,$dbname);    
    if(mysqli_connect_error()){
            die('Connect Error ('.mysqli_connect_errno().')'.mysqli_connect_error());
    }
    else{
        foreach ($spotIds as $spot_id){
            $sql = "SELECT orderid, times, height, period, spotname, state FROM reqdata join spotnames on reqdata.spot_id = spotnames.spot_id where reqdata.spot_id = $spot_id";
            if ($conn->query($sql)){
                $result = $conn->query($sql);
                if ($result->num_rows > 0){ // output data of each row
                    while($row = $result->fetch_assoc()) {
                        # put data in JSON format
                        $rowNum = $row['orderid'];
                        $pageData[$spot_id]['tableData'][$rowNum]['times'] = $row['times'];
                        $pageData[$spot_id]['tableData'][$rowNum]['height'] = $row['height'];
                        $pageData[$spot_id]['tableData'][$rowNum]['period'] = $row['period'];
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
    
    return $pageData;
}
$spotIds = getSpotIds();

$pageData = getPageData($spotIds);
#print_r($pageData);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Massachusetts Surf Forecast</title>
</head>
<body>
    <div>
        <?php
        foreach($spotIds as $spot_id){
            echo("<p>".$pageData[$spot_id]['spotname']."</p>");
                for($orderid = 0; $orderid < 40; $orderid++){
                    $times = $pageData[$spot_id]['tableData'][$orderid]['times'];
                    $height = $pageData[$spot_id]['tableData'][$orderid]['height'];
                    $period = $pageData[$spot_id]['tableData'][$orderid]['period'];
                    echo("<p> $times $height $period</p>");
                }
            }
        
        ?>
    </div>
</body>
</html>