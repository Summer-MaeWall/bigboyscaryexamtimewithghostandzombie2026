<?php

    session_start(); //starts the session

    require_once("assets/dbconn.php"); //requires dbconn.php to be brought in for the page to run as it is needed to insert data into the database.
    require_once("assets/common.php"); // requires common.php to be brought in for the page to run as it needed to use any of the functions.

    if (isset($_SESSION['user_id'])) {  // Looks for if the user is already logged in
        $_SESSION['usermessage'] = "ERROR: You have already logged in!";  // tells them they are logged in and redirect to their dashboard
        header("Location: user_dash.php"); //sends the user to the dashboard
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") { //using post as it is a secure method
        if ($_POST['password'] != $_POST['confirm_password']) { //checks to see if both passwords match
            $_SESSION['usermessage'] = "ERROR: Passwords do not match!"; //message to the user if they do not match
            header("Location: register.php"); //sends them back to the register page
            exit; //ensures redirect works and code stops executing
        } else {
            try {
                if (!email_ver(dbconn_select(), $_POST['email'] && reg_user(dbconn_insert(), $_POST))) { //calls the email_ver() and reg_user() functions with the correct parameters
                    $_SESSION['usermessage'] = "USER CREATED SUCCESSFULLY"; //tells the user that the user was created successfully
                    header('Location: login.php'); //redirects the user to the login page
                    exit; //ensures redirect works and code stops executing
                }
            }   catch (PDOException $e) {  // catch database error
                $_SESSION['usermessage'] = "ERROR: " . $e->getMessage();  // sets it to user message with a redirect
                header("Location: register.php");  // sends them back to same page with user error set
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
            echo "<link rel='stylesheet' type='text/css' href='assets/styles.css'>"; //links to the style sheet
            echo "<title>Register - Greenfield Local Hub</title>"; //puts a title on the tab of the page
        echo "</head>";

        echo "<body>";

            require "assets/header.php"; //requires the header for the page to load

            echo "<h1>Register</h1>"; //label for clarity (UAC 1.3)

            echo "<form action='' method='post'>"; //creates a form with appropriate action and method.

            echo "<label for='email'>Email:</label><br>"; //label for the input box. Makes the page clear and easy to understand (UAC 1.3, NFR 1.1)
            echo "<input type='email' name='email' id='email' required><br>"; //input box, is required so form cannot be submitted without it.

            echo "<label for='password'>Password:</label><br>"; //label for the input box. Makes the page clear and easy to understand (UAC 1.3, NFR 1.1)
            echo "<input type='password' name='password' id='password' required><br>"; //input box, is required so form cannot be submitted without it.

            echo "<label for='password'>Confirm Password:</label><br>"; //label for the input box. Makes the page clear and easy to understand (UAC 1.3, NFR 1.1)
            echo "<input type='password' name='confirm_password' id='confirm_password' required><br>"; //input box, is required so form cannot be submitted without it.

            echo "<br><input type='submit' name='submit' id='submit' value='Register Account'>"; //submit button, once clicked causes form to be submitted

            echo "</form>";

            echo "<br>";
            echo user_message(); //displays user messages
            echo "<br>";

            require "assets/footer.php"; //requires the footer for the page to load




echo "</body>";

    echo "</html>";