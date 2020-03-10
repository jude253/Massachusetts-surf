<!DOCTYPE html>
<?php 

require('GetData.php');




$spotIds = getSpotIds();

$pageData = getPageData($spotIds);
$tide24hrData = getTides24hr('MA');
#print_r($pageData);

?>
<html>
<head>
    <script language="JavaScript" src="Chart.js"></script>
    <script language="JavaScript" src="FrontEnd.js"></script>
    <script language="JavaScript"> 
        var pageData = <?php echo (json_encode($pageData));?>;
        var tide24hrData = <?php echo (json_encode($tide24hrData));?>;
            console.log(tide24hrData);
    </script>
    <title>Massachusetts Surf Forecast</title>
</head>
<body>
    <div>
        <div>
            <canvas id="371" width="1000" height="100" ></canvas>
            <script language="JavaScript"> 
            var ctx = document.getElementById('371');  
            var settings = {
                  type: 'line',
                  data: {
                    labels: tide24hrData['orderid'],

                    datasets: [{
                        label: 'Tide Height',
                        data: tide24hrData['tideHeight'],
                        backgroundColor: '#000000',
                        pointRadius: 0,
                        borderWidth: 1},]
                  },
                  options: {
                      title:{
                        display: false,
                        text: 'Tide Height by hour',
                        fontStyle: 'normal'
                    },
                    legend:{
                        display: false
                    },
                    tooltips: {
                        intersect: false,
                        displayColors: false,
                        callbacks: {
                            label: function(tooltipItem, data) {
                                return null;
                            },
                            title: function(tooltipItem, data) {
                                return tooltipItem[0].yLabel + ' ft at ' + tide24hrData['hour'][tooltipItem[0].xLabel];
                            }
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: true,
                    scales: {
                      yAxes: [{
                          gridLines: {
                              display: false
                          },
                          ticks: {
                              beginAtZero: true
                          }
                      }],
                      xAxes: [{
                          gridLines: {
                              display: false
                          }
                      }]
                    }
                  }
                };
            var myChart = new Chart(ctx,settings);
            
            </script>
        </div>

       
    </div>
    
</body>
</html>