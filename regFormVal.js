//this .js file contains all form validation for the form found on register.php page

function validateForm() {

    //this chunk ensures that the Full Name field is not empty
    var x = document.forms["myForm"]["fullname"].value;
    if (x == "") {
        alert("'Full Name' must be filled out.");
        return false;
    }

    //this chunk ensures that the username field is not empty
    var y = document.forms["myForm"]["username"].value;
    if (y == "") {
        alert("'Username' must be filled out.");
        return false;
    }

    //this chunk ensures that the username field contains only valid characters 
    // (letters, numbers, ., - and _)
    else if (/^[a-zA-Z0-9_.-]*$/.test(y) == false){
        alert("'Username' can only contain letters, numbers, ., -, and _");
        return false;
    }

    //this chunk ensures that the username field is between 5 and 25 characters 
    else if (y.length > 25 || y.length < 5){
        alert("'Username' has to be between 5 and 25 characters.");
        return false;
    }

    //this chunk ensures that the email field is not empty
    // no need to ensure right format here as that is done via the input type in register.html page
    var z = document.forms["myForm"]["email"].value;
    if (z == "") {
        alert("'Email' must be filled out.");
        return false;
    }

    //ensures that at least one of the 'Driver' or 'Owner' checkboxes is checked
    var checkboxes=document.getElementsByName("accounttype");
    var okay=false;
    for(var i=0,l=checkboxes.length;i<l;i++)
    {
        if(checkboxes[i].checked)
        {
            okay=true;
            break;
        }
    }
    if (!okay){
        alert("Please check at least one of the 'Driver' or 'Owner' checkboxes.");
        return false;
    }

    //all of the above produce alert pop up that tells users what they are missing or need to change
}