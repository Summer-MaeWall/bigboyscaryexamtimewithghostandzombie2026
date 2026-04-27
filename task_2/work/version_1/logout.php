<?php
    session_start(); //starts the session

    require_once "assets/dbconn.php";  //includes database connection

    session_destroy(); //ends the session, which logs out the user

    header("location:index.php?message=You have been logged out!"); //displays a message to the user saying they have been logged out on the index page
