<!DOCTYPE html>
<?php 

require('GetData.php');




$spotIds = getSpotIds();

$pageData = getPageData($spotIds);
#print_r($pageData);
?>
<html>
<head>
    <script language="JavaScript" src="Chart.js"></script>
    <script language="JavaScript" src="FrontEnd.js"></script>
    <script language="JavaScript"> 
        var pageData = <?php echo (json_encode($pageData));?>;
        console.log(pageData);
    </script>
    <link rel="stylesheet" href="style.css">
    <title>Massachusetts Surf Forecast</title>
</head>
<body>
    <script language="JavaScript" src="Chart.js"></script>
    <script language="JavaScript" src="FrontEnd.js"></script>
    <div id="pageBounds">
        <p id="time">Time: <?php echo($pageData[377]['tableData']['times'][0]);?></p>

        <div class="buttonHolder">
            <div class="buttonRow">
                <button id="leftDay" class="endOfList" onclick="leftShiftDay(pageData)">- day</button>
                <button id="left" class="endOfList" onclick="leftShift(pageData)">- 3hrs</button>
            </div>
            <div class="buttonRow">
                <button id="right" onclick="rightShift(pageData)">+ 3hrs</button>
                <button id="rightDay" onclick="rightShiftDay(pageData)">+ day</button>
            </div>
          
          
        </div>
        <div id="mapWindow">
            <div class="mapRow">
                <div class="mapContainer">
                    <img class="map" id="swellMap" src="images/mapImages/swell/0.gif" alt="Swell Map" height="100%" width="100%">
                </div>
                <div class="mapContainer">
                    <img class="map" id="windMap" src="images/mapImages/wind/0.gif" alt="Wind Map" height="100%" width="100%">
                </div>
                
            </div>
            <div class="mapRow">
                <div class="mapContainer">
                    <img class="map" id="periodMap" src="images/mapImages/period/0.gif" alt="Period Map" height="100%" width="100%">
                </div>
                <div class="mapContainer">
                    <img class="map" id="pressureMap" src="images/mapImages/pressure/0.gif" alt="Pressure Map" height="100%" width="100%">
                </div>
                
            </div>
            
        </div>
        
<!--
        <div>
            <canvas id="377" width="1000" height="400" ></canvas>
            <script language="JavaScript"> 
                
            var ctx = document.getElementById('377');
            var spotid = '377';
            var myChart = new Chart(ctx, createSettingsJSON(testData,spotid));
            </script>
        </div>
        <div>
            <canvas id="371" width="1000" height="400" ></canvas>
            <script language="JavaScript"> 
            var ctx = document.getElementById('371');  
            console.log(createSettingsJSON(testData,'371'));
            var myChart = new Chart(ctx, createSettingsJSON(testData,'371'));
            </script>
        </div>
-->
        <?php
        foreach($spotIds as $spot_id){
            echo("<div >
                    <div style='background-color: #14253d; max-width: 30%; padding: 5px 0 5px 15px; margin-top: 20px;  margin-bottom: 10px;'>
                        <p >".$pageData[$spot_id]['spotname'].", ".$pageData[$spot_id]['state']."</p>
                    </div>
                    
                    <canvas id='$spot_id' width='1000' height='400' style='background-color: #14253d;'></canvas>
                    <script language='JavaScript'> 
                    var ctx = document.getElementById('$spot_id');
                    var myChart = new Chart(ctx, createSettingsJSON(pageData,'$spot_id'));
                    </script>
                </div>");
            }
        
        ?>
    </div>
    
</body>
</html>