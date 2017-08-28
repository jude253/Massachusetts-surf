'use strict';
var chartIndex = 0;
var responseLongBeach = [];
var dateTime = new Date();

$.ajax({
    url: "http://magicseaweed.com/api/ad8f2245ae1d67e90d037af0dea211ff/forecast/?spot_id=368&fields=charts.*,timestamp,fadedRating,solidRating,swell.*",
 
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

        
        for(var i = 0; i < response.length; i ++) { // store the response in this file
            //console.log(response[i])
            responseLongBeach.push(response[i]);
        }
        
        responseLongBeach.push({id: "longBeach"},{name: "Long Beach"})
        /*responseLongBeach[0]["solidRating"] = 5; for testing the colors
        responseLongBeach[1]["solidRating"] = 5;
        responseLongBeach[2]["solidRating"] = 4;
        responseLongBeach[3]["solidRating"] = 4;
        responseLongBeach[4]["solidRating"] = 3;
        responseLongBeach[5]["solidRating"] = 3;
        responseLongBeach[6]["solidRating"] = 2;
        responseLongBeach[7]["solidRating"] = 2;*/
        // server response
        barMaker(responseLongBeach); // set up bar graph
    }
});

console.log(responseLongBeach); // to make sure HTTP response is saved in this file

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

function convertTime(unix) {
     dateTime.setTime(unix * 1000);
    var miltHours = dateTime.getHours();
    var hours = "";
    if (miltHours > 12) {
        hours = String(miltHours - 12) + ":00 PM";
    }
    if (miltHours <= 12) {
        hours = String(miltHours) + ":00 AM";
    }
    return String(dateTime.getMonth() + 1) + "/" + dateTime.getDate() + "/" + dateTime.getFullYear() + " " + hours;
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

function roundTo(n, digits) {
     if (digits === undefined) {
       digits = 0;
     }

     var multiplicator = Math.pow(10, digits);
     n = parseFloat((n * multiplicator).toFixed(11));
     var test =(Math.round(n) / multiplicator);
     return +(test.toFixed(digits));
   }


//bar graph area:

//to do: separate data creation and graph set up... pass data though as parameters
//also figure out how to make 1) correct aspect ratios 2) resizable

function dataFinder(response) { // get the data in array for chart.js from JSON format
    var data = [];
    for(var i = 0; i < 40; i++) {
        data.push(roundTo((response[i]["swell"]["absMaxBreakingHeight"] + response[i]["swell"]["absMinBreakingHeight"]) / 2, 2));
    }
    return data;
    
}

function labelFinder(response) { // get the time and date labels in array for chart.js from JSON
    var labels = [];
    for(var i = 0; i < 40; i++) {
        labels.push(convertTime(response[i]["timestamp"]));
    }
    return labels;
}

function ratingFinder(response) {
    var ratings = [];
    for(var i = 0; i < 40; i++) {
        //console.log(response[i]["solidRating"] - response[i]["fadedRating"]);
        if (response[i]["solidRating"] - response[i]["fadedRating"] >= 0) {
            ratings.push(response[i]["solidRating"] - response[i]["fadedRating"]);
        }
        else {
            ratings.push(0);
        }
    }
    return ratings;
}

function colorFinder(response) {
    var ratings = [];
    var colorRatings = [];
    ratings = ratingFinder(response);
    //console.log(ratings);
    
    for (var i = 0; i < 40; i++) {
        //console.log(ratings[i]);
        switch (ratings[i]) {
            case 0:
                colorRatings.push("rgba(142, 15, 15, 0.3)");
                break;
            case 1:
                colorRatings.push("rgb(122, 36, 36)");
                break;
            case 2:
                colorRatings.push("rgb(85, 150, 92)");
                break;
            case 3:
                colorRatings.push("rgb(6, 186, 0)");
                break;
            case 4:
                colorRatings.push("rgb(224, 142, 11)");
                break;
            case 5:
                colorRatings.push("rgb(242, 216, 19)");
}
    }
    
    return colorRatings;
    
}

function barMaker(response) {
    var dataResponse = [];
    var labelsResponse = [];
    var ratingsResponse = [];
    var colorResponse = [];
    var id = response[40]["id"]; //id of the information coming in so I can easily resuse this funct
    var name = response[41]["name"]; // just in case I need it
    
    
    ratingsResponse = ratingFinder(response);
    dataResponse = dataFinder(response);
    labelsResponse = labelFinder(response);
    colorResponse = colorFinder(response);
    
    //console.log(colorResponse);
    console.log(id + " " + name); // to figure out where the problems are coming from

    var ctx = document.getElementById(id).getContext("2d");

    var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: labelsResponse,
        
        datasets: [{
          label: '= Avg Wave Height',
          data: dataResponse,
          backgroundColor: colorResponse,
          borderWidth: 1},]
      },
      options: {
        responsive: true,
        maintainAspectRatio: true,
        scales: {
          yAxes: [{
            stacked: true,
            ticks: { 
              beginAtZero:true
            }
          }],
          xAxes: [{
            stacked: true,
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
    
        // to make the scale visible when mouse hovers over
    $("#swellMap").hover(function() {
        $(document).mousemove(function(event) {
            $(".swell").show();
            $("img.swell").css({position:"absolute", "left":event.pageX, "top":event.pageY}).show();    
        });    
    }, function() {
        $(document).unbind("mousemove");
        $("img.swell").hide();
        
    });

        //end movement with click
    $(document).bind("click",function(){
        $(document).unbind("mousemove");
            $("img.swell").hide();
    });
    
    $("#windMap").hover(function() {
        $(document).mousemove(function(event) {
            $("img.wind").css({position:"absolute", "left":event.pageX, "top":event.pageY     }).show();    
        });    
    }, function() {
        $(document).unbind("mousemove");
        $("img.wind").hide();
        
    });
    
            //end movement with click
    $(document).bind("click",function(){
        $(document).unbind("mousemove");
            $("img.wind").hide();
    });
    
    $("#periodMap").hover(function() {
        $(document).mousemove(function(event) {
            $("img.period").css({position:"absolute", "left":event.pageX, "top":event.pageY     }).show();    
        });    
    }, function() {
        $(document).unbind("mousemove");
        $("img.period").hide();
        
    });

        //end movement with click
    $(document).bind("click",function(){
        $(document).unbind("mousemove");
            $("img.period").hide();
    });

    $("#pressureMap").hover(function() {
        $(document).mousemove(function(event) {
            $("img.pressure").css({position:"absolute", "left":event.pageX, "top":event.pageY     }).show();    
        });    
    }, function() {
        $(document).unbind("mousemove");
        $("img.pressure").hide();
        
    });

        //end movement with click
    $(document).bind("click",function(){
        $(document).unbind("mousemove");
            $("img.pressure").hide();
    });
    
    
 
});