'use strict';
//this file does the ui mechanics for the index.php page
var chartIndex = 0;

function createSettingsJSON(pageData,spotid) { //this function creates the settings json that detetmines how the barcharts will be set up
                return {
                  type: 'bar',
                  data: {
                    labels: pageData[spotid]['tableData']['times'],

                    datasets: [{
                        label: 'Avg Wave Height',
                        data: pageData[spotid]['tableData']['avgHeight'],
                        backgroundColor: pageData[spotid]['tableData']['color'], // barchart background color
                        borderWidth: 1},]
                  },
                  options: {
                      title:{
                        display: true,
                        text: 'Average Wave Heights', //title
                        fontStyle: 'normal'
                    },
                    legend:{
                        display: false
                    },
                    tooltips: {
                        displayColors: false,
                        callbacks: { // floating labels on each bar chart elemnts
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
                        ticks: { //this makes it so the date labels are more or less midnight every night
                            maxTicksLimit: 5,
                            autoSkip: true
                        },
                      }]
                    }
                  }
                };
            }

function rightShiftDay(pageData) { //updates chartIndex for a day shift forward/to the right then calls the update functions for the rest of the elements that need to be updated by this function, ie, the charts, the time above the charts, the buttons that can be pressed.
    if (chartIndex < 32) {
        chartIndex= chartIndex + 8;
        updateCharts();
        displayTime(pageData);
        updateButtons();
        //console.log(chartIndex);
        return chartIndex;
    }
}

function rightShift(pageData) { //updates chartIndex for a three hour shift forward/to the right then calls the update functions for the rest of the elements that need to be updated by this function, ie, the charts, the time above the charts, the buttons that can be pressed.
    if (chartIndex !== 39) {
        chartIndex++;
        updateCharts();
        displayTime(pageData);
        updateButtons();
        //console.log(chartIndex);
        return chartIndex;
    }
}

function leftShift(pageData) { //updates chartIndex for a three hour shift backwards/to the left then calls the update functions for the rest of the elements that need to be updated by this function, ie, the charts, the time above the charts, the buttons that can be pressed.
    if (chartIndex !== 0) {
        chartIndex--;
        updateCharts();
        displayTime(pageData);
        updateButtons();
        //console.log(chartIndex);
        return chartIndex;
    }
}

function leftShiftDay(pageData) { //updates chartIndex for a day shift backwards/to the left then calls the update functions for the rest of the elements that need to be updated by this function, ie, the charts, the time above the charts, the buttons that can be pressed.
    if (chartIndex > 7) {
        chartIndex= chartIndex - 8;
        updateCharts();
        displayTime(pageData);
        updateButtons();
        //console.log(chartIndex);
        return chartIndex;
    }
}

function displayTime(pageData) { // updates the time from the pageData JSON which is created in getData.php and initialized in index.php
    document.getElementById("time").innerHTML = "Time:  " + pageData['377']['tableData']['times'][chartIndex];
}

function updateCharts() { //updates the <img> tag with the new chart that is stored in the images/file
    document.getElementById("swellMap").src = "images/mapImages/swell/"+ chartIndex + ".gif";
    document.getElementById("windMap").src = "images/mapImages/wind/"+ chartIndex + ".gif";
    document.getElementById("periodMap").src = "images/mapImages/period/"+ chartIndex + ".gif";
    document.getElementById("pressureMap").src = "images/mapImages/pressure/"+ chartIndex + ".gif";
}

function updateButtons() { //makes sure that the appropriate button is turned "unclickable" when that button reached it's scrolling limit
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