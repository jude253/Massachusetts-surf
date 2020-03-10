<!DOCTYPE html>
<!--for dev purposes:  eventually I will get page data from spot-clicked on-->
<?php 

require('GetData.php');

$spotIds = getSpotIds();

$pageData = getPageData($spotIds);
if(isset($_GET["spot_id"])){
    $spot_id = htmlspecialchars($_GET["spot_id"]);
}
 else {
     $spot_id = 377;
 }

$tide24hrData = getTides24hr($pageData[$spot_id]['state']);
$tideHiloData = getTidesHilo($pageData[$spot_id]['state']);
?>
<html>
<head>
    <script language="JavaScript" src="Chart.js"></script>
    <script language="JavaScript" src="FrontEnd.js"></script>
    <script language="JavaScript"> 
        var pageData = <?php echo (json_encode($pageData));?>;
        var tide24hrData = <?php echo (json_encode($tide24hrData));?>;
        var tideHiloData = <?php echo (json_encode($tideHiloData));?>;
            console.log(tide24hrData);
    </script>
    <link rel="stylesheet" href="style.css">
    <title>Spot Details Page</title>
    <meta name="Spot Details Page" descprition="Surf Forecast for MA and nearby States">
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
</head>
<body>
    <div id="pageBounds">
        
        <?php
        echo("<div >
                <div class='leftAligned'>
                    <h1 class='verticalSpacing'>".$pageData[$spot_id]['spotname'].", ".$pageData[$spot_id]['state']."</h1>
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
        
        ?>
        <div>
            <p>Tides For Today:</p>
            <div class="tideInfo smallPadding secondBackgroundColor verticalSpacing leftAligned ">
                 <canvas id="tide24hr" width="1000" height="100" ></canvas>
                <script language="JavaScript"> 
                var ctx = document.getElementById("tide24hr");  
                var myChart = new Chart(ctx,getTide24hrChartSettings(tide24hrData));

                </script>
            </div>
            
            <p>High And Low Tides For The Next 5 Days:</p>
            <div class="tideInfo smallPadding secondBackgroundColor verticalSpacing leftAligned ">
                <?php 
//                var_dump($tideHiloData);
                for($divCount = 0; $divCount < count($tideHiloData); $divCount++){
                    echo('<div class="subDiv">');
                    echo('<div class="centerHorizontally tableCenteredDiv">');
                    echo('<p class="noMargins">'.$tideHiloData[$divCount]['date'].':</p>');
                    echo('<table>');
                    for($rowCount = 0; $rowCount < count($tideHiloData[$divCount]['data']); $rowCount++){
                        echo('<tr class="fontSmaller">');
                        
                        echo('<td>'.$tideHiloData[$divCount]['data'][$rowCount]['type'].'</td>');
                        
                        echo('<td>'.$tideHiloData[$divCount]['data'][$rowCount]['hour'].'</td>');

                        echo('<td>'.$tideHiloData[$divCount]['data'][$rowCount]['tideHeight'].' ft </td>');

                        
                        
                        echo('</tr>');
                    }
                    echo('</table>');
                    echo('</div>');
                    echo('</div>');
                }
                
                ?>
            </div>
        </div>
<!--
        
        <div class="columnParent outline verticalSpacing leftAligned">
            <div class="secondBackgroundColor smallPadding column outline">
                <p>Wave Details</p>
            </div>
            <div class="secondBackgroundColor smallPadding column outline">
                <p>Wave Map</p>
            </div>
        </div>
-->
    </div>
    
</body>
</html>
