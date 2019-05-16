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

<!--defines header section of page along with grabbing its style from style sheet.
    Header and paragraph used to show page title.-->
<div class="header">
    <h1>P A R K A</h1>
    <p>The easy to use parking spot locator.</p>
</div>

<!--defines navigation bar section of page along with grabbing its style from style sheet.
    href used to reference other pages. #account does not link anywhere. class="active" pulls from style to show which page is the 
    currently active page.-->
<div class="navbar">
    <a href="index.php"><b>Home</b></a>
    <a href="search.php"><b>Search</b></a>
    <a href="register.php"><b>Register</b></a>
    <a class="active" href="submission.php"><b>Submit A Spot</b></a>
    <a href="#account"><b>Account</b></a>
</div>

<!--defines search form section of page along with setting padding in line.-->
<div style="padding: 0px 50px">
    <p><b>Fill out the below fields to submit a parking spot!</b></p>
    <!-- The scripting similar to search.php that gets user's current position and
        puts it in the correct input fields. -->
    <script>
            function getLocation() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(showPosition);
                } else { 
                    x.innerHTML = "Geolocation is not supported by this browser.";
                }
            }
    
            function showPosition(position) {
                document.getElementById('lati').value= position.coords.latitude;
                document.getElementById('longi').value= position.coords.longitude;
            }
    </script>
    <!-- The button that triggers above scripting -->
    <button class="locButton" onclick="getLocation()">Click to use your current coordinates</button><br><br>
    
    <!--Form for the user input submission, posts form inputs-->
    <!-- ***THIS FORM NOW HAS HTML/CSS FORM VALIDATION AS PER ASSIGNMENT 2 REQUEST*** -->
    <form method='post' action='submission.php'>
        <fieldset>
            <!--creates the outline Search box for the page that houses all input fields.-->
            <legend>Parking Information:</legend>
            <!--Added this entry field to only allow users that are signed up to 
                submit the form, checks against users table in database (text input)-->
            Your Full Name:<br>
            <input type="text" name="fullname" value="" class="textbox"><br><br>
            <!--First entry field (text input)-->
            Name of parking location:<br>
            <input type="text" name="parkingname" value="" class="textbox"><br><br>
            <!--Second entry field (textarea input to allow for multiline description)-->
            Parking spot description:<br>
            <textarea name="parkingdesc" rows="6" cols="50"></textarea><br><br>
            <!--Third entry field (text input)-->
            <!-- pattern added to only allow inputs that fit latitude format -->
            Latitude of parking spot:<br>
            <input type="text" pattern="-?\d{1,3}\.\d+" name="lati" value="" id="lati"><br><br>
            <!--Fourth entry field (text input)-->
            <!-- pattern added to only allow inputs that fit longitude format -->
            Longitude of parking spot:<br>
            <input type="text" pattern="-?\d{1,3}\.\d+" name="longi" value="" id="longi"><br><br>
            <!--Fifth entry field (number input)-->
            Price to park in $ (ie 6.50):<br>
            <input type="number" step="0.25" name="parkingprice" value="" class="textbox"><br><br>
            <!--Sixth entry field (text input)-->
            <!-- regex patterns added to only allow properly formatted time values in these fields -->
            Open time (ie 9:00am):<br>
            <input type="text" pattern="\b((1[0-2]|0?[1-9]):([0-5][0-9])([AaPp][Mm]))" name="opentime" value="" class="textbox"><br><br>
            Close time (ie 5:00pm):<br>
            <input type="text" pattern="\b((1[0-2]|0?[1-9]):([0-5][0-9])([AaPp][Mm]))" name="closetime" value="" class="textbox"><br><br>
            <!--Allow owner to upload image, only accepts files of image types-->
            Upload an image of the parking service:<br><br>
            <input type="file" name="parkingpic" accept="image/*"><br><br>
            <!--Submission button image that will submit data (not linked as currently client side only)-->
            <input type="image" src="submit-button-hi.png" alt="Submit" class="submitbutton">
        </fieldset>
    </form> 
</div>

<!-- below php section performs appropriate databse manipulation based on inputs -->
<?php
    // grabs value from post method and set them to php variables for later use
    $rname = $_POST['fullname'];
    $name = $_POST['parkingname'];
    $desc = $_POST['parkingdesc'];
    $lat = $_POST['lati'];
    $lon = $_POST['longi'];
    $openT = $_POST['opentime'];
    $closeT = $_POST['closetime'];
    $price = $_POST['parkingprice'];

    // below line grabs name of image the user uploads and references it to the specific parking spot
    $imgname = $FILES['parkingpic']['name'];
    
    // below lines change format of time to make it consistent with rest of database time format
    $opentime = date("H:i:s", strtotime($openT));
    $closetime = date("H:i:s", strtotime($closeT));

    //setting type of some variables to be consistent with data types in database
    settype($price,  "double");
    settype($lat, "float");
    settype($lon, "float");

    // this if checks whether or not values have been posted to those names yet and if not doesnt
    // perform the sql queries (this blocks this portion from running when page is first loaded for example)
    if(isset($_POST['parkingname']) && isset($_POST['closetime'])){

        // tries to performs query
        try {
            //atttempts to connect to database
            $pdo = new PDO('mysql:host=localhost;dbname=comp4ww3', 'elijah', 'Pade1997');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //performs query and sends output to $result
            $result = $pdo->query("SELECT name from users where name = '$rname'");

            //changing $result to actual readable variable through fetch to see if empty
            $resulty = $result->fetch(PDO::FETCH_ASSOC);

            //checks whether it is empty, if it is this shows that user trying to submit a parking
            // spot is not a signed up user and therefore it wont allow it
            if ($resulty == ''){ 
                //also alerts user that they are not signed up
                echo "<script> 
                alert('You are not a signed up user. Sign up to submit a spot.');
                </script>";
            }
            // if it isnt empty (aka the user is signed up) then this else occurs
            else {
                //another try/catch which attempts to connect again and performs query to insert
                // user input values into the database accordingly
                try {
                    $pdo = new PDO('mysql:host=localhost;dbname=comp4ww3', 'elijah', 'Pade1997');
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $pdo->exec("INSERT INTO parkings (name, longitude, latitude, price, opentime, closetime, description)
                        VALUES ('$name', '$lon', '$lat', '$price', '$opentime', '$closetime', '$desc')");	
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }
            }
        } 
        // catches first try if query fails or there is error
        catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    //nothing happens if post values havent been set yet
    else {

    }
?>

<!--defines the page's footer that house links to other pages that are currently not implemented.
    Links not working as client side only currently.-->
<div class="footer">
    <a href="#faq"><b>FAQ</b></a>
    <a href="#contactus"><b>Contact Us</b></a>
</div>

</body>
</html>
