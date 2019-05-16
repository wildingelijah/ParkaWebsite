<!DOCTYPE html>
<html>
<head>
    <title>CS 4WW3 Assignment 1</title>
    <!--The below meta gives browser instruction on how to handle page dimensions and scaling
        including the ability to find devices width and set initial zoom level-->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--link to the external style sheet-->
    <link href="StyleSheet.css" rel="StyleSheet" type="text/css">
</head>
<body>

<?php
    //gets all values for specific parking spot passed through url from previous page 
    $parkname = $_GET['parkname'];
    $id = $_GET['id'];
    $desc = $_GET['desc'];
    $lat = $_GET['lat'];
    $lon = $_GET['lon'];
    $openT = $_GET['openT'];
    $closeT = $_GET['closeT'];
    $price = $_GET['price'];
    $picname = $_GET['picname'];

    //changes format off times for nicer output
    $opentime = date("g:i a", strtotime($openT));
    $closetime = date("g:i a", strtotime($closeT));

    //gets all the reviews for specific parking spot and houses them in reviewArray
    try {$pdo = new PDO('mysql:host=localhost;dbname=comp4ww3', 'elijah', 'Pade1997');
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $result = $pdo->query("SELECT * FROM reviews WHERE (p_id = '$id')");	

        $reviewArray = array();
		foreach($result as $reviews){
            array_push($reviewArray, $reviews);
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
    href used to reference other pages. No page is active as the current page is not one of the menu pages.-->
<div class="navbar">
    <a href="index.php"><b>Home</b></a>
    <a href="search.php"><b>Search</b></a>
    <a href="register.php"><b>Register</b></a>
    <a href="submission.php"><b>Submit A Spot</b></a>
    <a href="#account"><b>Account</b></a>
</div>

<!--Takes user back to previous page!
    Grabs style from style sheet. -->
<div class="backtosearch">
    <?php
        echo '<p><a href="javascript:history.go(-1)" title="Return to previous page">&laquo; Go back</a></p>';
    ?>
</div>

<!--Name of chosen parking service appears here, grabs style from style sheet. -->
<div class="resultstitle">
    <?php
        echo "<p><b>" . $parkname . "</b></p>";
    ?>
</div>


<!-- This has been updated and separated from the paragraph below as it is now
    a live embedded javacsript map showing the one marker (parking spot) that this page displays
    information on. For more detailed info on how it works, see parkMap.js-->
<div id="map2" ></div>
<!-- php variables being passed to javascript variables so they can be used in parkMap.js -->
<script type="text/javascript">
    var lata = <?= $lat ?>;
    var lona = <?= $lon ?>;
    var eman = '<?php echo $parkname ?>';
</script>
<script type="text/javascript" src="parkMap.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAb6tFUn3qab_pjqLAur0VV6H8ML_OFJDY&callback=initMap"
async defer></script>

<!--Dynamicly generated paragraph housing information about the chosen parking spot,
    this information is grabbed from specific parking space chosen
    and shown here but for now it is client side only-->
<div class="parkdiv">
    <p class="parkpara">
        <b>Description:</b><br>
        <?php echo $desc ?><br><br>
        <b>Price:</b><br>
        $<?php echo number_format((float)$price, 2, '.', '') ?><br><br>
        <b>Hours of operation:</b><br>
        <?php echo $opentime ?>-<?php echo $closetime ?><br><br>
        <b>Latitude and Longitude:</b><br>
        <?php echo $lat ?>, <?php echo $lon ?><br><br>
    </p>
</div>

<!-- gets name of picture referencing that specific spot from database and then uses it
    to display pic on this page, pictures are stored locally as I am not using amazon's services -->
<div style="text-align: center; padding: 20px;">
    <img src='<?php echo $picname ?>' alt='<?php echo $parkname ?>'>
</div>

<!--Ratings and reviews table title-->
<div class="ratingstitle">
    <p><b>Ratings & Reviews</b></p>
</div>

<!-- All of the below table info is dynamically generated using that parking space's
    actual values and reviews-->
<div class="reviewstable">
    <table class="center">
        <?php
            echo
                "<tr>"
                ."<th>Rating</th>"
                ."<th>Review</th>"
                ."<th>Customer</th>"
                ."</tr>";
                
            for ($j=0; $j<count($reviewArray); $j++){
                
                //decides which image name to use based off of the rating given
                if ($reviewArray[$j][2] == '1'){
                    $stars = "1stars.png";
                    $alt = "1 Star";
                }
                else if ($reviewArray[$j][2] == '2'){
                    $stars = "2stars.png";
                    $alt = "2 Stars";
                }
                else if ($reviewArray[$j][2] == '3'){
                    $stars = "3stars.png";
                    $alt = "3 Stars";
                }
                else if ($reviewArray[$j][2] == '4'){
                    $stars = "4stars.png";
                    $alt = "4 Stars";
                }
                else if ($reviewArray[$j][2] == '5'){
                    $stars = "5stars.png";
                    $alt = "5 Stars";
                }

                // image name gets put in the below lines to use appropriate star image
                echo
                    "<tr>"
                    ."<td><img style='width:100px; height: auto;' src='". $stars . "' alt='" . $alt . "'></td>"
                    ."<td>" . $reviewArray[$j][4] . "</td>"
                    ."<td>" . $reviewArray[$j][3] . "</td>"
                    ."</tr>";
            }
            // clickable link added as last row which spans 3 columns which user can click
            // to be taken to review submission page
            echo
                "<tr>"
                .'<td colspan="3" style="text-align:center"><a href="rate.php?id=' . $reviewArray[0][1] . '">Leave a review!</a></td>'
                ."</tr>";
        ?>
    </table>
</div>


<!--defines the page's footer that house links to other pages that are currently not implemented.
    Links not working as client side only currently.-->
<div class="footer">
    <a href="#faq"><b>FAQ</b></a>
    <a href="#contactus"><b>Contact Us</b></a>
</div>

</body>
</html>
