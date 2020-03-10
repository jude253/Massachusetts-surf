<!DOCTYPE html>
<?php 

require('GetData.php');

$spotIds = getSpotIds();

$pageData = getPageData($spotIds);
?>
<html>
<head>
    <script language="JavaScript" src="Chart.js"></script>
    <script language="JavaScript" src="FrontEnd.js"></script>
    <script language="JavaScript"> 
        var pageData = <?php echo (json_encode($pageData));?>;
//        console.log(pageData);
    </script>
    <link rel="stylesheet" href="style.css">
    <title>Massachusetts Surf Forecast</title>
    <meta name="Massachusetts Surf Forecast" descprition="Surf Forecast for MA and nearby States">
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
</head>
<body>
    <script language="JavaScript" src="Chart.js"></script>
    <script language="JavaScript" src="FrontEnd.js"></script>
    
    <div id="pageBounds">
        <div id="header">
            <h2>Massachusetts Surf Forcasts And Nearby Spots</h2>
        </div>
        <div>
            <p id="time" >Time: <?php echo($pageData[377]['tableData']['times'][0]);?></p>
        </div>
        

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
        <div class="linkHolder">
                <a href="http://magicseaweed.com"><img src="https://im-1-uk.msw.ms/msw_powered_by.png"></a>
            </div>
        <?php
        foreach($spotIds as $spot_id){
            echo("<div >
                    <div class='spotNameBarGraph'>
                        <a href='http://localhost/test/spotDetails.php?spot_id=$spot_id'>".$pageData[$spot_id]['spotname'].", ".$pageData[$spot_id]['state']."</a>
                    </div>
                    
                    <canvas id='$spot_id' width='1000' height='400' style='background-color: #14253d;'></canvas>
                    <script language='JavaScript'> 
                    var ctx = document.getElementById('$spot_id');
                    var myChart = new Chart(ctx, createSettingsJSON(pageData,'$spot_id'));
                    </script>
                    <div class='linkHolder'>
                        <a href='http://magicseaweed.com'><img src='https://im-1-uk.msw.ms/msw_powered_by.png'></a>
                    </div>
                </div>");
            }
        
        ?>
        <div class="barContainer">
            <h2>Color Scale:</h2>
            <div class="barWrapper" id="legend">

                <div class="colorScale">
                    <div class="colorBox" style="background-color: rgb(91, 8, 13);"></div>
                    = stay out</div> 
                <div class="colorScale">
                    <div class="colorBox" style="background-color: rgb(122, 36, 36);"></div>
                    = risky</div> 
                <div class="colorScale">
                    <div class="colorBox" style="background-color: rgb(85, 150, 92);"></div>
                    = probably fine</div> 
                <div class="colorScale">
                    <div class="colorBox" style="background-color: rgb(6, 186, 0);"></div>
                    = paddle out</div> 
                <div class="colorScale">
                    <div class="colorBox" style="background-color: rgb(224, 142, 11);"></div>
                    = basically perfect</div> 
                <div class="colorScale">
                    <div class="colorBox" style="background-color: rgb(242, 216, 19);"></div>
                    = perfect</div>

            </div>

        </div>
        
    </div>
    
</body>
</html>