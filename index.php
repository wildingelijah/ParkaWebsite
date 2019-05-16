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
    <a class="active" href="index.php"><b>Home</b></a>
    <a href="search.php"><b>Search</b></a>
    <a href="register.php"><b>Register</b></a>
    <a href="submission.php"><b>Submit A Spot</b></a>
    <a href="#account"><b>Account</b></a>
</div>

<!-- simple paragraph and picture divs to give the landing page when site first loaded some content -->
<div class = "home"> 
    <p> Welcome to the easy to use parking spot locator. Click on any of the tabs above to navigate around the site.
</div>

<div style="text-align: center; padding-bottom: 40px;">
    <img src="homePark.png" alt="Parking Spots">
</div>

<!--defines the page's footer that house links to other pages that are currently not implemented.-->
<div class="footer">
    <a href="#faq"><b>FAQ</b></a>
    <a href="#contactus"><b>Contact Us</b></a>
</div>

</body>
</html>
