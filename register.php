<!DOCTYPE html>
<html>
<head>
    <title>CS 4WW3 Assignment 1</title>
    <!--The below meta gives browser instruction on how to handle page dimensions and scaling
        including the ability to find devices width and set initial zoom level-->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--link to the external style sheet-->
    <link href="StyleSheet.css" rel="StyleSheet" type="text/css">
    <!-- including script that will be used for js form validation -->
    <script type="text/javascript" src="regFormVal.js"></script>

</head>
<body>

<!--defines header section of page along with grabbing its style from style sheet.
    Header and paragraph used to show page title.-->
<div class="header">
    <h1>P A R K A</h1>
    <p>The easy to use parking spot locator.</p>
</div>

<!--defines navigation bar section of page along with grabbing its style from style sheet.
    href used to reference other pages (some not yet linked as client side only or have not
    been implemented yet).  class="active" pulls from style to show which page is the 
    currently active page.-->
<div class="navbar">
    <a href="index.php"><b>Home</b></a>
    <a href="search.php"><b>Search</b></a>
    <a class="active" href="register.php"><b>Register</b></a>
    <a href="submission.php"><b>Submit A Spot</b></a>
    <a href="#account"><b>Account</b></a>
</div>

<!--defines search form section of page along with setting padding in line.-->
<div style="padding: 10px 50px">
    <p><b>Fill out the below fields to register!</b></p>
    <!--Form for the user input submission-->
    <!-- ***THIS FORM NOW HAS JAVASCRIPT FORM VALIDATION AS PER ASSIGNMENT 2 REQUEST*** -->
    <!-- onsubmit form calls to validateForm() function which is in regFormVal.js 
        for more info on the validations see that file -->
    <form name="myForm" method="post" onsubmit="return validateForm()">
        <fieldset>
            <!--creates the outline Search box for the page that houses all input fields.-->
            <legend>User Registration:</legend>
            <!--First entry field (text input)-->
            Full Name:<br>
            <input type="text" name="fullname" value="" class="textbox"><br><br>
            <!--Second entry field (text input)-->
            Username:<br>
            <input type="text" name="username" value="" class="textbox"><br><br>
            <!--Third entry field (email input)-->
            Email:<br>
            <input type="email" name="email" class="textbox"><br><br>
            <!--Fourth entry field (checkbox input)-->
            How do you plan to use this website?:<br>
            <input type="checkbox" name="accounttype" value="driver">Driver
            &nbsp;&nbsp;&nbsp;&nbsp;
            <input type="checkbox" name="accounttype" value="driver">Owner<br><br>
            <!--Fifth entry field (drop down input)-->
            Country:<br>
            <select name="country">
                <option value="Canada" selected>Canada</option>
                <option value="America">America</option>
                <option value="Other">Other</option>
            </select><br><br>
            <!--Sixth and final entry field (radio input)-->
            Do you wish to receive email notifications from the website?:<br>
            <input id="r-yes" type="radio" name="price" value="yes" checked>
            <label for="r-yes">Yes</label><br>
            <input id="r-no" type="radio" name="price" value="no">
            <label for="r-no">No</label><br><br>
            <!--Submission button that will submit data (not linked as currently client side only)-->
            <input type="image" src="register-button-hi.png" alt="Register" class="submitbutton">
        </fieldset>
    </form> 
</div>


<!-- grabs values from post method and performs appropriate queries -->
<?php
//gets post method values based off their name
    $pname = $_POST['fullname'];
    $username = $_POST['username'];
    $email = $_POST['email'];

    // only passes conditional if form has been submitted before
    if(isset($_POST['fullname']) && isset($_POST['username']) && isset($_POST['email'])){
        // tries to establish database connection and perform query
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=comp4ww3', 'elijah', 'Pade1997');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // checks if entered name is already in the database
            $result = $pdo->query("SELECT name from users where name = '$rname'");

            // sets output to readable php variable
            $resulty = $result->fetch(PDO::FETCH_ASSOC);

            // if variable is empty (meaning no match) then it adds user entered info to the database
            if ($resulty == ''){ 
                try {
                    $pdo = new PDO('mysql:host=localhost;dbname=comp4ww3', 'elijah', 'Pade1997');
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $pdo->exec("INSERT INTO users (name, username, email) VALUES ('$pname', '$username', '$email')");
                }
                catch (PDOException $e) {
                    echo $e->getMessage();
                }
            }
            // if there is a match then no insert query is performed and an alert shows
            // telling user that they are already signed up
            else {
                echo "<script> 
                alert('You are already signed up.');
                </script>";
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
