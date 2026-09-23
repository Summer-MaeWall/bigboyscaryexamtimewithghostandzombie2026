<?php

    session_start(); //starts the session

    require_once "assets/dbconn.php"; //requires in dbconn for the database connection
    require_once "assets/common.php"; //requires in common for functions

    //below will ensure a user is logged in on this page, just in case a user manages to get onto this page without logging in.

    if (!isset($_SESSION['user'])) {  //ensures user is logged in to continue
        $_SESSION['usermessage'] = "ERROR: You are not logged in!"; // sets error message
        header("Location: login.php");  // redirects them to login
        exit;  // stops further code execution
    }

    echo "<!DOCTYPE html>";

        echo "<html lang='en'>";

            echo "<head>";
                echo "<meta charset='UTF-8'>";
                echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>"; //meta data
                echo "<link rel='stylesheet' type='text/css' href='assets/styles.css'>"; //links to the style sheet
                echo "<title>Settings - Greenfield Local Hub</title>"; //puts a title on the tab of the page
            echo "</head>";

            echo "<body>";

                require "assets/header.php"; //requires the header for the page to load

                echo "<h3>WIP</h3>";

                //ad change password, view account details, audits etc


                echo user_message(); //displays any user messages to the user.

                try {
                    echo "";
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }

                require "assets/footer.php"; //requires the header for the page to load

            echo "</body>";

        echo "</html>";