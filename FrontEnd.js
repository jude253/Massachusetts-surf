'use strict';
var chartIndex = 0;

function createSettingsJSON(pageData,spotid) {
                return {
                  type: 'bar',
                  data: {
                    labels: pageData[spotid]['tableData']['times'],

                    datasets: [{
                        label: 'Avg Wave Height',
                        data: pageData[spotid]['tableData']['avgHeight'],
                        backgroundColor: pageData[spotid]['tableData']['color'],
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
                                return 'Swell Height: ' + pageData[spotid]['tableData']['height'][tooltipItem.index] + " ft at " + pageData[spotid]['tableData']['period'][tooltipItem.index] + "s, " + pageData[spotid]['tableData']['swellCompDir'][tooltipItem.index];
                            },
                            afterLabel: function(tooltipItem, data) {
                                return 'Avg Wind Speed: ' + pageData[spotid]['tableData']['windSpeed'][tooltipItem.index] + ' mph, ' + pageData[spotid]['tableData']['windCompDir'][tooltipItem.index];
                            },
    
                            title: function(tooltipItem, data) {
//                                return tooltipItem[0].xLabel;
                                return tooltipItem[0].yLabel + ' ft on ' + tooltipItem[0].xLabel;
                            }
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: true,
                    scales: {
                      yAxes: [{
                        ticks: { 
                          beginAtZero: true
                        }
                      }],
                      xAxes: [{
                        ticks: {
                            maxTicksLimit: 5,
                            autoSkip: true
                        },
                      }]
                    }
                  }
                };
            }

function rightShiftDay(pageData) {
    if (chartIndex < 32) {
        chartIndex= chartIndex + 8;
        updateCharts();
        displayTime(pageData);
        updateButtons();
        //console.log(chartIndex);
        return chartIndex;
    }
}

function rightShift(pageData) { // so the charts can scroll to the right
    if (chartIndex !== 39) {
        chartIndex++;
        updateCharts();
        displayTime(pageData);
        updateButtons();
        //console.log(chartIndex);
        return chartIndex;
    }
}

function leftShift(pageData) { // so the chart can scroll to the left
    if (chartIndex !== 0) {
        chartIndex--;
        updateCharts();
        displayTime(pageData);
        updateButtons();
        //console.log(chartIndex);
        return chartIndex;
    }
}

function leftShiftDay(pageData) { // so the chart can scroll to the left
    if (chartIndex > 7) {
        chartIndex= chartIndex - 8;
        updateCharts();
        displayTime(pageData);
        updateButtons();
        //console.log(chartIndex);
        return chartIndex;
    }
}

function displayTime(pageData) { // to update the time from the charts & convert from unix
    document.getElementById("time").innerHTML = "Time:  " + pageData['377']['tableData']['times'][chartIndex];
}

function updateCharts() {
    document.getElementById("swellMap").src = "images/mapImages/swell/"+ chartIndex + ".gif";
    document.getElementById("windMap").src = "images/mapImages/wind/"+ chartIndex + ".gif";
    document.getElementById("periodMap").src = "images/mapImages/period/"+ chartIndex + ".gif";
    document.getElementById("pressureMap").src = "images/mapImages/pressure/"+ chartIndex + ".gif";
}

function updateButtons() {
    if (chartIndex === 0) {
            document.getElementById("left").classList.add("endOfList");
    } else{
        document.getElementById("left").classList.remove("endOfList");
    }
    if (chartIndex === 39) {
        document.getElementById("right").classList.add("endOfList");
    }else {
        document.getElementById("right").classList.remove("endOfList");
    }
    if (chartIndex >= 32) {
        document.getElementById("rightDay").classList.add("endOfList");
    } else {
        document.getElementById("rightDay").classList.remove("endOfList");
    }
    if (chartIndex >= 8){
        document.getElementById("leftDay").classList.remove("endOfList");
    } else {
        document.getElementById("leftDay").classList.add("endOfList");
    }
}