<?php

   // whatever product a user selects, the id will change the page to match the product.
// when a user adds an item to basket they need to get redirected and if they aren't logged in they need to get redirected to register
    // need to comment here

    if (!isset($_GET['message'])) {  // checks if the message parameter exists in the URL
        session_start(); //starts the session
        $message = false; //sets the default value to false when no message is passed
    } else {
        //decode the message for display
        $message = htmlspecialchars(urldecode($_GET['message'])); //retrieves a message and decodes it into something meaningful (something that a user can understand)
    }


    require_once "assets/dbconn.php"; //requires in dbconn for the database connection
    require_once "assets/common.php"; //requires in common for functions

    basket(); // creates a basket if one is not set

    //moved these up here so that they can be used to update the title of the page
    $product_id = isset($_GET['id']) ? $_GET['id'] : false; //pulls the product id from the url

    $product = getProductById(dbconn_select(), $product_id); //gets the product by the product id to display

    echo "<!DOCTYPE html>";

    echo "<html lang='en'>";

        echo "<head>";
            echo "<meta charset='UTF-8'>";
            echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>"; //meta data
            echo "<link rel='stylesheet' type='text/css' href='assets/styles.css'>"; //links to the style sheet
            echo "<title> " . $product['name'] . " - Greenfield Local Hub</title>"; //puts the product name of the product on top of the page
        echo "</head>";

        echo "<body>";

            require "assets/header.php"; //requires the header for the page to load



    echo "<div class =product-single>";
    echo "<h2>" . $product['name'] . "</h2>"; //brings name from database and displays it
        echo "<img src='" . $product['image'] . "' alt='" . $product['image_alt'] . "'>"; //pulls the image and image alt from database
        //brings product from database and puts them in

        echo "<p><strong>Price:  </strong> £" . $product['price'] . "</p>"; //brings price from database and displays it
        echo "<p><strong>Description:  </strong> " . $product['description'] . "</p>";
        echo "<p><strong>Quantity Available:  </strong> " . $product['quantity'] . "</p>";
        echo "<p><strong>Farm:  </strong> " . $product['farm'] . "</p>"; //maybe put farms in the database and pull the items from there?
    echo "</div>";

    //add to basket button //user clicks add to basket, asked to select a quantity, runs a function from common? , user gets redirected to basket with it displayed.

    echo "<a href='select_quantity.phpid=" . $product['product_id'] . "'>Add to basket</a>";

    echo user_message(); //displays any user messages to the user.

            try {
                echo "";
            } catch (PDOException $e) {
                echo $e->getMessage();
            }

            require "assets/footer.php"; //requires the header for the page to load


        echo "</body>";

    echo "</html>";

    if (!$message) {
        echo user_message(); // runs the user message function if the message variable is empty
    } else {
        echo $message;
    }