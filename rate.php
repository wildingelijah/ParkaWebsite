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
    href used to reference other pages. No page is active as the current page is not one of the menu pages.-->
<div class="navbar">
    <a href="index.php"><b>Home</b></a>
    <a href="search.php"><b>Search</b></a>
    <a href="register.php"><b>Register</b></a>
    <a href="submission.php"><b>Submit A Spot</b></a>
    <a href="#account"><b>Account</b></a>
</div>

<!--Takes user back one step to previous page with all the information tha was their
    Grabs style from style sheet. -->
<div class="backtosearch">
    <?php
        echo '<p><a href="javascript:history.go(-1)" title="Return to previous page">&laquo; Go back</a></p>';
    ?>
</div>

<!--Form for the user input submission-->
    <!-- ***THIS FORM NOW HAS HTML FORM VALIDATION *** -->
    <form method='post' action='rate.php'>
        <fieldset>
            <!--creates the outline Search box for the page that houses all input fields.-->
            <legend>Review Submission:</legend>
            <!--First entry field (text input)-->
            Your Name:<br>
            <input type="text" name="reviewername" value="" class="textbox" minlength="1" required><br><br>
            <!--Second entry field (textarea input to allow for multiline description)-->
            Review:<br>
            <textarea name="reviewtext" rows="6" cols="50" required></textarea><br><br>
            <!--Third entry field (text input)-->
            <!-- pattern added to only allow inputs that fit latitude format -->
            Rating:<br>
            <input id="r-one" type="radio" name="reviewrating" value="1" checked>
            <label for="r-one">1</label><br>
            <input id="r-two" type="radio" name="reviewrating" value="2">
            <label for="r-two">2</label><br>
            <input id="r-three" type="radio" name="reviewrating" value="3">
            <label for="r-three">3</label><br>
            <input id="r-four" type="radio" name="reviewrating" value="4">
            <label for="r-four">4</label><br>
            <input id="r-five" type="radio" name="reviewrating" value="5">
            <label for="r-five">5</label><br><br>
            <!--Submission button image that will submit data (not linked as currently client side only)-->
            <input type="image" src="submit-button-hi.png" alt="Submit" class="submitbutton">
        </fieldset>
    </form> 
</div>


<?php
    //gets post values from the query and get value passed through url
    $rname = $_POST['reviewername'];
    $text = $_POST['reviewtext'];
    $rating = $_POST['reviewrating'];
    $parkid = $_GET['id'];

    // sets types to integer to match database data types
    settype($rating,  "integer");
    settype($parkid,  "integer");

    //same as usual, conditional to prevent query from computing if post valeus have not been set yet
    if(isset($_POST['reviewername']) && isset($_POST['reviewtext']) && isset($_POST['reviewrating'])){
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=comp4ww3', 'elijah', 'Pade1997');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //checks if name entered is in database of signed up users
            $result = $pdo->query("SELECT name from users where name = '$rname'");

            $resulty = $result->fetch(PDO::FETCH_ASSOC);
            // if its empty then alert tells user they arent signed up
            if ($resulty == ''){ 
                echo "<script> 
                alert('You are not a signed up user. Sign up to submit a spot.');
                </script>";
            }
            // if it isnt empty then they are signed up so the review gets inserted into review
            // table with proper reference to the parking spot it is for
            else {
                try {
                    $pdob = new PDO('mysql:host=localhost;dbname=comp4ww3', 'elijah', 'Pade1997');
                    $pdob->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $pdob->exec("INSERT INTO reviews (p_id, rating, customer, text)
                        VALUES ('$parkid', '$rating', '$rname', '$text')");
                }
                catch (PDOException $e) {
                    echo $e->getMessage();
                }
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    //nothing happens if post values not set
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
