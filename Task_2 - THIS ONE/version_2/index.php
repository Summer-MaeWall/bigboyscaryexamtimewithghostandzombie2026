<?php

    if (!isset($_GET['message'])) {  // checks if the message parameter exists in the URL
        session_start(); //starts the session
        $message = false; //sets the default value to false when no message is passed
    } else {
        //decode the message for display
        $message = htmlspecialchars(urldecode($_GET['message'])); //retrieves a message and decodes it into something meaningful (something that a user can understand)
    }


    require_once "assets/dbconn.php"; //requires in dbconn for the database connection
    require_once "assets/common.php"; //requires in common for functions


echo "<!DOCTYPE html>";

        echo "<html lang='en'>"; //sets language to english
            echo "<head>";
            echo "<meta charset='UTF-8'>";
            echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>"; //meta data
            echo "<link rel='stylesheet' type='text/css' href='assets/styles.css'>"; //links the stylesheet
            echo "<title>Home - Greenfield Local Hub</title>"; //puts a title on the tab of the page
        echo "</head>";

        echo "<body>";

            require "assets/header.php"; //requires the header for the page to load

            echo "<h3>not logged in index</h3>";
            echo user_message();

            try {
                echo "";
            } catch (PDOException $e) {
                echo $e->getMessage();
            }

            require "assets/footer.php"; //requires the footer for the page to load

        echo "</body>";

    echo "</html>";


    if (!$message) {
        echo user_message();  // runs the user message function if the message variable is empty
    } else {
        echo $message;
    }