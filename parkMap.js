//VERY SIMILAR TO mapInit.js EXCEPT ONLY FOR ONE MARKER

function initMap() {
    // position of marker
    var mapcenter = {lat: lata, lng: lona};
   
    //creates map centered at the lone marker and puts in id=map2 element
    var map = new google.maps.Map(
    document.getElementById('map2'), {zoom: 13, center: mapcenter});

    // content section for marker's infowindow
    var contentString = '<div id="content">'+
        '<div id="siteNotice">'+
        '</div>'+
        '<h1 id="firstHeading" class="firstHeading" style="text-align: center">'+ eman +'</h1>'+
        '<div id="bodyContent">'+
        '<p>You are currently on this parking spots information page. All information ' +
        'on this spot can be found on the current page. </p>' +
        '</div>'+
        '</div>';

    // creates infowindow and sets content to be above contentString
    var infowindow = new google.maps.InfoWindow({
        content: contentString
    });
  
    // creates marker with certain properties
    var marker = new google.maps.Marker({
        position: mapcenter,
        map: map,
        title: eman
    });

    // on marker click content infowindow pops up
    marker.addListener('click', function() {
        infowindow.open(map, marker);
    });
}