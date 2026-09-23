<?php

session_start(); //starts the session

require_once "assets/dbconn.php"; //requires in dbconn for the database connection
require_once "assets/staff_common.php"; //requires in common for functions

//below will ensure a user is logged in on this page, just in case a user manages to get onto this page without logging in.

if (!isset($_SESSION['user'])) {  //ensures user is logged in to continue
    $_SESSION['usermessage'] = "ERROR: You are not logged in!"; // sets error message why is this repeating twice??
    header("Location: staff_login.php");  // redirects them to login
    exit;  // stops further code execution
}

$staff_type = getStaffType(dbconn_select(), $_SESSION['user']); //gets the staff staff type based on their staff id

echo "<!DOCTYPE html>";

echo "<html lang='en'>";

echo "<head>";
echo "<meta charset='UTF-8'>";
echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>"; //meta data
echo "<title>Staff Dashboard - Greenfield Local Hub</title>"; //puts a title on the tab of the page
echo "</head>";

echo "<body>";



echo "<h3>Your Staff Dashboard</h3>";

//in future, set up the access to things by type like in the header

if (implode($staff_type) == "adm") { //sets it so admin staff can only see below
    echo "<a href='staff_register.php'>Register Staff</a><br>"; //admin only

    echo "<br>";

    echo "<a href='new_products.php'>Add new Products</a><br>"; //admin only

    echo "<br>";

    echo "<a href='update_product_quan.php'>Update Product Quantity</a><br>"; //store staff and admin only

    echo "<br>";

} elseif (implode($staff_type) == "sto") { //sets it so store staff can only see below
    echo "<a href='update_product_quan.php'>Update Product Quantity</a><br>"; //store staff and admin only

    echo "<br>";

    //plans for future development

    echo "<a href='.php'>view unpacked orders</a><br>"; //store staff only (for packing purposes)

    echo "<br>";

    echo "<a href='.php'>view collection orders</a><br>"; //store staff only (for when customers collect)

    echo "<br>";

} elseif (implode($staff_type) == "del") { //sets it so delivery staff can only see below
    //plans for future development
    echo "<a href='.php'>view delivery orders</a><br>"; //for delivery staff (for delivering orders)

    echo "<br>";
}


echo "<a href='staff_logout.php'>Logout</a><br>"; //all staff need this




echo user_message(); //displays any user messages to the user.

try {
    echo "";
} catch (PDOException $e) {
    echo $e->getMessage();
}


echo "</body>";

echo "</html>";
