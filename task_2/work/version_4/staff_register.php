<?php

session_start(); //starts the session

require_once("assets/dbconn.php"); //requires dbconn.php to be brought in for the page to run as it is needed to insert data into the database.
require_once("assets/staff_common.php"); // requires common.php to be brought in for the page to run as it needed to use any of the functions.

$staff_type = getStaffType(dbconn_select(), $_SESSION['user']); //gets the staff staff type based on their staff id

if (!isset($_SESSION['user'])) {  //ensures user is logged in to continue
    $_SESSION['usermessage'] = "ERROR: You are not logged in!"; // sets error message
    header("Location: staff_login.php");  // redirects them to login
    exit;  // stops further code execution
} elseif (implode($staff_type) != 'adm') {  //ensures user has a staff type and its admin to access the page
    $_SESSION['usermessage'] = "ERROR: Account does not have clearance to access this page!"; // sets error message
    header("Location: staff_dash.php");  // redirects them to the dashboard
    exit;  // stops further code execution

} elseif ($_SERVER["REQUEST_METHOD"] === "POST") { //using post as it is a secure method
    if ($_POST['password'] != $_POST['confirm_password']) { //checks to see if both passwords match
        $_SESSION['usermessage'] = "ERROR: Passwords do not match!"; //message to the user if they do not match
        header("Location: staff_register.php"); //sends them back to the register page
        exit; //ensures redirect works and code stops executing
    } else {
        try {
            if (!email_ver(dbconn_select(), $_POST['email'])) { //calls the email_ver() functions with the correct parameters
                if (reg_user(dbconn_insert(), $_POST)) { //moved the reg user function so that email ver will work as intended
                    audtitor(dbconn_insert(), $_SESSION['user'], "reg", "New staff account created"); // instead of getting the user_id for the new user,
                    // I will use the user_id for the staff making the account since accounts should only be made by admins

                    $_SESSION['usermessage'] = "USER CREATED SUCCESSFULLY"; //tells the user that the user was created successfully
                    header('Location: staff_register.php'); //keeps the admin on the register page incase they need to register multiple accounts
                    exit; //ensures redirect works and code stops executing
                } else {
                    $_SESSION['usermessage'] = "ERROR: USER REGISTRATION FAILED"; //sends user an error message is the account fails to register
                }
            } else {
                $_SESSION['usermessage'] = "ERROR: EMAIL NOT AVAILABLE"; //sends user an error message if the email is not available
            }
        }   catch (PDOException $e) {  // catch database error
            $_SESSION['usermessage'] = "ERROR: " . $e->getMessage();  // sets it to user message with a redirect
            header("Location: staff_register.php");  // sends them back to same page with user error set
            exit;
        } catch (Exception $e){
            $_SESSION['usermessage'] = "ERROR: " . $e->getMessage();}  // catches any other error and redirects them to reg page
    }
}





    echo "<!DOCTYPE html>";

    echo "<html lang='en'>"; //sets language to english
        echo "<head>";
            echo "<meta charset='UTF-8'>";
            echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>"; //meta data
            // echo "<link rel='stylesheet' type='text/css' href='assets/styles.css'>"; //links stylesheet for now the staff system will not have a style sheet for convience
            echo "<title>Register Staff - Greenfield Local Hub</title>"; //puts a title on the tab of the page
        echo "</head>";

        echo "<body>";


            echo "<h1>Register New Staff</h1>"; //label for clarity (UAC 1.3)

            echo "<form action='' method='post'>"; //creates a form with appropriate action and method.

            echo "<label for='email'>Email:</label><br>"; //label for the input box. Makes the page clear and easy to understand (UAC 1.3, NFR 1.1)
            echo "<input type='email' name='email' id='email' required><br>"; //input box, is required so form cannot be submitted without it.

            echo "<label for='password'>Staff Role:</label><br>"; //label for the input box. Makes the page clear and easy to understand (UAC 1.3, NFR 1.1)
                echo "<select name='type' id='type' required>"; //using a select drop down menu over an input field so that all the inputs in the system will be the same
                echo "<option value='sto'>Store Staff</option>"; //in a larger staff system, these would be pulled from the database but with the time constraints I have
                echo "<option value='del'>Delivery Staff</option>"; //they will just be typed in. This is not the best way to do it though to ensure that it is adaptive to change in future/
                echo "<option value='adm'>Admin</option>";
            echo "</select><br>";


            echo "<label for='password'>Password:</label><br>"; //label for the input box. Makes the page clear and easy to understand (UAC 1.3, NFR 1.1)
            echo "<input type='password' name='password' id='password' required><br>"; //input box, is required so form cannot be submitted without it.

            echo "<label for='password'>Confirm Password:</label><br>"; //label for the input box. Makes the page clear and easy to understand (UAC 1.3, NFR 1.1)
            echo "<input type='password' name='confirm_password' id='confirm_password' required><br>"; //input box, is required so form cannot be submitted without it.

            echo "<br><input type='submit' name='submit' id='submit' value='Register Account'>"; //submit button, once clicked causes form to be submitted

            echo "</form>";


            echo "<br><br><a href='staff_dash.php'><- Back</a>"; //to make it so you can easily get back to the dash since there's no header

            echo "<br>";
            echo user_message(); //displays user messages
            echo "<br>";


        echo "</body>";

    echo "</html>";