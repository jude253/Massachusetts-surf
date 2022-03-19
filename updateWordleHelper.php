<?php 


function updatePageLoadCount() { //this funtion goes through the table spotnames and returns the spot_id for all the rows in the table, ie spots.
    $credentials = getCredentials("wordle.ini");
    $host = $credentials["host"];
    $dbusername = $credentials["dbusername"];
    $dbpassword = $credentials["dbpassword"];
    $dbname = $credentials["dbname"];
    
    // Create connection
    $conn = new mysqli($host,$dbusername,$dbpassword,$dbname);    
    if(mysqli_connect_error()){
            die('Connect Error ('.mysqli_connect_errno().')'.mysqli_connect_error());
    }
    else{
        $sql = "update count_of_page_loads set page_load_count = page_load_count + 1";
        if ($conn->query($sql)){
            echo "Update successful";
                
        }
        else{
            echo "Error:".$sql."<br>".$conn->error;
        }
    $conn->close();
    }
    
    return null;
}

function getCredentials($filename) { //gets database login and table info from another file so it is all edited in one spot
    $iniFile = parse_ini_file($filename,true);
    return $iniFile["dbInfoWordle"];
}


updatePageLoadCount()


?>