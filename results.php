<!DOCTYPE html>
<html>
<head>
    <title>CS 4WW3 Assignment 1</title>
    <!--The below meta gives browser instruction on how to handle page dimensions and scaling
        including the ability to find devices width and set initial zoom level-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <!--link to the external style sheet-->
    <link href="StyleSheet.css" rel="StyleSheet" type="text/css">
</head>
<body>

<?php 
    //gets post values
    $lati = $_POST['lati'];
    $longi  = $_POST['longi'];
    $rating = $_POST['rating'];
    $price = $_POST['price'];
    settype($rating, "integer");

    //distance function to calculate km distance between two lat/long pairs
    function distance($lat1, $lon1, $lat2, $lon2, $unit) {
        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
          return 0;
        }
        else {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $unit = strtoupper($unit);
        
            if ($unit == "K") {
                return ($miles * 1.609344);
            } else if ($unit == "N") {
                return ($miles * 0.8684);
            } else {
                return $miles;
            }
        }
    }

    //checks if parkname was posted to or not and performs appropriate action
    if(empty($_POST['parkname'])){
        $parkname = 'blank';
    }else{
        $parkname = $_POST['parkname'];
    }

    //checks if distance was posted to or not and sets default to 50 km if not
    if(empty($_POST['distance'])){
        settype($distance, "integer");
        $distance = 50;
    }else{
        $distance = $_POST['distance'];
    }

    //set max and min search values depending on user input price range
    if ($price == '0to5'){
        $min = 0.01;
        $max = 5.00;
        settype($min, "double");
        settype($max, "double");
    }
    else if ($price == '5to10'){
        $min = 5.01;
        $max = 10.00;
        settype($min, "double");
        settype($max, "double");
    }
    else if ($price == '10to20'){
        $min = 10.01;
        $max = 20.00;
        settype($min, "double");
        settype($max, "double");
    }
    else if ($price == '20plus'){
        $min = 20.01;
        $max = 100000.00;
        settype($min, "double");
        settype($max, "double");
    }
    else if ($price == 'Free'){
        $min = 0.00;
        $max = 0.00;
        settype($min, "double");
        settype($max, "double");
    }
    else if ($price == 'Any'){
        $min = 0.00;
        $max = 100000.00;
        settype($min, "double");
        settype($max, "double");
    }

    //attempts to establish connection and performs search query for parking spots that fit all entered criteria
    try {$pdo = new PDO('mysql:host=localhost;dbname=comp4ww3', 'elijah', 'Pade1997');
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $result = $pdo->query("SELECT * FROM parkings WHERE (name = '%$parkname%' or '$parkname' = 'blank') 
        and (price >= $min) 
        and (price <= $max) 
        and (rating = $rating or $rating = 6)");	

        //puts all results into an array if any
        $parkArray = array();
		foreach($result as $parking){
            array_push($parkArray, $parking);
        }
        
	} catch (PDOException $e) {
		echo $e->getMessage();
	}
?>

<!--defines header section of page along with grabbing its style from style sheet.
    Header and paragraph used to show page title.-->
<div class="header">
    <h1>P A R K A</h1>
    <p>The easy to use parking spot locator.</p>
</div>

<!--defines navigation bar section of page along with grabbing its style from style sheet.
    href used to reference other pages (some not yet linked as client side only or have not
    been implemented yet). No page is active as the current page is not one of the menu bar pages.-->
<div class="navbar">
    <a href="index.php"><b>Home</b></a>
    <a href="search.php"><b>Search</b></a>
    <a href="register.php"><b>Register</b></a>
    <a href="submission.php"><b>Submit A Spot</b></a>
    <a href="#account"><b>Account</b></a>
</div>

<!--Takes user back to search page when clicked.
    Grabs style from style sheet. -->
<div class="backtosearch">
    <?php
        echo '<p><a href="javascript:history.go(-1)" title="Return to previous page">&laquo; Go back</a></p>';
    ?>
</div>

<!--Title above map, grabs style from style sheet-->
<div class="resultstitle">
        <p><b>RESULTS</b></p>
</div>

<div id="target-id"></div>

<!--This is now the live javascript map div with specific map id styling from stylesheet.
    Also the script calls to the js file for all of the map initialization scripting
    and it calls to the google api for the actual embedded map.-->
    <!-- See mapInit.js for more details of script and how it works -->
<div id="map" ></div>
<script type="text/javascript">
    //passing php variables to js variables for use in the mapInit.js file
    var lati = <?= $lati ?>;
    var longi = <?= $longi ?>;  
    var distance = <?= $distance ?>;  
    var jsArray = <?php echo json_encode($parkArray); ?>;
</script>
<script type="text/javascript" src="mapInit.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAb6tFUn3qab_pjqLAur0VV6H8ML_OFJDY&callback=initMap"
async defer></script>

<!-- dynamically generated results table which shows all the resulting parking spots that can
    be seen on the map but in clickable tabular format, if clicked they will take you to their
    specific parking spot page-->
<div class="resultstable">
    <table class="center">
        <?php

        echo
            "<tr>"
            ."<th>Name</th>"
            ."<th>Distance Away</th>"
            ."<th>Price (per hour)</th>"
            ."</tr>";
            
        for ($j=0; $j<count($parkArray); $j++){
            if ($distance > distance($lati, $longi, $parkArray[$j][2], $parkArray[$j][3], "K")){
                echo
                    "<tr>"
                    .'<td><a href="parking.php?parkname=' . $parkArray[$j][1] . '&id=' . $parkArray[$j][0] . '&desc=' . $parkArray[$j][7] . 
                        '&lat=' . $parkArray[$j][2] . '&lon=' . $parkArray[$j][3] . '&openT=' . $parkArray[$j][5] . '&closeT=' . $parkArray[$j][6] . '&price=' . $parkArray[$j][4] . 
                        '&picname=' . $parkArray[$j][9] .'">' . $parkArray[$j][1] . "</a></td>"
                    ."<td>" . number_format((float)distance($lati, $longi, $parkArray[$j][2], $parkArray[$j][3], "K"), 2, '.', '') . "</td>"
                    ."<td>$" . number_format((float)$parkArray[$j][4], 2, '.', '') . "</td>"
                    ."</tr>";
            }
        }
        ?>
    </table>

</div>

<!--defines the page's footer that house links to other pages that are currently not implemented.-->
<div class="footer">
    <a href="#faq"><b>FAQ</b></a>
    <a href="#contactus"><b>Contact Us</b></a>
</div>

</body>
</html>
