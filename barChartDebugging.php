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
    <title>Massachusetts Surf Forecast</title>
</head>
<body>
    <div>
        <div>
            <canvas id="371" width="1000" height="400" ></canvas>
            <script language="JavaScript"> 
            var ctx = document.getElementById('371');  
            var settings = {
                  type: 'bar',
                  data: {
                    labels: pageData['371']['tableData']['times'],

                    datasets: [{
                        label: 'Avg Wave Height',
                        data: pageData['371']['tableData']['avgHeight'],
                        backgroundColor: pageData['371']['tableData']['color'],
                        borderWidth: 1},]
                  },
                  options: {
                      title:{
                        display: true,
                        text: 'Average Wave Heights',
                        fontStyle: 'normal'
                    },
                    legend:{
                        display: false
                    },
                    tooltips: {
                        displayColors: false,
                        callbacks: {
                            label: function(tooltipItem, data) {
                                return 'Swell Height: ' + pageData['371']['tableData']['height'][tooltipItem.index] + " ft at " + pageData['371']['tableData']['period'][tooltipItem.index] + "s, " + pageData['371']['tableData']['swellCompDir'][tooltipItem.index];
                            },
                            afterLabel: function(tooltipItem, data) {
                                return 'Avg Wind Speed: ' + pageData['371']['tableData']['windSpeed'][tooltipItem.index] + ' mph, ' + pageData['371']['tableData']['windCompDir'][tooltipItem.index];
                            },
    
                            title: function(tooltipItem, data) {
                                return tooltipItem[0].yLabel + ' ft on ' + tooltipItem[0].xLabel;
                            }
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: true,
                    scales: {
                      yAxes: [{
                        stacked: true,
                        ticks: { 
                          beginAtZero: true
                        }
                      }],
                      xAxes: [{
//                        stacked: true,
                        ticks: {
                            autoSkip: true,
                            maxTicksLimit: 5,
                            
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