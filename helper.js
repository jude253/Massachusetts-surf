'use strict';
var chartIndex = 0;
var responseLongBeach = [];
var dateTime = new Date();

$.ajax({
    url: "http://magicseaweed.com/api/ad8f2245ae1d67e90d037af0dea211ff/forecast/?spot_id=368&fields=charts.*,timestamp,swell.*",
 
    // The name of the callback parameter, as specified by the YQL service
    jsonp: "callback",
 
    // Tell jQuery we're expecting JSONP
    dataType: "jsonp",
 
    // Tell YQL what we want and that we want JSON/ wtf does this even mean
    data: {
        q: "charts and data to Long Beach Gloucester",
        format: "json"
    },
 
    // Work with the response
    success: function( response ) {
        //console.log( response );  // this is just in case
        
        
        //responseLongBeach = response;
        setUpCharts(response);// set up the charts
        barMaker(response); // set up bar graph
        
        for(var i = 0; i < response.length; i ++) { // store the response in this file
            responseLongBeach.push(response[i]);
        }
        // server response
    }
});


console.log(responseLongBeach);

function setUpCharts(response) {
        document.getElementById("swellMap").src = response[chartIndex]["charts"]["swell"];
        document.getElementById("windMap").src = response[chartIndex]["charts"]["wind"];
        document.getElementById("periodMap").src = response[chartIndex]["charts"]["period"];
        document.getElementById("pressureMap").src = response[chartIndex]["charts"]["pressure"];
        displayTime(response, chartIndex);
}


function rightShift(response) { // so the charts can scroll to the right
    if (chartIndex !== 39) {
        chartIndex++;
        document.getElementById("swellMap").src = response[chartIndex]["charts"]["swell"];
        document.getElementById("windMap").src = response[chartIndex]["charts"]["wind"];
        document.getElementById("periodMap").src = response[chartIndex]["charts"]["period"];
        document.getElementById("pressureMap").src = response[chartIndex]["charts"]["pressure"];
        displayTime(response, chartIndex);
        if (document.getElementById("left").classList.contains("endOfList")) {
            document.getElementById("left").classList.remove("endOfList");
        }
        if (chartIndex === 39) {
            document.getElementById("right").classList.add("endOfList");
        }
        return chartIndex;
    }
}

function leftShift(response) { // so the chart can scroll to the left
    if (chartIndex !== 0) {
        chartIndex--;
        document.getElementById("swellMap").src = response[chartIndex]["charts"]["swell"];
        document.getElementById("windMap").src = response[chartIndex]["charts"]["wind"];
        document.getElementById("periodMap").src = response[chartIndex]["charts"]["period"];
        document.getElementById("pressureMap").src = response[chartIndex]["charts"]["pressure"];
        displayTime(response, chartIndex);
        if (document.getElementById("right").classList.contains("endOfList")) {
            document.getElementById("right").classList.remove("endOfList");
        }
        if (chartIndex === 0) {
            document.getElementById("left").classList.add("endOfList");
        }
        return chartIndex;
    }
}

function displayTime(response, number) { // to update the time from the charts & convert from unix
    dateTime.setTime(response[number]["timestamp"] * 1000);
    var miltHours = dateTime.getHours();
    var hours = "";
    if (miltHours > 12) {
        hours = String(miltHours - 12) + ":00 PM";
    }
    if (miltHours <= 12) {
        hours = String(miltHours) + ":00 AM";
    }
    document.getElementById("time").innerHTML = "Time:  " + hours + "  " + String(dateTime.getMonth() + 1) + "/" + dateTime.getDate() + "/" + dateTime.getFullYear();
}

//bar graph area:

//to do: separate data creation and graph set up... pass data though as parameters
//also figure out how to make 1) correct aspect ratios 2) resizable

function barMaker(response) {
    var dataResponse = [];
    var labelsResponse = [];
    for(var i = 0; i < response.length; i++) {
        console.log(response[i]);
        dataResponse.push(response[i]["swell"]["absMaxBreakingHeight"]);
        labelsResponse.push(response[i]["timestamp"])
    }
    
    console.log(dataResponse);

    var ctx = document.getElementById("myChart").getContext("2d");

    var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: labelsResponse,
        datasets: [{
          label: '= Wave heights',
          data: dataResponse,
          backgroundColor: 'rgba(0, 0, 0, 1)',
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: true,
        scales: {
          yAxes: [{
            ticks: { 
              beginAtZero:true
            }
          }]
        }
      }
    });
    
}

$(document).ready(function () {
    $("button").mouseenter(function () {
        //$(this).fadeTo("fast", 0.5);
        $(this).addClass("hover");
    });
    
    $("button").mouseleave(function () {
        //$(this).fadeTo("fast", 1);
        $(this).removeClass("hover");
    });
    
    /*$("#left").click(function () { \\ not working jQuery UI stuff
        $("#left").effect("bounce", {time: 3}, 500);
        if (chartIndex === 0) {
            alert("got it");
            
        }
        
    });*/
});