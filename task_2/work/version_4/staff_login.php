<?php

    if (!isset($_GET['message'])) {  // checks if the message parameter exists in the URL
        session_start(); //starts the session
        $message = false; //sets the default value to false when no message is passed
    } else {
        //decode the message for display
        $message = htmlspecialchars(urldecode($_GET['message'])); //retrieves a message and decodes it into something meaningful (something that a user can understand)
        session_start(); //starts the session
    }

    require_once("assets/dbconn.php"); //requires dbconn.php to be brought in for the page to run as it is needed to insert data into the database.
    require_once("assets/staff_common.php"); // requires common.php to be brought in for the page to run as it needed to use any of the functions.

    if (isset($_SESSION['user'])) { //checks to see if the user is already logged in
        $_SESSION['ERROR'] = "ERROR: You are already logged in!"; //shows message to user
        header('Location: staff_dash.php'); //redirects them
        exit; //stop further execution
    } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') { //sets server request method to POST as it is more secure then GET
        try {
            $usr = login(dbconn_select(), $_POST); // login subroutine done here so we can use parts of the data if successful

            if ($usr && password_verify($_POST['password'], $usr['password'])) { //checks to make sure the correct password is entered
                $_SESSION['user'] = $usr['staff_id']; //checks if user matches the user id
                $_SESSION['usermessage'] = "SUCCESS: User Successfully Logged In!"; //shows a success message to the user
                audtitor(dbconn_insert(), $_SESSION['user'], "log", "User has successfully logged in");
                header('Location: staff_dash.php'); //redirects on success
                exit; //ensures code stops and helps redirect

            } elseif(!$usr) {
                $_SESSION['usermessage'] = "ERROR: User not found!"; //displays message to user
                header("Location: staff_login.php"); //redirects user back to the login page
                exit; //stops further execution
            } else {
                $_SESSION['usermessage'] = "ERROR: Wrong Email or Password!"; //displays message to user
                header('Location: staff_login.php'); //redirects user back to the login page
                exit; //stops further execution
            }

            //catches errors and sends messages to the user
        } catch(PDOException $e) {
            $_SESSION['usermessage'] = "ERROR: " . $e->getMessage(); //gets error messages for PDO exceptions to display to the user
            header("Location: staff_login.php"); //redirects user back to login page
            exit; //stops further execution
        } catch(Exception $e) {
            $_SESSION['usermessage'] = "ERROR: " . $e->getMessage(); //gets error messages for exceptions and displays to the user
            header("Location: staff_login.php"); //redirects user back to login page
            exit; //stops further execution
        }
    }




    echo "<!DOCTYPE html>";

    echo "<html lang='en'>"; //sets language to english
        echo "<head>";
            echo "<meta charset='UTF-8'>";
            echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>"; //meta data
           // echo "<link rel='stylesheet' type='text/css' href='assets/styles.css'>"; //links stylesheet for now the staff system will not have a style sheet for convience
            echo "<title>Staff Login - Greenfield Local Hub</title>"; //puts a title on the tab of the page
        echo "</head>";

        echo "<body>";

            echo "<br>";
            echo user_message(); //displays user messages
            echo "<br>";

            try {
                echo "";
            } catch (PDOException $e) {
                echo $e->getMessage();
            }

            echo "<h1>Staff Login</h1>"; //label for clarity (UAC 1.3)
            echo "<form action='' method='post'>"; //creates a form with appropriate action and method.

                echo "<br><label for='email'>Email:</label><br>"; //label for the input box. Makes the page clear and easy to understand (UAC 1.3, NFR 1.1)
                echo "<input type='text' name='email' id='email' required>"; //input box, is required so form cannot be submitted without it.

                echo "<br><label for='password'>Password:</label><br>"; //label for the input box. Makes the page clear and easy to understand (UAC 1.3, NFR 1.1)
                echo "<input type='password' name='password' id='password' required>"; //input box, is required so form cannot be submitted without it.

                echo "<br><input type='submit' name='submit' id='submit' value='Log In'>"; //submit button, once clicked causes form to be submitted

            echo "</form>";

        echo "</body>";

    echo "</html>";


    if (!$message) {
        echo user_message();  // runs the user message function if the message variable is empty
    } else {
        echo $message;
    }