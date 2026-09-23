<?php

    session_start(); //connects to session for session information

    require_once("assets/dbconn.php"); //requires dbconn.php to be brought in for the page to run as it is needed to insert data into the database.
    require_once("assets/common.php"); // requires common.php to be brought in for the page to run as it needed to use any of the functions.

    if (isset($_SESSION['user'])) { //checks to see if the user is already logged in
        $_SESSION['ERROR'] = "ERROR: You are already logged in!"; //shows message to user
        header('Location: user_dash.php'); //redirects them
        exit; //stop further execution
    } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') { //sets server request method to POST as it is more secure then GET
        try {
            $usr = login(dbconn_select(), $_POST); // login subroutine done here so we can use parts of the data if successful

            if ($usr && password_verify($_POST['password'], $usr['password'])) { //checks to make sure the correct password is entered
                $_SESSION['user'] = $usr['user_id']; //checks if user matches the user id
                $_SESSION['usermessage'] = "SUCCESS: User Successfully Logged In!"; //shows a success message to the user
                audtitor(dbconn_insert(), $_SESSION['user'], "log", "User has successfully logged in");
                header('Location: user_dash.php'); //redirects on success
                exit; //ensures code stops and helps redirect

            } elseif(!$usr) {
                $_SESSION['usermessage'] = "ERROR: User not found!"; //displays message to user
                header("Location: login.php"); //redirects user back to the login page
                exit; //stops further execution
            } else {
                $_SESSION['usermessage'] = "ERROR: Wrong Email or Password!"; //displays message to user
                header('Location: login.php'); //redirects user back to the login page
                exit; //stops further execution
            }

            //catches errors and sends messages to the user
        } catch(PDOException $e) {
            $_SESSION['usermessage'] = "ERROR: " . $e->getMessage(); //gets error messages for PDO exceptions to display to the user
            header("Location: login.php"); //redirects user back to login page
            exit; //stops further execution
        } catch(Exception $e) {
            $_SESSION['usermessage'] = "ERROR: " . $e->getMessage(); //gets error messages for exceptions and displays to the user
            header("Location: login.php"); //redirects user back to login page
            exit; //stops further execution
        }
    }




    echo "<!DOCTYPE html>";

    echo "<html lang='en'>"; //sets language to english
        echo "<head>";
            echo "<meta charset='UTF-8'>";
            echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>"; //meta data
            echo "<link rel='stylesheet' type='text/css' href='assets/styles.css'>"; //links stylesheet
            echo "<title>Login - Greenfield Local Hub</title>"; //puts a title on the tab of the page
        echo "</head>";

        echo "<body>";

            require "assets/header.php"; //requires the header for the page to load

            echo "<br>";
            echo user_message(); //displays user messages
            echo "<br>";

            echo "<h1>Login</h1>"; //label for clarity (UAC 1.3)
            echo "<form action='' method='post'>"; //creates a form with appropriate action and method.

            echo "<br><label for='email'>Email:</label><br>"; //label for the input box. Makes the page clear and easy to understand (UAC 1.3, NFR 1.1)
            echo "<input type='text' name='email' id='email' required>"; //input box, is required so form cannot be submitted without it.

            echo "<br><label for='password'>Password:</label><br>"; //label for the input box. Makes the page clear and easy to understand (UAC 1.3, NFR 1.1)
            echo "<input type='password' name='password' id='password' required>"; //input box, is required so form cannot be submitted without it.

            echo "<br><input type='submit' name='submit' id='submit' value='Log In'>"; //submit button, once clicked causes form to be submitted

            echo "</form>";

            echo "<div>";
            echo "<h2>Don't have an account?</h2>";
            echo "<p>Click here to register an account today!</p>";
            echo "<p><a href='register.php'>Register Here!</a></p>";
            echo "</div>";

            require "assets/footer.php"; //requires the footer for the page to load

        echo "</body>";

    echo "</html>";