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
    href used to reference other pages. class="active" pulls from style to show which page is the currently active page.-->

<div class="navbar">
    <a href="index.php"><b>Home</b></a>
    <a class="active" href="search.php"><b>Search</b></a>
    <a href="register.php"><b>Register</b></a>
    <a href="submission.php"><b>Submit A Spot</b></a>
    <a href="#account"><b>Account</b></a>
</div>

<!--defines search form section of page along with setting padding in line.-->
<div style="padding: 0px 50px 10px 50px">
    <p><b>Fill out the below fields to perform a search!</b></p>
    <!-- Below is the javascript that gets user's current lat/long and then inserts them into
        the proper input fields -->
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
    <!-- The button that triggers the javascript -->
    <button class="locButton" onclick="getLocation()">Click to use your current coordinates</button><br><br>
    <!--Form for the user input submission
        post values and takes user to results.php page where results are used for output-->
    <form method='post' action='results.php' >
        <fieldset>
            <!--creates the outline Search box for the page that houses all input fields.-->
            <legend>Search:</legend>
            <!--First entry field (text input)-->
            Name of parking spot:<br>
            <input type="text" name="parkname" value="" id="parkname"><br><br>
            <!-- id lati added to allow javascript to find the element by id -->
            Latitude:<br>
            <input type="text" pattern="-?\d{1,3}\.\d+" name="lati" value="" id="lati" required><br><br>
            <!--Third entry field (text input)-->
            <!-- id longi added to allow javascript to find the element by id -->
            Longitude:<br>
            <input type="text" pattern="-?\d{1,3}\.\d+" name="longi" value="" id="longi" required><br><br>
            <!--Fourth entry field (text input)-->
            Max distance to parking spot (km):<br>
            <input type="text" name="distance" value="" id="distance"><br><br>
            <!--Fifth entry field (radio button input with linked labels)-->
            Price range:<br>
            <input id="r-any" type="radio" name="price" value="Any" checked>
            <label for="r-any">Any</label><br>
            <input id="r-free" type="radio" name="price" value="Free">
            <label for="r-free">Free</label><br>
            <input id="r-0to5" type="radio" name="price" value="0to5">
            <label for="r-0to5">$0-5</label><br>
            <input id="r-5to10" type="radio" name="price" value="5to10">
            <label for="r-5to10">$5-10</label><br>
            <input id="r-10to20" type="radio" name="price" value="10to20">
            <label for="r-10to20">$10-20</label><br>
            <input id="r-20plus" type="radio" name="price" value="20plus">
            <label for="r-20plus">$20+</label><br><br>
            <!--Having this format with an input and label for each option allows for
                users to click labal as well as radio button-->

            <!--Last entry field (radio button input with linked labels)-->
            Star Rating (5 being the highest rating):<br>
            <input id="r-all" type="radio" name="rating" value="6" checked>
            <label for="r-all">All</label><br>
            <input id="r-one" type="radio" name="rating" value="1">
            <label for="r-one">1</label><br>
            <input id="r-two" type="radio" name="rating" value="2">
            <label for="r-two">2</label><br>
            <input id="r-three" type="radio" name="rating" value="3">
            <label for="r-three">3</label><br>
            <input id="r-four" type="radio" name="rating" value="4">
            <label for="r-four">4</label><br>
            <input id="r-five" type="radio" name="rating" value="5">
            <label for="r-five">5</label><br><br>
            <!--Submission button image that will submit data (not linked as currently client side only)-->
            <input type="image" src="submit-button-hi.png" alt="Submit" class="submitbutton">
        </fieldset>
    </form> 
</div>

<!--defines the page's footer that house links to other pages that are currently not implemented.-->
<div class="footer">
    <a href="#faq"><b>FAQ</b></a>
    <a href="#contactus"><b>Contact Us</b></a>
</div>

</body>
</html>
