'use strict';
var responseMatunuck = [];
var responseNahant = [];
var responseCapeCod = [];
var responseSecondBeach = [];
var responseRye = [];
var responseNarragansett = [];
var responseRuggles = [];
var responseTheWall = [];
var responseKennebunk = [];
var responseNantasket = [];

$.ajax({
    url: "http://magicseaweed.com/api/ad8f2245ae1d67e90d037af0dea211ff/forecast/?spot_id=377&fields=charts.*,timestamp,fadedRating,solidRating,swell.*,wind.*",
 
    // The name of the callback parameter, as specified by the YQL service
    jsonp: "callback",
 
    // Tell jQuery we're expecting JSONP
    dataType: "jsonp",
 
    // Tell YQL what we want and that we want JSON/ wtf does this even mean
    data: {
        q: "charts and data to Matunuck Ri",
        format: "json"
    },
 
    // Work with the response
    success: function( response ) {
        //console.log( response );  // this is just in case
        
        

        
        for(var i = 0; i < response.length; i ++) { // store the response in this file
            //console.log(response[i])
            responseMatunuck.push(response[i]);
        }
        
        responseMatunuck.push({id: "matunuck"},{name: "Matunuck"})
        // server response
        barMaker(responseMatunuck); // set up bar graph
    }
});

$.ajax({
    url: "http://magicseaweed.com/api/ad8f2245ae1d67e90d037af0dea211ff/forecast/?spot_id=1091&fields=charts.*,timestamp,fadedRating,solidRating,swell.*,wind.*",
 
    // The name of the callback parameter, as specified by the YQL service
    jsonp: "callback",
 
    // Tell jQuery we're expecting JSONP
    dataType: "jsonp",
 
    // Tell YQL what we want and that we want JSON/ wtf does this even mean
    data: {
        q: "charts and data to Nahant Ma",
        format: "json"
    },
 
    // Work with the response
    success: function( response ) {
        //console.log( response );  // this is just in case
        
        

        
        for(var i = 0; i < response.length; i ++) { // store the response in this file
            //console.log(response[i])
            responseNahant.push(response[i]);
        }
        
        responseNahant.push({id: "nahant"},{name: "Nahant"})
        // server response
        barMaker(responseNahant); // set up bar graph
    }
});

$.ajax({
    url: "http://magicseaweed.com/api/ad8f2245ae1d67e90d037af0dea211ff/forecast/?spot_id=373&fields=charts.*,timestamp,fadedRating,solidRating,swell.*,wind.*",
 
    // The name of the callback parameter, as specified by the YQL service
    jsonp: "callback",
 
    // Tell jQuery we're expecting JSONP
    dataType: "jsonp",
 
    // Tell YQL what we want and that we want JSON/ wtf does this even mean
    data: {
        q: "charts and data to Cape Cod Ma",
        format: "json"
    },
 
    // Work with the response
    success: function( response ) {
        //console.log( response );  // this is just in case
        
        

        
        for(var i = 0; i < response.length; i ++) { // store the response in this file
            //console.log(response[i])
            responseCapeCod.push(response[i]);
        }
        
        responseCapeCod.push({id: "capeCod"},{name: "Cape Cod"})
        // server response
        barMaker(responseCapeCod); // set up bar graph
    }
});

$.ajax({
    url: "http://magicseaweed.com/api/ad8f2245ae1d67e90d037af0dea211ff/forecast/?spot_id=846&fields=charts.*,timestamp,fadedRating,solidRating,swell.*,wind.*",
 
    // The name of the callback parameter, as specified by the YQL service
    jsonp: "callback",
 
    // Tell jQuery we're expecting JSONP
    dataType: "jsonp",
 
    // Tell YQL what we want and that we want JSON/ wtf does this even mean
    data: {
        q: "charts and data to Second Beach Ri",
        format: "json"
    },
 
    // Work with the response
    success: function( response ) {
        //console.log( response );  // this is just in case
        
        

        
        for(var i = 0; i < response.length; i ++) { // store the response in this file
            //console.log(response[i])
            responseSecondBeach.push(response[i]);
        }
        
        responseSecondBeach.push({id: "secondBeach"},{name: "Second Beach"})
        // server response
        barMaker(responseSecondBeach); // set up bar graph
    }
});

$.ajax({
    url: "http://magicseaweed.com/api/ad8f2245ae1d67e90d037af0dea211ff/forecast/?spot_id=368&fields=charts.*,timestamp,fadedRating,solidRating,swell.*,wind.*",
 
    // The name of the callback parameter, as specified by the YQL service
    jsonp: "callback",
 
    // Tell jQuery we're expecting JSONP
    dataType: "jsonp",
 
    // Tell YQL what we want and that we want JSON/ wtf does this even mean
    data: {
        q: "charts and data to Rye Rocks Nh",
        format: "json"
    },
 
    // Work with the response
    success: function( response ) {
        //console.log( response );  // this is just in case
        
        

        
        for(var i = 0; i < response.length; i ++) { // store the response in this file
            //console.log(response[i])
            responseRye.push(response[i]);
        }
        
        responseRye.push({id: "rye"},{name: "Rye"})
        // server response
        barMaker(responseRye); // set up bar graph
    }
});

