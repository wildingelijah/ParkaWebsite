function initMap() {
    //mapcenters around this position value which is made up of the user input lat and long

    var mapcenter = {lat: lati, lng: longi};
   
    // creates new map with zoom of 12 and centered on mapcenter position, houses the map in id=map
    // element on results.php page
    var map = new google.maps.Map(
    document.getElementById('map'), {zoom: 12, center: mapcenter});

    // these are all the content sections for each hardcoded marker
    // these hold all formatting for the popup boxes that happen when a marker is clicked
    

    // initializes the array that will store the necessary information for each marker on the map
    var location = [];

    // initializes variable that houses distTo each location from users input location
    // this variable is then stored in the above array for each location
    var distTo = 0;

    // loops through the array with all of the information returned from the search and put appropriate
    // information about each into the location array for displaying on the map
    for (let i = 0; i < jsArray.length; i++) {
        //creates the content box that pops up when clicking on a marker based off of values from each location
        var contentString = '<div id="content">'+
        '<div id="siteNotice">'+
        '</div>'+
        '<h1 id="firstHeading" class="firstHeading" style="text-align: center">' + jsArray[i][1] + '</h1>'+
        '<div id="bodyContent">'+
        '<p><b>Description:</b> ' + jsArray[i][7]+ '</p>'+
        '<p><b>Price:</b> $' + parseFloat(jsArray[i][4]).toFixed(2) + '</p>'+
        '<p><b>Location:</b> Latitude: ' + jsArray[i][2] + ', Longitude: ' + jsArray[i][3] + '</p>'+
        '</div>'+
        '</div>';

        // below calculations calculate distance between user input lat/long coordinates and each
        // locations lat/long coordinates using radius of earth and other fancy shmancy values
        var p = 0.017453292519943295;    // Math.PI / 180
        var c = Math.cos;
        var a = 0.5 - c((parseFloat(jsArray[i][2]) - lati) * p)/2 + 
          c(lati * p) * c(parseFloat(jsArray[i][2]) * p) * 
          (1 - c((parseFloat(jsArray[i][3]) - longi) * p))/2;

        distTo = 12742 * Math.asin(Math.sqrt(a));

        // pushes proper info to the location array only if the calculated distance is less
        // than the user input max distance is greater than the actual distance
        if (distTo < distance){
            location.push([jsArray[0][1], {lat: parseFloat(jsArray[i][2]), lng: parseFloat(jsArray[i][3])}, contentString, distTo])
        }
    }

    // creates new infowindow, only one infowindow can be open at a time, the content is just changed based on which marker is selected
    var infowindow = new google.maps.InfoWindow();

    // for loop that iterates over all instances in location array
    for (var i = 0; i < location.length; i++) {
        //IF STATEMENT HERE?
        //creates marker for each location grabbing values from array
        var marker = new google.maps.Marker({
            position: location[i][1],
            map: map,
            title: location[i][0]
        });

        //on click of a marker this brings up the infowindow with their respective information
        google.maps.event.addListener(marker, 'click', (function (marker, i) {
            return function () {
                infowindow.setContent(location[i][2]);
                infowindow.open(map, marker);
            }
        })(marker, i)); 
    }
}
