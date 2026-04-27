<?php

   // whatever product a user selects, the id will change the page to match the product.
// when a user adds an item to basket they need to get redirected and if they aren't logged in they need to get redirected to register
    // need to comment here

   session_start(); //starts the session


    require_once "assets/dbconn.php"; //requires in dbconn for the database connection
    require_once "assets/common.php"; //requires in common for functions


    //moved these up here so that they can be used to update the title of the page
    $product_id = isset($_GET['id']) ? $_GET['id'] : false; //pulls the product id from the url

    $product = getproductbyid(dbconn_select(), $product_id); //gets the product by the product id to display

    if (!isset($_SESSION['user'])) {  //ensures user is logged in to continue
        $_SESSION['usermessage'] = "ERROR: You are not logged in!"; // sets error message
        header("Location: login.php");  // redirects them to login
        exit;  // stops further code execution
    } elseif($_SERVER["REQUEST_METHOD"] === "POST" && $_POST['quantity']>0) {  // if the user has posted
        try {
            if (in_basket($product_id)) {
                $_SESSION["basket"][$_POST['itemid']] = $_POST['quantity'];
                $_SESSION['usermessage'] = "SUCCESS: Item added to your Basket!"; //message displayed when an item is successfully added to basket
                audtitor(dbconn_insert(), $_SESSION['user'], "bas", "User has successfully added an item to basket"); //adds an audit to the system when a user adds an item to the basket
                //this audit may need to be removed if it clogs up the audit system.
                header('Location: products.php');  // redirects them back to the page after the item is added (essentially the system refreshing the page for the user)
                exit;  // stops further code execution
            } else {
                $_SESSION['usermessage'] = "ERROR: In basket already"; //sends a message to the user if the item is already in the basket
                header('Location: basket.php');  // redirects them to their basket
                exit;  // stops further code execution
            }
        } catch (PDOException $e) {
            $_SESSION['usermessage'] = "ERROR: ".$e->getMessage();
            header('Location: products.php');  // redirects them
            exit;  // stops further code execution
        } catch (Exception $e){
            $_SESSION['usermessage'] = "ERROR: ".$e->getMessage();
            header('Location: products.php');  // redirects them
            exit;  // stops further code execution
        }
    } elseif($_SERVER["REQUEST_METHOD"] === "POST" && $_POST['quantity']==0) {
        $_SESSION['usermessage'] = "ERROR: You need a quantity higher than 1!"; // sets error message if user tries to add 0 items to the basket
        header("Location: products.php");  // redirects them
        exit;  // stops further code execution
    }

    if (!isset($_SESSION['basket'])) { //if basket doesnt exist, creates a basket
        $_SESSION['basket'] = []; //creates basket as an array.
    }

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

        $farms = get_farms(dbconn_select()); //gets the farm names and codes

        $matchedFarm = null; //sets matched farm variable to null
        foreach ($farms as $farm) { //for each entry in farms as farm
            if (trim($farm['farm_code']) == $product['farm']) { //searches through the farm codes in the farms array until one matches what is in products
                $matchedFarm = $farm; //sets matched farm as the array with the correct farm code
                break; //breaks the foreach loop
            }
        }


    echo "<div class =product-single>";
    echo "<h2>" . $product['name'] . "</h2>"; //brings name from database and displays it
        echo "<img src='" . $product['image'] . "' alt='" . $product['image_alt'] . "'>"; //pulls the image and image alt from database
        //brings product from database and puts them in

        echo "<p><strong>Price:  </strong> £" . number_format($product['price'], 2) . "</p>"; //brings price from database and displays it
        echo "<p><strong>Description:  </strong> " . $product['description'] . "</p>";
        echo "<p><strong>Quantity Available:  </strong> " . $product['quantity'] . "</p>";
        echo "<p><strong>Farm:  </strong> " . $matchedFarm['farm_name'] . "</p>"; //after going through the foreach loop, the correct name is displayed to the user.
    echo "</div>";

    if ($product['quantity'] > 0) {
        echo " <form action='' method='post'>";
        echo "<td>";
        echo "<input type='hidden' name='itemid' value=" . $product['product_id'] . ">";
        echo "<input type='number' name='quantity' min='1' max= " . $product['quantity'] . "  value='1' />"; //sets the quantity to add to basket
        echo "<input type='submit' name='addprod' value='Add to basket' />"; //this causes the page to reload and the product to the basket
        echo "</td>";
        echo "</form>";
    } else {
        echo " <form action='' method='post'>";
        echo "<input type='hidden' name='itemid' value=" . $product['product_id'] . ">";
        echo "<input type='submit' disabled name='addprod' value='Sold Out' />";
    }


echo user_message(); //displays any user messages to the user.


            require "assets/footer.php"; //requires the header for the page to load


        echo "</body>";

    echo "</html>";