$.ajax({
    url: "http://magicseaweed.com/api/ad8f2245ae1d67e90d037af0dea211ff/forecast/?spot_id=1103&fields=charts.*,timestamp,fadedRating,solidRating,swell.*,wind.*",
 
    // The name of the callback parameter, as specified by the YQL service
    jsonp: "callback",
 
    // Tell jQuery we're expecting JSONP
    dataType: "jsonp",
 
    // Tell YQL what we want and that we want JSON/ wtf does this even mean
    data: {
        q: "charts and data to Narragansett Ri",
        format: "json"
    },
 
    // Work with the response
    success: function( response ) {
        //console.log( response );  // this is just in case
        
        

        
        for(var i = 0; i < response.length; i ++) { // store the response in this file
            //console.log(response[i])
            responseNarragansett.push(response[i]);
        }
        
        responseNarragansett.push({id: "narragansett"},{name: "Narragansett"})
        // server response
        barMaker(responseNarragansett); // set up bar graph
    }
});

$.ajax({
    url: "http://magicseaweed.com/api/ad8f2245ae1d67e90d037af0dea211ff/forecast/?spot_id=374&fields=charts.*,timestamp,fadedRating,solidRating,swell.*,wind.*",
 
    // The name of the callback parameter, as specified by the YQL service
    jsonp: "callback",
 
    // Tell jQuery we're expecting JSONP
    dataType: "jsonp",
 
    // Tell YQL what we want and that we want JSON/ wtf does this even mean
    data: {
        q: "charts and data to Ruggles Ri",
        format: "json"
    },
 
    // Work with the response
    success: function( response ) {
        //console.log( response );  // this is just in case
        
        

        
        for(var i = 0; i < response.length; i ++) { // store the response in this file
            //console.log(response[i])
            responseRuggles.push(response[i]);
        }
        
        responseRuggles.push({id: "ruggles"},{name: "Ruggles"})
        // server response
        barMaker(responseRuggles); // set up bar graph
    }
});

$.ajax({
    url: "http://magicseaweed.com/api/ad8f2245ae1d67e90d037af0dea211ff/forecast/?spot_id=369&fields=charts.*,timestamp,fadedRating,solidRating,swell.*,wind.*",
 
    // The name of the callback parameter, as specified by the YQL service
    jsonp: "callback",
 
    // Tell jQuery we're expecting JSONP
    dataType: "jsonp",
 
    // Tell YQL what we want and that we want JSON/ wtf does this even mean
    data: {
        q: "charts and data to The Wall Nh",
        format: "json"
    },
 
    // Work with the response
    success: function( response ) {
        //console.log( response );  // this is just in case
        
        

        
        for(var i = 0; i < response.length; i ++) { // store the response in this file
            //console.log(response[i])
            responseTheWall.push(response[i]);
        }
        
        responseTheWall.push({id: "theWall"},{name: "The Wall"})
        // server response
        barMaker(responseTheWall); // set up bar graph
    }
});

$.ajax({
    url: "http://magicseaweed.com/api/ad8f2245ae1d67e90d037af0dea211ff/forecast/?spot_id=364&fields=charts.*,timestamp,fadedRating,solidRating,swell.*,wind.*",
 
    // The name of the callback parameter, as specified by the YQL service
    jsonp: "callback",
 
    // Tell jQuery we're expecting JSONP
    dataType: "jsonp",
 
    // Tell YQL what we want and that we want JSON/ wtf does this even mean
    data: {
        q: "charts and data to Kennebunk Me",
        format: "json"
    },
 
    // Work with the response
    success: function( response ) {
        //console.log( response );  // this is just in case
        
        

        
        for(var i = 0; i < response.length; i ++) { // store the response in this file
            //console.log(response[i])
            responseKennebunk.push(response[i]);
        }
        
        responseKennebunk.push({id: "kennebunk"},{name: "Kennebunk"})
        // server response
        barMaker(responseKennebunk); // set up bar graph
    }
});

$.ajax({
    url: "http://magicseaweed.com/api/ad8f2245ae1d67e90d037af0dea211ff/forecast/?spot_id=371&fields=charts.*,timestamp,fadedRating,solidRating,swell.*,wind.*",
 
    // The name of the callback parameter, as specified by the YQL service
    jsonp: "callback",
 
    // Tell jQuery we're expecting JSONP
    dataType: "jsonp",
 
    // Tell YQL what we want and that we want JSON/ wtf does this even mean
    data: {
        q: "charts and data to Nantasket Ma",
        format: "json"
    },
 
    // Work with the response
    success: function( response ) {
        //console.log( response );  // this is just in case
        
        

        
        for(var i = 0; i < response.length; i ++) { // store the response in this file
            //console.log(response[i])
            responseNantasket.push(response[i]);
        }
        
        responseNantasket.push({id: "nantasket"},{name: "Nantasket"})
        // server response
        barMaker(responseNantasket); // set up bar graph
    }
});